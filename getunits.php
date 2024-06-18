<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );

$sql1 = "select housecode,houseid from houseunits WHERE plotcode = ? and occupied='0'";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("i", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();
//echo "Unit Number ";
echo "<select name='housecode' id = 'housecode' style='width: 150px;height:25px;' onblur='showrent(this.value)'>";
while ($row=$result1->fetch_assoc()) {
	$housecode=$row['housecode'];
	$houseid = $row['houseid'];
	//$date = $row['date'];
	echo "<option value='$houseid'>$housecode</option>";
}
	echo "</select>";
?>