<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.entrada.php");
	$obj = new entrada();
	if (isset($_POST['codigo']) && isset($_POST['id_pelicula'])&& isset($_POST['costo'])){
		$obj->id=$_POST['codigo'];
		$obj->id_pelicula=$_POST['id_pelicula'];
		$obj->costo=$_POST['costo'];
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
