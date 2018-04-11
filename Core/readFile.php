<?php
error_reporting(E_ALL);
include 'connMongo.php';
 // I don't know if you need to wrap the 1 inside of double quotes.
 ini_set("display_startup_errors",1);
 ini_set("display_errors",1); 
$conn = new MongoDB\Driver\Manager("mongodb://localhost:27017");

try {
	$id           = new \MongoDB\BSON\ObjectId("5acc0a88745505b62353ea17");
	$filter      = ['_id' => $id];
	$options = [];
	$query = new \MongoDB\Driver\Query($filter, $options);
	$rows   = $conn->executeQuery('github.archivo', $query); 

	foreach ($rows as $document) {
	  header('Content-type:'.$document->tipo);
	  echo $document->archivo;
	}
} catch(MongoDB\Driver\Exception $e) {
    echo $e->getMessage(), "\n";
    exit;
}
?>