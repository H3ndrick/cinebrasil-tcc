<?php
include "includes/functions.php";
include "includes/head.php";

$conn = connect();
$categoria = 'avaliacoes';

if (isset($_GET["categoria"])) {
    $categoria = $_GET["categoria"];
}

if (!isset($_COOKIE["token"]) || !getIdUsuarioByToken($conn, $_COOKIE["token"])) {
    header("Location: login.php");
    exit();
}
?>

<div class="container-fluid p-0">
    <?php
    include "includes/header.php";

    if (!isset($_GET["id"])) {
        $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
    } else {
        $idUser = $_GET["id"];
    }

    $user = getUsuarioById($conn, $idUser);
    $idLogado = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
    $isFollowing = isFollowing($conn, $idLogado, $idUser);
    $followersCount = getFollowersCount($conn, $idUser);
    $followingCount = getFollowingCount($conn, $idUser);
    ?>

    <main class="">
        <section class="banner-perfil">
        </section>
        <section class="container  position-relative">
            <div class="div-foto-perfil overflow-hidden d-flex align-items-center justify-content-center position-absolute translate-middle badge">
                <img src="<?= $user["foto"]; ?>" alt="" class="h-100" draggable="false">
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col">
                            <div class="perfil-header">
                                <div class="perfil-username">
                                    <h3><?= $user["username"]; ?></h3>
                                    <p class="perfil-bio"><?= $user["bio"]; ?></p>
                                </div>

                                <?php 
                                    if ($idUser == $idLogado):
                                ?>
                                <div class="menu-reticencias">
                                    <button class="share-button" onclick="toggleShareOptions()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-three-dots" viewBox="0 0 16 16">
                                            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                        </svg>
                                    </button>
                                    <div class="share-options" id="shareOptions">
                                        <a href="editarPerfil.php" target="">Editar perfil</a>
                                        <a href="proc/procLogout.php" target="">Sair</a>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="seguir-e-seguidores">
                                    <?php if ($idUser != $idLogado): ?>
                                        <button id="followBtn" data-id="<?= $idUser ?>" class="btn btn-sm <?= $isFollowing ? 'btn-success' : 'btn-primary' ?>">
                                            <?= $isFollowing ? 'Deixar de seguir' : 'Seguir' ?>
                                        </button>
                                    <?php endif; ?>

                                    <div class="perfil-follow-info">
                                        <span id="followersCount" data-type="followers" title="Ver seguidores"><?= $followersCount ?> seguidores</span> |
                                        <span id="followingCount" data-type="following" title="Ver seguindo"><?= $followingCount ?> seguindo</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container d-flex align-items-center justify-content-center">
                            <nav class="navbar d-flex gap-3">
                                <ul class="d-flex gap-3 align-items-center m-0">
                                    <li><a class="categoria-perfil" id="avaliacoes-perfil">Avaliacoes</a></li>
                                    <li><a class="categoria-perfil" id="comunidades-perfil">Comunidades</a></li>
                                    <li><a class="categoria-perfil" id="listas-perfil">Listas</a></li>
                                </ul>
                            </nav>
                        </div>

                        <div class="col">

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container <?= $categoria == 'avaliacoes' ? '' : "hidden"; ?>" id="linha-do-tempo">
            <div class="row pt-3">
                <div class="col-12 d-flex flex-column gap-3 align-items-center justify-content-center">
                    <?php
                    $analises = getAnalisesByIdUsuario($conn, $idUser);
                    if (sizeof($analises) > 0) {
                        foreach ($analises as $i => $analise) {
                            $filme = getFilmeById($conn, $analise["id_filme"]);
                            echo '
                                        <div class="div-form p-3 rounded-2 postagem-card">

                                            <div class="container d-flex align-items-start justify-content-between position-relative">
                            
                                                <div class="div-postagem-capa-filme">
                                                    <img class="foto-comunidade" style=" flex: 0; z-index: 10; border-radius: 15px;" src="' . $filme["capa"] . '" alt="zecaixao">
                                                </div>
                            
                                                <div class="text-white " style="min-width:460px;">
                                                    <h3 style="margin-left: 40px; margin-top: 10px;"><a href="filme.php?id=' . $filme["id"] . '" class="link-secondary link-offset-2">' . $filme["titulo"] . '</a></h3>
                                                                                    
                                                    <div style="margin-left: 40px;">
                                                        ' . gerarEstrelas($analise["nota"]) . '
                                                    </div>

                                                    <p style="margin-left: 40px; margin-top: 40px;">' . $analise["comentario"] . '</p>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    ';
                        }
                    } else {
                        echo '<h3>' . $user["username"] . ' ainda não realizou nenhuma avaliação.</h3>';
                    }
                    ?>
                </div>
            </div>
        </section>

        <section class="container d-flex flex-column align-items-center gap-4 flex-wrap pt-3 <?= $categoria == 'comunidades' ? '' : "hidden"; ?>" id="minhas-comunidades">
            <div class="">
                <?php
                $idsComunidades = getIdsComunidadesByIdUsuario($conn, $idUser);
                $comunidades = [];

                foreach ($idsComunidades as $i => $idComunidade) {
                    $comunidades[] = getComunidadeById($conn, $idComunidade["id_comunidade"]);
                }

                if ($comunidades != null) {
                    foreach ($comunidades as $i => $comunidade) {
                        $qntMembros = getQntUsuariosComunidade($conn, $comunidade["id"])["qntUsers"];
                        $criadorComunidade = getUsuarioById($conn, $comunidade["criador_id"]);

                        echo '
                                    <div class="div-form p-3 rounded-2 comunidade-card m-3">

                                        <div class="container d-flex align-items-start justify-content-between position-relative">
                                            <a href="comunidade.php?id=' . $comunidade["id"] . '">
                                                <div class="div-img-comunidade">
                                                    <img class="foto-comunidade" style=" flex: 0; z-index: 100; border-radius: 15px;" src="' . $comunidade["capa"] . '" alt="zecaixao">
                                                </div>
                                            </a>

                                            <div class="div-banner-comunidade text-white" style="background: linear-gradient(to bottom,rgba(0, 0, 0, 0.3) 0%, #242832 100%), url(' . $comunidade["banner"] . ')">
                                                <h3 style="margin-left: 40px; margin-top: 10px;"><a href="comunidade.php?id=' . $comunidade["id"] . '" class="link-light link-underline link-underline-opacity-0">' . $comunidade["titulo"] . '</a></h3>
                                                <p style="margin-left: 40px;">' . $comunidade["descricao"] . '</p>
                                                <a style="margin-left: 40px; margin-top: 30px; width: 177px; height: 44.29px; color: #5D58ED;" class="btn btn-primary text-white" href="comunidade.php?id=' . $comunidade["id"] . '">ver mais</a>
                                            
                                                <div class="d-flex">
                                                    
                                                </div>

                                                <p style="margin-left: 40px; margin-top: 30px;"> ' . $qntMembros . ' Membros | Criado por ' . $criadorComunidade["username"] . '</p>
                                            </div>

                                        </div>
                                        
                                    </div>
                                ';
                    }
                } else {
                    echo '<h3>' . $user["username"] . ' ainda não faz parte de nenhuma comunidade.</h3>';
                }

                ?>
            </div>
        </section>

        <section class="container d-flex flex-column align-items-center gap-4 flex-wrap pt-3 <?= $categoria == 'listas' ? '' : "hidden"; ?>" id="minhas-listas">
            <h2>Listas de <?= $user["username"] ?></h2>
            <div class="d-flex align-items-center gap-4 flex-wrap">
                <?php if ($idUser == $idLogado): ?>
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
                <?php endif;?>
                <?php
                $listas = getListasByIdUsuario($conn, $idUser);

                foreach ($listas as $i => $lista) {
                    $filmes = getFilmesInLista($conn, $lista["id"]);
                    echo '
                                <div class="container-lista">
                                    <div class="lista" onclick="goToLista(' . $lista["id"] . ')">
                            ';

                    for ($i = 0; $i < 4; $i++) {
                        if ($i > sizeof($filmes)  - 1) {
                            break;
                        }
                        $filme = getFilmeById($conn, $filmes[$i]["id_filme"]);

                        echo '
                                    <div class="card-lista d-flex align-items-center justify-content-center">
                                        <img src="' . $filme["capa"] . '" alt="" class="w-100 h-100">
                                    </div>
                                ';
                    }

                    echo '
                                </div>
                                    <p class=" w-100">' . $lista["titulo"] . '</p>
                                </div>
                            ';
                }
                ?>
            </div>

            <h2>Listas Salvas de <?= $user["username"] ?></h2>

            <div class="d-flex align-items-center gap-4 flex-wrap">
                <?php
                $idListas = getListasSalvas($conn, $idUser);
                if (sizeof($idListas) == 0) {
                    echo "<h3>Nenhuma lista salva</h3>";
                } else {
                    foreach ($idListas as $i => $idLista) {
                        $lista = getListaById($conn, $idLista["id_lista"]);
                        $filmes = getFilmesInLista($conn, $idLista["id_lista"]);

                        echo '
                                    <div class="container-lista">
                                        <div class="lista" onclick="goToLista(' . $lista["id"] . ')">
                                ';

                        for ($i = 0; $i < 4; $i++) {
                            if ($i > sizeof($filmes)  - 1) {
                                break;
                            }
                            $filme = getFilmeById($conn, $filmes[$i]["id_filme"]);

                            echo '
                                        <div class="card-lista d-flex align-items-center justify-content-center">
                                            <img src="' . $filme["capa"] . '" alt="" class="w-100 h-100">
                                        </div>
                                    ';
                        }

                        echo '
                                        </div>
                                        <p class=" w-100">' . $lista["titulo"] . '</p>
                                    </div>
                                ';
                    }
                }
                ?>
            </div>
        </section>
    </main>

    <?php
        include ('includes/footer.php'); 
    ?>
