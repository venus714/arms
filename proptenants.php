<html>
<head>
<style>
.table,.td,.th {
	border: 1px solid black;
	border-collapse: collapse;
}
</style>
</head>
</html>
<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$sql1 = "select housecode,houseid,tenantcode,tenant from tenants WHERE plotcode = ? and movedout='0'";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("i", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();
echo "<div style='height: 250px;overflow: auto;border: 1px solid black'>";
echo "<table class='table'>";
echo "<tr>";
echo "<th class='th' style='width:20%'>House No</th>";
echo "<th class='th' style='width:60%'>Tenant Name</th>";
echo "<th class='th' style='width:20%'>select</th>";
echo "<th style='width:0%'></th>";
echo "</tr>";
while ($row=$result1->fetch_assoc()) {
	$housecode=$row['housecode'];
	$tenantcode = $row['tenantcode'];
	$tenant = $row['tenant'];
	echo "<tr>";
	echo "<td class='td' style='width: 20%'><input type='text' name='hsecode[]' class='hsecode' value='$housecode' readonly></td>";
	echo "<td class='td' style='width: 60%'><input type='text' name='tenant[]' class='tenant' value='$tenant' readonly ></td>";
	echo "<td class='td' style='width: 20%'><input type='radio' name='chk1[]' class='chk1' value='0' onclick='gmonth()' style='text-align: center'></td>";
	echo "<td><input type='hidden' name='tenantcode[]' class='tenantcode' value='$tenantcode' readonly></td>";
	echo "<tr>";
}
	echo "</table>";
	echo "</div>";
?>