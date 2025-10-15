<?php
$apiKey = '8d5b72f8965d9a6a26a450ab2afcee77';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

if (!$query) {
    http_response_code(400);
    echo json_encode(['error' => 'Query parameter is required']);
    exit;
}

// Buscar filmes pelo texto, com língua em pt-BR
$searchUrl = "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&language=pt-BR&query=" . urlencode($query) . "&page=$page";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $searchUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$searchResponse = curl_exec($ch);
curl_close($ch);

$searchData = json_decode($searchResponse, true);

$filteredResults = [];
$multiHandle = curl_multi_init();
$curlHandles = [];

// Criar requisições paralelas para detalhes dos filmes
foreach ($searchData['results'] as $movie) {
    $movieId = $movie['id'];
    $detailsUrl = "https://api.themoviedb.org/3/movie/$movieId?api_key=$apiKey&language=pt-BR";

    $chDetails = curl_init();
    curl_setopt($chDetails, CURLOPT_URL, $detailsUrl);
    curl_setopt($chDetails, CURLOPT_RETURNTRANSFER, true);
    curl_multi_add_handle($multiHandle, $chDetails);

    $curlHandles[$movieId] = $chDetails;
}

// Executar todas as requisições em paralelo
$running = null;
do {
    curl_multi_exec($multiHandle, $running);
    curl_multi_select($multiHandle);
} while ($running > 0);

// Processar respostas e filtrar por país Brasil
foreach ($curlHandles as $movieId => $chDetails) {
    $detailsResponse = curl_multi_getcontent($chDetails);
    $detailsData = json_decode($detailsResponse, true);

    $hasBrazil = false;
    if (!empty($detailsData['production_countries'])) {
        foreach ($detailsData['production_countries'] as $country) {
            if ($country['iso_3166_1'] === 'BR') {
                $hasBrazil = true;
                break;
            }
        }
    }

    if ($hasBrazil) {
        // Procurar o filme original no array inicial para pegar os dados básicos
        foreach ($searchData['results'] as $movie) {
            if ($movie['id'] == $movieId) {
                $filteredResults[] = $movie;
                break;
            }
        }
    }

    curl_multi_remove_handle($multiHandle, $chDetails);
    curl_close($chDetails);
}

curl_multi_close($multiHandle);

// Retornar só filmes brasileiros encontrados
header('Content-Type: application/json');
echo json_encode([
    'page' => $searchData['page'],
    'total_results' => count($filteredResults),
    'results' => $filteredResults
]);
exit;
?>
