<?php
    include "includes/functions.php";
    include "includes/head.php";

    $conn = connect();
    if (!isset($_COOKIE["token"]) || !getIdUsuarioByToken($conn, $_COOKIE["token"])) {
        header("Location: login.php");
        exit();
    }
?>
    <?php 
        $idComunidade = $_GET["id"];
        $comunidade = getComunidadeById($conn, $idComunidade);
        $idUsuario = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
        $usuarioCriador = getUsuarioById($conn, $comunidade["criador_id"]);
        $membro = $idUsuario ? isMembro($conn, $idComunidade, $idUsuario) : false;

        $posts = [];
        $tempPosts = getAllPostsByIdComunidade($conn, $idComunidade);

        foreach ($tempPosts as $post) {
            $usuarioPostou = getUsuarioById($conn, $post["usuario_id"]);
            $qntUpVotes = getQntUpVotes($conn, $post["id"]);
            $votouUp = votouUpPost($conn, $post["id"], $idUsuario);
            $votouDown = votouDownPost($conn, $post["id"], $idUsuario);

            $posts[] = [
                'id' => $post["id"],
                'titulo' => $post["titulo"],
                'comentario' => $post["comentario"],
                'usuario' => [
                    'id' => $usuarioPostou["id"],
                    'username' => $usuarioPostou["username"],
                    'foto' => $usuarioPostou["foto"]
                ],
                'qntUpVotes' => $qntUpVotes,
                'votouUp' => $votouUp,
                'votouDown' => $votouDown,
                'elementoPai' => $post["elemento_pai_id"]
            ];
        }

        $data = [
            'comunidade' => $comunidade,
            'usuarioCriador' => $usuarioCriador,
            'membro' => $membro,
            'idUsuario' => $idUsuario,
            'posts' => $posts
        ];
    ?>

    <div class="container-fluid p-0">
        <?php include "includes/header.php";?>
        
        <main class="">
            <section class="banner-comunidade" id="section-banner-comunidade">

            </section>
            <section class="container  position-relative">
                <div class="div-capa-comunidade overflow-hidden d-flex align-items-center justify-content-center position-absolute translate-middle badge">
                    <img src="<?= $data["comunidade"]["capa"] ?>" alt="" class="h-100">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col">
                                
                            </div>
                            <div class="col">
                                <div class="h-100 d-flex align-items-end">
                                    <div>
                                        <h3><?= $data["comunidade"]["titulo"] ?></h3>
                                        <p class="text-white-50">Criado por <span class="fw-bold"><a href="perfil.php?id=<?=$usuarioCriador["id"]?>" class="link-secondary"><?= $usuarioCriador["username"] ?></a></span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="h-100 d-flex align-items-end gap-3">
                                    <?php
                                    #mexi aqui
                                        if($data["membro"]){
                                            echo '
                                                <input type="hidden" name="idComunidade" value="'. $data["comunidade"]["id"] .'" id="inputIdComunidade">
                                                <a href="#" class="btn btn-primary w-50" id="btnPublicar" idComunidade="'. $data["comunidade"]["id"].'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                                    </svg>
                                                    publicar
                                                </a>
                                            ';

                                            if(isDonoComunidade($conn, $_GET["id"], $idUsuario)){
                                                echo '
                                                    <input type="hidden" name="idComunidade" value="'. $data["comunidade"]["id"] .  '" id="inputIdComunidade">
                                                    <a href="comunidadeEdit.php?idComunidade='.$data["comunidade"]["id"].'" class="btn btn-primary w-50" id="btnEditar" idComunidade="<?= $data["comunidade"]["id"] ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="32" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                            <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2L3 10.207V13h2.793L14 4.793 11.207 2z"/>
                                                        </svg>
                                                        editar
                                                    </a>
                                                ';
                                            } else{
                                                echo '
                                                    <a href="#" class="btn btn-primary w-50" id="btnSair">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="32" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                                                            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                                                        </svg>
                                                        sair
                                                    </a>
                                                ';
                                            }
                                        } else{
                                            echo '
                                                <input type="hidden" name="idComunidade" value="'. $data["comunidade"]["id"] .'" id="inputIdComunidade">
                                                <a href="#" class="btn btn-primary w-75" id="btnEntrarComunidade">
                                                    solicitar entrada
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-patch-plus-fill" viewBox="0 0 16 16">
                                                        <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zM8.5 6v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 1 0"/>
                                                    </svg>
                                                </a>   
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
                    <div class="col-8 d-flex flex-column gap-3" id="post-list">
                        <?php 
                            $posts = $data['posts'];
                            
                            if(sizeof($posts) > 0){
                                foreach ($posts as $i => $post) {
                                    if(!isPostRetido($conn, $post["id"])){
                                        exibirPost($post);
                                    }
                                }
                            }else{
                                echo "<h3>Nenhuma publicação foi feita neste fórum ainda.</h3>";
                            }
                        ?>
                    </div>

                    <div class="col-4">
                        <div class="div-info-comunidade p-3 text-white-50">
                            <p class="fs-4 text-white"><?= $data["comunidade"]["titulo"] ?></p>
                            <p class=""><?= $data["comunidade"]["descricao"] ?></p>
                            <p class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                </svg>
                                <?php 
                                    $dataHora = explode(' ', $comunidade["criado_em"]);
                                    $data = explode('-', $dataHora[0]);
                                    $hora = $dataHora[1];
                                    $qntUsersComunidade = getQntUsuariosComunidade($conn, $_GET["id"])["qntUsers"];
                                ?>

                                Criada em <?= $data[2] ?> de <?= numeroPraMes($data[1]) ?> de <?= $data[0] ?> <br>
                                
                                <span class="text-white"><?= $qntUsersComunidade ?></span> membros
                                <?php 
                                    if(isAdmComunidade($conn, $_GET["id"], $idUsuario) || isDonoComunidade($conn, $_GET["id"], $idUsuario)){
                                ?>
                                <a href="gerenciarComunidade.php?id=<?= $comunidade["id"] ?>" class="btn btn-2 btn-primary mt-3">Gerenciar comunidade</a>
                                <?php
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php
            include ('includes/footer.php'); 
        ?>
    </div>

    <script>
        document.getElementById('section-banner-comunidade').style.backgroundImage = 'url(<?= $comunidade["banner"]?>)';
    </script>
    <script src="assets/js/comunidade/main.js"></script>
    <script src="assets/js/comunidade/entrarComunidade.js"></script>
    <script src="assets/js/comunidade/sairComunidade.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>