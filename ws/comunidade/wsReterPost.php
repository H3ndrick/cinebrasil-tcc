<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_POST["idPost"])){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $idPost = $_POST["idPost"];

            if(empty($idPost)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }
            
            $conn = connect();
            $resultado = reterPostParaAnalise($conn,$idPost);
            disconnect($conn);

            if($resultado){
                $response = ['sucess' => true, 'mensagem' => 'Publicação retida para análise com sucesso!', 'idPost' => $idPost];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a comunidade não foi criada com sucesso.'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }