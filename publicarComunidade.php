<?php
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include "includes/functions.php";
    include "includes/head.php";
?>
    <?php 
        $conn = connect();

        $idUsuario = getIdUsuarioByToken($conn, $_COOKIE["token"])["id_usuario"];
        $idComunidade = $_GET["idComunidade"];
        $comunidade = getComunidadeById($conn, $idComunidade);
        
        $data = [
            'comunidade' => $comunidade,
            'idUusario' => $idUsuario
        ];
    ?>
    <link href="/styles.css" rel="stylesheet" />
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
                            <h3>Criar postagem em</h3>
                            
                            <div class="d-flex gap-3 align-items-center p-3 rounded-pill bg-dark w-50">
                                <img src="<?= $data["comunidade"]["capa"]?>" alt="" class="rounded-circle" width="50px">
                                <span><?= $data["comunidade"]["titulo"]?></span>
                            </div>

                            <form action="" method="post" class="pt-3" id="formPost">
                                <input type="hidden" name="idComunidade" value="<?= $comunidade["id"]?>">
                                <input type="hidden" name="idElementoPai" value="0">
                                <div class="mb-3">
                                    <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título">
                                    <div class="error" id="tituloError"></div>
                                </div>

                                <div id="toolbar-container">
                                    <span class="ql-formats">
                                        <select class="ql-font"></select>
                                        <select class="ql-size"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                        <button class="ql-strike"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <select class="ql-color"></select>
                                        <select class="ql-background"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-script" value="sub"></button>
                                        <button class="ql-script" value="super"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-header" value="1"></button>
                                        <button class="ql-header" value="2"></button>
                                        <button class="ql-blockquote"></button>
                                        <button class="ql-code-block"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-list" value="ordered"></button>
                                        <button class="ql-list" value="bullet"></button>
                                        <button class="ql-indent" value="-1"></button>
                                        <button class="ql-indent" value="+1"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-direction" value="rtl"></button>
                                        <select class="ql-align"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-link"></button>
                                        <button class="ql-image"></button>
                                        <button class="ql-video"></button>
                                        <button class="ql-formula"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-clean"></button>
                                    </span>
                                </div>
                                <div id="editor">
                                </div>

                                <div class="d-flex py-3 align-items-center justify-content-end">                    
                                    <button class="btn btn-primary rounded-pill w-25" id="btnCriarPublicacao">Postar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 
            </section>
        </main>
    </div>


    <script src="assets/js/comunidade/createPost.js"></script>
    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            modules: {
            syntax: true,
            toolbar: '#toolbar-container',
            },
            placeholder: 'Comece seu artigo...',
            theme: 'snow',
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>