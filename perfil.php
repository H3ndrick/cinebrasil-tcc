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
    $usuarioLogado = getUsuarioById($conn, $idLogado);
    ?>

    <main class="">
        <section class="banner-perfil">
        </section>
        <section class="container  position-relative">
            <div style="object-fit: cover;" class="div-foto-perfil overflow-hidden d-flex align-items-center justify-content-center position-absolute translate-middle badge">
                <img src="<?= $user["foto"]; ?>" alt="" class="h-100 rounded-circle seguindo-avatar" style="object-fit: cover; " draggable="false">
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
                                        <span id="followersCount" data-type="followers" title="Ver seguidores"><a class="categoria-perfil" id="seguidores-perfil"><?= $followersCount ?> seguidores</a></span> |
                                        <span id="followingCount" data-type="following" title="Ver seguindo"><a class="categoria-perfil" id="seguindo-perfil"><?= $followingCount ?> seguindo</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container d-flex align-items-center justify-content-center">
                            <nav class="navbar d-flex gap-3">
                                <ul class="d-flex gap-3 align-items-center m-0">
                                    <li><a class="categoria-perfil" id="avaliacoes-perfil">Avaliações</a></li>
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

                        $capa = !empty($comunidade["capa"]) ? $comunidade["capa"] : "assets/img/comunidades/default-avatar.jpg";
                            $banner = !empty($comunidade["banner"]) ? $comunidade["banner"] : "assets/img/comunidades/default-banner.jpg";

                        echo '
                        <div class="comunidade-card" style="margin-top: 25px;">

                        <a style="text-decoration: none;" href="comunidade.php?id='.$comunidade["id"].'">

                            <div class="comunidade-banner" style="background: url('.$banner.')"></div>
                            
                            <div class="comunidade-content">
                                <div class="comunidade-avatar">
                                
                                            
                                        
                                    <img class="avatar-img" src="'. $capa .'" alt="'.$comunidade["titulo"].'">
                                    
                                </div>

                                <div class="comunidade-info text-white">
                                    <div class="card-header">
                                    <h3 class="comunidade-title">'.$comunidade["titulo"].'</h3>
                                        <p class="comunidade-description">'.$comunidade["descricao"].'</p>
                                    </div>
                                    
                                    <div class="card-footer">
                                        <div class="comunidade-meta">
                                            <span class="meta-item">
                                                <i class="fas fa-users"></i>
                                                '.$qntMembros.' Membros
                                            </span>
                                            <span class="meta-item">|</span>
                                            <span class="meta-item">
                                                Criado por '.$criadorComunidade["username"].'
                                            </span>
                                        </div>
                                        <a class="btn-comunidade" href="comunidade.php?id='.$comunidade["id"].'">
                                            Ver mais
                                        </a>
                                    </div>
                                </div>
                            </div>
                            </a>
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
    object-fit: cover;
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
<style>

        

        /* Fundo e texto */ 
        body {
            background-color: #121217;
            color: #e0e0e0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.6;
        }

        .container-fluid{
            padding: 0;
            margin: 0;
        }

        /* Main Container */
        .main {
            padding: 40px 20px;
            background: var(--background);
            min-height: 100vh;
            
        }

        /* Título Principal */
        .page-title {
            font-size: 2.8rem;
            font-weight: 700;
            color: #a78bfa;
            margin-bottom: 2rem;
            letter-spacing: 1.2px;
            text-align: center;
        }

        /* Container das comunidades em linhas */
        .comunidades-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            max-width: 1000px;
            margin: 0 auto;
            padding-bottom: 3rem;
        }

        /* Card de comunidade individual */
        .comunidade-card {
            display: flex;
            background-color: #1e1e2f;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(98, 92, 255, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            min-height: 200px;
            position: relative;
        }

        .comunidade-card:hover {
            transform: translateY(-2px);
            box-shadow: 3px 5px 12px rgba(98, 92, 255, 0.3);
        }

        /* Banner como fundo de todo o card */
        .comunidade-banner {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            z-index: 1;
        }

        .comunidade-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(30, 30, 47, 0.7) 40%, rgba(47, 79, 229, 0.3) 150%);
        }

        /* Container do conteúdo (sobre o banner) */
        .comunidade-content {
            position: relative;
            z-index: 2;
            display: flex;
            width: 100%;
            min-height: 200px;
        }

        /* Avatar da comunidade (lado esquerdo) */
        .comunidade-avatar {
            flex: 0 0 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        .avatar-img {
            width: 160px;
            height: 160px;
            border-radius: 5px;
            object-fit: cover;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        /* Informações da comunidade (lado direito) */
        .comunidade-info {
            flex: 1;
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }

        /* Header do card */
        .card-header {
            margin-bottom: 15px;
        }

        .comunidade-title {
            font-size: 1.6rem;
            color: white;
            font-weight: 700;
            margin: 0 0 12px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .comunidade-title a {
            color: white;
            text-decoration: none;
        }

        .comunidade-description {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.5;
            margin: 0;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        /* Footer do card */
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .comunidade-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        /* Botões */
        .btn-comunidade {
            background: white;
            color: #3455fb !important;
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-comunidade:hover {
            background: #f8f9fa;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            color: rgba(18, 18, 23) !important;
        }

        /* Card de criar comunidade especial */
        .create-card {
            border: 2px  #5D58ED;
            background: linear-gradient(135deg, #rgba(36, 64, 174), black);
        }

        .create-card .comunidade-banner {
            display: none;
        }

        .create-card .comunidade-avatar {
            background: linear-gradient(135deg, #222430, rgba(36, 64, 174), #3455fb);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .create-card .avatar-img {
            display: none;
        }

        .create-card .comunidade-avatar::before {
            content: '+';
            font-size: 3.5rem;
            color: white;
            font-weight: 300;
        }

    

        .create-card .comunidade-info {
            background: none;
        }

        /* Estados Vazios */
        .empty-state {
            text-align: center;
            padding: 60px 40px;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: 0 4px 12px rgba(98, 92, 255, 0.15);
            max-width: 500px;
            margin: 0 auto;
        }

        .empty-state i {
            font-size: 3rem;
            color: #a78bfa;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #cfcfff;
            margin-bottom: 15px;
        }

        .empty-state p {
            color: #a0a0c0;
            margin-bottom: 25px;
        }

        /* Layout Responsivo */
        @media (max-width: 768px) {
            

            .comunidade-card {
                flex-direction: column;
                min-height: auto;
            }
            
            .comunidade-content {
                flex-direction: column;
            }
            
            .comunidade-avatar {
                flex: none;
                padding: 20px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                
            }
            
            .avatar-img {
                width: 120px;
                height: 120px;
                
            }
            
            .comunidade-info {
                padding: 20px;
            }
            
            .card-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .comunidade-meta {
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .comunidade-title {
                font-size: 1.4rem;
            }
            .perfil-follow-info{
                margin-right: -100px;
                margin-top: 90px;
                max-width: 300px;
             }

            .perfil-username{
                margin-left: -100px;
                
             }
            .div-foto-perfil{
                margin-left: 40px;
                
              }
        }

            

        @media (max-width: 480px) {
            .main {
                padding: 20px 15px;
            }
            
            .page-title {
                font-size: 2.2rem;
            }
            
            .comunidade-info {
                padding: 15px;
            }
            
            .comunidade-title {
                font-size: 1.3rem;
            }
            
            .comunidade-description {
                font-size: 0.9rem;
            }
            
            .comunidade-avatar {
                flex: 0 0 150px;
            }
            
            .avatar-img {
                width: 100px;
                height: 100px;
            }
            .perfil-follow-info{
                margin-right: -100px;
                margin-top: 90px;
                max-width: 300px;
             }

            .perfil-username{
                margin-left: -100px;
                
             }
            .div-foto-perfil{
                margin-left: 40px;
                
              }
        }

        
    </style>
</html>