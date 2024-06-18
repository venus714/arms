<?php
$totpaid = $_POST['totpaid'];
$recdesc = $_POST['recdesc'];
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );

$sql1="select pcode,description,bbf,amtdue,paid,bcf from baldue order by pcode";
$sql2=$conn->query($sql1);

$sql3 ="select sum(bcf) as totdue from baldue";
$sql4 = $conn->query($sql3);
$row1=$sql4->fetch_assoc();
$totdue =$row1['totdue'];

echo "<div>"; 
echo "<form method='PSOT' action='recptprint.php'>";
echo "Receipt Description...";
echo "<input type=text id='desc' name='desc' value='$recdesc' style='width:250px;height:25px'><br><br>";
echo "Total Amount Paid.....";
echo "<input type='text' name='chkamt' id='chkamt' value='$totpaid' style='width: 100px;height: 25px' onblur='recptupdate()'><br><br>";
echo "<div id='recptno'>";
echo "</div>";
echo "<br>";
echo "<table class='table'>";
echo "<tr>";
echo "<th class='th'>Pay Code</th>";
echo "<th class='th'>Description</th>";
echo "<th class='th'>Amount Due</th>";
echo "<th class='th'>Amount Paid</th>";
echo "</tr>";
while ($row2=$sql2->fetch_assoc()) {
	$pcode=$row2['pcode'];
	$description = $row2['description'];
	$amtdue = $row2['bcf'];
	//$amtdue1 = number_format($amtdue,2);
	if ($amtdue>0)
	{
	$paid = (($amtdue/$totdue)*$totpaid);
	//$paid = number_format($paid1,2);
	
	} else {$paid=0.00;}
	echo "<tr>";
	echo "<td class='td'><input type=text class='pcode' value='$pcode' readonly></td>";
	echo "<td class='td'><input type='text' class='descript' value='$description' readonly></td>";
	echo "<td class='td'><input type='text' class='amtdue' value='$amtdue' readonly style='text-align:right'></td>";
	echo "<td class='td'><input type='paid' class='paid' value='$paid' style='text-align:right'></td>";
	echo "</tr>";
	
}
	echo "</table>";
	echo "<br><br>";
	echo "<div style='text-align: center'>";
	echo "<button type='button' name='btn2' id='btn2' class='button1' onclick='writedata()'>Save</button>";
	echo "<input type='submit' name='btn4' id='btn4' class='button1' value='Print' disabled>";
	echo "<button type='reset' name='btn3' id='btn3' class='button1'>Cancel</button>";
	echo "</div>";
	echo "</form>";
	echo "</div>";
?>