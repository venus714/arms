<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$plotcode = $_POST['plotcode'];
$date1 = $_POST['date1'];
$nyear = $_POST['nyear'];
$nmonth = $_POST['nmonth'];
$advance = $_POST['advance'];
$narrative= $_POST['narrative'];

$sql1 ="insert into bankexp(plotcode,trans_date,amount,nmonth,nyear,narrative)
value('$plotcode','$date1','$advance','$nmonth','$nyear','$narrative')";
$result = $conn->query($sql1);

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