<?php
ini_set('display_errors', 'off');
include_once("resources/class.database.php");

class equipo_tecnico{
	var $codigoequ;
  	var $nombre;
	var $descripcion;
	

function equipo_tecnico(){
}

function select($codigoequ){
	$sql =  "SELECT * FROM administrador.tbl_equipo_tecnico WHERE codigoequ = '$codigoequ'";
	try {
		$row = pg::query($sql);
		$row=pg_fetch_array($row);
		$this->codigoequ = $row['codigoequ'];
		$this->nombre = $row['nombre'];
		$this->descripcion = $row['descripcion'];
		return true;
	}
	catch (DependencyException $e) {
	}
}

function delete($codigoequ){
	$sql = "DELETE FROM administrador.tbl_equipo_tecnico WHERE codigoequ = '$codigoequ'";
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
//echo "me llamo";
	if ($this->validaP($this->codigoequ) == false){
		$sql = "INSERT INTO administrador.tbl_equipo_tecnico( codigoequ, nombre,descripcion) VALUES ( '$this->codigoequ', '$this->nombre', '$this->descripcion')";
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
		$sql="UPDATE administrador.tbl_equipo_tecnico set nombre='" . $this->nombre . "', descripcion='" . $this->descripcion . "' WHERE codigoequ='" . $this->codigoequ ."'";
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");		
		echo "2";
	}
}

function validaP ($codigoequ){
      $sql =  "SELECT * FROM administrador.tbl_equipo_tecnico WHERE codigoequ = '$codigoequ'";
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
	
	$sql="SELECT * FROM administrador.tbl_equipo_tecnico";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>nombre</th>";
		echo "	<th>descripcion</th>";
		echo "	<th>.</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['codigoequ'] . "</th>";
			echo "	<th>" . $row['nombre'] . "</th>";
			echo "	<th>" . $row['descripcion'] . "</th>";
			echo "	<th><a href='#' class='btn btn-danger' onclick='elimina(\"" . $row['codigoequ'] . "\")'>X<i class='icon-white icon-trash'></i></a>.<a href='#' class='btn btn-primary' onclick='edit(\"" . $row['codigoequ'] . "\", \"" . $row['nombre'] . "\", \"" . $row['descripcion'] . "\")'>E<i class='icon-white icon-refresh'></i></a></th>";
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

function getTablaInicianPorA(){
	
	$sql="select * from administrador.tbl_equipo_tecnico where nombre like 'A%'";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>nombre</th>";
		echo "	<th>descripcion</th>";

		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['codigoequ'] . "</th>";
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
	
	$sql="select * from administrador.tbl_equipo_tecnico";	
	$tabla="";
	try {
		$tabla="<table>";
		$tabla=$tabla . "<tr>";
		$tabla=$tabla . "	<td>Codigo</td>";
		$tabla=$tabla . "	<td>nombre</td>";
		$tabla=$tabla . "	<td>descripcion</td>";

		$tabla=$tabla . "</tr>";

		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$tabla=$tabla . "<tr>";
			$tabla=$tabla . "	<td>" . $row['codigoequ'] . "</td>";
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
	
	$sql="SELECT * FROM administrador.tbl_equipo_tecnico";
	try {
		echo "<SELECT codigoequ='codigoequ'>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<OPTION value='".$row['codigoequ']."'> ".$row['nombre'].".".$row['descripcion']." </OPTION>";
		
		}
		echo "</SELECT>";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
	}
}

function getAutocomplete(){
	$res="";
	$sql="SELECT * FROM administrador.tbl_equipo_tecnico";
	try {
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$res .= '"' . $row['codigoequ'] . ', ' . $row['nombre'] . ', ' . $row['descripcion'] . '"';
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
