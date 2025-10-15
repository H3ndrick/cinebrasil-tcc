<header>
    <?php
        $conn = connect();
        if (isset($_COOKIE["token"])) {
            $token = $_COOKIE["token"];

            $idUser = getIdUsuarioByToken($conn, $token);
            $user = getUsuarioById($conn, $idUser["id_usuario"]);
            if ($user["role"] == 'user') {
                include "includes/nav-auth.php";
            } else {
                include "includes/nav-adm.php";
            }
        } else {
            include "includes/nav.php";
        }
    ?>
</header>
