<?php
    include "includes/functions.php";
    include "includes/head.php";
    include "includes/header.php";
?>

    <div class="container mt-5 p-2">
        <main class="mt-3 d-flex align-items-center justify-content-center main">
            <div class="div-form w-50 p-3 rounded-2">
                <h3 class="text-center text-white">Cadastro - filme</h3>
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <form method="post" enctype="multipart/form-data" id="formCadastroFilme">
                        <div class="mb-3 w-100">
                            <label for="titulo">Titulo:</label>
                            <input type="text" name="titulo" id="titulo" class="form-control">
                            <div class="error" id="tituloError"></div>
                        </div>
    
                        <div class="mb-3 w-100">
                            <label for="dataLancamento">Data de lançamento:</label>
                            <input type="date" name="dataLancamento" id="dataLancamento" class="form-control">
                            <div class="error" id="dataError"></div>
                        </div>
    
                        <div class="mb-3 w-75">
                            <label for="sinopse">sinopse:</label>
                            <textarea name="sinopse" id="sinopse" class="form-control"></textarea>
                            <div class="error" id="sinopseError"></div>
                        </div>


    
                        <div class="mb-3 w-75">
                            <label for="capa">capa:</label>
                            <input type="file" name="capa" id="capa" class="form-control">
                            <div class="error" id="capaError"></div>
                        </div>

                        <div class="mb-3 w-75">
                            <label for="foto">foto:</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                            <div class="error" id="fotoError"></div>
                        </div>
    
                        <div class="d-flex py-3 align-items-center justify-content-center">                    
                            <button class="btn btn-primary" id="btnCadastrarFilme">Cadastrar Filme</button>
                        </div>

                        <div class="error" id="erroCadastro"></div>
                    </form>
                </div>
            </div>
        </main>

        <footer>

        </footer>
    </div>
    <script src="assets/js/filme/createFilme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/grafico.js"></script>
</body>
</html>