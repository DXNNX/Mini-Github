<?php
error_reporting(E_ALL | E_STRICT);
 // I don't know if you need to wrap the 1 inside of double quotes.
 ini_set("display_startup_errors",'On');
 ini_set("display_errors",'On');
 
$Childbranch = $_POST['nb'];
$owner = $_POST['user'];
$project = $_POST['pn'];

$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT * FROM proyecto where idProyecto='$project' and owner='$owner' and branch='$Childbranch';");
$result    = $session->execute($statement);
if($result->count() != 0){
	$Parentbranch = $result[0]['parentbranch'];
	if(is_null($Parentbranch)){die;}
	$arr = $result[0]['secuencia']->values();
	$elem = end($arr);
	$js = "'{$elem->get(0)}','{$elem->get(1)}','{$elem->get(2)}'";
	$files = "";
	foreach( $elem->get(3) as $archivo){
		$files=$files."{idArchivo:'{$archivo->get('idarchivo')}',nombre:'{$archivo->get('nombre')}'},";
	}
	$js = "[(".$js.",[".substr($files, 0, -1)."])]";
	$session->execute("UPDATE github.proyecto SET secuencia=secuencia+$js where idProyecto='$project' and owner='$owner' and branch='$Parentbranch'");
	$session->execute("delete from github.proyecto where idProyecto='$project' and owner='$owner' and branch='$Childbranch';");

}
/*	
$result = $session->execute("SELECT * FROM github.proyecto");

foreach ($result as $row) {
  var_dump($row);
}
*/
?>