<?php
error_reporting(E_ALL);
include 'connMongo.php';
 // I don't know if you need to wrap the 1 inside of double quotes.
 ini_set("display_startup_errors",1);
 ini_set("display_errors",1);
 
 $branch = $_POST['bn'];
 if(isset($_FILES['filePath'])){
 	$file = $_FILES['filePath']['tmp_name'];
	$conn = new MongoDB\Driver\Manager("mongodb://localhost:27017");
	$insert = array(
		"nombre" => $_FILES['filePath']['name'],
		"archivo" => new MongoDB\BSON\Binary(file_get_contents($file),0),
		"fecha" => getdate(),
		"tipo" => $_FILES['filePath']['type']
		
	);
	$bulk = new MongoDB\Driver\BulkWrite;
	$file = $_FILES['filePath']['name'];
	$doc = $bulk->insert($insert);
	$result = $conn->executeBulkWrite('github.archivo', $bulk);

 }else{
	 $file = $_POST['file'];
	 $doc = $_POST['did'];
}
$branch = $_POST['bn'];
$user = $_POST['user'];
$project = $_POST['pn'];
$version = $_POST['ver'];


$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT * FROM archivoHist where projectname='$project' and branchname='$branch' and docname='$file'");

$result= $session->execute($statement);
if($result->count() == 0){
		$session->execute("insert into archivoHist(projectname,branchname,docname,owner,historial) values ('$project','$branch','$file','$user',[{idArchivo:'$doc',version:'$version',comentario:'First Commit',usuario:'$user'}]);");

}else{
	$session->execute("UPDATE github.archivohist SET historial=historial+[{idArchivo:'$doc',version:'$version',comentario:'La historia continua',usuario:'$user'}] where projectname='$project' and branchname='$branch' and docname='$file'");
}

$result = $session->execute("SELECT * FROM github.archivohist");

foreach ($result as $row) {
  print_r($row);
}

?>