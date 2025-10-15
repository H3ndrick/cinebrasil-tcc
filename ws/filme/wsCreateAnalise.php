<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["idFilme"]) || isset($_POST["comentario"]) || isset($_POST["nota"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $idFilme = $_POST["idFilme"];
            $comentario = $_POST["comentario"];
            $nota = $_POST["nota"];

            if(empty($idFilme) || empty($comentario) || empty($nota)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }
            
            $conn = connect();
            $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
            $user = getUsuarioById($conn, $idUser["id_usuario"]);
            $analise = createAnalise($conn, $idFilme, $idUser["id_usuario"], $comentario, $nota);
            disconnect($conn);

            if($analise){
                $response = ['sucess' => true, 'mensagem' => 'Análise criada com sucesso!', 'conteudo' => $comentario, 'nota' => $nota, 'usuario' => $user, 'idUser' => $idUser, 'idFilme' => $idFilme];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a análise não foi criada com sucesso.'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }