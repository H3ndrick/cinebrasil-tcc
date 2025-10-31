<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../../includes/functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["idPost"])) {
        $response = ['success' => false, 'mensagem' => 'ID do post não informado.'];
    } else {
        $idPost = $_POST["idPost"];
        $idComunidade = $_POST["idComunidade"]; 

        $conn = connect();
        $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];

        $post = getPostById($conn, $idPost);

        $comunidade = getComunidadeById($conn, $idComunidade);
        $isDono = $comunidade["dono_id"] == $idUser;

        if (!$post) {
            $response = ['success' => false, 'mensagem' => 'Post não encontrado.'];
        } elseif ($post["usuario_id"] != $idUser && (!isAdmComunidade($conn, $idComunidade, $idUser) && !$isDono)) {
            $response = ['success' => false, 'mensagem' => 'Você não tem permissão para excluir este post.'];
        } else {
            $deleteRetido = permitirPostRetido($conn, $idPost);
            if($deleteRetido){
                $deleted = deletarPost($conn, $idPost);

                if ($deleted) {
                    $response = ['success' => true, 'mensagem' => 'Post excluído com sucesso', 'idComunidade' => $idComunidade];
                } else {
                    $response = ['success' => false, 'mensagem' => 'Erro ao excluir post'];
                }
            }
        }
        
        disconnect($conn);
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
