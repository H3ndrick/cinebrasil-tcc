<?php 
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }
    include "../../includes/functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!(isset($_POST["username"]) || isset($_POST["email"]) || isset($_POST["password"]))){
            $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obtigatórios.'];
        }else{
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $foto = "assets/img/fotoPerfilVazia.png";
            
            $conn = connect();

            if(empty($username) || empty($email) || empty($password)){
                $response = ['sucess' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
            }

            $usernameIsUsado = verificarUsernameUsuario($conn, $username);

            if($usernameIsUsado > 0){
                $response = ['sucess' => false, 'mensagem' => 'Esse username já está sendo usado por outra conta.'];
            } else{

                $emailIsUsado = verificarEmailUsuario($conn, $email);

                if($emailIsUsado > 0){
                    $_SESSION["err-msg"] = "Esse email já está associado à outra conta";
                    $response = ['sucess' => false, 'mensagem' => 'Esse eail já está associado à outra conta.'];
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
                                $foto = "assets/img/fotoPerfilVazia.png";
                            } else{
                                $foto = "uploads/users/fotoPerfil/".$username."Perfil.$extensao";
                            }
        
                            
                        }
                    }
        
                    $usuario = createUsuario($conn, $username, $email, $password, $foto);
        
                    disconnect($conn);
        
                    if($usuario){
                        $response = ['sucess' => true, 'mensagem' => 'Conta registrada com sucesso.'];
                    } else{
                        $response = ['sucess' => false, 'mensagem' => 'Não foi possível cadastrar o usuário.'];
                    }
                }
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
