<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_POST["idFilme"])){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $idFilme = $_POST["idFilme"];

            if(empty($idFilme)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }
            
            
            $conn = connect();

            $analises = getAnalisesByIdFilme($conn, $idFilme);
            $usuarios = [];

            foreach ($analises as $i => $analise) {
                $usuarios[] = getUsuarioById($conn, $analise["id_usuario"]);
            }

            disconnect($conn);

            if($analises){
                $response = ['sucess' => true, 'mensagem' => 'Análise listada com sucesso!', 'idFilme' => $idFilme, 'analises' => $analises, 'usuarios' => $usuarios];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, não foi possível listar as análises com sucesso.', 'analises' => $analises];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }