<?php
include 'connMysql.php';
header('Content-type: application/json');
$conn = OpenCon();

$pass = $_POST['pass'];
$user = $_POST['user'];


if(mysqli_query($conn,"INSERT INTO usuario(user,pass)  VALUES ('$user',AES_ENCRYPT('$pass', '$user'))")){
	    $msg['status'] = 'success';  
}else {
	    $msg['status'] = mysqli_error($conn);  
}
CloseCon($conn);
echo json_encode($msg);die;
 
?>