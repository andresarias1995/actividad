<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.registro.equipo_tecnico.php");
	$obj = new registro_equipo_tecnico();
	if (isset($_POST['fec']) && isset($_POST['act'])){
		$obj->fecha=$_POST['fec'];
		$obj->id_equipo_tecnico=$_POST['act'];
		echo $obj->insert();
	}
	else{
		echo "-1";
	}
?>
