<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.empleados.php");
	$obj = new empleados();
	if (isset($_POST['codigo']) && isset($_POST['nombre'])&& isset($_POST['salario'])){
                $obj->id=$_POST['codigo'];
		$obj->nombre=$_POST['nombre'];
                $obj->salario=$_POST['salario'];
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
