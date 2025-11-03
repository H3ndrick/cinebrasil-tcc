<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["idFilme"]) || !isset($_POST["listas"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $idFilme = $_POST["idFilme"];
            $listas = $_POST["listas"];
            
            if(empty($idFilme)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }

            $conn = connect();
            $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];

            $listas = explode(',', $listas);
            $listasAtuais = getIdListasUsuarioByIdFilme($conn, $idFilme, $idUser);

            foreach ($listas as $i => $idLista) {
                if(!in_array(intval($idLista), array_column($listasAtuais, 'id_lista'))){
                    $result1 = addFilmeInLista($conn, intval($idLista), intval($idFilme));
                }
            }
            
            $listasAtuais = getIdListasUsuarioByIdFilme($conn, $idFilme, $idUser);

            foreach (array_column($listasAtuais, 'id_lista') as $i => $listaAtual) {
                if(!in_array($listaAtual, $listas)){
                    removeFilmeLista($conn, $listaAtual, $idFilme);
                }
            }

            $result = sizeof(getIdListasUsuarioByIdFilme($conn, $idFilme, $idUser)) == sizeof($listas) ? true : false;
            
            disconnect($conn);
            
            if($result){
                $response = ['sucess' => true, 'mensagem' => 'Lista atualizada com sucesso!', 'idsLista' => $listas];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a lista não foi atualizada com sucesso.'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }