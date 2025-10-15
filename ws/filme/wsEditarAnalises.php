<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include "../../includes/functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!(isset($_POST["idFilme"]) && isset($_POST["idUsuario"]) && isset($_POST["comentario"]) && isset($_POST["nota"]))){
        $response = ['success' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
    } else {
        $idFilme = $_POST["idFilme"];
        $idUsuario = $_POST["idUsuario"];
        $comentario = $_POST["comentario"];
        $nota = $_POST["nota"];

        $conn = connect();
        $atualizou = updateAnalise($conn, $idFilme, $idUsuario, $comentario, $nota);
        

        if($atualizou){
            
            $analise = getAnaliseById($conn, $idFilme, $idUsuario); 
            $response = ['success' => true, 'mensagem' => 'Análise atualizada com sucesso!', 'analise' => $analise, 'idFilme' => $idFilme];
        } else {
            $response = ['success' => false, 'mensagem' => 'Falha ao atualizar a análise.'];
        } 
        disconnect($conn);
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>