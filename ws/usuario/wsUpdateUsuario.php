<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }
    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["username"]) || isset($_POST["fotoAtual"]) || isset($_POST["idUsuario"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obtigatórios.'];
        }else{
            $id = $_POST["idUsuario"];
            $username = $_POST["username"];
            $bio = $_POST["bio"];
            $foto = $_POST["fotoAtual"];
            
            $conn = connect();

            if(empty($username) || empty($id) || empty($foto)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }
            
            $usuario = getUsuarioById($conn, $id);
            $usernameIsUsado = $username == $usuario["username"] ? 0 : verificarUsernameUsuario($conn, $username);
            
            if($usernameIsUsado > 0){
                $response = ['sucess' => false, 'mensagem' => 'Esse username já está sendo usado por outra conta.'];
            } else{
                if(isset($_FILES["imgUser"])){
                    if(!empty($_FILES["imgUser"])){
                        $nomeImagem = $_FILES["imgUser"]["name"];
                        $tmpName = $_FILES["imgUser"]["tmp_name"];
    
                        $extensao = pathinfo ($nomeImagem, PATHINFO_EXTENSION);
                        $extensao = strtolower ($extensao);
    
                        $uploadDir = "../../uploads/users/fotoPerfil/";
                        $uploadFile = $uploadDir . $username . "Perfil.$extensao";
    
                        if(!move_uploaded_file($tmpName, $uploadFile)){
                            $foto = $_POST["fotoAtual"];
                        } else{
                            $foto = "uploads/users/fotoPerfil/".$username."Perfil.$extensao";
                        }
                    }
                }
    
                $usuario = updateUsuario($conn, $id, $username, $foto, $bio);
    
                disconnect($conn);
    
                if($usuario){
                    $response = ['sucess' => true, 'mensagem' => 'Perfil atualizado com sucesso.'];
                } else{
                    $response = ['sucess' => false, 'mensagem' => 'Não foi possível atualizar o perfil.'];
                }
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
