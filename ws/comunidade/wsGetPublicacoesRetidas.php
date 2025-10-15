<?php 
    include "../../includes/functions.php";
    if(session_status()==PHP_SESSION_NONE){
        session_start();
    }

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        $conn = connect();
        $postsIds = getIdPostsRetidos($conn);
        $posts = array();
        $usuarios = array();

        foreach ($postsIds as $i => $postId) {
            $posts[] = getPostById($conn,$postId["idPost"]);
            $usuarios[] = getUsuarioById($conn, $posts[$i]["usuario_id"]);
        }
        
        disconnect($conn);
        
        if($posts)
            $response = ['success' => true, 'mensagem' => 'Posts retidos foram pegos com sucesso.', 'posts' => $posts, 'usuarios' => $usuarios];
        else{
            $response = ['success' => false, 'mensagem' => 'problema no banco de dados'];
        }
        
        header("Content-Type: application/json");
        echo json_encode($response);
    }