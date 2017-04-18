<?php
	ini_set('display_errors', 'on');
	session_start();
	include_once("../models/class.obra.php");
	$obj = new obra();
	if (isset($_POST['codigo'])){
		echo $obj->delete($_POST['codigo']);
	}
	else{
		echo "-2";
	}
?>
