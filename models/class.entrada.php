<?php
ini_set('display_errors', 'off');
include_once("resources/class.database.php");

class entrada{
	var $id;
  	var $costo;
	var $id_pelicula;

function entrada(){
}

function select($id){
	$sql =  "SELECT * FROM cine.entrada WHERE id = '$id'";
	try {
		$row = pg::query($sql);
		$row=pg_fetch_array($row);
		$this->id = $row['id'];
		$this->descripcion = $row['descripcion'];
		return true;
	}
	catch (DependencyException $e) {
	}
}

function delete($id){
	$sql = "DELETE FROM cine.entrada WHERE id_entrada = '$id'";
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
                $hora= date("F j, Y, g:i a");
		$sql = "INSERT INTO cine.entrada( id_entrada, costo,hora_venta,fk_id_pelicula) VALUES ( '$this->id', '$this->costo', '$hora','$this->id_pelicula')";
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
		$sql="UPDATE cine.entrada set descripcion='" . $this->descripcion . "' WHERE id='" . $this->id . "'";
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");		
		echo "2";
	}
}

function validaP ($id){
      $sql =  "SELECT * FROM cine.entrada WHERE id_entrada = '$id'";
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
	
	$sql="SELECT * FROM cine.entrada";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Pelicula</th>";
		echo "	<th>Costo</th>";
		echo "	<th>Hora</th>";
		echo "	<th>.</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id_entrada'] . "</th>";
			echo "	<th>" . $row['fk_id_pelicula'] . "</th>";
			echo "	<th>" . $row['costo'] . "</th>";
			echo "	<th>" . $row['hora_venta'] . "</th>";
			echo "	<th><a href='#' class='btn btn-danger' onclick='elimina(\"" . $row['id_entrada'] . "\")'>X<i class='icon-white icon-trash'></i></a>.<a href='#' class='btn btn-primary' onclick='edit(\"" . $row['id_entrada'] . "\", \"" . $row['fk_id_pelicula']. "\", \"" . $row['costo'] . "\", \"" . $row['hora_venta'] . "\")'>E<i class='icon-white icon-refresh'></i></a></th>";
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
	$sql="SELECT * FROM cine.pelicula ";
	echo"<select id='id_pelicula'>";
	try{
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo"<option value=".$row['id_pelicula'].">".$row['nombre']."</option>\n";
		}
		echo"</select>";			
	}
	catch (DependencyException $e) {
		echo "Error al cargar el combobox";
	}
	
}

function getTablaInicianPorA(){
	
	$sql="select * from cine.entrada where descripcion like 'A%'";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Descripcion</th>";

		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id'] . "</th>";
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
	
	$sql="select * from cine.entrada";	
	$tabla="";
	try {
		$tabla="<table>";
		$tabla=$tabla . "<tr>";
		$tabla=$tabla . "	<td>Codigo</td>";
		$tabla=$tabla . "	<td>Descripcion</td>";

		$tabla=$tabla . "</tr>";

		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$tabla=$tabla . "<tr>";
			$tabla=$tabla . "	<td>" . $row['id'] . "</td>";
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
	
	$sql="SELECT * FROM cine.entrada";
	try {
		echo "<SELECT id='id'>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<OPTION value='".$row['id']."'> ".$row['descripcion']." </OPTION>";
		}
		echo "</SELECT>";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
	}
}

function getAutocomplete(){
	$res="";
	$sql="SELECT * FROM cine.entrada";
	try {
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$res .= '"' . $row['id'] . ', ' . $row['descripcion'] . '"';
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
