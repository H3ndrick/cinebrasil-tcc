<?php 
    if (isset($_COOKIE["token"])) {
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3; URL='login.php'" />

    <title>Conta Criada</title>
    <link rel="stylesheet" href="assets/css/styleTelaSucesso.css">
</head>
<body>
    <div class="message">Conta criada com sucesso</div>
    <script>
        const message = document.querySelector('.message');
        let scaleUp = true;
        setInterval(() => {
            if(scaleUp) {
                message.style.transform = 'scale(1.05)';
            } else {
                message.style.transform = 'scale(1)';
            }
            scaleUp = !scaleUp;
        }, 1000);
    </script>
</body>
</html>

