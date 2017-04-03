<?php
ini_set('display_errors', 'off');
include_once("resources/class.database.php");

class sala{
	var $id;
  	var $cantidad;
        var $tipo;
	var $tamano;

function sala(){
}

function select($id){
	$sql =  "SELECT * FROM cine.sala WHERE id = '$id'";
	try {
		$row = pg::query($sql);
		$row=pg_fetch_array($row);
		$this->id = $row['id'];
		$this->cantidad = $row['cantidad'];
                $this->tipo = $row['tipo'];
		$this->tamano=$row['tamano'];
		return true;
	}
	catch (DependencyException $e) {
	}
}

function delete($id){
	$sql = "DELETE FROM cine.sala WHERE id = '$id'";
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
		$sql = "INSERT INTO cine.sala( id, cantidad, tipo,tamano) VALUES ( '$this->id', '$this->cantidad', '$this->tipo', '$this->tamano')";
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
		$sql="UPDATE cine.sala set cantidad='" . $this->cantidad . "' WHERE id='" . $this->id . "'";
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");		
		echo "2";
	}
}

function validaP ($id){

      $sql =  "SELECT * FROM cine.sala WHERE id = '$id'";
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
	
	$sql="SELECT * FROM cine.sala";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Cantidad de Sillas</th>";
                echo "	<th>Tipo Sala</th>";
                echo "	<th>Tamaño</th>";
		echo "	<th>.</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['id'] . "</th>";
			echo "	<th>" . $row['cantidad'] . "</th>";
                        echo "	<th>" . $row['tipo'] . "</th>";
                        echo "	<th>" . $row['tamano'] . "</th>";
			echo "	<th><a href='#' class='btn btn-danger' onclick='elimina(\"" . $row['id'] . "\")'>X<i class='icon-white icon-trash'></i></a>.<a href='#' class='btn btn-primary' onclick='edit(\"" . $row['id'] . "\", \"" . $row['cantidad'] . "\", \"" . $row['tipo'] . "\",\"" . $row['tamano'] . "\")'>E<i class='icon-white icon-refresh'></i></a></th>";
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
}
?>
