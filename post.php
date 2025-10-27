<?php
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include "includes/functions.php";
    include "includes/head.php";
?>
    <?php 
        $conn = connect();
        $idUsuario = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
        $idPost = $_GET["idPost"];

        $tempPost = getPostById($conn, $idPost);
        $usuarioPostou = getUsuarioById($conn, $tempPost["usuario_id"]);
        $qntUpVotes = getQntUpVotes($conn, $tempPost["id"]);
        $votouUp = votouUpPost($conn, $tempPost["id"], $idUsuario);
        $votouDown = votouDownPost($conn, $tempPost["id"], $idUsuario);

        $comunidade_id = $tempPost["comunidade_id"];
        $comunidade = getComunidadeById($conn, $comunidade_id);

        $comentariosTemp = getComentariosByIdElementoPai($conn, $idPost);
        $comentarios = array();
        foreach ($comentariosTemp as $comentario) {
            $usuarioPostouComentario = getUsuarioById($conn, $comentario["usuario_id"]);
            $comentarios[] = [
                'id' => $comentario["id"],
                'titulo' => $comentario["titulo"],
                'comentario' => $comentario["comentario"],
                'usuario' => [
                    'id' => $comentario["usuario_id"],
                    'username' => $usuarioPostouComentario["username"],
                    'foto' => $usuarioPostouComentario["foto"]
                ]
            ];
        }

        $post = [
            'id' => $tempPost["id"],
            'titulo' => $tempPost["titulo"],
            'comentario' => $tempPost["comentario"],
            'usuario' => [
                'id' => $usuarioPostou["id"],
                'username' => $usuarioPostou["username"],
                'foto' => $usuarioPostou["foto"]
            ],
            'qntUpVotes' => $qntUpVotes,
            'votouUp' => $votouUp,
            'votouDown' => $votouDown
        ];

        $data = [
            'post' => $post,
            'comunidade' => $comunidade,
            'comentarios' => $comentarios
        ];
    ?>

    <div class="container-fluid p-0">
        <?php include "includes/header.php";?>

        <main class="mt-4 pt-4">
            <section class="container">
                <div class="row">
                    <div class="col">
                        <div id="post">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex align-items-start gap-2">
                                        <img src="<?= $data["post"]["usuario"]["foto"]?>" alt="" class="fotoPerfilPost">
                                        <div class="d-flex flex-column">
                                            <span class="nomeUsuario"><a href="perfil.php?id=<?=$data["post"]["usuario"]["id"]?>" class="link-secondary"><?= $data["post"]["usuario"]["username"]?></a></span>
                                            <span><a href="comunidade.php?id=<?=$data["comunidade"]["id"]?>">comunidade/<?= $data["comunidade"]["titulo"]?></a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-11">
                                    <div class="conteudoPost px-3 py-1">
                                        <div class="borda-post p-2">
                                            <h1><?= $data["post"]["titulo"]?></h1>
                                        
                                            <div>
                                                <?= $data["post"]["comentario"] ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="px-3">
                                        <div class="d-flex gap-3 align-items-center p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-square-dots" viewBox="0 0 16 16" role="button" id="btn-comentar">
                                                <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                            </svg>
                                            <input type="hidden" id="idComunidadeInput" name="idComunidade" value="<?= $comunidade["id"]?>">
                                            <?php 
                                                if($tempPost["usuario_id"] == $idUsuario){
                                                    echo '
                                                        <form id="formExcluirPost" method="post">
                                                            <input type="hidden" name="idPost" value="'.$data['post']['id'].'">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16" role="button" onclick="deletePost('.$data['post']['id'].')">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                            </svg>
                                                        </form>
                                                    ';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <form action="" method="post" class="pt-3 hidden" id="formComentario">
                                        <input type="hidden" name="idComunidade" value="<?= $comunidade["id"]?>">
                                        <input type="hidden" name="idElementoPai" value="<?= $data["post"]["id"]?>">
                                        <div class="mb-3">
                                            <input type="text" name="comentario" id="comentario" class="form-control" placeholder="Escreva seu comentário">
                                            <div class="error" id="comentarioError"></div>
                                        </div>

                                        <div class="d-flex py-3 align-items-center justify-content-start">                    
                                            <button class="btn btn-primary rounded-pill w-25" id="btnCriarPublicacao">Comentar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class='mt-3'>
                                        <h3>Comentarios:</h3>
                                        <div class="comentarios pt-3 d-flex flex-column gap-4">
                                            <?php 
                                                if(sizeof($data["comentarios"]) > 0){
                                                    foreach ($data["comentarios"] as $i => $comentario) {?>
                                                        <div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="d-flex align-items-start gap-2">
                                                                        <img src="<?= $comentario["usuario"]["foto"]?>" alt="" class="fotoPerfilPost">
                                                                        <div class="d-flex flex-column">
                                                                            <span class="nomeUsuario"><a href="perfil.php?id=<?= $comentario["usuario"]["id"]?>" class="link-secondary"><?= $comentario["usuario"]["username"]?></a></span>
                                                                            <span><a href="comunidade.php?id=<?=$data["comunidade"]["id"]?>">comunidade/<?= $data["comunidade"]["titulo"]?></a></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-11">
                                                                    <div class="conteudoPost px-3 py-1">
                                                                        <div class="borda-post p-2">
                                                                            <h1><?= $comentario["titulo"]?></h1>
                                                                        
                                                                            <div>
                                                                                <?= $comentario["comentario"] ?>
                                                                            </div>

                                                                            <?php 
                                                                                if($comentario["usuario"]["id"] == $idUsuario){
                                                                                    echo '
                                                                                        <form id="formExcluirPost" method="post">
                                                                                            <input type="hidden" name="idPost" value="'.$data['post']['id'].'">
                                                                                            <input type="hidden" name="idComunidade" value="'.$comunidade['id'].'">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16" role="button" onclick="deletePost('.$comentario['id'].')">
                                                                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                                                            </svg>
                                                                                        </form>
                                                                                    ';
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                            <?php 
                                                    } 
                                                } else{
                                                    echo "<h3 class='text-center'>Seja o primeiro a comentar nesse post.</h3>";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </section>
        </main>
        <?php
        include ('includes/footer.php'); 
        ?>
    </div>

    <script src="assets/js/comunidade/createComentario.js"></script>
    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <!-- Initialize Quill editor -->
    <script>
        document.getElementById('btn-comentar').addEventListener('click', () => {
            document.getElementById('formComentario').classList.remove('hidden');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="assets/js/comunidade/deletePost.js"></script>

</body>
</html>