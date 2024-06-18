<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$sql1 = "select description from receivables WHERE pcode = ?";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$resultz=$stmt->get_result();

$row2=$resultz->fetch_assoc();
	$description=$row2['description'];
echo "<input type='text' name='descript' id='descript' value='$description' readonly>";
?>