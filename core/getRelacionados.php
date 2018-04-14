<?php

include 'connMysql.php';
function getSimilarityCoefficient( $item1, $item2, $separator = "," ) {
	
	$item1 = explode( $separator, $item1 );
	$item2 = explode( $separator, $item2 );
	$arr_intersection = array_intersect( $item2, $item2 );
	$arr_union = array_merge( $item1, $item2 );
	$coefficient = count( $arr_intersection ) / count( $arr_union );
	
	return $coefficient;
}
function getHTMLList($datos){
	global $project,$user,$conn;
	$result = $conn->query("select * from github.proyecto where nombreproyecto='$project' and user='$user'");

    $row = $result->fetch_assoc();
 $strout = "<header><b>Version: </b>{$datos->get(0)}<br><b>Comentarios: </b>{$datos->get(2)}<br><b>Dueño: </b>{$datos->get(1)}<br>
	 <b>Etiquetas: </b>{$row['tags']}<br>
	 <b><a href='http://localhost/comentarios.php?usuario={$datos->get(1)}&proyecto={$project}' target='_blank'>Ver Comentarios</a></b><br>
	 
	 <b>Lista de Archivos:</b></header><div class='12u$'><ul>";

 foreach($datos->get(3) as $arch){
	$strout=$strout."<li onclick=\"JavaScript:mostrarArchivo('{$arch->get('nombre')}')\">".$arch->get('nombre')."</li>";
 	
 }
 return $strout."</ul></div>";
}

function getPorProyecto($user){
$conn = OpenCon();
$myProjects = $conn->query("select * from github.proyecto where user='$user'");
$Others = $conn->query("select * from github.proyecto where user!='$user' and tipo=0");
$array = Array();
if ($myProjects->num_rows > 0 && $Others->num_rows >0) {
    while($Myrow = $myProjects->fetch_assoc()) {
		$Others = $conn->query("select * from github.proyecto where user!='$user' and tipo=0");
		while($Otherrow = $Others->fetch_assoc()) {  			array_push($array,['fitness'=>getSimilarityCoefficient($Myrow['tags'],$Otherrow['tags']),'data'=>[$Otherrow['nombreProyecto'],$Otherrow['user']]]);
		}
}
}
usort($array, 'compare_fitness');
$out = Array();
foreach(array_reverse($array) as $item){
	if(!in_array($item['data'],$out)){
		array_push($out,$item['data']);
	}
}
return array_slice($out,0,2);
}

function getPorSuscripcion($user){
	$cluster   = Cassandra::cluster()->build();
	$keyspace  = 'github';
	$session   = $cluster->connect($keyspace);

	$statement = new Cassandra\SimpleStatement("SELECT * FROM proyecto where suscriptores contains '$user';");
	$result    = $session->execute($statement);
	$array1 = "";
	$array2 = "";
	foreach($result as $row){
		$array1=$array1." user!='".$row['owner']."' and nombreproyecto='".$row['idproyecto']."' ";
		$array2=$array2." user!='".$row['owner']."' and nombreproyecto!='".$row['idproyecto']."' ";
	}
	$conn = OpenCon();
	$myProjects = $conn->query("select * from github.proyecto where ".$array1);
	$Others = $conn->query("select * from github.proyecto where ".$array2);
	$array = Array();
	if ($myProjects->num_rows > 0 && $Others->num_rows >0) {
	    while($Myrow = $myProjects->fetch_assoc()) {
			$Others = $conn->query("select * from github.proyecto where ".$array2);
			while($Otherrow = $Others->fetch_assoc()) {  			array_push($array,['fitness'=>getSimilarityCoefficient($Myrow['tags'],$Otherrow['tags']),'data'=>[$Otherrow['nombreProyecto'],$Otherrow['user']]]);
			}
	}
	}
	usort($array, 'compare_fitness');
	$out = Array();
	foreach(array_reverse($array) as $item){
		if(!in_array($item['data'],$out)){
			array_push($out,$item['data']);
		}
	}
	return array_slice($out,0,2);
}


function compare_fitness($a, $b)
  {
    return $a['fitness']-$b['fitness'];
}
?>