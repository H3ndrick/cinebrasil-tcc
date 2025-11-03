<?php
    include "includes/functions.php";
    include "includes/head.php";
    include "includes/header.php";

    $idUsuarioLogado = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
    $usuario = getUsuarioById($conn, $idUsuarioLogado);
?>

    <div class="container mt-5 p-2">
        <main class="mt-3 d-flex align-items-center justify-content-center main">
            <div class="div-form w-50 p-3 rounded-2">
                <h3 class="text-center text-white">Editar - perfil</h3>
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <form method="post" enctype="multipart/form-data" id="formEditarPerfil">
                        <input type="hidden" name="idUsuario" value="<?= $idUsuarioLogado ?>">
                        <div class="mb-3 w-100">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= $usuario["username"] ?>">
                            <div class="error" id="usernameError"></div>
                        </div>
    
                        <div class="mb-3 w-75">
                            <label for="bio">Biografia:</label>
                            <textarea name="bio" id="bio" class="form-control"><?= $usuario["bio"] ?></textarea>
                            <div class="error" id="bioError"></div>
                        </div>

                        <div class="mb-3 w-75">
                            <label for="imgUser">Foto:</label>
                            <input type="file" name="imgUser" id="foto" class="form-control" accept=".jpeg, .jpg, png, .webp">
                            <input type="hidden" name="fotoAtual" value="<?= $usuario["foto"] ?>">
                            <div class="error" id="fotoError"></div>
                        </div>
                        <div class="mb-3 w-75 d-flex align-items-center gap-2">
                            <button type="button" id="btnCancelarFoto" class="btn btn-secondary">Cancelar Foto</button>
                            <input type="hidden" name="fotoAtual" value="<?= $usuario["foto"] ?>">
                            <div class="error" id="fotoError"></div>
                        </div>

    
                        <div class="d-flex gap-3 py-3 align-items-center justify-content-center">                    
                            <button class="btn btn-primary" id="btnEditar">Atualizar perfil</button>
                            <a href="perfil.php?id=<?= $usuario['id'] ?>" class="btn btn-secondary">Cancelar</a>
                        </div>

                        <div class="error" id="erroCadastro"></div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/usuario/updateUsuario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/grafico.js"></script>
</body>
</html>