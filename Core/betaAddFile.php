<?php
error_reporting(E_ALL | E_STRICT);
 // I don't know if you need to wrap the 1 inside of double quotes.
 
 function getArchStruct($lista){
	 $strout = "";
	 foreach($lista as $arch){
		$strout=$strout."{idarchivo:'".$arch->get('idarchivo')."',"."nombre:'".$arch->get('idarchivo')."'},";
	 	
	 }
	 return substr($strout,0,-1);
	
 }
 function getArchStructOld($lista){
	 $strout = "";
	 foreach($lista as $arch){
		$strout=$strout."('{$arch->get(0)}','{$arch->get(1)}','{$arch->get(2)}',[".getArchStruct($arch->get(3))."]),";
	 	
	 }
	 return substr($strout,0,-1);
	
 }
 
 ini_set("display_startup_errors",'On');
 ini_set("display_errors",'On');
 
 $cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace


$project = 'P2';
$owner = 'dxnnx';
$branch = 'master';

$statement = new Cassandra\SimpleStatement("SELECT secuencia FROM proyecto where idProyecto='$project' and owner='$owner' and branch='$branch';");
//echo "SELECT secuencia FROM proyecto where idProyecto='$project' and owner='$owner' and branch='$branch';";
$result    = $session->execute($statement);
$records = $result->current()['secuencia']->values();
echo getArchStructOld($records).',';




?>