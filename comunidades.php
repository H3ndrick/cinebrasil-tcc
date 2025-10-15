<?php
    include "includes/functions.php";
    include "includes/head.php";
    include "includes/header.php";
?>
    
    <div class="container-fluid">
        <main class="d-flex align-items-center main flex-column gap-3">
            <div class="mt-5 pt-5">
                <h2 style="margin-bottom: 50px;">Explorar Comunidades</h2>
            </div>

            <div class="div-form p-3 rounded-2 comunidade-card">

                <div class="container d-flex align-items-start justify-content-between position-relative">

                    <div class="div-img-comunidade">
                        <img class="foto-comunidade" style=" flex: 0; z-index: 10; border-radius: 15px;" src="assets/img/comunidades/+.jpg" alt="zecaixao">
                    </div>

                    <div class="div-banner-comunidade4 text-white ">
                        <h3 style="margin-left: 40px; margin-top: 10px;">Criar Comunidade</h3>
                        <p style="margin-left: 40px; margin-top: 60px;">Gerencie sua própria comunidade dentro do Cine Brasil</p>
                        <a style="margin-left: 40px; margin-top: 40px; width: 177px; height: 44.29px; color: #5D58ED;" class="btn btn-primary text-white" href="cadastroComunidades.php">Criar</a>
                    </div>
                </div>
            </div>
            
            <?php 
                $comunidades = getAllComunidades($conn);

                foreach ($comunidades as $i => $comunidade) {
                    $qntMembros = getQntUsuariosComunidade($conn, $comunidade["id"])["qntUsers"];
                    $criadorComunidade = getUsuarioById($conn, $comunidade["criador_id"]);

                    echo '
                        <div class="div-form p-3 rounded-2 comunidade-card">

                            <div class="container d-flex align-items-start justify-content-between position-relative">
                                <a href="comunidade.php?id='.$comunidade["id"].'">
                                    <div class="div-img-comunidade">
                                        <img class="foto-comunidade" style=" flex: 0; z-index: 10; border-radius: 15px;" src="'. $comunidade["capa"] .'" alt="zecaixao">
                                    </div>
                                </a>

                                <div class="div-banner-comunidade text-white" style="background: linear-gradient(to bottom,rgba(0, 0, 0, 0.3) 0%, #242832 100%), url('.$comunidade["banner"].')">
                                    <h3 style="margin-left: 40px; margin-top: 10px;"><a href="comunidade.php?id='.$comunidade["id"].'" class="link-light link-underline link-underline-opacity-0">'.$comunidade["titulo"].'</a></h3>
                                    <p style="margin-left: 40px;">'.$comunidade["descricao"].'</p>
                                    <a style="margin-left: 40px; margin-top: 30px; width: 177px; height: 44.29px; color: #5D58ED;" class="btn btn-primary text-white" href="comunidade.php?id='.$comunidade["id"].'">ver mais</a>
                                
                                    <div class="d-flex">
                                        
                                    </div>

                                    <p style="margin-left: 40px; margin-top: 30px;"> '.$qntMembros.' Membros | Criado por '.$criadorComunidade["username"].'</p>
                                </div>

                            </div>
                            
                        </div>
                    ';
                }
            ?>

        </main>

        <?php
            include ('includes/footer.php'); 
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/grafico.js"></script>
</body>
</html>