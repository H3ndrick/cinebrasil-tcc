<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }
    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_POST["idUsuario"])){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obtigatórios.'];
        }else{
            $id = $_POST["idUsuario"];
            
            $conn = connect();

            if(empty($id)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }

            $usuario = tornarAdm($conn, $id);

            disconnect($conn);

            if($usuario){
                $response = ['sucess' => true, 'mensagem' => 'Usuário transformado em ADM com sucesso.'];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Não foi possível transformar o usuário em ADM.'];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
