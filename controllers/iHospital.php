<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.hospital.php");
	$obj = new hospital();
	if (isset($_POST['codigo']) && isset($_POST['nombre'])&& isset($_POST['descripcion'])){
                $obj->id=$_POST['codigo'];
		$obj->nombre=$_POST['nombre'];
                $obj->descripcion=$_POST['descripcion'];
            
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
