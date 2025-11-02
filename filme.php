<?php
    include "includes/functions.php";
    include "includes/head.php";
    $conn = connect();
    
    $idFilme = 1;
    
    if(!isset($_GET["id"])){
        $idFilme = 1;
    }else{
        $idFilme = $_GET["id"];
    }

    $filme = getFilmeById($conn, $idFilme);
    $isAdm = false;
    
    if(isset($_COOKIE["token"])){
        $idUsuario = getIdUsuarioByToken($conn, $_COOKIE["token"]);
        $isAdm = isAdm($conn, $idUsuario["id_usuario"]);
    }
    

?>
    <input type="hidden" name="idAdm" value="<?= $isAdm ?>" id="isAdmInput">
    <div class="container-fluid p-0">
        <?php include "includes/header.php";?>

        <main class="">
            <input type="hidden" name="idFilme" value="<?= $idFilme?>" id="inputIdFilme">
            <section class="banner-filme" id="banner-filme">

            </section>
            <div class="container">
                <section class="d-flex gap-3 position-relative">

                    <div class="div-capa-filme overflow-hidden d-flex align-items-center justify-content-center position-absolute translate-middle badge">
                        <img src="<?= $filme["capa"] ?>" alt="" class="w-100" draggable="false">
                    </div>

                    
    
                    <div class="d-flex gap-3 position-relative" id="div-infos-filmes">
                        <div class="w-50">
                            <div class="div-info-filme">
                                <div>
                                    <?php  $dataLancamento = explode('-', $filme["dataDeLancamento"]);?>
                                    <h2><?= $filme["titulo"] ?></h2>
                                    <p></p>
                                    <p>Lançado em <?= $dataLancamento[2] ?> de <?= numeroPraMes($dataLancamento[1]) ?> de <?= $dataLancamento[0] ?></p>
                                </div>
                                
                                <?php if(isset($idUsuario)): ?>
                                    <button type="button" class="div-icone-analises btn-adicionar-lista d-flex align-items-center justify-content-center gap-2 p-2" data-bs-toggle="modal" data-bs-target="#modalAdicionarLista">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-task" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5zM3 3H2v1h1z"/>
                                            <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1z"/>
                                            <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5zM2 7h1v1H2zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm1 .5H2v1h1z"/>
                                        </svg>    
                                        Adicionar à lista
                                    </button>

                                    <div class="modal fade" id="modalAdicionarLista" tabindex="-1" aria-labelledby="modalAdicionarListaLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content bg-dark text-white">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalAdicionarListaLabel">Adicionar filme às listas</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div id="listasUsuarioContainer" class="scrollable-div">
                                                        <!-- Aqui serão listadas dinamicamente as listas com checkboxes -->
                                                        <p>Carregando listas...</p>
                                                    </div>

                                                    <hr>

                                                    <div>
                                                        <input type="text" id="novaListaTitulo" class="form-control" placeholder="Criar nova lista">
                                                        <div class="error" id="tituloNovaListaError"></div>
                                                        <button class="btn btn-success mt-2 w-25 d-flex align-items-center justify-content-center gap-2" id="btnCriarLista">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                                                            </svg>
                                                            Criar lista
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <div class="modal-footer d-flex gap-3">
                                                    <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="button" class="btn btn-secondary" id="btnSalvarListas">Salvar alterações</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <a href="login.php" class="btn btn-primary">Login para adicionar a lista</a>
                                <?php endif; ?>
                            
                            </div>
                                
        
                            <p>
                                <span>Sinopse</span><br>
                                <?= $filme["sinopse"] ?>
                            </p>
        
                            <hr>
        
                            <div class="border border-secondary text-secondary div-icone-analises">
                                <a href="#container-avaliacoes-filme" style="color: inherit; text-decoration: none;" class="rolar-baixo d-flex gap-2 align-items-center ">
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-text-left" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                                        </svg>
                                    </div>
                                    <span id="qntAnalises"> analises</span>
                                </a>
                            </div>
        
                            <div class="p-2 d-flex flex-column div-media-avaliacoes align-items-center justify-content-center">
                                <div class="text-center">
                                    <h3 style="font-size:24px">Média Avaliações</h3>
                                    <h2 class="text-white" id="mediaAvaliacoes">4.3</h2>
                                    <div></div>
                                </div>
            
                                <canvas id="graficoMediaAvaliacoes" style="height:150px; width: 250px;" class=""></canvas>
                            </div>
                        </div>
                        
                        <div class="mt-2">
                            <input type="hidden" name="idUsuarioLogado" value="<?= $idUsuario["id_usuario"] ?>" id="idUsuarioLogado">
                            <?php 
                                if(!isset($_COOKIE["token"])){
                            ?>
                                <a href="login.php" class="text-decoration-none text-white btn btn-primary">Login para avaliar</a>
                                
                            <?php
                                } else{
                                    $idUsuario = getIdUsuarioByToken($conn, $_COOKIE["token"]);
                                    $idUsuario = $idUsuario["id_usuario"];
                            ?>  

                                    <div id="containerAvaliacaoUsuario">
                                        <?php 
                                            
                                            if(jaAnalisei($conn, $idFilme, $idUsuario)){
                                                $analise = getAnaliseById($conn, $idFilme, $idUsuario);
                                                $usuario = getUsuarioById($conn, $idUsuario);
                                                if(! isAnaliseRetida($conn, $idFilme, $idUsuario)){
                                                    echo '
                                                        <div class="bg-gradient-dark px-3" id="containerMinhaAnalise">
                                                            <h3>Minha análise:</h3>
                                                            <div class=" d-flex gap-3 align-items-center justify-content-center pt-2">
                                                                <div class="divFotoPerfil">
                                                                    <img src="'.$usuario["foto"].'" alt="foto de perfil de disk água SJ" class="foto-perfil">
                                                                </div>
                                                                <div class="comentario">
                                                                    <div class="infosUsuario">
                                                                        <span class="nomeUsuario"><a href="perfil.php" class="link-secondary">'.$usuario["username"].'</a></span>
                                                                        <p class="AvaliacaoUsuario" id="avaliacao-minha-analise">'.gerarEstrelas($analise["nota"]).'</p>
                                                                    </div>

                                                                    <div class="infosAnalise">
                                                                        <p class="texto-minha-analise" id="texto-minha-analise">'.$analise["comentario"].'</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="py-2 d-flex align-items-center justify-content-start gap-3">
                                                                <button class="btn btn-2 btn-excluir btn-primary" onclick="mostrarConfirmarExluir()">Excluir</button>
                                                                <button class="btn btn-editar btn-primary" onclick="mostrarEditar('.$filme["id"].')">Editar</button>
                                                            </div>
                                                        </div>
                                                    ';
                                                } else{
                                                    echo '
                                                        <div class="bg-gradient-dark px-3 py-3" id="containerMinhaAnalise">
                                                            <h3>Minha análise:</h3>
                                                            <div class=" d-flex gap-3 align-items-center justify-content-center pt-2">
                                                                <div class="divFotoPerfil">
                                                                    <img src="'.$usuario["foto"].'" alt="foto de perfil de disk água SJ" class="foto-perfil">
                                                                </div>
                                                                <div class="comentario">
                                                                    <div class="infosUsuario">
                                                                        <span class="nomeUsuario"><a href="perfil.php" class="link-secondary">'.$usuario["username"].'</a></span>
                                                                        <p class="AvaliacaoUsuario" id="avaliacao-minha-analise">'.gerarEstrelas($analise["nota"]).'</p>
                                                                    </div>

                                                                    <div class="infosAnalise">
                                                                        <p class="texto-minha-analise" id="texto-minha-analise">'.$analise["comentario"].'</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="py-2 d-flex align-items-center justify-content-center gap-3 bg-dark">
                                                                <span>Sua avaliação está retida para análise</span>
                                                            </div>
                                                        </div>
                                                    ';
                                                }
                                        ?>
                                                <div id="confirmacaoExcluirAnalise" class="bg-dark p-3 rounded-3">
                                                    <h3 class="text-center">Tem certeza que deseja excluir essa análise?</h3>
                                                    <div class="d-flex gap-3 pt-3">
                                                        <button class="btn btn-2 btn-primary w-50" id="btnConfirmarExcluirAnalise" onclick="deleteAnalise();">Excluir</button>
                                                        <button class="btn btn-primary w-50" onclick="esconderConfirmarExluir();">Cancelar</button>
                                                        <form action="" method="post" id="formExcluirAnalise">
                                                            <input type="hidden" name="idFilme" value="<?= $idFilme ?>">
                                                            <input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">
                                                        </form>
                                                    </div>
                                                </div>
                                        <?php
                                            } else{
                                                echo '
                                                    <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center gap-2" id="btn-avaliar-filme" data-bs-toggle="modal" data-bs-target="#modalAvaliarFilme">
                                                        Avaliar
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                    </button>
                                                ';
                                            }
                                        ?>

                                        <script>
                                            function fecharEdicaoAnalise() {
                                                document.getElementById('editarAnalise').style.display = 'none';
                                            }
                                        </script>
                                    </div>

                                    <div class="modal fade" id="modalAvaliarFilme" tabindex="-1" aria-labelledby="modalAvaliarFilmeLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content bg-dark text-white">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalAvaliarFilmeLabel">Avaliar filme: <?= htmlspecialchars($filme["titulo"]) ?></h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="formAvaliarFilme" method="post" action="avaliar.php">
                                                    <input type="hidden" name="idFilme" value="<?= $idFilme ?>">

                                                    <div class="mb-3">
                                                        <label class="form-label">Nota:</label>
                                                        <div id="star-rating" style="font-size: 2rem; color: #5d58ed; cursor: pointer; display: inline-block;">
                                                            <i class="bi bi-star" data-value="1"></i>
                                                            <i class="bi bi-star" data-value="2"></i>
                                                            <i class="bi bi-star" data-value="3"></i>
                                                            <i class="bi bi-star" data-value="4"></i>
                                                            <i class="bi bi-star" data-value="5"></i>
                                                        </div>

                                                        <input type="hidden" name="nota" id="notaAvaliacao" required> 
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="comentarioAvaliacao" class="form-label">Comentário:</label>
                                                        <textarea class="form-control" id="comentarioAvaliacao" name="comentario" rows="3" placeholder="Escreva sua avaliação (opcional)"></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary" id="btnEnviarAnalise">Enviar avaliação</button>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </section>
    
                <section class="pt-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex gap-3 align-items-center">
                            <h3>analises</h3>
                        </div>
                    </div>
    
                    <div class="container-avaliacoes-filme pt-3" id="container-avaliacoes-filme">
                        
                    </div>
                </section>
            </div>
        </main>

        <?php
            include ('includes/footer.php'); 
        ?>
    </div>
    <script>
        document.getElementById('banner-filme').style.backgroundImage = "linear-gradient(to bottom, transparent 0%, #16181C 100%), url('<?= $filme["foto"] ?>')";
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 25,
            loop: true,
            centerSlide: 'true',
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                520: {
                    slidesPerView: 2,
                },
                950: {
                    slidesPerView: 3,
                }
            }
        });
    </script>
    <script src="assets/js/filme/createAnalise.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const stars = document.querySelectorAll('#star-rating i');
        const notaInput = document.getElementById('notaAvaliacao');
        let currentRating = 0;
        const starsEdit = document.querySelectorAll('#star-rating-edit i');
        const notaInputEditada = document.getElementById('notaAvaliacaoEditada');
        let currentRatingEdit = notaInput.value; 

        function setStars(rating, stars) {
            stars.forEach((star, index) => {
            star.classList.remove('bi-star-fill', 'bi-star-half', 'bi-star');
            const starValue = index + 1;

            if (rating >= starValue) {
                star.classList.add('bi-star-fill');
            } else if (rating >= (starValue - 0.5)) {
                star.classList.add('bi-star-half');
            } else {
                star.classList.add('bi-star');
            }
            });
        }

        stars.forEach(star => {
            star.addEventListener('mousemove', (e) => {
            const rect = star.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const starWidth = rect.width;
            let hoverValue = star.getAttribute('data-value');

            if (mouseX < starWidth / 2) {
                hoverValue = parseFloat(hoverValue) - 0.5;
            } else {
                hoverValue = parseFloat(hoverValue);
            }

            setStars(hoverValue, stars);
            });

            star.addEventListener('mouseout', () => {
            setStars(currentRating, stars);
            });

            star.addEventListener('click', (e) => {
            const rect = star.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            let selectedValue = star.getAttribute('data-value');

            if (mouseX < rect.width / 2) {
                selectedValue = parseFloat(selectedValue) - 0.5;
            } else {
                selectedValue = parseFloat(selectedValue);
            }

            currentRating = selectedValue;
            notaInput.value = currentRating;
            setStars(currentRating, stars);
            });
        });

        setStars(0, stars);

        starsEdit.forEach(star => {
            star.addEventListener('mousemove', (e) => {
            const rect = star.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const starWidth = rect.width;
            let hoverValue = star.getAttribute('data-value');

            if (mouseX < starWidth / 2) {
                hoverValue = parseFloat(hoverValue) - 0.5;
            } else {
                hoverValue = parseFloat(hoverValue);
            }

            setStars(hoverValue, starsEdit);
            });

            star.addEventListener('mouseout', () => {
            setStars(currentRating, starsEdit);
            });

            star.addEventListener('click', (e) => {
            const rect = star.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            let selectedValue = star.getAttribute('data-value');

            if (mouseX < rect.width / 2) {
                selectedValue = parseFloat(selectedValue) - 0.5;
            } else {
                selectedValue = parseFloat(selectedValue);
            }

            currentRating = selectedValue;
            notaInputEditada.value = currentRating;
            setStars(currentRating, starsEdit);
            });
        });

        setStars(0, starsEdit);

    </script>
    <script src="assets/js/filme/deleteAnalise.js"></script>
    <script src="assets/js/filme/getAnalisesFilme.js"></script>
    <script src="assets/js/filme/editarAnalise.js"></script>
    <script src="assets/js/centralAnalises/centralAnaliseAvaliacao.js"></script>
    <script src="assets/js/filme/gerenciarLista.js"></script>
</body>
</html>