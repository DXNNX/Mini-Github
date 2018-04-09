<?php
error_reporting(E_ALL | E_STRICT);
 // I don't know if you need to wrap the 1 inside of double quotes.
 ini_set("display_startup_errors",'On');
 ini_set("display_errors",'On');
 
$files = $_POST['files'];
$branch = $_POST['bn'];
$owner = $_POST['user'];
$project = $_POST['pn'];
$version = $_POST['ver'];

$outJson = "";
$lineas = explode("\n",$files);
foreach($lineas as $data){
	$temp = explode('->',$data);
	$outJson=$outJson."{idArchivo:'$temp[0]',nombre:'$temp[1]'},";
}
$outJson = substr($outJson, 0, -1);

$cluster   = Cassandra::cluster()                 // connects to localhost by default
                 ->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace

$statement = new Cassandra\SimpleStatement("SELECT * FROM proyecto where idProyecto='$project' and owner='$owner' and branch='$branch';");

$result    = $session->execute($statement);
if($result->count() == 0){
		$session->execute("insert into proyecto(idProyecto, owner,suscriptores,branch,secuencia,parentbranch) values
('$project','$owner',[],'$branch',[('$version','$owner','version inicial',[$outJson])],NULL);");
	}else{
$session->execute("UPDATE github.proyecto SET secuencia=secuencia+[('$version','$owner','version inicial',[$outJson])] where idProyecto='$project' and owner='$owner' and branch='$branch'");		
		
	}
	
$result = $session->execute("SELECT * FROM github.proyecto");

foreach ($result as $row) {
  var_dump($row);
}

?>