<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["id"]) || isset($_POST["titulo"]) || isset($_POST["dataLancamento"]) || isset($_POST["sinopse"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $idFilme = $_POST["id"];
            $conn = connect();

            if(!filmeJaCadastrado($conn, $idFilme)){
                $titulo = $_POST["titulo"];
                $dataLancamento = $_POST["dataLancamento"];
                $sinopse = $_POST["sinopse"];
                $capa = $_POST["capa"];
                $foto = $_POST["banner"];

                if(empty($titulo) || empty($dataLancamento) || empty($sinopse)){
                    $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
                }

                $idFilme= createFilme($conn, $idFilme, $titulo, $dataLancamento, $sinopse, $capa, $foto);
                
                disconnect($conn);

                if($idFilme){
                    $response = ['sucess' => true, 'mensagem' => 'Filme cadastrado com sucesso!', 'idFilme' => $idFilme];
                } else{
                    $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, o filme não foi cadastrado com sucesso.'];
                }
            } else{
                $response = ['sucess' => true, 'mensagem' => 'Filme já foi cadastrado anteriormente no sistema', 'idFilme' => $idFilme];
            }
            
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }