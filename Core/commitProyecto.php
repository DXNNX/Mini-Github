<?php
error_reporting(E_ALL);
include 'connMongo.php';

function getArchStruct($lista,$file){
	global $doc,$flag,$addLast;
 $strout = "";

 foreach($lista as $arch){
	$strout=$strout."{idarchivo:'".$arch->get('idarchivo')."',"."nombre:'".$arch->get('nombre')."'},";
 	
 }
 return substr($strout,0,-1);

}
function getArchStructOld($lista){
	global $doc,$flag,$addLast,$comentario,$version,$user;
 $strout = "";
 $i = 0;
 $len = count($lista);
 foreach($lista as $arch){
	$struct=getArchStruct($arch->get(3),$file);
	$append="('$version','$user','$comentario',[".$struct."]),";
	$strout=$strout."('{$arch->get(0)}','{$arch->get(1)}','{$arch->get(2)}',[".$struct."]),";
	$i++;
 	
 }
 return substr($strout.$append,0,-1);

}

 // I don't know if you need to wrap the 1 inside of double quotes.
ini_set("display_startup_errors",1);
ini_set("display_errors",1);
 
$branch = $_POST['bn'];
$user = $_POST['user'];
$project = $_POST['pn'];
$version = $_POST['version'];
$comentario = $_POST['comentario'];

$cluster   = Cassandra::cluster()->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT secuencia FROM proyecto where idProyecto='$project' and owner='$user' and branch='$branch';");
$result    = $session->execute($statement);
$records = $result->current()['secuencia']->values();
$JSList = getArchStructOld($records);

$session->execute("UPDATE github.proyecto SET secuencia=[$JSList] where idProyecto='$project' and owner='$user' and branch='$branch';");



?>