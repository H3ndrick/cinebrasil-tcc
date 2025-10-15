<?php
    setcookie("token", $_COOKIE['token'], time()-1, '/');
    

    header("location: ../login.php");
    exit();