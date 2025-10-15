<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../../includes/functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["idComunidade"])) {
        $response = ['success' => false, 'mensagem' => 'ID da comunidade não informado.'];
    } else {
        $idComunidade = $_POST["idComunidade"];

        $conn = connect();
        $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
        $comunidade = getComunidadeById($conn, $idComunidade);
        $isDono = $comunidade["dono_id"] == $idUser;

        if (!$comunidade) {
            $response = ['success' => false, 'mensagem' => 'Comunidade não encontrada.'];
        } elseif (!$isDono) {
            $response = ['success' => false, 'mensagem' => 'Você não tem permissão para excluir essa comunidade.'];
        } else {
            $deleted = excluirComunidade($conn, $idComunidade);

            if ($deleted) {
                $response = ['success' => true, 'mensagem' => 'Comunidade excluída com sucesso', 'idComunidade' => $idComunidade];
            } else {
                $response = ['success' => false, 'mensagem' => 'Erro ao excluir post'];
            }
        }
        
        disconnect($conn);
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
