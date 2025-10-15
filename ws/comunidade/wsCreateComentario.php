<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["comentario"]) || isset($_POST["idComunidade"]) || isset($_POST["idElementoPai"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $comentario = $_POST["comentario"];
            $idComunidade = $_POST["idComunidade"];
            $idElementoPai = $_POST["idElementoPai"];
            $titulo = '';

            if(empty($comentario) || empty($idComunidade) || empty($idElementoPai)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            } else {
                #var_dump($comentario);
                if($idElementoPai == 0){
                    $idElementoPai = null;
                }
                
                $conn = connect();
                $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
                $dataCriacao = date("Y-m-d H:i:s");
                $idPost = createPost($conn, $idElementoPai, $idComunidade, $idUser["id_usuario"], $titulo, $comentario, $dataCriacao);
                disconnect($conn);

                if($idComunidade){
                    $response = ['sucess' => true, 'mensagem' => 'Comentario criado com sucesso!', 'idComunidade' => $idComunidade, 'conteudo' => $comentario];
                } else{
                    $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, o comentário não foi criado com sucesso.'];
                }
            }
            
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }