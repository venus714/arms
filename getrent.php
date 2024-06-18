<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );

$sql1 = "select rent from houseunits WHERE houseid = ?";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();
$row1 = $result1->fetch_assoc();
$rent = $row1['rent'];
echo "<input type = 'text' name='rent' id='rent' value='$rent' readonly>";
?>