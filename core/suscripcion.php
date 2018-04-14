<?php
header('Content-type: application/json');
include 'connMysql.php';
$conn = OpenCon();
$project = $_POST['pn'];
$user = $_POST['user'];
$owner = $_POST['owner'];
$branch = $_POST['bn'];

$cluster   = Cassandra::cluster()->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);

$statement = new Cassandra\SimpleStatement("SELECT * FROM proyecto where idProyecto='$project' and owner='$user' and branch='$branch' and suscriptores contains '$user';");
$result    = $session->execute($statement);
if($result->count() == 0){
	$statement = new Cassandra\SimpleStatement("Update proyecto set suscriptores=suscriptores+['$user'] where idProyecto='$project' and owner='$user' and branch='$branch';");
	$result    = $session->execute($statement);
}
die;
 
?>