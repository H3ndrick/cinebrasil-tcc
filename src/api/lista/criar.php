<?php 
if(session_status()==PHP_SESSION_NONE){
    session_start();
}

$projectRoot = dirname(__DIR__, 3);

require_once $projectRoot . '/src/helpers/response.php';
require_once $projectRoot . '/src/repositories/ListaRepository.php';
require_once $projectRoot . '/includes/functions.php';

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    jsonResponse(false, 'Método não permitido');
}

if(!isset($_POST["titulo"]) || empty($_POST["titulo"])){
    jsonResponse(false, 'Preencha todos os campos obrigatórios');
}

$titulo = trim($_POST['titulo'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');

if ($titulo === '') {
    jsonResponse(false, 'Preencha todos os campos obrigatórios');
}

$token = trim($_COOKIE['token'] ?? '');

if ($token === '') {
    jsonResponse(false, 'Usuário não autenticado');
}

$conn = connect();
$idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);

if (!is_array($idUser) || !isset($idUser['id_usuario'])) {
    disconnect($conn);
    jsonResponse(false, 'Token inválido ou expirado');
}

$idLista = ListaRepository::createLista($conn, $titulo, $descricao, $idUser["id_usuario"]);
disconnect($conn);

if($idLista){
    jsonResponse(true, 'Lista criada com sucesso!', ['idLista' => $idLista]);
} else{
    jsonResponse(false, 'Algo deu errado, a lista não foi criada com sucesso.');
}