<?php
include 'configure.php';
//$database='property';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$sql1 = "select distinct housecode,houseid,tenantcode from tenants WHERE plotcode = ? and movedout='1'";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("i", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();

//$rec = $conn->query($sql2);
	
echo "<select name='hsecode' id = 'hsecode' style='width: 150px;height:25px;' onblur='xdisplay(this.value)'>";
while ($row=$result1->fetch_assoc()) {
	$housecode=$row['housecode'];
	$houseid = $row['houseid'];
	$tenantcode = $row['tenantcode'];
	//$date = $row['date'];
	echo "<option value='$houseid'>$housecode</option>";
}
	echo "</select>";
?>