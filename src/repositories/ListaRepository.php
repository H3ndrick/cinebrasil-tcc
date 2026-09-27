<?php
class ListaRepository{
    public static function createLista($conn, $titulo, $descricao, $idUsuarioCriador){
        $command = "INSERT INTO listas(titulo, descricao, idCriadorLista) values (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ssi", $titulo, $descricao, $idUsuarioCriador);
        $result = mysqli_stmt_execute($stmt);

        $idLista = $result ? mysqli_insert_id($conn) : false;
        mysqli_stmt_close($stmt);

        return $idLista;
    }

    public static function deleteLista($conn, $idLista){
        removeAllFilmesLista($conn, $idLista);
        removeAllListasSalvas($conn, $idLista);

        $command = "DELETE FROM listas WHERE id = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idLista);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    public static function updateLista($conn, $idLista, $novoNome, $novaDescricao){
        $command = "UPDATE `listas` SET `titulo`= ?, `descricao` = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ssi", $novoNome, $novaDescricao, $idLista);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    public static function getListaById($conn, $idLista){
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

    public static function getAllListas($conn){
        $command = "SELECT id, titulo, descricao, idCriadorLista FROM listas";

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

    public static function addFilmeInLista($conn, $idLista, $idFilme){
        $command = "INSERT INTO lista_filmes(id_lista, id_filme) values(?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idLista, $idFilme);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    public static function removeFilmeLista($conn, $idLista, $idFilme){
        $command = "DELETE FROM lista_filmes WHERE id_lista = ? AND id_filme = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idLista, $idFilme);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    public static function removeAllFilmesLista($conn, $idLista){
        $command = "DELETE FROM lista_filmes WHERE id_lista = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idLista);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    public static function removeAllListasSalvas($conn, $idLista){
        $command = "DELETE FROM listas_salvas WHERE id_lista = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "i", $idLista);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    public static function getListasByIdUsuario($conn, $idUsuario){
        $command = "SELECT id, titulo, descricao, idCriadorLista FROM listas WHERE idCriadorLista = ?";

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

    public static function getIdListasUsuarioByIdFilme($conn, $idFilme, $idCriador){
        $command = "SELECT lf.id_lista 
                    FROM lista_filmes lf 
                    INNER JOIN listas l ON lf.id_lista = l.id 
                    WHERE lf.id_filme = ? AND l.idCriadorLista = ?";
    
        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idFilme, $idCriador);
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


    public static function getFilmesInLista($conn, $idLista){
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

    public static function salvarLista($conn, $idLista, $idUsuario){
        $command = "INSERT INTO listas_salvas(id_lista, id_usuario) values(?, ?)";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idLista, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result ? true : false;
    }

    public static function removerListaSalva($conn, $idLista, $idUsuario){
        $command = "DELETE FROM listas_salvas WHERE id_lista = ? AND id_usuario = ?";

        $stmt = mysqli_prepare($conn, $command);
        mysqli_stmt_bind_param($stmt, "ii", $idLista, $idUsuario);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    public static function getListasSalvas($conn, $idUsuario){
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
}