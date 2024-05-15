<?php
    include 'conexion.php';

    if(!empty($_POST["register"])) {
        $name = $_POST["name"];
        $user = $_POST["user"];
        $password = md5($_POST["password"]);

        $repeat = $conexion->query(" SELECT * FROM user WHERE user = '$user' ");
            
        if($datos = $repeat->fetch_object()) {
            echo '<p class="session-control duplicate" style="display: flex;">Usuario existente.</p>';
        } else {
            $sql = $conexion->query(" INSERT INTO user(user, password, name) VALUES('$user', '$password', '$name') ");
                
            if($sql == 1) {
                echo '<script>window.location="/";</script>';
            } else {
                echo '<p class="session-control error" style="display: flex;">Error al registrar.</p>';
            }
        }
    }
?>
