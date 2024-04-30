<!Doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate</title>
    <link href="style/style.css" rel="stylesheet">
    <link rel="icon" href="../logo.png" type="image/png">
  </head>
  <body>
    <div class="container">
      <form action="" method="post">
        <h1>Registrate</h1>

        <?php
        include 'config/conexion.php';
        include 'config/sign_Up_Controller.php';
        ?>
        
        <div class="input-box">
          <input type="text" placeholder="Nombre" name="name">
        </div>
        <div class="input-box">
          <input type="text" placeholder="Usuario" name="user">
        </div>
        <div class="input-box">
          <input class="password" type="password" placeholder="Contraseña" name="password">
          <a id="showPassword"><img class="register-show" id="show" src="../icon/hide-regular-24.png" alt="hide-password"></a>
        </div>
        <input class="button" type="submit" value="Registrarse" name="register">
        <div class="link">
          <p>Ya tienes cuenta. <a href="sign_In.php">Inicia sesión</a></p>
          <p>Continuar sin registrarse. <a href="../index.php">Volver</a></p>
        </div>
      </form>
    </div>
    <script src="script/script.js"></script>
  </body>
</html>
