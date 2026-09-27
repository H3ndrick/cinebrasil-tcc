<?php
    include "includes/functions.php";

    $conn = connect();

    if (!isset($_COOKIE["token"]) || !getIdUsuarioByToken($conn, $_COOKIE["token"])) {
        header("Location: login.php");
        exit();
    }

    $idUsuarioAtivo = getIdUsuarioByToken($conn, $_COOKIE["token"]);
    $isAdm = isAdm($conn,$idUsuarioAtivo["id_usuario"]);
    $usuarios = getAllUsuarios($conn, $idUsuarioAtivo["id_usuario"]);
    disconnect($conn);

    if(!$isAdm){
        header("Location: index.php");
    }
    
    include "includes/head.php";
    include "includes/header.php";
?>

    <div class="container mt-5 p-5">
        <main class="mt-3 d-flex flex-column align-items-center justify-content-center main">
            <h1>Gerenciamento de usuarios:</h1>
            
            <table class="table table-dark">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Status</th>
                    <th scope="col">Gerenciar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($usuarios as $i => $usuario) {
                            if($usuario["id"] != 1){
                                if($usuario["role"] == "user"){
                                    $role = 'usuario';
                                    $tag = 'tag-usuario';
                                    $gerenciar = '<a href="#" class="" onclick="tornarAdm('.$usuario["id"].')">Tornar ADM</a>';
                                } else{
                                    $role = 'ADM';
                                    $tag = 'tag-adm';
                                    $gerenciar = '<a href="#" class="" onclick="removerAdm('.$usuario["id"].')">Remover ADM</a>';
                                }

                                echo '
                                    <tr id="tr-usuario-'.$usuario["id"].'">
                                        <th scope="row">'.($i + 1).'</th>
                                        <td><a href="perfil.php?id='.$usuario["id"].'" class="link-secondary">'.$usuario["username"].'</a></td>
                                        <td id="role-usuario-'.$usuario["id"].'">
                                            <span class="badge rounded-pill '.$tag.'">'. $role .'</span>
                                        </td>
                                        <td id="gerenciar-usuario-'.$usuario["id"].'">
                                            <div>'.$gerenciar.'</div>
                                        </td>
                                    </tr>
                                ';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </main>

        <footer>

        </footer>
    </div>
    <script src="assets/js/usuario/tornarADM.js"></script>
    <script src="assets/js/usuario/removerADM.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>