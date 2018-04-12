<?php
error_reporting(E_ALL | E_STRICT);
 // I don't know if you need to wrap the 1 inside of double quotes.
 ini_set("display_startup_errors",'On');
 ini_set("display_errors",'On');
 
 
function consultaPB($owner){
$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT * FROM proyecto;");	
$result = $session->execute("SELECT idproyecto,branch,owner FROM github.proyecto");

foreach ($result as $row) {
	
	$out[] = array();
	if($row['owner'] == 'dxnnx'){
		array_push($out,array('idproyecto'=>$row['idproyecto'],'branch'=>$row['branch']));
		
	}
}
return array_filter($out);
}
function consultaPBMerge($owner){
$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT * FROM proyecto;");	
$result = $session->execute("SELECT idproyecto,branch,owner,parentbranch FROM github.proyecto");

foreach ($result as $row) {
	
	$out[] = array();
	if($row['owner'] == 'dxnnx'){
		array_push($out,array('idproyecto'=>$row['idproyecto'],'branch'=>$row['branch'],'parentbranch'=>$row['parentbranch'],));
		
	}
}
return array_filter($out);
}


function consultaPVersion($project,$branch,$user){
$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT secuencia FROM proyecto where idproyecto='$project' and owner='$user' and branch='$branch' ALLOW FILTERING;");	

$result = $session->execute($statement);
$out = "<select name='select' id='select'>";
foreach ($result as $row) {
		$versiones=$row['secuencia']->values();
		foreach($versiones as $ver){
			$out=$out."<option value='{$ver->get(0)}'>{$ver->get(0)}</option>";
		}
}
$data['status'] = $out."</select>";
header('Content-type: application/json');
echo json_encode($data);
die;
}

if(isset($_POST['project']) && isset($_POST['branch']) && isset($_POST['user']) && isset($_POST['callp'])){
	consultaPVersion($_POST['project'],$_POST['branch'],$_POST['user']);
}


function consultaPFiles($project,$branch,$user){
$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT secuencia FROM proyecto where idproyecto='$project' and owner='$user' and branch='$branch' ALLOW FILTERING;");	

$result = $session->execute($statement);


$i = 0;
$len = $result->count();
foreach ($result as $row) {
	if($i == $len-1){
		$out = "<select name='archivo' id='archivo'>";
		$versiones=$row['secuencia']->values();
		$last = end($versiones)->get(3);
		foreach($last as $file){
			$out=$out."<option value='{$file->get('nombre')}'>{$file->get('nombre')}</option>";
		}
		$data['status'] = $out."</select>";
		header('Content-type: application/json');
		echo json_encode($data);
		die;
	
	}
}
}
if(isset($_POST['project']) && isset($_POST['branch']) && isset($_POST['user']) && isset($_POST['callarchivop'])){
	consultaPFiles($_POST['project'],$_POST['branch'],$_POST['user']);
}






function consultaVFiles($project,$branch,$user,$file){
$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT * FROM archivoHist where projectname='$project' and branchname='$branch' and docname='$file' and owner='$user' allow filtering");	
$result = $session->execute($statement);


$i = 0;
$len = $result->count();
$out = "<select name='version' id='version'>";
foreach($result[0]['historial']->values() as $file){
	$out=$out."<option value='{$file->get('version')}'>{$file->get('version')}</option>";
	}
	
	$data['status'] = $out."</select>";
	header('Content-type: application/json');
	echo json_encode($data);
	die;
	
}
if(isset($_POST['project']) && isset($_POST['branch']) && isset($_POST['user']) && isset($_POST['callarchivov']) && isset($_POST['archivo'])){
	consultaVFiles($_POST['project'],$_POST['branch'],$_POST['user'],$_POST['archivo']);
}





















?>