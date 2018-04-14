<?php
	session_start();
	$guser="";
	if(isset($_SESSION['user'])){
		$guser=$_SESSION['user'];
	}
?>
