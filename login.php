<?php
    if (isset($_COOKIE["token"])) {
        header("Location: index.php");
        exit();
    }

    include "includes/functions.php";
    include "includes/head.php";
    include "includes/header.php";
?>

    <div class="container mt-5 p-5 tamanho-form">
        <main class="mt-3 d-flex align-items-center justify-content-center main">
            <div class="div-form w-50 p-3 rounded-2">
                <h3 class="text-center text-white">Login</h3>
                <form method="post" id="loginForm">
                    <div class="mb-3">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" class="form-control">
                        <div id="emailError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="password">Senha:</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <div id="passwordError"></div>
                    </div>
                    <p id="mensagemErro" class="error"></p>
                    
                        <button class="btn btn-primary" id="btnLogin">Login</button>
                    
                    <p class="mt-3">Não tem uma conta? <a href="cadastro.php">Cadastrar-se</a></p>
                </form>
            </div>
        </main>

        <footer>

        </footer>
    </div>
    <script src="assets/js/login/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>