<?php
include 'configure.php';
//$database='property';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$sql1 = "select tenant from tenants WHERE tenantcode = ?";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("i", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();

$row=$result1->fetch_assoc();
$tenant = $row['tenant'];
echo "<input type='text' name='tenant' id='tenant' value='$tenant' readonly>";
?>