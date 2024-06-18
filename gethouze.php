<?php
include 'configure.php';
//$database='property';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );

$sql1 = "select housecode,houseid,tenantcode from tenants WHERE plotcode = ? and movedout='0'";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("i", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();
//echo "Unit Number ";
echo "<select name='houseid' id = 'houseid' style='width: 150px;height:25px;' onchange='zerch()'>";
while ($row=$result1->fetch_assoc()) {
	$housecode=$row['housecode'];
	$houseid = $row['houseid'];
	//$tenantcode = $row['tenantcode'];
	//$date = $row['date'];
	echo "<option value='$houseid'>$housecode</option>";
}
	echo "</select>";
?>