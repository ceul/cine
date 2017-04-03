<?php
ini_set('display_errors', 'off');
include_once("resources/class.database.php");

class silla{
	var $id;
  	var $color;
        var $fila;
	var $columna;
	var $sala;

function silla(){
}

function select($id){
	$sql =  "SELECT * FROM cine.silla WHERE id = '$id'";
	try {
		$row = pg::query($sql);
		$row=pg_fetch_array($row);
		$this->id = $row['id'];
		$this->color = $row['color'];
                $this->fila = $row['fila'];
		$this->columna=$row['columna'];
		$this->sala=$row['fk_sala'];
		return true;
	}
	catch (DependencyException $e) {
	}
}

function delete($id){
	$sql = "DELETE FROM cine.silla WHERE id = '$id'";
	try {
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");
		return "1";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
		return "-1";
	}
}

function insert(){
//echo "me llamoooooo";
	if ($this->validaP($this->id) == false){
		$sql = "INSERT INTO cine.silla( id,fk_sala, color, fila,columna) VALUES ( '$this->id','$this->sala', '$this->color', '$this->fila', '$this->columna')";
		try {
			pg::query("begin");
			$row = pg::query($sql);
			pg::query("commit");
			echo "1";
		}
		catch (DependencyException $e) {
			echo "Error: " . $e;
			pg::query("rollback");
			echo "-1";
		}
	}
	else{
		$sql="UPDATE cine.silla set color='" . $this->color . "' WHERE id='" . $this->id . "'";
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");		
		echo "2";
	}
}

function validaP ($id){

      $sql =  "SELECT * FROM cine.silla WHERE id = '$id'";
      try {
		$row = pg::query($sql);
		if(pg_num_rows($row) == 0){
		        return false;
	        }
		else{

			return true;
		 }
		}
		catch (DependencyException $e) {
			//pg::query("rollback");
			return false;
		}
}

function getTabla(){
	
	$sql="SELECT * FROM cine.silla";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Color</th>";
                echo "	<th>Fila</th>";
                echo "	<th>Columna</th>";
		echo "	<th>Sala</th>";
		echo "	<th>.</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id'] . "</th>";
			echo "	<th>" . $row['color'] . "</th>";
                        echo "	<th>" . $row['fila'] . "</th>";
                        echo "	<th>" . $row['columna'] . "</th>";
			echo "	<th>" . $row['fk_sala'] . "</th>";
			echo "	<th><a href='#' class='btn btn-danger' onclick='elimina(\"" . $row['id'] . "\")'>X<i class='icon-white icon-trash'></i></a>.<a href='#' class='btn btn-primary' onclick='edit(\"" . $row['id'] . "\", \"" . $row['color'] . "\", \"" . $row['fila'] . "\",\"" . $row['columna'] . "\",\"" . $row['fk_sala'] . "\")'>E<i class='icon-white icon-refresh'></i></a></th>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
	catch (DependencyException $e) {
		echo "Procedimiento sql invalido en el servidor";
	}
}
function getCombo(){
	$sql="SELECT * FROM cine.sala ";
	echo"<select id='sala'>";
	try{
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo"<option value=".$row['id'].">".$row['id']."</option>\n";
		}
		echo"</select>";			
	}
	catch (DependencyException $e) {
		echo "Error al cargar el combobox";
	}
	
}

function getTablaInicianPorA(){
	
	$sql="select * from hospital.estado_habitacion where nombre like 'A%'";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Nombre</th>";
                echo "	<th>Descripcion</th>";

		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id'] . "</th>";
			echo "	<th>" . $row['nombre'] . "</th>";
                        echo "	<th>" . $row['descripcion'] . "</th>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
	catch (DependencyException $e) {
		echo "Procedimiento sql invalido en el servidor";
	}
}

function getTablaPDF(){
	
	$sql="select * from hospital.estado_habitacion";	
	$tabla="";
	try {
		$tabla="<table>";
		$tabla=$tabla . "<tr>";
		$tabla=$tabla . "	<td>Codigo</td>";
		$tabla=$tabla . "	<td>Nombre</td>";
                $tabla=$tabla . "	<td>>Descripcion</td>";

		$tabla=$tabla . "</tr>";

		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$tabla=$tabla . "<tr>";
			$tabla=$tabla . "	<td>" . $row['id'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['nombre'] . "</td>";
                        $tabla=$tabla . "	<td>" . $row['descripcion'] . "</td>";
			$tabla=$tabla . "</tr>";
		}
		$tabla=$tabla . "</table>";
	}
	catch (DependencyException $e) {
		echo "Procedimiento sql invalido en el servidor";
	}
	return $tabla;
}

function getLista(){
	
	$sql="SELECT * FROM hospital.estado_habitacion";
	try {
		echo "<SELECT id='id'>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<OPTION value='".$row['id']."'> ".$row['nombre']." '> ".$row['descripcion']."</OPTION>";
		}
		echo "</SELECT>";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
	}
}

function getAutocomplete(){
	$res="";
	$sql="SELECT * FROM hospital.estado_habitacion";
	try {
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$res .= '"' . $row['id'] . ', ' . $row['nombre'] . ', ' . $row['descripcion'] .'"';
			$res .= ',';
		}
		$res = substr ($res, 0, -2);
		$res = substr ($res, 1);
	}
	catch (DependencyException $e) {
	}
	return $res;
}
}
?>
