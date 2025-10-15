<?php
    include "includes/functions.php";
    include "includes/head.php";
    include "includes/header.php";
?>

    <div class="container mt-5 p-2">
        <main class="mt-3 d-flex align-items-center justify-content-center main">
            <div class="div-form w-50 p-3 rounded-2">
                <h3 class=" text-white">Criar  Lista</h3>
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <form method="post" id="formCriarLista" class="row">
                        <div class="col-md-8">
                            <label for="titulo">Titulo</label>
                            <input type="text" name="titulo" id="titulo" class="form-control">
                            <div class="error" id="tituloError"></div>
                        </div>
    
                        <div class="col-md-12">
                            <label for="descricao">Descricao</label>
                            <textarea name="descricao" id="descricao" class="form-control"></textarea>
                            <div class="error" id="descricaoError"></div>
                        </div>

                        <div class="col-md-12">
                            <div class="scrollable-div d-flex align-items-center gap-3 flex-wrap my-3">
                                <?php
                                    $filmes = getAllFilmes($conn);


                                    foreach ($filmes as $filme) {
                                        #var_dump($filme);

                                        echo '
                                            <div class="d-flex flex-wrap flex-column align-items-start justify-content-center">
                                                <div class="container-filme-alta">
                                                    <img src="'.$filme["capa"].'" alt="central-do-brasil-filmes-em-alta" class="img-filme-alta h-100 w-100 capa-filme-adicionar-lista" onclick="adicionarFilme('.$filme["id"].')" id="capaFilme-'.$filme["id"].'">
                                                </div>
                                                <p class="titulo-filme-exibicao">'.$filme["titulo"].'</p>
                                                <input type="hidden" name="idFilme" value="'.$filme["id"].'">
                                            </div>
                                        ';
                                    }
                                ?>
                            </div>
                            
                        </div>
    
                        <div class="d-flex py-3 align-items-center justify-content-center">                    
                            <button class="btn btn-primary" id="btnCriarLista">Criar Lista</button>
                        </div>

                        <div class="error" id="erroCadastro"></div>
                    </form>
                </div>
            </div>
        </main>

        <footer>

        </footer>
    </div>
    <script src="assets/js/lista/createLista.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/grafico.js"></script>
</body>
</html>