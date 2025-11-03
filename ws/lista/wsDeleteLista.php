<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_POST["idLista"])){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $idLista = $_POST["idLista"];

            if(empty($idLista)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }
            
            $conn = connect();
            $excluiuLista = deleteLista($conn, $idLista);
            disconnect($conn);

            if($excluiuLista){
                $response = ['sucess' => true, 'mensagem' => 'Lista excluida com sucesso!', 'idLista' => $idLista];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a Lista não foi excluida com sucesso.'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }