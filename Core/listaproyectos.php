<?php
header('Content-type: application/json');

$project = $_POST['pn'];
$user = $_POST['user'];
$branch = $_POST['bn'];

$cluster   = Cassandra::cluster()->build();
$keyspace  = 'github';
$session   = $cluster->connect($keyspace);


function getHTMLList($datos){
	global $doc,$flag,$addLast;
 $strout = "<header><b>Version: </b>{$datos->get(0)}<br><b>Comentarios: </b>{$datos->get(2)}<br><b>Dueño: </b>{$datos->get(1)}<br><b>Lista de Archivos:</b></header><div class='12u$'><ul>";

 foreach($datos->get(3) as $arch){
	$strout=$strout."<li onclick=\"JavaScript:mostrarArchivo('{$arch->get('nombre')}')\">".$arch->get('nombre')."</li>";
 	
 }
 return $strout."</ul></div>";
}


$statement = new Cassandra\SimpleStatement("SELECT secuencia FROM proyecto where idProyecto='$project' and owner='$user' and branch='$branch';");
$result    = $session->execute($statement);
$records = $result->current()['secuencia']->values();
$data['status'] = getHTMLList(end($records));
echo json_encode($data);
die;
 
?>