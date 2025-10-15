<?php
    include "includes/functions.php";
    $conn = connect();

    if (!isset($_COOKIE["token"]) || !getIdUsuarioByToken($conn, $_COOKIE["token"])) {
        header("Location: login.php");
        exit();
    }

    $idUsuarioAtivo = getIdUsuarioByToken($conn, $_COOKIE["token"]);
    $isAdm = isAdm($conn,$idUsuarioAtivo["id_usuario"]);

    if(!$isAdm){
        header("Location: index.php");
    }

    include "includes/head.php";
    include "includes/header.php";

    disconnect($conn);
?>

    <div class="container mt-5 p-5">
        <main class="mt-3 d-flex flex-column align-items-center justify-content-center main">
            <h1>Posts retidos para análise:</h1>
            
            <div class="d-flex gap-3 flex-wrap">
                <div id="containerPostsRetidos">
                </div>
            </div>
        </main>

        <footer>

        </footer>
    </div>
    <script src="assets/js/centralAnalises/getPostsRetidos.js"></script>
    <script src="assets/js/centralAnalises/centralAnalisesPost.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>