<?php

function login($user,$pass){
	include 'connMysql.php';
	$conn = OpenCon();

	$pass = $_POST['pass'];
	$user = $_POST['user'];


	$query = mysqli_query($conn, "Select * from github.usuario where usuario='$user' and pass=AES_ENCRYPT('$pass', '$user')");

	if(mysqli_num_rows($query) > 0){
	
		$out = true;
	}else {
		$out = false;
	}

	return $out;
}
 
?>