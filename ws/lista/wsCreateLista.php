<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["titulo"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $titulo = $_POST["titulo"];
            if(!isset($_POST["privacidade"])){
                $privacidade = false;
            } else{
                $privacidade = $_POST["privacidade"];
            }
            
            $descricao = $_POST["descricao"];
            
            if(empty($titulo)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }

            $conn = connect();
            $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
            $idLista = createLista($conn, $titulo, $descricao, $idUser["id_usuario"]);

            disconnect($conn);

            if($idLista){
                $response = ['sucess' => true, 'mensagem' => 'Lista criada com sucesso!', 'idLista' => $idLista];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a lista não foi criada com sucesso.'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }