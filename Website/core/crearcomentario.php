
<?php
include 'connMysql.php';
$conn = OpenCon();

$np = $_POST['pn'];
$user = $_POST['user'];
$owner = $_POST['owner'];
$doc = $_POST['doc'];
$comentario = $_POST['comentario'];

if(strcmp($doc,'')==0){ 
	$doc= "null";
}else{$doc="'$doc'";}
$query = "INSERT INTO github.comentario(owner,usuario,proyecto,doc,fecha,comentario)VALUES('$owner','$user','$np',".$doc.",NOW(),'$comentario')";

if(mysqli_query($conn,$query)){
	    $msg['status'] = 'success';  
}else {
	    $msg['status'] = mysqli_error($conn);  
}
die;
?>