</div>

<script>
    function toggleShareOptions() {
        const shareOptions = document.getElementById('shareOptions');
        shareOptions.classList.toggle('visible');
    }

    document.addEventListener('click', function(e) {
        const shareContainer = document.querySelector('.share-container');
        const shareOptions = document.getElementById('shareOptions');
        if (!shareContainer.contains(e.target)) {
            shareOptions.classList.remove('visible');
        }
    });
</script>

<script src="assets/js/main.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    document.getElementById('followBtn')?.addEventListener('click', function() {
        const button = this;
        const userId = button.getAttribute('data-id');
        const action = button.textContent.trim() === 'Seguir' ? 'follow' : 'unfollow';

        fetch('proc/followUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'idPerfil=' + userId + '&action=' + action
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.action === 'follow') {
                        button.textContent = 'Deixar de seguir';
                        button.classList.remove('btn-primary');
                        button.classList.add('btn-success');
                    } else {
                        button.textContent = 'Seguir';
                        button.classList.add('btn-primary');
                        button.classList.remove('btn-success');
                    }
                    document.getElementById('followersCount').textContent = data.followers + ' seguidores';
                    document.getElementById('followingCount').textContent = data.following + ' seguindo';
                } else {
                    alert('Erro: ' + data.message);
                }
            })

    });
</script>



</body>

</html>