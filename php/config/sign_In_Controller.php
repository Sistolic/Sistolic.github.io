<?php
    session_start();

    if(!empty($_POST["login"])) {
        if(empty($_POST["user"]) or empty($_POST["password"])) {
            $message = '<div class="alert">Uno de los campos está vacío</div>';
        } else {
            $user = $_POST["user"];
            $password = md5($_POST["password"]);
            $sql = $conexion->query("SELECT * FROM user WHERE user = '$user' AND password = '$password'");
            
            if($datos = $sql->fetch_object()) {
                $_SESSION['user'] = $user;
                echo '<script>window.location="/index.php";</script>';
                exit();
            } else {
                $message = '<div class="alert">Acceso denegado</div>';
            }
        }
    }
?>

<?php if(isset($message)) echo $message; ?>
