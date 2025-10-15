<?php
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include "includes/functions.php";
    include "includes/head.php";
?>
    <?php 
        $conn = connect();
        $idFilme = $_GET["idFilme"];
        $idUsuario = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
        $filme = getFilmeById($conn, $idFilme);
        $analise = getAnaliseById($conn, $idFilme, $idUsuario);
        
        $data = [
            'filme' => $filme,
            'idUusario' => $idUsuario,
            'analise' => $analise
        ];
    ?>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />

    <div class="container-fluid p-0">
        <?php include "includes/header.php";?>

        <main class="mt-4 pt-4">
            <section class="container">
                <div class="row">
                    <div class="col">
                        <div class=" p-3">
                            <h3>Editar analise do filme:</h3>
                            
                            <div class="rounded-pill bg-dark w-50">
                                <div class="mx-3 d-flex gap-3 align-items-center p-3">
                                    <img src="<?= $data["filme"]["capa"]?>" alt="" class="" width="50px">
                                    <span><?= $data["filme"]["titulo"]?></span>
                                </div>
                            </div>

                            <div id="editarAnalise" class="bg-dark p-3 rounded-3 mt-3">
                                <form method="post" id="formEditarAnalise">
                                    <input type="hidden" name="idFilme" value="<?= $data["filme"]["id"] ?>">
                                    <input type="hidden" name="idUsuario" value="<?= $data["idUusario"] ?>">
                                    <input type="hidden" name="notaAvaliacao" value="<?= $data["analise"]["nota"] ?>" id="notaAvaliacao">

                                    <div class="mb-3">
                                            <label class="form-label">Nota:</label>
                                            <div id="star-rating-edit" style="font-size: 2rem; color: #5d58ed; cursor: pointer; display: inline-block;">
                                                <i class="bi bi-star" data-value="1"></i>
                                                <i class="bi bi-star" data-value="2"></i>
                                                <i class="bi bi-star" data-value="3"></i>
                                                <i class="bi bi-star" data-value="4"></i>
                                                <i class="bi bi-star" data-value="5"></i>
                                            </div>

                                            <input type="hidden" name="nota" id="notaAvaliacaoEditada" required> 
                                        </div>

                                    <div class="mb-3">
                                        <label for="comentario" class="form-label">Comentário:</label>
                                        <textarea id="comentario" name="comentario" rows="4" class="form-control"><?php if (isset($analise) && $analise !== null && isset($analise["comentario"])) {
                                            echo htmlspecialchars($analise["comentario"]);
                                        } else {
                                            echo "Nenhuma análise encontrada.";
                                        }?></textarea>
                                    </div>

                                    <div class="d-flex gap-3 justify-content-center">
                                        <button type="button" class="btn btn-primary w-50" onclick="editarAnalise()">Salvar</button>
                                        <button type="button" class="btn btn-secondary w-50" onclick="esconderConfirmarEditar(<?= $idFilme ?>);">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 
            </section>
        </main>
    </div>

    <script>
        const baseUrl = window.location.origin + '/ws/';
        const notaInput = document.getElementById('notaAvaliacao');
        const starsEdit = document.querySelectorAll('#star-rating-edit i');
        const notaInputEditada = document.getElementById('notaAvaliacaoEditada');
        let currentRatingEdit = notaInput.value; 

        function setStars(rating, stars) {
            stars.forEach((star, index) => {
            star.classList.remove('bi-star-fill', 'bi-star-half', 'bi-star');
            const starValue = index + 1;

            if (rating >= starValue) {
                star.classList.add('bi-star-fill');
            } else if (rating >= (starValue - 0.5)) {
                star.classList.add('bi-star-half');
            } else {
                star.classList.add('bi-star');
            }
            });
        }

        starsEdit.forEach(star => {
            star.addEventListener('mousemove', (e) => {
            const rect = star.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const starWidth = rect.width;
            let hoverValue = star.getAttribute('data-value');

            if (mouseX < starWidth / 2) {
                hoverValue = parseFloat(hoverValue) - 0.5;
            } else {
                hoverValue = parseFloat(hoverValue);
            }

            setStars(hoverValue, starsEdit);
            });

            star.addEventListener('mouseout', () => {
            setStars(currentRating, starsEdit);
            });

            star.addEventListener('click', (e) => {
            const rect = star.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            let selectedValue = star.getAttribute('data-value');

            if (mouseX < rect.width / 2) {
                selectedValue = parseFloat(selectedValue) - 0.5;
            } else {
                selectedValue = parseFloat(selectedValue);
            }

            currentRating = selectedValue;
            notaInputEditada.value = currentRating;
            setStars(currentRating, starsEdit);
            });
        });

        setStars(currentRatingEdit, starsEdit);
    </script>
    <script src="assets/js/filme/editarAnalise.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>