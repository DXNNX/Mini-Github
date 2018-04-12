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

?>