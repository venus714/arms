<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$plotcode = $_POST['plotcode'];
$nyear = $_POST['nyear'];
$nmonth = $_POST['nmonth'];
$pcode = '01';

$sql1 = "select rdate from remittance where plotcode='$plotcode' and nyear='$nyear' and nmonth='$nmonth' and pcode='$pcode'";
$result = $conn->query($sql1);

echo "<select name='dremit' id='dremit' style='width:150px;height:25px'>";
while ($row=$result->fetch_assoc())
{
	$rdate = $row['rdate'];
	echo "<option value='$rdate'>$rdate</option>";
}
echo "</select>";	
?>