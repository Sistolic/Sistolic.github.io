<?php
    session_start();

    $host=$_ENV["MYSQLHOST"];
    $user=$_ENV["MYSQLUSER"];
    $password=$_ENV["MYSQL_ROOT_PASSWORD"];
    $db_name=$_ENV["MYSQL_DATABASE"];
    $port=$_ENV["MYSQLPORT"];

    $conexion=mysqli_connect("$host", "$user", "$password", "$db_name", "$port");
    $conexion->set_charset('utf8');
?>
