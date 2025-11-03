<?php
    include "includes/functions.php";
    include "includes/head.php";

    $conn = connect();
    $idFilmes = getFilmesInLista($conn, $_GET["id"]);
    $lista = getListaById($conn, $_GET["id"]);

    if($lista == null){
        header("location: listas.php");
        exit();
    }

    $criadorLista = getUsuarioById($conn, $lista["idCriadorLista"]);
?>
    
    <div class="container-fluid p-0">
        <?php include "includes/header.php";?>

        <?php 

            if (!isset($_COOKIE["token"]) || !getIdUsuarioByToken($conn, $_COOKIE["token"])) {
                $idUserAtual = "";
            }else{
                $idUserAtual = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
            }
            
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
                                        <?php if($criadorLista["id"] == $idUserAtual):?>
                                            <div class="d-flex align-items-center gap-3">
                                                <a href="editarLista.php?id=<?= $lista["id"] ?>" class="text-decoration-none link-light d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                                    </svg>
                                                </a>

                                                <a href="#" class="text-decoration-none link-light d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalConfirmarExcluirLista">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        <?php endif;?>
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
                            if(count($idFilmes) != 0){
                                foreach ($idFilmes as $i => $idFilme) {
                                    $filme = getFilmeById($conn, $idFilme["id_filme"]);
                                    echo '
                                        <div class="div-capa-filme-lista overflow-hidden my-3">
                                            <a href="filme.php?id='.$filme["id"].'"><img src="'.$filme["capa"].'" alt="" class="w-100 capa-filme-lista"></a>
                                        </div>
                                    ';
                                }
                            } else{
                                echo '
                                    <h3>Nenhum filme foi adicionado a essa lista ainda.</h3>
                                ';

                                if($criadorLista["id"] == $idUserAtual){
                                    echo '
                                        <p>clique no botão a baixo para explorar e adicionar novos filmes a essa lista!</p>
                                        <a href="filmes.php" class="btn btn-primary">Explorar filmes</a>
                                    ';
                                }
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
    
    <div class="modal fade" id="modalConfirmarExcluirLista" tabindex="-1" aria-labelledby="modalConfirmarExcluirListaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmarExcluirListaLabel">Confirmar exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <p>Tem certeza que deseja deletar a lista <strong><?= htmlspecialchars($lista["titulo"]) ?></strong>? Essa ação não pode ser desfeita.</p>
                </div>

                <div class="modal-footer d-flex">
                    <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger w-25" id="btnDeletarLista">Deletar</button>
                    <form method="post" id="formExluirLista">
                        <input type="hidden" name="idLista" value="<?= $lista["id"] ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/lista/salvarLista.js"></script>
    <script src="assets/js/lista/deleteLista.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>