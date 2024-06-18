<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$refno = $_POST['refno'];

$sql="select id,amount,narrative,trans_date from advance where id='$refno'";
$result = $conn->query($sql);
$row= $result->fetch_assoc();
$amount= $row['amount'];
$narrative = $row['narrative'];
$trans_date = $row['trans_date'];
echo "<div class='mypara'>";
echo "<input type='hidden' id='refno' value='$refno'>";
echo "<table>";
echo "<tr><th>Date</th>";
echo "<td><input type='date' name='date1' id='date1' value='$trans_date' readonly></td></tr>";
echo "<tr><th>Amount</th>";
echo "<td><input type='text' id='adv' name='adv' value='$amount' style='text-align: right' readonly></td></tr>";
echo "<tr><th> Narrative </th>";
echo "<td><textarea name='narr' id='narr' cols=20 rows=5 readonly>$narrative</textarea></td></tr>";
echo "<tr><td class='hz'><button type='button' id='btnedit' onclick='editdata()'>Edit</button></td>";
echo "<td class='hz'><button type='button' id='btnupdate' onclick='updatedata()' disabled>Update</button></td></tr>";
echo "</table>";
echo "</div>";
?>