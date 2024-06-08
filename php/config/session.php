<?php
  include 'sign_In_Controller.php';

  if (isset($_SESSION['user'])) {
    echo json_encode(array("sesion_activa" => true));
  } else {
    echo json_encode(array("sesion_activa" => false));
  }