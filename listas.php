<?php
    include "includes/functions.php";
    include "includes/head.php";
    include "includes/header.php";
?>

    <div class="container-fluid">
        <main class="mt-4 pt-4 d-flex flex-column align-items-center justify-content-center main">
            <h1>Listas</h1>
            
            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
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
                            <p class=" w-100">Criar lista</p>
                        </div>
                <?php 
                    } 
                ?>

                <?php 
                    $listas = getAllListas($conn);
                    if(sizeof($listas) == 0){
                        echo "<h3>Nenhuma lista encontrada</h3>";
                    }else{
                        foreach ($listas as $i => $lista) {
                            $filmes = getFilmesInLista($conn, $lista["id"]);
                            echo '
                                <div class="container-lista">
                                    <div class="lista" onclick="goToLista('.$lista["id"].')">
                            ';

                            for ($i=0; $i < 4; $i++) {
                                if($i >  count($filmes) - 1){
                                    break;
                                }

                                $filme = getFilmeById($conn, $filmes[$i]["id_filme"]);

                                echo '
                                    <div class="card-lista d-flex align-items-center justify-content-center" >
                                        <img src="'.$filme["capa"].'" alt="" class="w-100 h-100">
                                    </div>
                                ';
                            }

                            echo '
                                    </div>
                                    <p class=" w-100">'.$lista["titulo"].'</p>
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