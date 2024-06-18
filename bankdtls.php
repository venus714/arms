<?php
$date1 = date('Y-m-d');
require 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$sql1 ="select * from banks";
$sql2 = $conn->query($sql1);

echo "<table>";
echo "<tr>";
echo "<th>Reference Number</th>";
echo "<th>Date Banked</th>";
echo "<th>Bank A/C</th>";
echo "</tr>";
echo "<td><input type='text' name='ref' id='ref' value='' style='height: 25px' autofocus></td>";
echo "<td><input type='date' name='dbanked' id='dbanked' value='$date1' style='height: 25px'></td>";
echo "<td><select name='acno' id='acno' style='width: 100px;height: 25px;' onblur='itemdtls()'>";
while ($row = $sql2->fetch_assoc())
{
	$accno = $row['accno'];
	$bankname = $row['bankname'];
echo "<option value='$accno'>$bankname</option>";
}
echo "</select";
echo "</td>";
echo "</tr>";
echo "</table>";
?>