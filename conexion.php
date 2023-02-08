<?php
	$mysqli = new mysqli("localhost","root","","sitio"); 
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
?>