<?php 
include('../../includes/functions.php');
$msg = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!(isset($_POST["email"]) && isset($_POST["password"]))) {
        $msg = "Usuário e senha devem estar preenchidos";
    } else {
        $email = $_POST["email"];
        $senha = $_POST["password"];

        if (empty($email) || empty($senha)) {
            $msg = "Usuário e senha devem estar preenchidos";
        } else {
            $conn = connect();
            $user = validaLogin($conn, $email, $senha);

            if (!$user) {
                $msg = "Usuário inexistente ou senha inválida";
            } else {
                $token = gerarToken($conn, $user);
                $validade = date('Y-m-d H:i:s', strtotime('+10 minutes'));
                adicionaTokenUsuario($conn, $user["id"], $token, $validade);
                setcookie("token", $token, time() + (30 * 24 * 60 * 60), "/");

                $msg = "Login efetuado com sucesso";
                $success = true;
            }

            disconnect($conn);
        }
    }

    header('Content-Type: application/json');
    $response = ['success' => $success, 'mensagem' => $msg];
    echo json_encode($response);
}