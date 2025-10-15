<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["idFilme"]) || isset($_POST["idUsuario"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $idFilme = $_POST["idFilme"];
            $idUsuario = $_POST["idUsuario"];

            if(empty($idFilme) || empty($idUsuario)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }
            
            $conn = connect();
            $excluiuAnalise = deleteAnalise($conn, $idFilme, $idUsuario);
            disconnect($conn);

            if($excluiuAnalise){
                $response = ['sucess' => true, 'mensagem' => 'Análise excluida com sucesso!', 'idFilme' => $idFilme, 'idUser' => $idUsuario];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a análise não foi excluida com sucesso.'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }