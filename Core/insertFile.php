<?php
include 'connMongo.php';
error_reporting(E_ALL);
 // I don't know if you need to wrap the 1 inside of double quotes.
 ini_set("display_startup_errors",1);
 ini_set("display_errors",1);
header('Content-type: application/json');
$conn = new MongoDB\Driver\Manager("mongodb://localhost:27017");

$file = $_POST['file'];
$branch = $_POST['branch'];

$path = pathinfo($file);
$name = $path['filename'];
$insert = array(
	"nombre" => $name,
	"archivo" => new MongoDB\BSON\Binary(file_get_contents($file),0),
	"fecha" => getdate(),
	"branch" => $branch
);


$bulk = new MongoDB\Driver\BulkWrite;
$id = $bulk->insert($insert);


$msg['status'] = $id;  
		

echo json_encode($msg);die;
 
?>