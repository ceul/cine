<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.pelicula.php");
	$obj = new pelicula();
	if (isset($_POST['codigo']) && isset($_POST['nombre'])){
		$obj->id=$_POST['codigo'];
		$obj->nombre=$_POST['nombre'];
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
