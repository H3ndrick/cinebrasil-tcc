<?php
    include "includes/functions.php";
    include "includes/head.php";
    include "includes/header.php";
?>
    <link rel="stylesheet" href="assets/css/listas-style.css">
    <div class="container-fluid">
        <main class="mt-4 pt-4 d-flex flex-column align-items-center justify-content-center main">
            <h1>Listas</h1>
            

            <div class="pb-3 mb-2">
                <?php 
                    if (!(!isset($_COOKIE["token"]) || !getIdUsuarioByToken($conn, $_COOKIE["token"]))) {
                ?>
                        <div class="container-lista">
                            <div class="lista" id="criarLista">
                                <div class="card-lista d-flex align-items-center justify-content-center" style="background-color:rgb(130, 82, 207);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                    </svg>
                                </div>
                                <div class="card-lista" style="background-color:rgb(162, 111, 229);"></div>
                                <div class="card-lista" style="background-color:rgb(188, 156, 206);"></div>
                                <div class="card-lista" style="background-color:rgb(195, 175, 212);"></div>
                            </div>
                            <div class="div-infos-lista d-flex flex-column px-3 pb-3">
                                <span class=" w-100 titulo-lista">Criar lista</span>
                            </div>
                        </div>
                <?php 
                    } 
                ?>

            </div>

            <div class="box-listas d-flex align-items-center justify-content-center gap-4 flex-wrap">

                <?php 
                    $listas = getAllListas($conn);

                    if (sizeof($listas) == 0) {
                        echo "<h3>Nenhuma lista encontrada</h3>";
                    } else {
                        foreach ($listas as $lista) {
                            $filmes = getFilmesInLista($conn, $lista["id"]);
                            $usuarioCriador = getUsuarioById($conn, $lista["idCriadorLista"]);

                            echo '
                                    <div class="container-lista" onclick="goToLista('.$lista["id"].')">
                                        <div class="lista">
                            ';

                            for ($i = 0; $i < 4; $i++) {
                                if ($i > count($filmes) - 1) break;

                                $filme = getFilmeById($conn, $filmes[$i]["id_filme"]);
                                echo '
                                    <div class="card-lista d-flex align-items-center justify-content-center">
                                        <img src="'.$filme["capa"].'" alt="">
                                    </div>
                                ';
                            }

                            echo '
                                        </div>
                                        <div class="div-infos-lista d-flex gap-2 px-3 pb-3">
                                            <span class="titulo-lista">'.$lista["titulo"].' -</span>
                                            <div class="">
                                                <span class="usuario-lista">por</span>
                                                <a class="link-secondary text-decoration" href="perfil.php?id='.$usuarioCriador["id"].'">'.$usuarioCriador["username"].'</a>
                                            </div>
                                        </div>
                                    </div>
                            ';
                        }
                    }
                ?>
            </div>
        </main>

        <?php
            include ('includes/footer.php'); 
        ?>
    </div>
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>