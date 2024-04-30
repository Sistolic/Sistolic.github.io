<?php
    include 'sign_In_Controller.php';

    if(isset($_SESSION['user'])) {
        session_destroy();
        echo '<script>window.location="../sign_In.php";</script>';
    } else {
        if(window.confirm("Sin sesión activa, ¿Regresar?")) {
           echo '<script>window.location="/index.php";</script>';
        } else {
            echo '<script>window.location="../sign_In.php";</script>';
        }
        
    }
?>
