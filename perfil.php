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
<link rel="stylesheet" href="assets/css/listas-style.css">
<div class="container-fluid p-0">
    <?php

    if (!isset($_GET["id"])) {
        $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
        $idUser = $idUser["id_usuario"];
    } else {
        $idUser = $_GET["id"];
    }

    $user = getUsuarioById($conn, $idUser);
    if($user == null){
        header("location: index.php");
        exit();
    }

    include "includes/header.php";

    if (!isset($_GET["id"])) {
        $idUser = getIdUsuarioByToken($conn, $_COOKIE["token"]);
        $idUser = $idUser["id_usuario"];
    } else {
        $idUser = $_GET["id"];
    }

    $idLogado = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
    $isFollowing = isFollowing($conn, $idLogado, $idUser);
    $followersCount = getFollowersCount($conn, $idUser);
    $followingCount = getFollowingCount($conn, $idUser);
    $usuarioLogado = getUsuarioById($conn, $idLogado);
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
                                <div class="menu-reticencias share-container">
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
                                        <span id="followersCount" data-type="followers" title="Ver seguidores"><a class="categoria-perfil" id="seguidores-perfil"><?= $followersCount ?> seguidores</a></span> |
                                        <span id="followingCount" data-type="following" title="Ver seguindo"><a class="categoria-perfil" id="seguindo-perfil"><?= $followingCount ?> seguindo</a></span>
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
                    <div class="div-infos-lista d-flex gap-2 px-3 pb-3">
                        <span class="titulo-lista">Criar Lista</span>
                    </div>
                </div>
                <?php endif;?>
                <?php
                $listas = getListasByIdUsuario($conn, $idUser);
                
                foreach ($listas as $i => $lista) {
                    $filmes = getFilmesInLista($conn, $lista["id"]);
                    $usuarioCriador = getUsuarioById($conn, $lista["idCriadorLista"]);
                    echo '
                                <div class="container-lista" onclick="goToLista(' . $lista["id"] . ')">
                                    <div class="lista">
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
        
        <section class="container d-flex flex-column align-items-center gap-4 flex-wrap <?= $categoria == 'seguidores' ? '' : "hidden"; ?>" id="seguidores">
            <div class="w-100" id="container-seguidores">
                <h3 class="text-white text-center mb-4">Seguidores</h3>
                <?php
                    $idsUsuariosSeguidores = getFollowersIds($conn, $idUser);
                    $usuariosSeguidores = [];

                    foreach ($idsUsuariosSeguidores as $i => $idUsuario) {
                        $usuariosSeguidores[] = getUsuarioById($conn, $idUsuario["id_usuario_seguidor"]);
                    }

                    if ($usuariosSeguidores != null) {
                        echo '<div class="row g-3 justify-content-center" id="div-seguidores">';
                        foreach ($usuariosSeguidores as $i => $usuarioSeguidor) {
                            echo '
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3" id="card-'.$usuarioSeguidor["id"].'">
                                    <div class="card bg-dark text-white border-0 shadow-sm h-100 seguindo-card">
                                        <div class="card-body text-center p-3">
                                            <div class="mb-3">
                                                <img src="' . $usuarioSeguidor["foto"] . '" 
                                                    alt="' . $usuarioSeguidor["username"] . '" 
                                                    class="rounded-circle seguindo-avatar"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            </div>
                                            <h5 class="card-title mb-2">' . $usuarioSeguidor["username"] . '</h5>
                                            <a href="perfil.php?id=' . $usuarioSeguidor["id"] . '" 
                                            class="btn btn-outline-light btn-sm mt-2">
                                                Ver Perfil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                        echo '</div>';
                    } else {
                        echo '
                            <div class="text-center text-white py-5" id="div-nao-tem-seguidores">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-people mb-3 opacity-50" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                </svg>
                                <h4 class="opacity-75">' . $user["username"] . ' ainda não é seguido por ninguém.</h4>
                                <p class="opacity-50">Quando alguém seguir este perfil, aparecerá aqui.</p>
                            </div>
                        ';
                    }
                ?>
            </div>
        </section>

        <section class="container d-flex flex-column align-items-center gap-4 flex-wrap <?= $categoria == 'seguindo' ? '' : "hidden"; ?>" id="seguindo">
            <div class="w-100">
                <h3 class="text-white text-center mb-4">Seguindo</h3>
                <?php
                    $idsUsuariosSeguindo = getFollowingIds($conn, $idUser);
                    $usuariosSeguindo = [];

                    foreach ($idsUsuariosSeguindo as $i => $idUsuario) {
                        $usuariosSeguindo[] = getUsuarioById($conn, $idUsuario["id_usuario_seguindo"]);
                    }

                    if ($usuariosSeguindo != null) {
                        echo '<div class="row g-3 justify-content-center">';
                        foreach ($usuariosSeguindo as $i => $usuarioSeguindo) {
                            echo '
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3"">
                                    <div class="card bg-dark text-white border-0 shadow-sm h-100 seguindo-card">
                                        <div class="card-body text-center p-3">
                                            <div class="mb-3">
                                                <img src="' . $usuarioSeguindo["foto"] . '" 
                                                    alt="' . $usuarioSeguindo["username"] . '" 
                                                    class="rounded-circle seguindo-avatar"
                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                            </div>
                                            <h5 class="card-title mb-2">' . $usuarioSeguindo["username"] . '</h5>
                                            <a href="perfil.php?id=' . $usuarioSeguindo["id"] . '" 
                                            class="btn btn-outline-light btn-sm mt-2">
                                                Ver Perfil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                        echo '</div>';
                    } else {
                        echo '
                            <div class="text-center text-white py-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-people mb-3 opacity-50" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                </svg>
                                <h4 class="opacity-75">' . $user["username"] . ' ainda não segue ninguém.</h4>
                                <p class="opacity-50">Quando esse perfil seguir alguém, aparecerá aqui.</p>
                            </div>
                        ';
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

                        const existeDivSeguidores = document.querySelector('#container-seguidores #div-seguidores') !== null;

                        if (existeDivSeguidores) {
                            console.log('A div div-seguidores existe dentro de container-seguidores');
                            document.getElementById('div-seguidores').innerHTML += `
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3" id="card-<?= $usuarioLogado["id"] ?>">
                                    <div class="card bg-dark text-white border-0 shadow-sm h-100 seguindo-card">
                                        <div class="card-body text-center p-3">
                                            <div class="mb-3">
                                                <img src="<?= $usuarioLogado["foto"] ?>" alt="<?= $usuarioLogado["username"] ?>'" class="rounded-circle seguindo-avatar" style="width: 80px; height: 80px; object-fit: cover;">
                                            </div>
                                            <h5 class="card-title mb-2"><?= $usuarioLogado["username"] ?></h5>
                                            <a href="perfil.php?id=<?=$usuarioLogado["id"]?>" class="btn btn-outline-light btn-sm mt-2">
                                                Ver Perfil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        } else {
                            console.log('A div div-seguidores NÃO existe dentro de container-seguidores');
                            document.getElementById('container-seguidores').removeChild(document.getElementById('div-nao-tem-seguidores'));
                            document.getElementById('container-seguidores').innerHTML = `
                                <div class="row g-3 justify-content-center" id="div-seguidores">
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3" id="card-<?= $usuarioLogado["id"] ?>">
                                        <div class="card bg-dark text-white border-0 shadow-sm h-100 seguindo-card">
                                            <div class="card-body text-center p-3">
                                                <div class="mb-3">
                                                    <img src="<?= $usuarioLogado["foto"] ?>" 
                                                        alt="<?= $usuarioLogado["username"] ?>'" 
                                                        class="rounded-circle seguindo-avatar"
                                                        style="width: 80px; height: 80px; object-fit: cover;">
                                                </div>
                                                <h5 class="card-title mb-2"><?= $usuarioLogado["username"] ?></h5>
                                                <a href="perfil.php?id=<?= $usuarioLogado["id"] ?>" class="btn btn-outline-light btn-sm mt-2">
                                                    Ver Perfil
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }

                    } else {
                        let divSeguidores = document.getElementById('div-seguidores')
                        let containerSeguidores = document.getElementById('container-seguidores');
                        button.textContent = 'Seguir';
                        button.classList.add('btn-primary');
                        button.classList.remove('btn-success');
                        divSeguidores.removeChild(document.getElementById('card-<?= $usuarioLogado["id"] ?>'));

                        if(divSeguidores.children.length == 0){
                            containerSeguidores.removeChild(divSeguidores);
                            containerSeguidores.innerHTML = `
                                <div class="text-center text-white py-5" id="div-nao-tem-seguidores">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-people mb-3 opacity-50" viewBox="0 0 16 16">
                                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                    </svg>
                                    <h4 class="opacity-75"><?= $user["username"] ?> ainda não é seguido por ninguém.</h4>
                                    <p class="opacity-50">Quando alguém seguir este perfil, aparecerá aqui.</p>
                                </div>
                            `;

                        }
                    }
                    document.getElementById('seguidores-perfil').textContent = data.followers + ' seguidores';
                    document.getElementById('seguindo-perfil').textContent = data.following + ' seguindo';
                } else {
                    alert('Erro: ' + data.message);
                }
            })

    });
</script>

<style>
.seguindo-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.05) !important;
    backdrop-filter: blur(10px);
}

.seguindo-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.seguindo-avatar {
    border: 3px solid rgba(255, 255, 255, 0.1);
    transition: border-color 0.2s ease;
}

.seguindo-card:hover .seguindo-avatar {
    border-color: rgba(255, 255, 255, 0.3);
}

.btn-outline-light {
    border-width: 1px;
    transition: all 0.2s ease;
}

.btn-outline-light:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.3);
}
</style>

</body>

</html>