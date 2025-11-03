<?php
    if (isset($_COOKIE["token"])) {
        header("Location: index.php");
        exit();
    }
    
    include "includes/functions.php";
    include "includes/head.php";
    include "includes/header.php";
?>

    <div class="container mt-5 p-2">
        <main class="mt-3 d-flex align-items-center justify-content-center main">
            <div class="div-form w-50 p-3 rounded-2">
                <h3 class="text-center text-white">Cadastro</h3>
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <form method="post" enctype="multipart/form-data" id="formCadastro">
                        <div class="mb-3 w-100">
                            <label for="username">Nome de Usuário:</label>
                            <input type="text" name="username" id="username" class="form-control">
                            <div class="error" id="usernameError"></div>
                        </div>
    
                        <div class="mb-3 w-100">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control">
                            <div class="error" id="emailError"></div>
                        </div>
    
                        <div class="mb-3 w-75">
                            <label for="password">Senha:</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <div class="error" id="passwordError"></div>
                        </div>
    
                        <div class="mb-3 w-75">
                            <label for="confirmPassword">Confirmar senha:</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                            <div class="error" id="confirmPasswordError"></div>
                        </div>
                        
                        <div class="mb-3 w-75">
                            <label for="imgUser">Foto:</label>
                            <input type="file" name="imgUser" id="foto" class="form-control" accept=".jpeg, .jpg, png, .webp">
                            <div class="error" id="fotoError"></div> </div>
                        
                        <div class="mb-3 w-75 d-flex align-items-center gap-2">
                            <button type="button" id="btnCancelarFoto" class="btn btn-secondary">Cancelar Foto</button> 
                        </div>

                        <div class="d-flex gap-3 py-3 align-items-center justify-content-center"> 
                            <button class="btn btn-primary" id="btnCadastrar">Cadastrar Perfil</button>
                        </div>

                        <div class="d-flex align-items-center justify-content-center">
                            <p>Já possui Conta? <a href="login.php" class="text-decoration-none">Clique Aqui</a></p>
                        </div>

                        <div class="error" id="erroCadastro"></div>
                    </form>
                </div>
            </div>
        </main>

        <footer>

        </footer>
    </div>
    <script src="assets/js/usuario/createUsuario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/grafico.js"></script>
</body>
</html>