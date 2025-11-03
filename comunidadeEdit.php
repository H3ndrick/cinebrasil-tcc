<?php
    include "includes/functions.php";
    include "includes/head.php";

    $conn = connect();
    
    $idComunidade = $_GET["idComunidade"];
    $comunidade = getComunidadeById($conn, $idComunidade);

    $idUsuario = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];

    if($idUsuario != $comunidade["criador_id"]){
        echo "<h2>Você não tem permissão para editar esta comunidade.</h2>";
        exit;
    }

    disconnect($conn);
?>

<div class="container mt-5 d-flex flex-column align-items-center">
    <h2 class="text-center mb-4 w-100">Editar Comunidade</h2>
    <form id="formEditarComunidade" enctype="multipart/form-data" class="d-flex flex-column align-items-center w-100" style="max-width: 500px; margin: auto;">
        <input type="hidden" name="idComunidade" value="<?= $comunidade['id'] ?>">

        <div class="mb-4 w-100">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" name="titulo" value="<?= $comunidade['titulo'] ?>">
        </div>

        <div class="mb-4 w-100">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao"><?= $comunidade['descricao'] ?></textarea>
        </div>

        <div class="mb-4 w-100 text-center">
            <label for="capa" class="form-label d-block">Capa atual</label>
            <img src="<?= $comunidade['capa'] ?>" alt="Capa" width="200" class="mb-2">
            <input type="file" class="form-control form-control-sm" name="capa">
        </div>

        <div class="mb-4 w-100 text-center">
            <label for="banner" class="form-label d-block">Banner atual</label>
            <img src="<?= $comunidade['banner'] ?>" alt="Banner" width="300" class="mb-2 mx-auto d-block">
            <input type="file" class="form-control" name="banner">
        </div>

            <div class="d-flex justify-content-center gap-3 w-100">
                <button type="submit" class="btn btn-primary" id="btnEditarComunidade">Confirmar Edição</button>
                <a href="comunidade.php?id=<?= $comunidade['id'] ?>" class="btn btn-secondary btn-sm">Cancelar</a>
        </div>
    </form>
</div>
           <div style=" margin-top: 30%;"> 
        <?php
        
                include ('includes/footer.php'); 
                ?>

             <script src="assets/js/comunidade/editarComunidade.js"></script>
             </div>
        
