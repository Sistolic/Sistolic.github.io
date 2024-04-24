<?php
    if(!empty($_POST["login"])) {
        if(empty($_POST["user"]) or empty($_POST["password"])) {
            echo '<div class="alert">Uno de los campos esta vacio</div>';
        } else {
            $user = $_POST["user"];
            $password = md5($_POST["password"]);
            $sql = $conexion->query(" select * from user where user = '$user' and password = '$password' ");
            
            if($datos = $sql->fetch_object()) {
                $_SESSION['user'] = $user;
                header("location:../index.html");
            } else {
                echo '<div class="alert">Acceso denegado</div>';
            }
        }
    }
?>
