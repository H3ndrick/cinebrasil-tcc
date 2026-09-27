<?php
    include "includes/functions.php";
    include "includes/head.php";
    include "includes/header.php";
?>
    
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorar Comunidades - Cine Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <main class="main ">
            <div class="text-center mt-4">
                <h3>Explorar Comunidades</h3>
                
            </div>

            <div class="comunidades-container align-items-center justify-content">
                <!-- Card para criar nova comunidade -->

                <a style="text-decoration: none;" href="cadastroComunidades.php">

                <div class="comunidade-card create-card">
                    <div class="comunidade-content">
                        <div class="comunidade-avatar">
                            <!-- Avatar será gerado via CSS -->
                        </div>
                        
                        <div class="comunidade-info text-white">
                            <div class="card-header">
                                <h3 class="comunidade-title">Criar Comunidade</h3>
                                <p class="comunidade-description">Gerencie sua própria comunidade dentro do Cine Brasil</p>
                            </div>
                            
                            <div class="card-footer">
                                <div class="comunidade-meta">
                                </div>
                               <div class="btn-comunidade">
                                    Criar
                                    </div>
                                
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                
                <?php 
                    // Busca todas as comunidades
                    $comunidades = getAllComunidades($conn);

                    // Verifica se existem comunidades
                    if (!empty($comunidades)) {
                        foreach ($comunidades as $i => $comunidade) {
                            $qntMembros = getQntUsuariosComunidade($conn, $comunidade["id"])["qntUsers"];
                            $criadorComunidade = getUsuarioById($conn, $comunidade["criador_id"]);
                            
                            // Define imagem padrão caso não exista
                            $capa = !empty($comunidade["capa"]) ? $comunidade["capa"] : "assets/img/comunidades/default-avatar.jpg";
                            $banner = !empty($comunidade["banner"]) ? $comunidade["banner"] : "assets/img/comunidades/default-banner.jpg";

                            echo '
                                <div class="comunidade-card">

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
                        // Mensagem quando não há comunidades
                        echo '
                            <div class="empty-state">
                                <i class="fas fa-users-slash"></i>
                                <h4>Nenhuma comunidade encontrada</h4>
                                <p>Seja o primeiro a criar uma comunidade!</p>
                                <a class="btn-comunidade" href="cadastroComunidades.php">
                                    Criar Primeira Comunidade
                                </a>
                            </div>
                        ';
                    }
                ?>
            </div>
        </main>

        <?php
            include ('includes/footer.php'); 
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmX5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/grafico.js"></script>
</body>
</html>