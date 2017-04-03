<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.sala.php");
	$obj = new sala();
	if (isset($_POST['codigo']) && isset($_POST['cantidad'])&& isset($_POST['tipo'])&& isset($_POST['tamano'])){
                $obj->id=$_POST['codigo'];
		$obj->cantidad=$_POST['cantidad'];
                $obj->tipo=$_POST['tipo'];
                $obj->tamano=$_POST['tamano'];
            
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
