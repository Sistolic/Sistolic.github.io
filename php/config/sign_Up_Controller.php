<?php
    if(!empty($_POST["register"])) {
        $name = $_POST["name"];
        $user = $_POST["user"];
        $password = md5($_POST["password"]);

        $sql = $conexion->query("INSERT INTO user(user, password, name) VALUES ('$user', '$password', '$name') ");

        if($sql == 1) {
            echo '<script>window.location="../php/index.php";</script>';
            exit();
        }
    }
?>
