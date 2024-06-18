<?php
include 'configure.php';
//$database='property';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$sql1 = "select housecode,tenant,pcode,exprent,paid from receipts WHERE recptno = ? and canx!='1'";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("i", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();

if ($result1->num_rows>0) 
{
$qr1 = $conn->prepare("select distinct tenantcode,housecode,tenant,trans_date,plotname from receipts left join plots on receipts.plotcode=plots.plotcode 
where recptno =?");
$qr1->bind_param("i",$_GET['q']);
$qr1->execute();
$result = $qr1->get_result();

$row1=$result->fetch_assoc();
$housecode= $row1['housecode'];
$tenant = $row1['tenant'];
$plotname= $row1['plotname'];

echo "Property Name: $plotname";
echo "<br><br>";
echo "house Number: $housecode";
echo "<br><br>";
echo "Tenant Name: $tenant";
echo "<br><br>";
echo "<table>";
echo "<tr>";
echo "<th>Paycode</th><th>Amount Due</th><th>Amout Paid</th><th>Balance</th>";
while ($row=$result1->fetch_assoc()) {
	$pcode=$row['pcode'];
	$exprent = $row['exprent'];
	$paid = $row['paid'];
	$balance = $exprent-$paid;
	echo "<tr>";
	echo "<td>$pcode</td><td>$exprent</td><td>$paid</td><td>$balance</td>";
	echo "</tr>";
}
	echo "</table>";
	echo "<br><br>";
	echo "<div class='hz'>";
	echo "<button type='button' id='btn1' class='button1' onclick='canx()'>Accept</button>";
	echo "</div>";
	echo "<br><br>";
} else {
	echo "Receipt Number Does not Exist OR is Already Canceled";
}
?>