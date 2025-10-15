<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["idComunidade"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $idComunidade = $_POST["idComunidade"];

            if(empty($idComunidade)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }

            $conn = connect();
            $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
            $isMembro = addMembroComunidade($conn, $idComunidade, $idUser["id_usuario"]);
            disconnect($conn);

            if($isMembro){
                $response = ['sucess' => true, 'mensagem' => 'Publicação criada com sucesso!', 'idComunidade' => $idComunidade];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a comunidade não foi criada com sucesso.'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }