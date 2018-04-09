<?php
include 'connMysql.php';
header('Content-type: application/json');
$conn = OpenCon();

$pass = $_POST['pass'];
$user = $_POST['user'];


$query = mysqli_query($conn, "Select * from usuario where user='$user' and pass=AES_ENCRYPT('$pass', '$user')");
if(mysqli_num_rows($query) > 0){
	    $msg['status'] = 'success';  
}else {
	    $msg['status'] = 'Usuario y/o contraseña no coinciden';  
}
CloseCon($conn);
echo json_encode($msg);die;
 
?>