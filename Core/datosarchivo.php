<?php
header('Content-type: application/json');

$project = $_POST['pn'];
$file = $_POST['file'];
$branch = $_POST['bn'];

$cluster   = Cassandra::cluster()->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);


function getHTMLList($datos){
	global $doc,$flag,$addLast;
	$actual = $datos['historial']->values();
	$actual = end($actual);
 $strout = "<header><b>Información del Archivo</b><br>
	 <b>Nombre del Archivo: </b>{$datos['docname']}</b><br>
	 <b>Version de archivo: </b>{$actual->get('version')}</b><br>
	 <b>Comentarios de version: </b>{$actual->get('comentario')}</b><br>
	 <b>Realizado por: </b>{$actual->get('usuario')}</b><br>
	 </header><div class='12u$'><iframe src='http://localhost/core/obtenerarchivo.php?idfile={$actual->get('idarchivo')}'></iframe><br>
	 <a target='_blank' href=http://localhost/core/obtenerarchivo.php?idfile={$actual->get('idarchivo')}>Pantalla completa</a><br>
	 
	 </div>";

 return $strout."</div>";
}


$statement = new Cassandra\SimpleStatement("SELECT * FROM archivohist where projectname='$project' and docname='$file' and branchname='$branch';");
$result    = $session->execute($statement);
$records = $result->current();
$data['status'] = getHTMLList($records);
echo json_encode($data);
die;

//select * from github.archivohist where projectname='P2' and branchname='master' and docname='g4.png'; 
?>
