<?php
ini_set('display_errors', 'off');
include_once("resources/class.database.php");

class obra{
	var $codigo;
	var $codigoequ;
  	var $nombre;
	var $genero;
	var $descripcion;
	
function obra(){
}

function select($codigo){
	$sql =  "SELECT * FROM administrador.tbl_obra	WHERE codigo = '$codigo'";
	try {
		$row = pg::query($sql);
		$row=pg_fetch_array($row);
		$this->codigo = $row['codigo'];
		$this->codigoequ = $row['codigoequ'];
		$this->nombre = $row['nombre'];
		$this->genero = $row['genero'];
		$this->descripcion = $row['descripcion'];
		return true;
	}
	catch (DependencyException $e) {
	}
}

function delete($codigo){
	$sql = "DELETE FROM administrador.tbl_obra WHERE codigo = '$codigo'";
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
	if ($this->validaP($this->codigo) == false){
		$sql = "INSERT INTO administrador.tbl_obra(codigo,codigoequ,nombre,genero,descripcion) VALUES ( '$this->codigo', '$this->codigoequ', '$this->nombre', '$this->genero', '$this->descripcion')";
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
		$sql="UPDATE administrador.tbl_obra set nombre='" . $this->nombre . "', codigoequ='" . $this->codigoequ . "', nombre='" . $this->nombre . "', genero='" . $this->genero . "', descripcion='" . $this->descripcion . "' WHERE codigo='" . $this->codigo ."'";
		pg::query("begin");
		$row = pg::query($sql);
		pg::query("commit");		
		echo "2";
	}
}

function validaP ($codigo){
      $sql =  "SELECT * FROM administrador.tbl_obra WHERE codigo = '$codigo'";
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
	
	$sql="SELECT * FROM administrador.tbl_obra";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Codigoequ</th>";
		echo "	<th>Nombre</th>";
		echo "	<th>Genero</th>";
		echo "	<th>Descripcion</th>";
		echo "	<th>.</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['codigo'] . "</th>";
			echo "	<th>" . $row['codigoequ'] . "</th>";
			echo "	<th>" . $row['nombre'] . "</th>";
			echo "	<th>" . $row['genero'] . "</th>";
			echo "	<th>" . $row['descripcion'] . "</th>";
			echo "	<th><a href='#' class='btn btn-danger' onclick='elimina(\"" . $row['codigo'] . "\")'>X<i class='icon-white icon-trash'></i></a>.<a href='#' class='btn btn-primary' onclick='edit(\"" . $row['codigo'] . "\", \"" . $row['codigoequ']. "\", \"" . $row['nombre']. "\", \"" . $row['genero'] . "\", \"" . $row['descripcion'] . "\")'>E<i class='icon-white icon-refresh'></i></a></th>";
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
	
	$sql="select * from administrador.tbl_obra where nombre like 'A%'";
	try {
		echo "<div class='container' style='margin-top: 10px'>";
		echo "<table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered' id='example'>";
		echo "<thead>";
		echo "<tr>";
		echo "	<th>Codigo</th>";
		echo "	<th>Codigoequ</th>";
		echo "	<th>Nombre</th>";
		echo "	<th>Genero</th>";
		echo "	<th>Descripcion</th>";

		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<tr class='gradeA'>";
			echo "	<th>" . $row['codigo'] . "</th>";
			echo "	<th>" . $row['codigoequ'] . "</th>";
			echo "	<th>" . $row['nombre'] . "</th>";
			echo "	<th>" . $row['genero'] . "</th>";
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
	
	$sql="select * from administrador.tbl_obra";	
	$tabla="";
	try {
		$tabla="<table>";
		$tabla=$tabla . "<tr>";
		$tabla=$tabla . "	<td>Codigo</td>";
		$tabla=$tabla . "	<td>Codigoequ</td>";
		$tabla=$tabla . "	<td>Nombre</td>";
		$tabla=$tabla . "	<td>Genero</td>";
		$tabla=$tabla . "	<td>Descripcion</td>";

		$tabla=$tabla . "</tr>";

		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$tabla=$tabla . "<tr>";
			$tabla=$tabla . "	<td>" . $row['codigo'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['codigoequ'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['nombre'] . "</td>";
			$tabla=$tabla . "	<td>" . $row['genero'] . "</td>";
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
	
	$sql="SELECT * FROM administrador.tbl_obra";
	try {
		echo "<SELECT codigo='codigo'>";
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			echo "<OPTION value='".$row['codigo']."'> ".$row['codigoequ']." ".$row['nombre']." ".$row['genero']." ".$row['descripcion']." </OPTION>";
		
		}
		echo "</SELECT>";
	}
	catch (DependencyException $e) {
		pg::query("rollback");
	}
}

function getAutocomplete(){
	$res="";
	$sql="SELECT * FROM administrador.tbl_obra";
	try {
		$result = pg::query($sql);
		while ($row= pg_fetch_array($result)){
			$res .= '"' . $row['codigo'] . ', ' . $row['codigoequ'] . ', ' . $row['nombre'] . ', ' . $row['genero'] . ', ' . $row['descripcion'] . '"';
			$res .= ',';
		}
		$res = substr ($res, 0, -2);
		$res = substr ($res, 1);
	}
	catch (DependencyException $e) {
	}
	return $res;
}

function lista_obra(){
	$sql="SELECT * FROM administrador.tbl_equipo_tecnico";
	
	$result = pg::query($sql); 
            if (!$result) { 
                echo "Problema con la consulta " . $query . "<br/>"; 
                echo pg_last_error(); 
                exit(); 
            } 
           $lista_obra = null;

            while($myrow = pg_fetch_assoc($result)) { 
                $lista_obra .= "<option value=\"".$myrow['codigoequ']."\">".$myrow['nombre']."</option>"; 
            }	
            echo $lista_obra;
}		
}
?>
