<?php

$apiKey = '8d5b72f8965d9a6a26a450ab2afcee77';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$url = "https://api.themoviedb.org/3/discover/movie?api_key=$apiKey&language=pt-BR&region=BR&with_original_language=pt&page=$page&sort_by=popularity.desc&vote_count.gte=35";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resposta = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $resposta;
exit;
