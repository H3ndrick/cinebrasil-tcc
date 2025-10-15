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
            $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
            $voto = false;

            if(!votouPost($conn,$idPost, $idUser["id_usuario"])){
                $voto = criarVoto($conn, $idPost, $idUser["id_usuario"], false, true);
            }else{
                $voto = downVote($conn, $idPost, $idUser["id_usuario"]);
            }
            
            disconnect($conn);

            if($voto){
                $response = ['sucess' => true, 'mensagem' => 'curtida realizada com sucesso!', 'idPost' => $idPost];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a comunidade não foi criada com sucesso.', 'voto' => $voto];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }