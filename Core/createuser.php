<?php
include 'connMysql.php';
header('Content-type: application/json');
$conn = OpenCon();

$pass = $_POST['pass'];
$user = $_POST['user'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];


if(mysqli_query($conn,"INSERT INTO usuario(usuario,pass,nombre,email)  VALUES ('$user',AES_ENCRYPT('$pass', '$user'),'$nombre','$email')")){
	    $msg['status'] = 'success';  
}else {
	    $msg['status'] = mysqli_error($conn);  
}
CloseCon($conn);
echo json_encode($msg);die;
 
?>