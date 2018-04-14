
<?php
include 'connMongo.php';
 
$conn = OpenConMon();
 
echo "Connected Successfully";
 
CloseCon($conn);
 
?>