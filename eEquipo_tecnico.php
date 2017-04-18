<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.equipo_tecnico.php");
	$obj = new equipo_tecnico();
	if (isset($_POST['codigoequ'])){
		echo $obj->delete($_POST['codigoequ']);
	}
	else{
		echo "-2";
	}
?>
