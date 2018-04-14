<?php

function OpenConMon()
 {
	 $conn = new MongoDB\Driver\Manager("mongodb://localhost:27017");
 return $conn;
 }
 
function CloseConMon($conn)
 {
 $conn -> close();
 }
   
?>