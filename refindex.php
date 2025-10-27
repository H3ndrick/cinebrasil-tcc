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
        <!-- Hero Section -->
        <section class="hero-section d-flex flex-column align-items-center justify-content-center text-center">
            <div class="hero-content">
                <h1 class="hero-title">Cine Brasil</h1>
                <p class="hero-subtitle">Indique, salve e avalie seus filmes nacionais favoritos!</p>
                
                <?php if(! isset($_COOKIE["token"])): ?>
                    <div class="hero-buttons">
                        <a href="cadastro.php" class="btn btn-primary hero-btn">Cadastre-se</a>
                        <a href="login.php" class="btn btn-outline hero-btn">Entrar</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">Descubra o mundo do cinema brasileiro</h2>
                    <p class="section-subtitle">Uma plataforma dedicada aos amantes do cinema nacional</p>
                </div>
                
                <div class="row g-4">
                    <!-- Feature 1 -->
                    <div class="col-lg-4 col-md-6">
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
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="col-lg-4 col-md-6">
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
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="col-lg-4 col-md-6">
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
                </div>
            </div>
        </section>
        
        <!-- CTA Section -->
        <?php if(!isset($_COOKIE["token"])): ?>
        <section class="cta-section">
            <div class="container">
                <div class="cta-content text-center">
                    <h2 class="cta-title">Pronto para começar sua jornada cinematográfica?</h2>
                    <p class="cta-subtitle">Junte-se a milhares de amantes do cinema brasileiro</p>
                    <div class="cta-buttons">
                        <a href="cadastro.php" class="btn btn-primary cta-btn">Criar conta gratuita</a>
                        <a href="filmes.php" class="btn btn-outline cta-btn">Explorar filmes</a>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </main>
    
    <?php include ('includes/footer.php'); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
/* ===== VARIÁVEIS ===== */
:root {
    --primary-color: #353DCB;
    --primary-hover: #5f66f8;
    --bg-dark: #16181C;
    --bg-card: #242832;
    --bg-card-hover: #2a2e3a;
    --text-primary: #ffffff;
    --text-secondary: #BABABA;
    --text-muted: #8a8a8a;
    --border-radius: 12px;
    --transition: all 0.3s ease;
}

/* ===== ESTILOS GLOBAIS ===== */
body {
    background-color: var(--bg-dark);
    color: var(--text-primary);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.6;
}

/* ===== HERO SECTION ===== */
.hero-section {
    min-height: 85vh;
    background: linear-gradient(135deg, rgba(22, 24, 28, 0.9) 0%, rgba(53, 61, 203, 0.2) 100%), 
                url('assets/img/auto_da_compadecida.webp') no-repeat center center;
    background-size: cover;
    padding: 2rem 1rem;
    position: relative;
}

.hero-content {
    max-width: 700px;
    padding: 2rem;
    border-radius: var(--border-radius);
    backdrop-filter: blur(10px);
    background-color: rgba(22, 24, 28, 0.7);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #ffffff, #c3c3ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.4rem;
    color: var(--text-secondary);
    margin-bottom: 2rem;
    max-width: 600px;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.hero-btn {
    padding: 0.75rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    transition: var(--transition);
    min-width: 150px;
}

.btn-primary {
    background-color: var(--primary-color);
    border: none;
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(53, 61, 203, 0.3);
}

.btn-outline {
    background-color: transparent;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-outline:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

/* ===== FEATURES SECTION ===== */
.features-section {
    padding: 5rem 0;
}

.section-header {
    margin-bottom: 4rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.section-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto;
}

.feature-card {
    background-color: var(--bg-card);
    border-radius: var(--border-radius);
    padding: 2rem;
    height: 100%;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.feature-card:hover {
    transform: translateY(-10px);
    background-color: var(--bg-card-hover);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.feature-icon {
    margin-bottom: 1.5rem;
    width: 120px;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(53, 61, 203, 0.1);
    padding: 1rem;
}

.feature-img {
    max-width: 80px;
    max-height: 80px;
    filter: brightness(0) invert(1);
}

.feature-img-2{
    max-width: 80px;
    max-height: 80px;
}

.feature-content {
    flex: 1;
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.feature-description {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
    font-size: 1rem;
}

.feature-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
    display: inline-block;
}

.feature-link:hover {
    color: var(--primary-hover);
    transform: translateX(5px);
}

/* ===== CTA SECTION ===== */
.cta-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, rgba(53, 61, 203, 0.1) 0%, rgba(22, 24, 28, 1) 100%);
}

.cta-content {
    max-width: 700px;
    margin: 0 auto;
}

.cta-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.cta-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    margin-bottom: 2.5rem;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-btn {
    padding: 0.75rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    transition: var(--transition);
    min-width: 180px;
}

/* ===== RESPONSIVIDADE ===== */
@media (max-width: 992px) {
    .hero-title {
        font-size: 2.8rem;
    }
    
    .section-title {
        font-size: 2.2rem;
    }
    
    .feature-card {
        padding: 1.5rem;
    }
}

@media (max-width: 768px) {
    .hero-section {
        min-height: 70vh;
    }
    
    .hero-title {
        font-size: 2.2rem;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .cta-title {
        font-size: 1.8rem;
    }
    
    .hero-buttons, .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .hero-btn, .cta-btn {
        width: 100%;
        max-width: 300px;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .feature-card {
        padding: 1.2rem;
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
    }
    
    .feature-img {
        max-width: 50px;
        max-height: 50px;
    }
}
</style>

<script>
// Efeito de digitação para o título (opcional)
document.addEventListener('DOMContentLoaded', function() {
    // Adiciona classe de animação após o carregamento
    setTimeout(function() {
        document.querySelector('.hero-title').classList.add('animate__animated', 'animate__fadeInDown');
        document.querySelector('.hero-subtitle').classList.add('animate__animated', 'animate__fadeInUp');
    }, 300);
    
    // Animação suave ao rolar para as seções
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
            }
        });
    }, observerOptions);
    
    // Observar os cards de features
    document.querySelectorAll('.feature-card').forEach(card => {
        observer.observe(card);
    });
});
</script>
</body>