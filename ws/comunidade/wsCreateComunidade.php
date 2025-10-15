<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["titulo"]) || isset($_POST["descricao"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios'];
        } else{
            $titulo = $_POST["titulo"];
            $descricao = $_POST["descricao"];

            if(empty($titulo) || empty($descricao)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }
            
            if(isset($_FILES["capa"]) and isset($_FILES["banner"])){
                if(!(empty($_FILES["capa"]) and empty($_FILES["banner"]))){
                    $nomeImagemCapa = $_FILES["capa"]["name"];
                    $tmpNameCapa = $_FILES["capa"]["tmp_name"];

                    $nomeImagembanner = $_FILES["banner"]["name"];
                    $tmpNamebanner = $_FILES["banner"]["tmp_name"];

                    $extensaoCapa = pathinfo ($nomeImagemCapa, PATHINFO_EXTENSION);
                    $extensaoCapa = strtolower ($extensaoCapa);

                    $extensaobanner = pathinfo($nomeImagembanner, PATHINFO_EXTENSION);
                    $extensaobanner = strtolower($extensaobanner);

                    $tituloSemEspaco = str_replace(" ", "", $titulo);

                    $uploadDirCapa = "../../uploads/comunidades/capas/";
                    $capa = "capa-$tituloSemEspaco-". md5(uniqid()) . "-". time() .".$extensaoCapa";
                    $uploadFileCapa = $uploadDirCapa . $capa;

                    $uploadDirbanner = "../../uploads/comunidades/banners/";
                    $banner = "banner-$tituloSemEspaco-". md5(uniqid()) . "-". time() .".$extensaobanner";
                    $uploadFilebanner = $uploadDirbanner . $banner;

                    if(!move_uploaded_file($tmpNameCapa, $uploadFileCapa)){
                        $capa = "uploads/comunidades/capas/fotoCapaVazia.png";
                    } else{
                        $capa = "uploads/comunidades/capas/$capa";
                    }

                    if(!move_uploaded_file($tmpNamebanner, $uploadFilebanner)){
                        $banner = "uploads/comunidades/banners/bannerVazio.png";
                    } else{
                        $banner = "uploads/comunidades/banners/$banner";
                    }
                }
            }

            $conn = connect();
            $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
            $dataCriação = date("Y-m-d H:i:s");
            $idComunidade = createComunidade($conn, $titulo, $descricao, $idUser["id_usuario"], $idUser["id_usuario"], $dataCriação, $capa, $banner);
            addMembroComunidade($conn, $idComunidade, $idUser["id_usuario"]);
            disconnect($conn);

            if($idComunidade){
                $response = ['sucess' => true, 'mensagem' => 'Comunidade criada com sucesso!', 'idComunidade' => $idComunidade, 'descricao' => $descricao];
            } else{
                $response = ['sucess' => false, 'mensagem' => 'Algo deu errado, a comunidade não foi criada com sucesso.'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }