<?php
include 'configure.php';
//$database='property';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$sql1 = "select * from houseunits WHERE houseid = ?";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();
$row = $result1->fetch_assoc();
$housecode=$row['housecode'];
$newrent = $row['rent'];
echo "<td><input type ='hidden' name='hsecode2' id='hsecode2' value='$housecode' readonly></td>";
echo "<td><input type ='hidden' name='newrent' id='newrent' value='$newrent' readonly></td>";
?>