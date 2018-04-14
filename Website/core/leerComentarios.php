
<?php
include 'connMysql.php';
$conn = OpenCon();
header('Content-type: application/json');
$np = $_POST['pn'];
$owner = $_POST['usuario'];
$doc = $_POST['doc'];

if(strcmp($doc,'')==0){ 
	$doc= "doc is null";
}else{$doc="doc='$doc'";}


$query = "select * from github.comentario  where proyecto='$np' and owner='$owner' and $doc order by fecha desc;";

$result = $conn->query($query);

$strout="<dl>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $strout=$strout. "<dt><h5>".$row["usuario"]."</h5>".$row["fecha"]."</h6></dt><dd><blockquote>".$row["comentario"]."</blockquote></dd>";
    }
}
$data['status']=$strout.'</dl>';
echo json_encode($data);
die;

?>