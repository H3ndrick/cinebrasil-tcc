<?php 
if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include "../../includes/functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!isset($_POST["idComunidade"]) || !isset($_POST["titulo"]) || !isset($_POST["descricao"])){
        $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
    } else{
        $idComunidade = $_POST["idComunidade"];
        $titulo = $_POST["titulo"];
        $descricao = $_POST["descricao"];

        if(empty($titulo) || empty($descricao)){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
        } else {
            $conn = connect();
            $comunidade = getComunidadeById($conn, $idComunidade);

            $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
            if($comunidade["criador_id"] != $idUser){
                $response = ['sucess' => false, 'mensagem' => 'Você não tem permissão para editar esta comunidade.'];
                echo json_encode($response);
                exit;
            }

            $capa = $comunidade["capa"];
            $banner = $comunidade["banner"];

            if(isset($_FILES["capa"]) && !empty($_FILES["capa"]["name"])){
                $extensaoCapa = strtolower(pathinfo($_FILES["capa"]["name"], PATHINFO_EXTENSION));
                $uploadDirCapa = "../../uploads/comunidades/capas/";
                $nomeCapa = "capa-".md5(uniqid()).time().".$extensaoCapa";
                if(move_uploaded_file($_FILES["capa"]["tmp_name"], $uploadDirCapa.$nomeCapa)){
                    $capa = "uploads/comunidades/capas/$nomeCapa";
                }
            }

            if(isset($_FILES["banner"]) && !empty($_FILES["banner"]["name"])){
                $extensaoBanner = strtolower(pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION));
                $uploadDirBanner = "../../uploads/comunidades/banners/";
                $nomeBanner = "banner-".md5(uniqid()).time().".$extensaoBanner";
                if(move_uploaded_file($_FILES["banner"]["tmp_name"], $uploadDirBanner.$nomeBanner)){
                    $banner = "uploads/comunidades/banners/$nomeBanner";
                }
            }

            $ok = updateComunidade($conn, $idComunidade, $titulo, $descricao, $capa, $banner);
            disconnect($conn);

            if($ok){
                $response = ['sucess' => true, 'mensagem' => 'Comunidade atualizada com sucesso!', 'idComunidade' => $idComunidade];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Erro ao atualizar comunidade.'];
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
