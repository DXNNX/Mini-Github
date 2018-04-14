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
	
	$statement = new Cassandra\SimpleStatement("SELECT * FROM github.archivohist" );
	$res = $session->execute($statement);
	foreach($res as $row){
		 $projectname = $row['projectname'];
		 $branchname = $row['branchname'];
		 $owner2 = $row['owner'];
		 $docname = $row['docname'];
		 if(strcmp($projectname,$project)==0 && strcmp($owner,$owner2)==0 && strcmp($branchname,$Childbranch)==0){
		 $strout = "[";
		 foreach($row['historial']->values() as $hist){
			 $id = $hist->get('idarchivo');
			 $version = $hist->get('version');
			 $comentario = $hist->get('comentario');
			 $usuario = $hist->get('usuario');
		  	 $strout=$strout."{idarchivo:'$id',usuario:'$usuario',comentario:'$comentario',version:'$version'},";
		 }
		 $strout = substr($strout,0,-1)."]";
		 
		 $session->execute("delete from github.archivohist where projectname='$project' and owner='$owner' and branchname='$Childbranch' and docname='$docname';");
		 $session->execute("insert into archivoHist(projectname,branchname,docname,owner,historial) values ('$projectname','$Parentbranch','$docname','$owner',$strout);");
		}
	}
	$session->execute("delete from github.proyecto where idProyecto='$project' and owner='$owner' and branch='$Childbranch';");
}


?>