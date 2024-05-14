<?php
    session_start();

    if(!empty($_POST["login"])) {
        $user = $_POST["user"];
        $password = md5($_POST["password"]);
        $sql = $conexion->query("SELECT * FROM user WHERE user = '$user' AND password = '$password'");
            
        if($datos = $sql->fetch_object()) {
            $_SESSION['user'] = $user;
            echo '<script>window.location="/main.html";</script>';
        } else {
            echo '<p class="session-control denied" style="display: flex;">Acceso denegado.</p>';
        }
    }
?>
