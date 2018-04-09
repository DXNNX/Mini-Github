<?php
include 'connMysql.php';
header('Content-type: application/json');
$conn = OpenCon();

$np = $_POST['nombreProyecto'];
$tipo = $_POST['tipo'];
$user = $_POST['user'];

if(mysqli_query($conn,"INSERT INTO proyecto(nombreProyecto,user,tipo)  VALUES ('$np','$user',$tipo)")){
	    $msg['status'] = 'success';  
}else {
	    $msg['status'] = mysqli_error($conn);  
}
CloseCon($conn);
echo json_encode($msg);die;
 
?>