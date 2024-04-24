<?php
    include 'sign_In_Controller.php';

    if(isset($_SESSION['user'])) {
        session_destroy();
        header("location:../sign_In.php");
    } else {
        header("location:../sign_In.php");
    }