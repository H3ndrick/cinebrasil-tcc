<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "GET"){

        $conn = connect();
        $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
        $listas = getListasByIdUsuario($conn, $idUser["id_usuario"]);
        
        foreach ($listas as $i => $lista) {
            $filmes = getFilmesInLista($conn, $lista["id"]);
            $lista["filmes"] = $filmes;
            $listas[$i] = $lista;
        }

        disconnect($conn);

        if($listas){
            $response = ['sucess' => true, 'mensagem' => 'Lista criada com sucesso!', 'listas' => $listas];
        } else{
            $response = ['sucess' => false, 'mensagem' => 'Erro ao carregar listas.', 'listas' => $listas];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }