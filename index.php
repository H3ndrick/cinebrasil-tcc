<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include "includes/functions.php";
    include "includes/head.php";
    include "includes/header.php";
?>
    
    <div class="container-fluid d-flex flex-column">
        <main>
            <section class="d-flex flex-column align-items-center justify-content-center qualquer-coisa">
                <h1>Cine Brasil</h1>

                <p>Indique, salve e avalie seus filmes nacionais favoritos!</p>

                <?php if(! isset($_COOKIE["token"])){?>
                    <a href="cadastro.php" class="btn btn-primary">Cadastre-se</a>
                <?php }?>

            </section>

            <div class="container">
        
                <div class="row mt-3 w-100 container-funcional">
                    <div class="col">
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3 py-3">
                            <img src="assets/img/landing-page/capas-landing.png" alt="capas-variadas-landing-page" class="img-container-funcional">
                            <div class="w-75"> 
                                <h2>Criar listas</h2>
                                <p class="fs-4">Crie uma conta para poder criar listas dos seus filmes preferidos</p>
                                <?php if(!isset($_COOKIE["token"])){?>
                                    <a href="login.php" class="btn btn-primary">login</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="row mt-3 w-100 container-funcional">
                    <div class="col">
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3 py-3">
                            <img src="assets/img/landing-page/icon-group.png" alt="icon-group-png-landing-page" class="img-container-funcional icone-comunidade">
                            <div class="w-75"> 
                                <h2>Participar de comunidades</h2>
                                <p class="fs-4">Faça parte e contribua com comunidades de sua preferência</p>
                                <?php if(!isset($_COOKIE["token"])){?>
                                    <a href="login.php" class="btn btn-primary">login</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="row mt-3 w-100 container-funcional">
                    <div class="col">
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3 py-3">
                            <img src="assets/img/landing-page/icon-text.png" alt="icon-text-png-landing-page" class="img-container-funcional icone-comunidade">
                            <div class="w-75"> 
                                <h2>Fazer análises de filmes</h2>
                                <p class="fs-4">Faça parte e contribua com comunidades de sua preferência</p>
                                <?php if(!isset($_COOKIE["token"])){?>
                                    <a href="login.php" class="btn btn-primary">login</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
            include ('includes/footer.php'); 
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 5,
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
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 5,
            }
        }
    });
  </script>
</body>