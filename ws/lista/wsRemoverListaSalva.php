<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["idLista"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $idLista = $_POST["idLista"];
            
            if(empty($idLista)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }

            $conn = connect();
            $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
            $result = removerListaSalva($conn, $idLista, $idUser["id_usuario"]);

            disconnect($conn);

            if($result){
                $response = ['sucess' => true, 'mensagem' => 'Lista salva removida com sucesso!', 'idLista' => $idLista];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a lista não foi criada com sucesso.'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }