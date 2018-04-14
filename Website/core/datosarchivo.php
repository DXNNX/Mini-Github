<?php
header('Content-type: application/json');

$project = $_POST['pn'];
$file = $_POST['file'];
$branch = $_POST['bn'];
$user = $_POST['user'];

$cluster   = Cassandra::cluster()->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);

function getFecha($file){
	include 'connMongo.php';
	$conn = new MongoDB\Driver\Manager("mongodb://localhost:27017");
		$id           = new \MongoDB\BSON\ObjectId($file);
		$filter      = ['_id' => $id];
		$options = ['projection' => ['archivo' => 0]];
		$query = new \MongoDB\Driver\Query($filter, $options);
		$rows   = $conn->executeQuery('github.archivo', $query); 

		foreach ($rows as $document) {
			return $document->fecha->mday."/".$document->fecha->mon."/".$document->fecha->year;
		}
		
}
	

function getHTMLList($datos){
	global $file,$project;
	$actual = $datos['historial']->values();
	$actual = end($actual);
 $strout = "<header><b>Información del Archivo</b><br>
	 <b>Nombre del Archivo: </b>{$datos['docname']}</b><br>
	 <b>Version de archivo: </b>{$actual->get('version')}</b><br>
	 <b>Comentarios de version: </b>{$actual->get('comentario')}</b><br>
	 <b>Realizado por: </b>{$actual->get('usuario')}</b><br>
	 <b>Fecha: </b>".getFecha($actual->get('idarchivo'))."</b><br>
	 
	 
	 <b><a href='http://localhost/comentarios.php?usuario={$actual->get('usuario')}&proyecto={$project}&doc={$file}' target='_blank'>Ver Comentarios</a></b><br>
	 </header><div class='12u$'><iframe src='http://localhost/core/obtenerarchivo.php?idfile={$actual->get('idarchivo')}'></iframe><br>
	 <a target='_blank' href=http://localhost/core/obtenerarchivo.php?idfile={$actual->get('idarchivo')}>Pantalla completa</a><br>
	 
	 </div>";

 return $strout."</div>";
}


$statement = new Cassandra\SimpleStatement("SELECT * FROM archivohist where projectname='$project' and docname='$file' and branchname='$branch';");
$result    = $session->execute($statement);
while($result->count()==0){
	$statement = new Cassandra\SimpleStatement("SELECT parentbranch FROM proyecto where idproyecto='$project' and  branch='$branch' and owner='$user';");
	$result    = $session->execute($statement);
	$branch = $result->current()['parentbranch'];
	$statement = new Cassandra\SimpleStatement("SELECT * FROM archivohist where projectname='$project' and docname='$file' and branchname='$branch';");
	$result    = $session->execute($statement);
}


$records = $result->current();
$data['status'] = getHTMLList($records);
echo json_encode($data);
die;

//select * from github.archivohist where projectname='P2' and branchname='master' and docname='g4.png'; 
?>
