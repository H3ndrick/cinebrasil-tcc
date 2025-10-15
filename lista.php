<?php
    include "includes/functions.php";
    include "includes/head.php";
?>
    
    <div class="container-fluid p-0">
        <?php include "includes/header.php";?>

        <?php 
            $idFilmes = getFilmesInLista($conn, $_GET["id"]);
            $lista = getListaById($conn, $_GET["id"]);
            $criadorLista = getUsuarioById($conn, $lista["idCriadorLista"]);
        ?>
        <main class="pt-4">
            <section class="container  position-relative pt-4 mt-4">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col">
                                <div class="h-100 d-flex align-items-end">
                                    <div>
                                        <h3><?= $lista["titulo"] ?></h3>
                                        <p class="text-white-50">Criado por <span class="fw-bold"><a href="perfil.php?id=<?= $criadorLista["id"] ?>"><?= $criadorLista["username"] ?></a></span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="h-100 d-flex align-items-end">
                                    <?php
                                        if(isset($_COOKIE["token"])){
                                            $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
                                            $idsListasBanco = getListasSalvas($conn, $idUser["id_usuario"]);

                                            $idsListas = [];
                                            foreach ($idsListasBanco as $i => $idLista) {
                                                array_push($idsListas, $idLista["id_lista"]);
                                            }

                                            $isSalva = false;

                                            if(in_array($lista["id"], $idsListas)){
                                                $isSalva = true;
                                            }

                                            echo '
                                                <input type="hidden" name="idLista" value="'.$_GET["id"].'" id="idLista">

                                                <button href="#" class="btn btn-primary w-25 '.($isSalva ? "hidden": "").'" id="btnSalvarLista">
                                                    salvar
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                                                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                                    </svg>
                                                </button>
                                                
                                                <button href="#" class="btn btn-primary w-25 '.($isSalva ? "": "hidden").'" id="btnRemoverListaSalva">
                                                    salvo
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check-fill" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5m8.854-9.646a.5.5 0 0 0-.708-.708L7.5 7.793 6.354 6.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
                                                    </svg>
                                                </button>
                                            ';

                                        } else{
                                            echo '
                                                <a href="login.php" class="btn btn-primary">Login para salvar lista</a>
                                            ';
                                        }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="container">
                <div class="row pt-3">
                    <p class="text-white-50"><?= $lista["descricao"] ?></p>
                </div>
                <div class="row pt-3">
                    <span class="text-white-50 p-0"><?= count($idFilmes) ?> filmes</span>
                    <div class="col-9 border-top border-secondary py-3 d-flex flex-wrap gap-3">
                        <?php 
                            foreach ($idFilmes as $i => $idFilme) {
                                $filme = getFilmeById($conn, $idFilme["id_filme"]);
                                echo '
                                    <div class="div-capa-filme-lista overflow-hidden my-3">
                                        <a href="filme.php?id='.$filme["id"].'"><img src="'.$filme["capa"].'" alt="" class="w-100 capa-filme-lista"></a>
                                    </div>
                                ';
                            }
                        ?>
                    </div>
                </div>
            </section>
        </main>
        <?php
            include ('includes/footer.php'); 
        ?>
    </div>
    
    <script src="assets/js/lista/salvarLista.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>