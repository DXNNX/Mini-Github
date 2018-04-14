<?php
error_reporting(E_ALL);
 // I don't know if you need to wrap the 1 inside of double quotes.
 ini_set("display_startup_errors",1);
 ini_set("display_errors",1);
$branch = $_POST['bn'];
$user = $_POST['user'];
$project = $_POST['pn'];
$version = $_POST['version'];
$file = $_POST['archivo'];

$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace
$statement = new Cassandra\SimpleStatement("SELECT * FROM archivoHist where projectname='$project' and branchname='$branch' and docname='$file'");

$result= $session->execute($statement);
if($result->count() != 0){
	foreach($result[0]['historial']->values() as $data){
		if(strcmp($data->get('version'),$version)==0){
			$d1=$data->get('idarchivo');
			$d2 = $data->get('version');
			$d3 = $data->get('comentario');
			$d4 = $data->get('usuario');
			$session->execute("UPDATE github.archivohist SET historial=historial+[{idArchivo:'$d1',version:'$d2',comentario:'$d3',usuario:'$d4'}] where projectname='$project' and branchname='$branch' and docname='$file' and owner='$user'");
			break;
		}
		
	}
	//$session->execute("UPDATE github.archivohist SET historial=historial+[{idArchivo:'$doc',version:'$version',comentario:'La historia continua',usuario:'$user'}] where projectname='$project' and branchname='$branch' and docname='$file'");
}
/*
foreach ($result as $row) {
  print_r($row);
}
*/

?>