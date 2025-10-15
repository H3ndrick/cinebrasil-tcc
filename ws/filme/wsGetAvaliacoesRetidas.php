<?php 
    include "../../includes/functions.php";
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $conn = connect();
        $avaliacoesIds = getIdAvaliacoesRetidas($conn);
        $avaliacoes = array();
        $usuarios = array();

        foreach ($avaliacoesIds as $i => $avaliacaoId) {
            $avaliacoes[] = getAnaliseById($conn,$avaliacaoId["idFilme"], $avaliacaoId["idUsuario"]);
            $usuarios[] = getUsuarioById($conn, $avaliacoes[$i]["id_usuario"]);
        }
        
        disconnect($conn);
        
        if($avaliacoes)
            $response = ['success' => true, 'mensagem' => 'Avaliações retidas foram pegas com sucesso.', 'avaliacoes' => $avaliacoes, 'usuarios' => $usuarios];
        else{
            $response = ['success' => false, 'mensagem' => 'problema no banco de dados'];
        }
        
        header("Content-Type: application/json");
        echo json_encode($response);
    }