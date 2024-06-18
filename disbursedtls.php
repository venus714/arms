<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plotcode =  $_POST['plotcode'];
$nmonth = $_POST['nmonth'];
$nyear = $_POST['nyear'];

$str1= "select id,description,amount,trans_date from disbursement where plotcode=$plotcode and nmonth=$nmonth and nyear=$nyear and canx!='1'";
$str2 = $conn->query($str1);

echo "<table>";
echo "<tr>";
echo "<th>Recno</th>";
echo "<th>Narrative</th>";
echo "<th>Amount</th>";
echo "<th>Date</th>";
echo "<th>Select</th>";
echo "</tr>";
while ($row = $str2->fetch_assoc())
{
$id= $row['id'];
$narrative = $row['description'];
$amount = $row['amount'];
$trans_date = $row['trans_date'];
echo "<tr>";
echo "<td style='width: 5%;'><input type='text' name='idno[]' class='idno' value='$id' readonly></td>";
echo "<td style='width: 50%'><textarea readonly name='narrative[]' class='narrative'>$narrative</textarea></td>";
echo "<td style='width: 20%;text-align:right;'><input type='text' name='amount[]' class='amount' value='$amount' readonly></td>";
echo "<td style='width: 20%'><input type='text' name='date1[]' class='date1' value=$trans_date readonly></td>";
echo "<td style='width: 5%'><input type ='checkbox' name='chek1[]' class='chek1' value='0' onclick='zmark()'></td>";
echo "</tr>";
}
echo "</table>";
?>