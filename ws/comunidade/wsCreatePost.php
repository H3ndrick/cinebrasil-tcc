<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["titulo"]) || isset($_POST["conteudo"]) || isset($_POST["idComunidade"]) || isset($_POST["idElementoPai"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $titulo = $_POST["titulo"];
            $conteudo = $_POST["conteudo"];
            $idComunidade = $_POST["idComunidade"];
            $idElementoPai = $_POST["idElementoPai"];

            if(empty($titulo) || empty($conteudo) || empty($idComunidade) || empty($idElementoPai)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }

            #var_dump($conteudo);
            if($idElementoPai == 0){
                $idElementoPai = null;
            }
            
            $conn = connect();
            $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
            $dataCriacao = date("Y-m-d H:i:s");
            $idPost = createPost($conn, $idElementoPai, $idComunidade, $idUser["id_usuario"], $titulo, $conteudo, $dataCriacao);
            disconnect($conn);

            if($idComunidade){
                $response = ['sucess' => true, 'mensagem' => 'Publicação criada com sucesso!', 'idComunidade' => $idComunidade, 'conteudo' => $conteudo];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a comunidade não foi criada com sucesso.'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }