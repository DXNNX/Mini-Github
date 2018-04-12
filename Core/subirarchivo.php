<?php
error_reporting(E_ALL);
include 'connMongo.php';
$flag = false;
$addLast = true;
function getArchStruct($lista,$file){
	global $doc,$flag,$addLast;
 $strout = "";

 foreach($lista as $arch){
	$strout=$strout."{idarchivo:'".$arch->get('idarchivo')."',"."nombre:'".$arch->get('nombre')."'},";
 	
 }
 return substr($strout,0,-1);

}
function getArchStructOld($lista,$file){
	global $doc,$flag,$addLast;
 $strout = "";
 $i = 0;
 $len = count($lista);
 foreach($lista as $arch){
	if ($i == $len - 1) {
		$l = $arch->get(3);
	    foreach($l as $arch2){
	   		 if(strcmp($arch2->get('nombre'),$file)==0){
			 
	   		 	$arch2->set('idarchivo',$doc."");
	   			$addLast = false;
			
	   		 }
	}}
	$strout=$strout."('{$arch->get(0)}','{$arch->get(1)}','{$arch->get(2)}',[".getArchStruct($arch->get(3),$file)."]),";
	$i++;
 	
 }
 return substr($strout,0,-1);

}

 // I don't know if you need to wrap the 1 inside of double quotes.
 ini_set("display_startup_errors",1);
 ini_set("display_errors",1);
 $branch = $_POST['bn'];
 if(isset($_FILES['file'])){
 	$file = $_FILES['file']['name'];
	$conn = new MongoDB\Driver\Manager("mongodb://localhost:27017");
	$insert = array(
		"nombre" => $_POST['nombre'],
		"archivo" => new MongoDB\BSON\Binary(file_get_contents($_FILES['file']['tmp_name']),0),
		"fecha" => getdate(),
		"tipo" => $_FILES['file']['type']
		
	);
	$bulk = new MongoDB\Driver\BulkWrite;
	$file = $_FILES['file']['name'];
	$doc = $bulk->insert($insert);
	$result = $conn->executeBulkWrite('github.archivo', $bulk);

}else{die;}
$branch = $_POST['bn'];
$user = $_POST['user'];
$project = $_POST['pn'];
$version = $_POST['version'];
$comentario = $_POST['comentario'];

$cluster   = Cassandra::cluster()->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT * FROM archivoHist where projectname='$project' and branchname='$branch' and docname='$file'");

$result= $session->execute($statement);
if($result->count() == 0){
		$session->execute("insert into archivoHist(projectname,branchname,docname,owner,historial) values ('$project','$branch','$file','$user',[{idArchivo:'$doc',version:'$version',comentario:'$comentario',usuario:'$user'}]);");

}else{
	$session->execute("UPDATE github.archivohist SET historial=historial+[{idArchivo:'$doc',version:'$version',comentario:'$comentario',usuario:'$user'}] where projectname='$project' and branchname='$branch' and docname='$file'");
}

$statement = new Cassandra\SimpleStatement("SELECT secuencia FROM proyecto where idProyecto='$project' and owner='$user' and branch='$branch';");
$result    = $session->execute($statement);
$records = $result->current()['secuencia']->values();
$JSList = getArchStructOld($records,$file);
if($addLast){
	if(strcmp(substr($JSList, -3),"[])")==0){
			$JSList = substr($JSList,0,-2)."{idarchivo:'".$doc."',"."nombre:'".$file."'}])";
	}else{
		$JSList = substr($JSList,0,-2).','."{idarchivo:'".$doc."',"."nombre:'".$file."'}])";
	}
}

$session->execute("UPDATE github.proyecto SET secuencia=[$JSList] where idProyecto='$project' and owner='$user' and branch='$branch';");



?>