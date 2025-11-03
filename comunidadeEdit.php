<?php
include "includes/functions.php";
include "includes/head.php";


$conn = connect();

$idComunidade = $_GET["idComunidade"];
$comunidade = getComunidadeById($conn, $idComunidade);

$idUsuario = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];

if($idUsuario != $comunidade["criador_id"]){
    
    header("location: comunidades.php");
    exit;
}
include "includes/header.php";
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

        <div class="mb-4 text-center d-flex gap-3">
            <div>
                <label for="capa">Selecionar capa</label>
                <input type="file" class="form-control" name="capa" id="capa" accept=".jpeg, .jpg, png, .webp">
            </div>
            <button type="button" id="btnCancelarCapa" class=" btn btn-primary mt-2">Cancelar Capa</button>
            <input type="hidden" name="capaAtual" value="<?= $data["capa"] ?>">
        </div>

        <div class="text-center d-flex gap-3">
            <div>
                <label for="banner">Selecionar banner</label>
                <input type="file" class="form-control" name="banner" id="banner" accept=".jpeg, .jpg, png, .webp">
            </div>
            <button type="button" id="btnCancelarBanner" class="btn btn-primary mt-2">Cancelar Banner</button>
            <input type="hidden" name="bannerAtual" value="<?= $data["banner"] ?>">
        </div>

        <div class="d-flex justify-content-center gap-3 w-100 my-3">
            <button type="submit" class="btn btn-primary" id="btnEditarComunidade">Confirmar Edição</button>
            <a href="comunidade.php?id=<?= $comunidade['id'] ?>" class="btn btn-secondary">Cancelar</a>
        </div>

        </div>
            
    </form>
</div>
        
<script src="assets/js/comunidade/editarComunidade.js"></script>