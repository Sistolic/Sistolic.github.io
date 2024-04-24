<?php
    session_start();

    $host=$_ENV["DB_HOST"];
    $user=$_ENV["DB_USER"];
    $password=$_ENV["DB_PASSWORD"];
    $db_name=$_ENV["DB_NAME"];
    $port=$_ENV["DB_PORT"];

    $conexion=new mysqli_connect("$host", "$user", "$password", "$db_name", "$port");
    // $conexion->set_charset('utf8');
?>
