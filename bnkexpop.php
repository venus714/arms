<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$plotcode = $_POST['plotcode2'];
$nyear = $_POST['nyear2'];
$nmonth = $_POST['nmonth2'];

$sql2="select id,amount,narrative from bankexp where plotcode='$plotcode' and nyear='$nyear' and nmonth='$nmonth'";
$result2 = $conn->query($sql2);
echo "<div class='mypara'>";
echo "<table>";
echo "<tr><th>Ref No.</th><th>Narrative</th><th>Amount</th></tr>";
while ($row=$result2->fetch_assoc())
{
	$id=$row['id'];
	$narrative=$row['narrative'];
	$amount = number_format($row['amount'],2);
	
echo "<tr><td>$id</td><td>$narrative</td><td class='right'>$amount</td></tr>";
}
echo "</table>";
echo "</div>";
?>
