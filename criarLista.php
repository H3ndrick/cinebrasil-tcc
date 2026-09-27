<?php
include "includes/functions.php";
include "includes/head.php";
include "includes/header.php";
?>
<link rel="stylesheet" href="assets/css/criarLista-style.css">
<div class="container mt-5 p-2">
    <main class="mt-3 d-flex align-items-center justify-content-center main">
        <div class="div-form w-50 p-3 rounded-2">
            <h3 class=" text-white">Criar Lista</h3>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const descricao = document.getElementById('descricao');
        const contador = document.createElement('div');
        contador.id = 'descricaoCounter';
        descricao.parentNode.style.position = 'relative';
        descricao.parentNode.appendChild(contador);
<<<<<<< HEAD
        const maxLength = 500;
=======
        const maxLength = 250;
>>>>>>> master
        descricao.maxLength = maxLength;
        contador.textContent = `0 / ${maxLength}`;
        descricao.addEventListener('input', () => {
            const length = descricao.value.length;
            contador.textContent = `${length} / ${maxLength}`;
        });
    });

    function showToast(message) {
        let toast = document.getElementById('toastSuccess');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'toastSuccess';
            document.body.appendChild(toast);
        }
        toast.textContent = message;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
</script>
<script src="assets/js/lista/createLista.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>