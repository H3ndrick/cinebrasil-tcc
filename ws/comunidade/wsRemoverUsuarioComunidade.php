<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }
    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["idComunidade"]) || isset($_POST["idUsuario"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obtigatórios.'];
        }else{
            $idComunidade = $_POST["idComunidade"];
            $idUsuario = $_POST["idUsuario"];
            
            $conn = connect();

            if(empty($idComunidade) || empty($idUsuario)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }

            $usuario = removerUsuarioComunidade($conn, $idComunidade, $idUsuario);

            disconnect($conn);

            if($usuario){
                $response = ['sucess' => true, 'mensagem' => 'Usuario removido da comunidade com sucesso.'];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Não foi possível remover o usuário da comunidade.'];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
