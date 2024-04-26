<?php
    if(!empty($_POST["register"])) {
        if(empty($_POST["name"]) or empty($_POST["user"]) or empty($_POST["password"])) {
            echo '<div class="alert">Uno de los campos está vacío</div>';
        } else {
            $name = $_POST["name"];
            $user = $_POST["user"];
            $password = md5($_POST["password"]);

            $sql = $conexion->query("INSERT INTO user(user, password, name) VALUES ('$user', '$password', '$name') ");

            if($sql == 1) {
                header("Location: ../sign_In.php");
                exit();
            } else {
                echo '<div class="alert">Error al registrar</div>';
            }
        }
    }
?>
