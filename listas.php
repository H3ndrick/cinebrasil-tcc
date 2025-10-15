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