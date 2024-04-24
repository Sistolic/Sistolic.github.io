<?php
    if(!empty($_POST["register"])) {
        if(empty($_POST["name"]) or empty($_POST["user"]) or empty($_POST["password"])) {
            echo '<div class="alert">Uno de los campos esta vacio</div>';
        } else {
            $name = $_POST["name"];
            $user = $_POST["user"];
            $password = md5($_POST["password"]);
            md5($password);
            echo $pasword;
            $sql = $conexion->query(" insert into user(user, password, name) values('$user', '$password', '$name') ");

            if($sql == 1) {
                header("location:sign_In.php");
            } else {
                echo '<div class="alert">Error al registrar</div>';
            }
        }
    }