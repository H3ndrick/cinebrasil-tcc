<?php 
    function connect(){
        $server = "sql100.infinityfree.com";
        $user = "if0_40105604";
        $password = "w6GAHypqNy";
        $database = "if0_40105604_cinebrasil";
        $port = 3306;

        $conn = mysqli_connect($server, $user, $password, $database, $port);

        if(!$conn){
            die("Erro ao conectar no banco de dados ". mysqli_connect_error());
        }

        mysqli_set_charset($conn,"utf8");
        
        return $conn;
    }

    function disconnect($conn){
        if(isset($conn)){
            mysqli_close($conn);
            return true;
        }else{
            return false;
        }
    }

    function numeroPraMes($mes){
        $meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
        return $meses[$mes - 1];
    }

    function isAdm($conn, $idUsuario){
        $command = "SELECT id, username, email, foto, role FROM usuarios WHERE id = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $user = false;

        if($result){
            $user = mysqli_fetch_assoc($result);
        }

        if($user["role"] == 'user'){
            return false;
        }

        return true;
    }

    function getAllusuarios($conn, $idUsuarioLogado){
        $command = "SELECT id, username, email, foto, bio, role FROM usuarios WHERE id != 1 AND id != ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idUsuarioLogado);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $usuarios = array();

        if($result){
            while($usuario = mysqli_fetch_assoc($result)){
                array_push($usuarios, $usuario);
            }
        }

        return $usuarios;
    }

    function getUsuarioById($conn, $idUsuario){
        $command = "SELECT id, username, email, foto, bio, role FROM usuarios WHERE id = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $user = false;

        if($result){
            $user = mysqli_fetch_assoc($result);
        }

        return $user;
    }

    function getIdUsuarioByToken($conn,$token){
       
        $sql = "Select id_usuario, data_expiracao from usuario_token where token = ?";
    
        $usuarioToken = false;
    
        $stmt = mysqli_prepare($conn, $sql);
    
        mysqli_stmt_bind_param($stmt, "s", $token);
    
        mysqli_stmt_execute($stmt);
    
        $resultado = mysqli_stmt_get_result($stmt);
    
        if($resultado){
            $usuarioToken = mysqli_fetch_assoc($resultado);
        }
    
        return $usuarioToken;
    }

    //cadastro
    function verificarUsernameUsuario($conn, $username){
        $command = "SELECT count(*) AS usernameEmUso FROM usuarios WHERE username = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $usernameEmUso = false;

        if($result){
            $usernameEmUso = mysqli_fetch_assoc($result);
        }

        return $usernameEmUso["usernameEmUso"];
    }

    function verificarEmailUsuario($conn, $email){
        $command = "SELECT count(*) AS emailEmUso FROM usuarios WHERE email = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $emailEmUso = false;

        if($result){
            $emailEmUso = mysqli_fetch_assoc($result);
        }

        return $emailEmUso["emailEmUso"];
    }

    function createUsuario($conn, $username, $email, $password, $foto){
        $command = "INSERT INTO usuarios(username, email, senha, foto) VALUES (?, ?, ?, ?)";

        $passwordCripto = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $passwordCripto, $foto);
        $result = mysqli_stmt_execute($stmt);

        return $result ? mysqli_insert_id($conn) : false;
    }

    function updateUsuario($conn, $id, $username, $foto, $bio){
        $command = "UPDATE `usuarios` SET `username`= ?,`foto`= ?, `bio`= ?   WHERE id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "sssi", $username, $foto, $bio, $id);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function tornarAdm($conn, $id){
        $command = "UPDATE `usuarios` SET `role`= 'admin' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function removerAdm($conn, $id){
        $command = "UPDATE `usuarios` SET `role`= 'user' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    //login
    function validaLogin($conn, $email, $password){
        $user = false;

        $command = "SELECT  id, username, email, senha, foto, role FROM usuarios WHERE email = ?";

        
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if($result && $result->num_rows != 0){
            $user = mysqli_fetch_assoc($result);

            if(!password_verify($password, $user["senha"])){
                $user = false;
            } else{
                unset($user["password"]);
            }
        }

        return $user;
    }

    function gerarToken($conn, $user){
        $bytes = random_bytes(16);
        $token = bin2hex($bytes);
    
        $validade = date('Y-m-d H:i:s', strtotime('+10 days'));
    
        $sql = "Insert into usuario_token(id_usuario, token, data_expiracao) values (?, ?, ?)";
    
        $stmt = mysqli_prepare($conn, $sql);
    
        mysqli_stmt_bind_param($stmt,"iss",$user["id"], $token, $validade);
    
        $result = mysqli_stmt_execute($stmt);
    
        return $result ? $token : false;    
    }

    function adicionaTokenUsuario($conexao, $idUsuario, $token, $validade) {
        if (!$conexao || !$idUsuario || !$token || !$validade) {
            return false;
        }
    
        $sql = "INSERT INTO usuario_token (id_usuario, token, data_expiracao) 
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE token = ?, data_expiracao = ?";
    
        $stmt = mysqli_prepare($conexao, $sql);
    
        if (!$stmt) {
            return false;
        }
    
        mysqli_stmt_bind_param($stmt, "issss", $idUsuario, $token, $validade, $token, $validade);
    
        if (!mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return false;
        }
    
        mysqli_stmt_close($stmt);
        return true;
    }

    //filme
    function createFilme($conn, $id, $titulo, $dataLancamento, $sinopse, $capa, $foto){
        $command = "INSERT INTO filmes(id, titulo, dataDeLancamento, sinopse, capa, foto) values (?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "isssss", $id, $titulo, $dataLancamento, $sinopse, $capa, $foto);
        $result = mysqli_stmt_execute($stmt);

        return $result ? $id : false;
    }

    function filmeJaCadastrado($conn, $idFilme){
        $command = "SELECT count(*) AS existeFilme FROM filmes WHERE id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idFilme);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $filme = false;

        if($result){
            $filmeExiste = mysqli_fetch_assoc($result);
        }

        if($filmeExiste["existeFilme"] == 1){
            $filme = true;
        }

        return $filme;
    }

    function getFilmeById($conn, $id){
        $command = "SELECT id, titulo, dataDeLancamento ,sinopse, capa, foto FROM filmes WHERE id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $filme = false;

        if($result){
            $filme = mysqli_fetch_assoc($result);
        }

        return $filme;
    }

    function getAllFilmes($conn){
        $command = "SELECT id, titulo, capa, foto FROM filmes";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $filmes = array();

        if($result){
            while($filme = mysqli_fetch_assoc($result)){
                array_push($filmes, $filme);
            }
        }

        return $filmes;
    }

    function deleteFilme($conn, $id){
        $command = "DELETE FROM filmes WHERE id = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    //analise
    function createAnalise($conn, $idFilme, $idUsuario, $comentario, $nota){
        $command = "INSERT INTO analises(id_filme, id_usuario, comentario, nota) values (?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "iisd", $idFilme, $idUsuario, $comentario, $nota);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function deleteAnalise($conn, $idFilme, $idUsuario){
        $command = "DELETE FROM analises WHERE id_filme = ? AND id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idFilme, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function updateAnalise($conn, $idFilme, $idUsuario, $comentario, $nota){
        $command = "UPDATE `analises` SET `comentario`= ?,`nota`= ?  WHERE id_filme = ? AND id_usuario = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "sdii", $comentario, $nota, $idFilme, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function jaAnalisei($conn, $idFilme, $idUsuario){
        $command = "SELECT count(*) AS existeAnalise FROM analises WHERE id_filme = ? AND id_usuario = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idFilme, $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $analisou = false;

        if($result){
            $ExisteAnalise = mysqli_fetch_assoc($result);
        }

        if($ExisteAnalise["existeAnalise"] == 1){
            $analisou = true;
        }

        return $analisou;
    }

    function getAnalisesByIdFilme($conn, $idFilme){
        $command = "SELECT id_filme, id_usuario, comentario, nota, curtidas FROM analises WHERE id_filme = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idFilme);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $analises = array();

        if($result){
            while($analise = mysqli_fetch_assoc($result)){
                $conn = connect();
                if(!isAvaliacaoRetida($conn, $analise["id_filme"], $analise["id_usuario"])){
                    array_push($analises, $analise);
                }
                disconnect($conn);
            }
        }

        return $analises;
    }

    function getAnalisesByIdUsuario($conn, $idUsuario){
        $command = "SELECT id_filme, id_usuario, comentario, nota, curtidas FROM analises WHERE id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $analises = array();

        if($result){
            while($analise = mysqli_fetch_assoc($result)){
                $conn = connect();
                if(!isAvaliacaoRetida($conn, $analise["id_filme"], $analise["id_usuario"])){
                    array_push($analises, $analise);
                }
                disconnect($conn);
            }
        }

        return $analises;
    }

    function getAnaliseById($conn, $idFilme, $idUsuario){
        $command = "SELECT id_filme, id_usuario, comentario, nota, curtidas FROM analises WHERE id_filme = ? AND id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idFilme, $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $analise = false;

        if($result){
            $analise = mysqli_fetch_assoc($result);
        }

        return $analise;
    }

    function isAnaliseRetida($conn, $idFilme, $idUsuario){
        $command = "SELECT count(*) as isRetida FROM `avaliacoesretidas` WHERE idFilme = ? AND idUsuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idFilme, $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $analise = false;

        if($result){
            $analise = mysqli_fetch_assoc($result);
        }

        if($analise["isRetida"] > 0){
            return true;
        }

        return false;
    }

    function gerarEstrelas($nota){
        $estrelas = '';

        for ($i = 1; $i <= 5; $i++) {
            if($nota >= $i){
                $estrelas .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill estrela" viewBox="0 0 16 16">
                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>';
            } else if($nota == $i - 0.5){
                $estrelas .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half meia-estrela" viewBox="0 0 16 16">
                                    <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                                </svg>';
            } else{
                $estrelas .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#5f66f8" class="bi bi-star estrela-vazia" viewBox="0 0 16 16">
                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                            </svg>';
            }
        }

        return $estrelas;
    }

    //lista
    function createLista($conn, $titulo, $descricao, $idUsuarioCriador){
        $command = "INSERT INTO listas(titulo, descricao, idCriadorLista) values (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ssi", $titulo, $descricao, $idUsuarioCriador);
        $result = mysqli_stmt_execute($stmt);

        return $result ? mysqli_insert_id($conn) : false;
    }

    function deleteLista($conn, $idLista){
        removeAllFilmesLista($conn, $idLista);

        $command = "DELETE FROM listas WHERE id = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idLista);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function getListaById($conn, $idLista){
        $command = "SELECT id, titulo, descricao, idCriadorLista FROM listas WHERE id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idLista);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $lista = false;

        if($result){
            $lista = mysqli_fetch_assoc($result);
        }

        return $lista;
    }

    function getAllListas($conn){
        $command = "SELECT id, titulo, descricao FROM listas";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $listas = array();

        if($result){
            while($lista = mysqli_fetch_assoc($result)){
                array_push($listas, $lista);
            }
        }

        return $listas;
    }

    function addFilmeInLista($conn, $idLista, $idFilme){
        $command = "INSERT INTO lista_filmes(id_lista, id_filme) values(?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idLista, $idFilme);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function removeFilmeLista($conn, $idLista, $idFilme){
        $command = "DELETE FROM lista_filmes WHERE id_lista = ? AND id_filme = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idLista, $idFilme);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function removeAllFilmesLista($conn, $idLista){
        $command = "DELETE FROM lista_filmes WHERE id_lista = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idLista);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function getListasByIdUsuario($conn, $idUsuario){
        $command = "SELECT id, titulo, descricao FROM listas WHERE idCriadorLista = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $listas = array();

        if($result){
            while($lista = mysqli_fetch_assoc($result)){
                array_push($listas, $lista);
            }
        }

        return $listas;
    }

    function getFilmesInLista($conn, $idLista){
        $command = "SELECT id_filme FROM lista_filmes WHERE id_lista = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idLista);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $filmes = array();

        if($result){
            while($filme = mysqli_fetch_assoc($result)){
                array_push($filmes, $filme);
            }
        }

        return $filmes;
    }

    function salvarLista($conn, $idLista, $idUsuario){
        $command = "INSERT INTO listas_salvas(id_lista, id_usuario) values(?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idLista, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function removerListaSalva($conn, $idLista, $idUsuario){
        $command = "DELETE FROM listas_salvas WHERE id_lista = ? AND id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idLista, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function getListasSalvas($conn, $idUsuario){
        $command = "SELECT id_lista FROM listas_salvas WHERE id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $listas = array();

        if($result){
            while($lista = mysqli_fetch_assoc($result)){
                array_push($listas, $lista);
            }
        }

        return $listas;
    }

    //comunidade
    function createComunidade($conn, $titulo, $descricao, $criadorId, $donoId, $dataCriacao, $capa, $banner){
        $command = "INSERT INTO comunidades(titulo, descricao, criador_id, dono_id, criado_em, capa, banner) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ssiisss", $titulo, $descricao, $criadorId, $donoId, $dataCriacao, $capa, $banner);
        $result = mysqli_stmt_execute($stmt);

        return $result ? mysqli_insert_id($conn) : false;
    }

    function getAllComunidades($conn){
        $command = "SELECT id, titulo, descricao, criador_id, capa, banner FROM comunidades";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $comunidades = array();

        if($result){
            while($comunidade = mysqli_fetch_assoc($result)){
                array_push($comunidades, $comunidade);
            }
        }

        return $comunidades;
    }

    function getComunidadeById($conn, $id){
        $command = "SELECT id, titulo, descricao, criador_id, dono_id, criado_em, capa, banner, dono_id FROM comunidades WHERE id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $comunidade = false;

        if($result){
            $comunidade = mysqli_fetch_assoc($result);
        }

        return $comunidade;
    }

    function getIdsComunidadesByIdUsuario($conn, $idUsuario){
        $command = "SELECT id_comunidade, id_usuario FROM comunidade_usuarios WHERE id_usuario = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $idsComunidades = array();

        if($result){
            while($idComunidade = mysqli_fetch_assoc($result)){
                array_push($idsComunidades, $idComunidade);
            }
        }

        return $idsComunidades;
    }

    function getQntUsuariosComunidade($conn, $idComunidade){
        $command = "SELECT count(id_comunidade) as qntUsers FROM comunidade_usuarios WHERE id_comunidade = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idComunidade);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $qntUsuarios = false;

        if($result){
            $qntUsuarios = mysqli_fetch_assoc($result);
        }

        return $qntUsuarios;
    }

    function getAllIdsMembrosComunidade($conn, $idComunidade, $idDono){
        $command = "SELECT id_usuario FROM comunidade_usuarios WHERE id_comunidade = ? AND id_usuario != ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idComunidade, $idDono);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $idsUsuarios = array();

        if($result){
            while($idUsuario = mysqli_fetch_assoc($result)){
                array_push($idsUsuarios, $idUsuario);
            }
        }

        return $idsUsuarios;
    }

    function addMembroComunidade($conn, $idComunidade, $idUsuario){
        $command = "INSERT INTO comunidade_usuarios(id_comunidade, id_usuario) values(?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idComunidade, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function removeMembroComunidade($conn, $idComunidade, $idUsuario){
        $command = "DELETE FROM `comunidade_usuarios` WHERE id_comunidade = ? AND id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idComunidade, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function isMembro($conn, $idComunidade, $idUsuario){
        $command = "SELECT id_usuario FROM comunidade_usuarios WHERE id_comunidade = ? AND id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idComunidade, $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $user = false;

        if($result){
            $user = mysqli_fetch_assoc($result);
        }

        return $user;
    }

    function tornarAdmComunidade($conn, $idComunidade, $idUsuario){
        $command = "INSERT INTO comunidade_adm(id_comunidade, id_usuario) VALUES (?,?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii",$idComunidade, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function removerAdmComunidade($conn, $idComunidade, $idUsuario){
        $command = "DELETE FROM comunidade_adm WHERE id_comunidade = ? AND id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idComunidade, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function isAdmComunidade($conn, $idComunidade, $idUsuario){
        $command = "SELECT count(id_usuario) as isAdm FROM comunidade_adm WHERE id_comunidade = ? AND id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idComunidade, $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $isAdm = false;

        if($result){
            $isAdm = mysqli_fetch_assoc($result);
        }

        if($isAdm["isAdm"] == 0){
            return false;
        }

        return true;
    }

    function removerUsuarioComunidade($conn, $idComunidade, $idUsuario){
        $command = "DELETE FROM comunidade_usuarios WHERE id_comunidade = ? AND id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idComunidade, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function isDonoComunidade($conn, $idComunidade, $idUsuario){
        $comunidade = getComunidadeById($conn, $idComunidade);

        if($comunidade["dono_id"] != $idUsuario){
            return false;
        }

        return true;
    }

    function passarPosseComunidade($conn, $idComunidade, $idUsuario){
        $command = "UPDATE `comunidades` SET `dono_id`= ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idUsuario, $idComunidade);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function excluirComunidade($conn, $idComunidade) {
        $command1 = "DELETE FROM post WHERE comunidade_id = ?";
        $stmt1 = mysqli_prepare($conn, $command1);
        mysqli_stmt_bind_param($stmt1, "i", $idComunidade);
        $result1 = mysqli_stmt_execute($stmt1);

        if (!$result1) {
            return false;
        }

        $command3 = "DELETE FROM comunidade_usuarios WHERE id_comunidade = ?";
        $stmt3 = mysqli_prepare($conn, $command3);
        mysqli_stmt_bind_param($stmt3, "i", $idComunidade);
        $result3 = mysqli_stmt_execute($stmt3);

        if (!$result3) {
            return false;
        }

        $command4 = "DELETE FROM comunidade_adm WHERE id_comunidade = ?";
        $stmt4 = mysqli_prepare($conn, $command4);
        mysqli_stmt_bind_param($stmt4, "i", $idComunidade);
        $result4 = mysqli_stmt_execute($stmt4);

        if (!$result4) {
            return false;
        }

        $command5 = "DELETE FROM comunidades WHERE id = ?";
        $stmt5 = mysqli_prepare($conn, $command5);
        mysqli_stmt_bind_param($stmt5, "i", $idComunidade);
        $result5 = mysqli_stmt_execute($stmt5);

        if (!$result5) {
            return false;
        }

        return true;
    }

    //postagem comunidade

    function createPost($conn, $idElementoPai ,$idComunidade, $idUsuario, $titulo, $conteudo, $dataHora){
        $command = "INSERT INTO post(elemento_pai_id, comunidade_id, usuario_id, titulo, comentario, data_hora) VALUES (?,?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "iiisss", $idElementoPai, $idComunidade, $idUsuario, $titulo, $conteudo, $dataHora);
        $result = mysqli_stmt_execute($stmt);

        return $result ? mysqli_insert_id($conn) : false;
    }

    function getAllPostsByIdComunidade($conn, $idComunidade){
        $command = "SELECT id, elemento_pai_id, comunidade_id, usuario_id, titulo, comentario, data_hora, up_votes, down_votes FROM post WHERE comunidade_id = ? AND elemento_pai_id IS NULL ORDER BY data_hora DESC";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idComunidade);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $posts = array();

        if($result){
            while($post = mysqli_fetch_assoc($result)){
                array_push($posts, $post);
            }
        }

        return $posts;
    }

    function getPostById($conn, $idPost){
        $command = "SELECT id, comunidade_id, usuario_id, titulo, comentario, data_hora, up_votes, down_votes FROM post WHERE id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idPost);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $post = false;

        if($result){
            $post = mysqli_fetch_assoc($result);
        }

        return $post;
    }

    function exibirPost($post){
        $votouUp = '';
        if($post["votouUp"])
            $votouUp = 'btnUpVoteFeito';

        $votouDown = '';
        if($post["votouDown"])
            $votouDown = "btnDownFeito";
        
        $conn = connect();
        $idUsuarioAtivo = getIdUsuarioByToken($conn, $_COOKIE["token"]);
        $isAdm = isAdm($conn,$idUsuarioAtivo["id_usuario"]);
        disconnect($conn);

        if($isAdm){
            echo'
                <div class="post p-3 d-flex gap-2" data-post-id="'.$post["id"].'" id="containerPost-'.$post["id"].'">
                    <div class="w-100">
                        <div class="d-flex align-itens-center justify-content-between w-100">
                            <div class="d-flex gap-3">
                                <div class="foto-perfil-post">
                                    <img src="'.$post["usuario"]["foto"].'" alt="" width="30px">
                                </div>
                                <span class="nomeUsuario"><a href="perfil.php?id='.$post["usuario"]["id"].'" class="link-secondary">'.$post["usuario"]["username"].'</a></span>
                                <p>'. $post["elementoPai"].'</p>
                            </div>
                        </div>
                        <div>
                            <p class="fs-4">'.$post["titulo"].'</p>
                            <div class="comentario-limitado">
                                '.$post["comentario"].'
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-center mt-3">
                            <div class="d-flex gap-2 align-items-center div-up-vote rounded-5">
                                <div class="child-div-up-vote p-1 rounded-5 '. $votouUp .'" id="btnUpVote-'.$post["id"].'" role="button" tabindex="0" data-action="upvote">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 19 19">
                                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                    </svg>
                                </div>

                                '.$post["qntUpVotes"].'
                                

                                <div class="child-div-up-vote p-1 rounded-5 '. $votouDown .'" id="btnDownVote-'.$post["id"].'" role="button" tabindex="0" data-action="downvote">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-chevron-down"  viewBox="0 0 19 19">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-dots" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>

                            <button class="btn-adm bg-gradient-dark p-2" data-action="reterPost">
                                Reter publicação
                            </button>
                        </div>
                    </div>
                </div>
            ';
        }else{
            echo'
                <div class="post p-3 d-flex gap-2" data-post-id="'.$post["id"].'" id="containerPost-'.$post["id"].'">
                    <div class="w-100">
                        <div class="d-flex align-itens-center justify-content-between w-100">
                            <div class="d-flex gap-3">
                                <div class="foto-perfil-post">
                                    <img src="'.$post["usuario"]["foto"].'" alt="" width="30px">
                                </div>
                                <span class="nomeUsuario"><a href="perfil.php?id='.$post["usuario"]["id"].'" class="link-secondary">'.$post["usuario"]["username"].'</a></span>

                                <p>'. $post["elementoPai"].'</p>
                            </div>
                        </div>
                        <div>
                            <p class="fs-4">'.$post["titulo"].'</p>
                            <div class="comentario-limitado">
                                '.$post["comentario"].'
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-center mt-3">
                            <div class="d-flex gap-2 align-items-center div-up-vote rounded-5">
                                <div class="child-div-up-vote p-1 rounded-5 '. $votouUp .'" id="btnUpVote-'.$post["id"].'" role="button" tabindex="0" data-action="upvote">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 19 19">
                                        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
                                    </svg>
                                </div>

                                '.$post["qntUpVotes"].'
                                

                                <div class="child-div-up-vote p-1 rounded-5 '. $votouDown .'" id="btnDownVote-'.$post["id"].'" role="button" tabindex="0" data-action="downvote">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-chevron-down"  viewBox="0 0 19 19">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-dots" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                        </div>
                    </div>
                </div>
            ';
        }
        
    }

    function reterPostParaAnalise($conn, $idPost){
        $command = "INSERT INTO postsretidos(idPost) VALUES (?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idPost);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function permitirPostRetido($conn, $idPost){
        $command = "DELETE FROM postsretidos WHERE idPost = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idPost);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function reterAvaliacaoParaAnalise($conn, $idFilme, $idUsuario){
        $command = "INSERT INTO avaliacoesretidas(idFilme, idUsuario) VALUES (?,?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idFilme, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function permitirAvaliacaoRetida($conn, $idFilme, $idUsuario){
        $command = "DELETE FROM avaliacoesretidas WHERE idFilme = ? AND idUsuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idFilme, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function isPostRetido($conn, $idPost){
        $command = "SELECT count(*) AS isRetido FROM postsretidos WHERE idPost = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idPost);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $retido = false;

        if($result){
            $isRetido = mysqli_fetch_assoc($result);
        }

        if($isRetido["isRetido"] == 1){
            $retido = true;
        }

        return $retido;
    }

    function isAvaliacaoRetida($conn, $idFilme, $idUsuario){
        $command = "SELECT count(*) AS isRetido FROM avaliacoesretidas WHERE idFilme = ? and idUsuario = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idFilme, $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $retido = false;

        if($result){
            $isRetido = mysqli_fetch_assoc($result);
        }

        if($isRetido["isRetido"] == 1){
            $retido = true;
        }

        return $retido;
    }

    function getIdPostsRetidos($conn){
        $command = "SELECT idPost FROM postsretidos";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $posts = array();

        if($result){
            while($post = mysqli_fetch_assoc($result)){
                array_push($posts, $post);
            }
        }

        return $posts;
    }

    function getIdAvaliacoesRetidas($conn){
        $command = "SELECT idFilme, idUsuario FROM avaliacoesretidas";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $avaliacoes = array();

        if($result){
            while($avaliacao = mysqli_fetch_assoc($result)){
                array_push($avaliacoes, $avaliacao);
            }
        }

        return $avaliacoes;
    }

    function getComentariosByIdElementoPai($conn, $idElementoPai){
        $command = "SELECT id, elemento_pai_id, comunidade_id, usuario_id, titulo, comentario, data_hora FROM post WHERE elemento_pai_id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idElementoPai);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $comentarios = array();

        if($result){
            while($post = mysqli_fetch_assoc($result)){
                array_push($comentarios, $post);
            }
        }

        return $comentarios;
    }

    function votouPost($conn, $idPost, $idUser){
        $command = "SELECT count(*) AS existeVoto FROM votos_posts WHERE id_post = ? AND id_usuario = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idPost, $idUser);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $votou = false;

        if($result){
            $ExisteVoto = mysqli_fetch_assoc($result);
        }

        if($ExisteVoto["existeVoto"] == 1){
            $votou = true;
        }

        return $votou;
    }

    function votouUpPost($conn, $idPost, $idUser){
        $command = "SELECT count(*) AS existeVoto, up_vote FROM votos_posts WHERE id_post = ? AND id_usuario = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idPost, $idUser);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $votou = false;

        if($result){
            $ExisteVoto = mysqli_fetch_assoc($result);
        }

        if($ExisteVoto["existeVoto"] == 1 and $ExisteVoto["up_vote"] == 1){
            $votou = true;
        }

        return $votou;
    }

    function votouDownPost($conn, $idPost, $idUser){
        $command = "SELECT count(*) AS existeVoto, down_vote FROM votos_posts WHERE id_post = ? AND id_usuario = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idPost, $idUser);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $votou = false;

        if($result){
            $ExisteVoto = mysqli_fetch_assoc($result);
        }

        if($ExisteVoto["existeVoto"] == 1 and $ExisteVoto["down_vote"] == 1){
            $votou = true;
        }

        return $votou;
    }

    function criarVoto($conn, $idPost, $idUser, $upVote, $downVote){
        $command = "INSERT INTO votos_posts(id_post, id_usuario, up_vote, down_vote) VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "iiii", $idPost, $idUser, $upVote, $downVote);
        $result = mysqli_stmt_execute($stmt);

        return $result ? mysqli_insert_id($conn) : false;
    }

    function upVote($conn, $idPost, $idUser){
        $command = "SELECT up_vote, down_vote FROM votos_posts WHERE id_post = ? AND id_usuario = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idPost, $idUser);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $voto = false;

        if($result){
            $voto = mysqli_fetch_assoc($result);
        }

        if($voto["down_vote"] == 1){
            $command = "UPDATE `votos_posts` SET `up_vote`= 1,`down_vote`= 0 WHERE id_post = ? AND id_usuario = ?";
        } else if($voto["up_vote"] == 1){
            $command = "UPDATE `votos_posts` SET `up_vote`= 0 WHERE id_post = ? AND id_usuario = ?";
        } else{
            $command = "UPDATE `votos_posts` SET `up_vote`= 1 WHERE id_post = ? AND id_usuario = ?";
        }

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idPost, $idUser);
        mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function downVote($conn, $idPost, $idUser){
        $command = "SELECT up_vote, down_vote FROM votos_posts WHERE id_post = ? AND id_usuario = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idPost, $idUser);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $voto = false;

        if($result){
            $voto = mysqli_fetch_assoc($result);
        }

        if($voto["up_vote"] == 1){
            $command = "UPDATE `votos_posts` SET `up_vote`= 0, `down_vote`= 1 WHERE id_post = ? AND id_usuario = ?";
        } else if($voto["down_vote"] == 1){
            $command = "UPDATE `votos_posts` SET `down_vote`= 0 WHERE id_post = ? AND id_usuario = ?";
        } else{
            $command = "UPDATE `votos_posts` SET `down_vote`= 1 WHERE id_post = ? AND id_usuario = ?";
        }

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idPost, $idUser);
        mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    function getQntUpVotes($conn, $idPost){
        $command = "SELECT count(*) AS upVotes FROM votos_posts WHERE id_post = ? AND up_vote = 1";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idPost);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $qntUpVotes = false;

        if($result){
            $qntUpVotes = mysqli_fetch_assoc($result)["upVotes"];
        }

        return $qntUpVotes;
    }

    function isFollowing($conn, $idSeguidor, $idSeguido) {
        $stmt = $conn->prepare("SELECT 1 FROM seguidores WHERE id_usuario_seguidor = ? AND id_usuario_seguindo = ?");
        $stmt->bind_param("ii", $idSeguidor, $idSeguido);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    
    function followUser($conn, $idSeguidor, $idSeguido) {
        $stmt = $conn->prepare("INSERT IGNORE INTO seguidores (id_usuario_seguidor, id_usuario_seguindo) VALUES (?, ?)");
        $stmt->bind_param("ii", $idSeguidor, $idSeguido);
        return $stmt->execute();
    }
    
    function unfollowUser($conn, $idSeguidor, $idSeguido) {
        $stmt = $conn->prepare("DELETE FROM seguidores WHERE id_usuario_seguidor = ? AND id_usuario_seguindo = ?");
        $stmt->bind_param("ii", $idSeguidor, $idSeguido);
        return $stmt->execute();
    }
    
    function getFollowersCount($conn, $idUsuario) {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM seguidores WHERE id_usuario_seguindo = ?");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }
    
    function getFollowingCount($conn, $idUsuario) {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM seguidores WHERE id_usuario_seguidor = ?");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }


    //abraham linconler
    function updateComunidade($conn, $idComunidade, $titulo, $descricao, $capa, $banner){
        $stmt = $conn->prepare("UPDATE comunidades SET titulo=?, descricao=?, capa=?, banner=? WHERE id=?");
        return $stmt->execute([$titulo, $descricao, $capa, $banner, $idComunidade]);
    }

    function deleteComentariosPost($conn, $idPost){
        $command = "DELETE FROM post WHERE elemento_pai_id = ?"; 

        $stmt = mysqli_prepare($conn, $command); 
        mysqli_stmt_bind_param($stmt, "i", $idPost); 
        $result = mysqli_stmt_execute($stmt); 

        return $result; 
    }

    function deletarPost($conn, $idPost){
        deleteComentariosPost($conn, $idPost); 
        $command = "DELETE FROM post WHERE id = ?"; 

        $stmt = mysqli_prepare($conn, $command); 
        mysqli_stmt_bind_param($stmt, "i", $idPost); 
        $result = mysqli_stmt_execute($stmt); 

        return $result; 
    }

    //similares
    /* function exibirCarouselSimilares($conn, $categorias, $jogoAtual){
        $idJogosUnicos = array();

        foreach ($categorias as $i => $categoria) 
        {
            $idJogos = getIdJogosByCategoria($conn, $categoria["id"]);
            foreach ($idJogos as $i => $idJogo) {
                array_push($idJogosUnicos, $idJogo["idJogoCategoria"]);
            }
        }

        $idJogosUnicos = array_unique($idJogosUnicos);
        foreach ($idJogosUnicos as $i => $idJogo) {
            if($jogoAtual != $idJogo){
                $jogo = getJogoById($conn ,$idJogo);
                echo '
                    <div style="width: 18rem; height: 180px; overflow:hidden; cursor: pointer;" class="div-imagem-card-jogo swiper-slide position-relative rounded-3 m-2 pe-auto" onclick="window.location=\'jogo.php?id='.$jogo["id"].'\'">
                        <img src="'.$jogo["capa"].'" alt="" class="img-card-jogo h-100 d-block rounded-3">
                        <div class="titulo-card-jogo w-100 position-absolute top-0 start-0 d-flex align-items-end">
                            <p class="text-white px-2 dt">'.$jogo["titulo"].'</p>
                        </div>
                    </div>
                ';
            }
        }
    } */