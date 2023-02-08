<?php
    $db=mysqli_connect("localhost","root","","sitio");
    if (!$db){
        echo "error de conexion";
        exit;
    }
    echo "conexion correcta";

?>