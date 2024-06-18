<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$sql1 = "select housecode,houseid,tenantcode from tenants WHERE plotcode = ? and movedout!='1'";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("i", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();
//echo "Unit Number ";
echo "<select name='tntcode' id = 'tntcode' style='width: 150px;height:25px;' onblur='zdisplay(this.value)'>";
while ($row=$result1->fetch_assoc()) {
	$housecode=$row['housecode'];
	$tenantcode = $row['tenantcode'];
	//$date = $row['date'];
	echo "<option value='$tenantcode'>$housecode</option>";
}
	echo "</select>";
?>