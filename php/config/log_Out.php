<?php
    include 'sign_In_Controller.php';

    if(isset($_SESSION['user'])) {
        session_destroy();
        echo '<script>window.location="/";</script>';
    } else {
        echo '<script>window.location="/";</script>';
    }
?>
