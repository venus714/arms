<?php
include 'configure.php';
//$database='property';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );

$sql1 = "select tenant,tenantcode,houseid from tenants WHERE houseid = ? and movedout='1' ";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();
//$row1 = $result1->fetch_assoc();
//$houseid = $row1['houseid'];

$sql2 = "select tenant,tenantcode,houseid from tenants WHERE houseid = ? and movedout='1' ";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("s", $_GET['q']);
$stmt2->execute();
$result2=$stmt2->get_result();
$row1 = $result2->fetch_assoc();
$houseid = $row1['houseid'];

$qry1 = "select houseid from tenants where houseid='$houseid' && movedout='0'";
$rez1 = $conn->query($qry1);
if ($rez1) {
	if ($rez1->num_rows>0) {
		echo "Unit has new Occupant";
	} else {

//echo "Unit Number ";
echo "<select name='xcode' id = 'xcode' style='width: 150px;height:25px;' onblur='zdisplay(this.value)'>";
while ($row=$result1->fetch_assoc()) {
	$tenant = $row['tenant'];
	$tenantcode = $row['tenantcode'];
	//$date = $row['date'];
	echo "<option value='$tenantcode'>$tenant</option>";
}
	echo "</select>";
	}
} else {
	echo "Error in".$qry1.'<br>'.$conn->error;
}
?>