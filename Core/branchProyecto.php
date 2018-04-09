<?php
error_reporting(E_ALL | E_STRICT);
 // I don't know if you need to wrap the 1 inside of double quotes.
 ini_set("display_startup_errors",'On');
 ini_set("display_errors",'On');
 
$branch = $_POST['bn'];
$newbranch = $_POST['nb'];
$owner = $_POST['user'];
$project = $_POST['pn'];

$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT * FROM proyecto where idProyecto='$project' and owner='$owner' and branch='$branch';");
$result    = $session->execute($statement);
if($result->count() != 0){
	$arr = $result[0]['secuencia']->values();
	$elem = end($arr);
	$js = "'{$elem->get(0)}','{$elem->get(1)}','{$elem->get(2)}'";
	$files = "";
	foreach( $elem->get(3) as $archivo){
		$files=$files."{idArchivo:'{$archivo->get('idarchivo')}',nombre:'{$archivo->get('nombre')}'},";
	}
	$js = "[(".$js.",[".substr($files, 0, -1)."])]";
	echo "insert into proyecto(idProyecto, owner,suscriptores,branch,secuencia,parentbranch) values
		('$project','$owner',[],'$newbranch',$js,'$branch');";
	$session->execute("insert into proyecto(idProyecto, owner,suscriptores,branch,secuencia,parentbranch) values('$project','$owner',[],'$newbranch',$js,'$branch');");

}
/*	
$result = $session->execute("SELECT * FROM github.proyecto");

foreach ($result as $row) {
  var_dump($row);
}
*/
?>