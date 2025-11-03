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
        
            <section class="features-section">
            <div class="container">
                <div class="row g-4 d-flex justify-content-center">
                    <!-- Feature 1 -->
                    <div class="col-lg-4 col-md-6">
                        <a href="listas.php" style="color: inherit; text-decoration: none;">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <img src="assets/img/landing-page/capas-landing.png" alt="Criar listas" class="feature-img-2">
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">Criar listas</h3>
                                <p class="feature-description">Organize seus filmes favoritos em listas personalizadas</p>
                                <?php if(!isset($_COOKIE["token"])): ?>
                                    <a href="login.php" class="feature-link">Comece agora →</a>
                                <?php endif; ?>
                            </div>
                        </div>
                                </a>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="col-lg-4 col-md-6">
                    <a href="comunidades.php" style="color: inherit; text-decoration: none;">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <img src="assets/img/landing-page/icon-group.png" alt="Participar de comunidades" class="feature-img">
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">Participar de comunidades</h3>
                                <p class="feature-description">Conecte-se com outros fãs e compartilhe suas paixões</p>
                                <?php if(!isset($_COOKIE["token"])): ?>
                                    <a href="login.php" class="feature-link">Junte-se →</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        </a>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="col-lg-4 col-md-6">
                        <a href="filmes.php" style="color: inherit; text-decoration: none;">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <img src="assets/img/landing-page/icon-text.png" alt="Fazer análises" class="feature-img">
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">Fazer análises</h3>
                                <p class="feature-description">Compartilhe suas opiniões e descubra novas perspectivas</p>
                                <?php if(!isset($_COOKIE["token"])): ?>
                                    <a href="login.php" class="feature-link">Explore →</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                </div>
            </section>

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