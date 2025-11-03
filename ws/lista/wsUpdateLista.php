<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }
    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["id"]) || isset($_POST["titulo"]) || isset($_POST["descricao"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obtigatórios.'];
        }else{
            $id = $_POST["idLista"];
            $titulo = $_POST["titulo"];
            $descricao = $_POST["descricao"];
            
            $conn = connect();

            if(empty($id) || empty($titulo)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }else{
    
                $lista = updateLista($conn, $id, $titulo, $descricao);
                disconnect($conn);
    
                if($lista){
                    $response = ['sucess' => true, 'mensagem' => 'Lista atualizada com sucesso.', 'id' => $id];
                } else{
                    $response = ['sucess' => false, 'mensagem' => 'Não foi possível atualizar a lista.'];
                }
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
