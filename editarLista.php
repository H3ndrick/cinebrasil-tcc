<?php
    include "includes/functions.php";
    include "includes/head.php";
    

    $conn = connect();
    if (!isset($_COOKIE["token"]) || !getIdUsuarioByToken($conn, $_COOKIE["token"])) {
        header("Location: login.php");
        exit();
    }

    if(!isset($_GET["id"])){
        header("location: listas.php");
    }

    $idUsuarioLogado = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
    $lista = getListaById($conn, $_GET["id"]);

    if($lista["idCriadorLista"] != $idUsuarioLogado){
        header("location: listas.php");
    }

    include "includes/header.php";
?>
    <link rel="stylesheet" href="assets/css/criarLista-style.css">
    <div class="container mt-5 p-2">
        <main class="mt-3 d-flex align-items-center justify-content-center main">
            <div class="div-form w-50 p-3 rounded-2">
                <h3 class=" text-white">Editar Lista - <?= $lista["titulo"] ?></h3>
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <form method="post" id="formEditarLista" class="row">
                        <input type="hidden" name="idLista" value="<?= $lista["id"] ?>">
                        <div class="col-md-8">
                            <label for="titulo">Titulo</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" value="<?= $lista["titulo"] ?>">
                            <div class="error" id="tituloError"></div>
                        </div>

                        <div class="col-md-12">
                            <label for="descricao">Descricao</label>
                            <textarea name="descricao" id="descricao" class="form-control"><?= $lista["descricao"] ?></textarea>
                            <div class="error" id="descricaoError"></div>
                        </div>

                        <div class="d-flex py-3 align-items-center justify-content-center">
                            <button type="button" class="btn btn-primary" id="btnEditarLista">Salvar alterações</button>
                        </div>

                        <div class="error" id="erroCadastro"></div>
                    </form>
                </div>
            </div>
        </main>

        <footer>

        </footer>
    </div>
    <script src="assets/js/lista/updateLista.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/grafico.js"></script>
</body>
</html>