<?php
  include 'config/conexion.php';
  include 'config/sign_In_Controller.php';
?>

<!Doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="style/style.css" rel="stylesheet">
    <link rel="icon" href="../logo.png" type="image/png">
  </head>
  <body>
    <div class="container">
      <form action="" method="post">
        <h1>Iniciar sesión</h1>

    <?php
      if (isset($_SESSION['user'])) {
        echo '<div class="link"><p>Sesion activa. <a href="config/log_Out.php">Cerrar sesión</a></p></div>';
      }
    ?>
        
        <div class="input-box">
          <input type="text" placeholder="Usuario" name="user" required>
          <img class="user-login" src="../icon/user-regular-24.png" alt="user">
        </div>
        <div class="input-box">
          <input class="password" type="password" placeholder="Contraseña" name="password" required>
          <a id="showPassword"><img id="show" src="../icon/hide-regular-24.png" alt="hide-password"></a>
        </div>
        <input class="button" type="submit" value="Iniciar sesión" name="login">
        <div class="link">
          <p>¿No tienes cuenta? <a href="sign_Up.php">Registrate</a></p>
          <p>Continuar sin cuenta. <a href="../index.html">Volver</a></p>
        </div>
      </form>
    </div>
    <script src="script/script.js"></script>
  </body>
</html>
