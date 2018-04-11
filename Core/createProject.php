<?php
include 'connMysql.php';
header('Content-type: application/json');
$conn = OpenCon();

$np = $_POST['np'];
$tipo = $_POST['tipo'];
$user = $_POST['user'];
$branch = $_POST['branch'];
$version = $_POST['version'];
$comentario = $_POST['comentario'];

if(mysqli_query($conn,"INSERT INTO proyecto(nombreProyecto,user,tipo)  VALUES ('$np','$user',$tipo)")){
	    $msg['status'] = 'success';  
}else {
	    $msg['status'] = mysqli_error($conn);  
}

$cluster   = Cassandra::cluster()->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);
$session->execute("insert into proyecto(idProyecto, owner,suscriptores,branch,secuencia,parentbranch) values('$np','$user',[],'$branch',[('$version','$user','$comentario',[])],NULL);");

CloseCon($conn);
echo json_encode($msg);
die;
 
?>