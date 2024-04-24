<?php
    $host="monorail.proxy.rlwy.net";
    $user="root";
    $password="iqIXVKwlgQhJEPYbyIgDduUnvzvpARje";
    $db_name="railway";
    $port="14644";

    $conexion=mysqli_connect("$host", "$user", "$password", "$db_name", "$port");
    $conexion->set_charset('utf8');
?>
