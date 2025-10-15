<?php
    include "includes/functions.php";

    $conn = connect();

    if (!isset($_COOKIE["token"]) || !getIdUsuarioByToken($conn, $_COOKIE["token"])) {
        header("Location: login.php");
        exit();
    }

    $idUsuarioAtivo = getIdUsuarioByToken($conn, $_COOKIE["token"]);
    $isAdmComunidade = isAdmComunidade($conn, $_GET["id"], $idUsuarioAtivo["id_usuario"]);
    $isAdm = isAdm($conn,$idUsuarioAtivo["id_usuario"]);
    $comunidade = getComunidadeById($conn, $_GET["id"]);
    $donoComunidade = getUsuarioById($conn, $comunidade["dono_id"]);
    $idsUsuarios = getAllIdsMembrosComunidade($conn, $_GET["id"], $comunidade["dono_id"]);
    $usuarios = [];
    $isDono = $comunidade["dono_id"] == $idUsuarioAtivo["id_usuario"];

    foreach ($idsUsuarios as $i => $idUsuario) {
        $usuarios[] = getUsuarioById($conn, $idUsuario["id_usuario"]);
    }

    disconnect($conn);

    if(!$isAdmComunidade && !$isDono){
        header("Location: index.php");
    }
    
    include "includes/head.php";
    include "includes/header.php";
?>

    <div class="container mt-5 p-5">
        <main class="mt-3 d-flex flex-column align-items-center justify-content-center main">
            <h3>Gerenciamento da comunidade: <?= $comunidade["titulo"]?></h3>
            
            <table class="table table-dark">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Status</th>
                    <th scope="col">Gerenciar</th>
                    </tr>
                </thead>
                <tbody id="tbody-usuarios-comunidade">
                    <tr id="tr-usuario-dono">
                        <th scope="row">1</th>
                        <td><a href="perfil.php?id=<?= $comunidade["dono_id"]?>" class="link-secondary"><?= $donoComunidade["username"] ?></a></td>
                        <td id="role-usuario-">
                            <span class="badge rounded-pill tag-dono">dono</span>
                        </td>
                        <td id="gerenciar-usuario-dono">
                            <div>
                                <?php 
                                    if($isDono){
                                        echo '<a href="#" id="excluirLink">Excluir comunidade</a>';

                                        echo '
                                            <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content bg-dark">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalExcluirLabel">Confirmar Exclusão</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Você tem certeza que deseja excluir esta comunidade? Essa ação não pode ser desfeita.
                                                        </div>
                                                        <div class="modal-footer d-flex align-items-center gap-3">
                                                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="button" class="btn btn-danger w-100" onclick="deleteComunidade('.$_GET["id"].')">Excluir</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <?php 
                    
                        foreach ($usuarios as $i => $usuario) {
                            if(!isAdmComunidade($conn, $_GET["id"], $usuario["id"])){
                                $role = 'usuario';
                                $tag = 'tag-usuario';
                                $gerenciar = '<a href="#" class="" onclick="tornarAdmComunidade('.$_GET["id"].', '.$usuario["id"].', '.$isDono.')">Tornar ADM</a> <a href="#" class="" onclick="removerUsuarioComunidade('.$_GET["id"].', '.$usuario["id"].')">Remover usuario</a>';
                            } else{
                                $role = 'ADM';
                                $tag = 'tag-adm';
                                $gerenciar = '<a href="#" class="" onclick="removerAdmComunidade('.$_GET["id"].', '.$usuario["id"].', '.$isDono.')">Remover ADM</a>';
                            }

                            if($isDono && !isAdmComunidade($conn, $_GET["id"], $usuario["id"])){
                                $gerenciar .= '<a href="#" class="" onclick="passarPosse('.$_GET["id"].', '.$usuario["id"].')">Passar posse</a>';
                            }

                            if($usuario["id"] == $idUsuarioAtivo["id_usuario"]){
                                $gerenciar = '';
                            }

                            echo '
                                <tr id="tr-usuario-'.$usuario["id"].'">
                                    <th scope="row">'.($i + 1).'</th>
                                    <td><a href="perfil.php?id='.$usuario["id"].'" class="link-secondary">'.$usuario["username"].'</a></td>
                                    <td id="role-usuario-'.$usuario["id"].'">
                                        <span class="badge rounded-pill '.$tag.'">'. $role .'</span>
                                    </td>
                                    <td id="gerenciar-usuario-'.$usuario["id"].'">
                                        <div class="d-flex gap-4">'.$gerenciar.'</div>
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
    <script>
        // Mostrar o modal quando o link for clicado
        document.getElementById("excluirLink").addEventListener("click", function(e) {
            e.preventDefault(); // Impede o comportamento padrão do link
            var modal = new bootstrap.Modal(document.getElementById("modalExcluir"));
            modal.show();
        });
    </script>
    <script src="assets/js/comunidade/tornarAdmComunidade.js"></script>
    <script src="assets/js/comunidade/removerAdmComunidade.js"></script>
    <script src="assets/js/comunidade/removerUsuarioComunidade.js"></script>
    <script src="assets/js/comunidade/passarPosse.js"></script>
    <script src="assets/js/comunidade/deleteComunidade.js"></script>
    <script src="assets/js/usuario/removerADM.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>