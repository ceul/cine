<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.silla.php");
	$obj = new silla();
	if (isset($_POST['codigo']) && isset($_POST['color'])&& isset($_POST['fila'])&& isset($_POST['columna'])&& isset($_POST['sala'])){
                $obj->id=$_POST['codigo'];
		$obj->color=$_POST['color'];
                $obj->fila=$_POST['fila'];
                $obj->columna=$_POST['columna'];
                $obj->sala=$_POST['sala'];
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
