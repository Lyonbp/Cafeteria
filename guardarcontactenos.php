 <?php
    require ("administrador/config/conexion.php");

    $nombre=strtolower($_POST["txtnombre"]);
    $apellido=strtolower($_POST["txtapellido"]);
    $correo=$_POST["txtcorreo"];
    $telefono=$_POST["txttelefono"];
    $fecha=$_POST["txtfecha"];
    $comentarios=$_POST["txtcomentarios"];

    $insertar="INSERT INTO `contactanos`( nombre, apellido, correo, telefono, fecha, comentarios) 
    VALUES ('$nombre','$apellido','$correo','$telefono','$fecha','$comentarios')";

    $resultado=mysqli_query($db, $insertar);

    if($resultado){
        echo "<script>alert('Datos guardados correctamente');
        window.location='contactanos.php'</script>";  
    }else{
        echo "<script>alert('Datos No Se Guardaron Intente Nuevamente');
        windows.history.go(-1);
        </script>";
    }
?>


