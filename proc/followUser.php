<?php
include "../includes/functions.php";
$conn = connect();

if (!isset($_COOKIE["token"]) || !getIdUsuarioByToken($conn, $_COOKIE["token"])) {
    echo json_encode(["success" => false, "message" => "Usuário não autenticado"]);
    exit();
}

$idLogado = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
$idPerfil = intval($_POST["idPerfil"]);
$action = $_POST["action"];

if ($idPerfil == $idLogado) {
    echo json_encode(["success" => false, "message" => "Você não pode seguir a si mesmo"]);
    exit();
}

if ($action == "follow") {
    $success = followUser($conn, $idLogado, $idPerfil);
} elseif ($action == "unfollow") {
    $success = unfollowUser($conn, $idLogado, $idPerfil);
} else {
    echo json_encode(["success" => false, "message" => "Ação inválida"]);
    exit();
}

if ($success) {
    $followers = getFollowersCount($conn, $idPerfil);
    $following = getFollowingCount($conn, $idPerfil);
    echo json_encode(["success" => true, "followers" => $followers, "following" => $following, "action" => $action]);
} else {
    echo json_encode(["success" => false, "message" => "Erro ao executar ação"]);
}
