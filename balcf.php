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
$tenantcode= $_POST['tenantcode1'];
$plotcode= $_POST['plotcode'];
$nmonth = $_POST['nmonth'];
$nyear = date("Y");
$totpaid = 0;
$recdesc = '';

//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$view1 = "create or replace view bill1 as select bills.tenantcode,bills.pcode,bills.amtdue,
receipts.paid,bills.amtdue-receipts.paid as bbf from bills left join receipts on
bills.tenantcode=receipts.tenantcode where bills.tenantcode=$tenantcode and 
(bills.nmonth<$nmonth or bills.nyear<$nyear) and bills.nyear<=$nyear";
$view2 = $conn->query($view1);

$view3 ="create or replace view mntbill2 as select tenantcode,pcode,sum(amtdue) as amtdue,000000.00 as paid,000.00 as bbf 
from bills where bills.tenantcode=$tenantcode and bills.nmonth=$nmonth and bills.nyear=$nyear group by pcode"; 
$view4 = $conn->query($view3);

$view5 ="create or replace view mntbill1 as select tenantcode,pcode,000000.00 as amtdue,sum(paid) as paid,000.00 as bbf 
from receipts where tenantcode=$tenantcode and nmonth=$nmonth and nyear=$nyear group by pcode"; 
$view6 = $conn->query($view5);


$view7 = "create or replace view mntbill as select * from mntbill1 union all select * from mntbill2";
$view8 = $conn->query($view7);

$qr1 = "create or replace view arrears1 as select tenantcode,pcode,sum(amtdue) as amtdue,0000.00 as paid
from bills where tenantcode=$tenantcode and (nmonth<$nmonth or nyear<$nyear) and nyear<=$nyear group by pcode";
$qr2 = $conn->query($qr1);

$qr3 = "create or replace view arrears2 as select tenantcode,pcode,000.00 as amtdue,sum(paid) as paid
from receipts where tenantcode=$tenantcode and (nmonth<$nmonth or nyear<$nyear) and nyear<=$nyear group by pcode";
$qr4 = $conn->query($qr3);


$qr5 = "create or replace view arrears3 as select * from arrears1 union all select * from arrears2";
$qr6 = $conn->query($qr5);

$qr7 = "create or replace view arrears as select tenantcode,pcode,000.00 as amtdue,000.00 as paid,sum(amtdue-paid) as bbf from arrears3 group by pcode";
$qr8 = $conn->query($qr7);


$qr9 = "create or replace view baldue1 as select * from arrears union all select * from mntbill";
$qr10 = $conn->query($qr9);

$qr11 = "create or replace view baldue as select tenantcode,baldue1.pcode,receivables.description,sum(bbf) as bbf,sum(amtdue) as amtdue,sum(paid) as paid,
sum(bbf+amtdue-paid) as bcf from baldue1 left join receivables on baldue1.pcode=receivables.pcode group by baldue1.pcode";
$qr12= $conn->query($qr11);

$sql1="select pcode,description,bbf,amtdue,paid,bcf from baldue order by baldue.pcode";
$sql2=$conn->query($sql1);

echo "<table class='table'>";
echo "<tr>";
echo "<th class='th'>Pay Code</th>";
echo "<th class='th'>Bal BF</th>";
echo "<th class='th'>Month Bill</th>";
echo "<th class='th'>Month Paid</th>";
echo "<th class='th'>Bal CF</th>";
echo "</tr>";
while ($row=$sql2->fetch_assoc()) {
	$pcode=$row['pcode'];
	$bbf = number_format($row['bbf'],2);
	$amtdue = number_format($row['amtdue'],2);
	$paid = number_format($row['paid'],2);
	$bcf = number_format($row['bcf'],2);
	echo "<tr>";
	echo "<td class='td'>$pcode</td>";
	echo "<td class='td'>$bbf</td>";
	echo "<td class='td'>$amtdue</td>";
	echo "<td class='td'>$paid</td>";
	echo "<td class='td'>$bcf</td>";
	echo "<tr>";
}
	echo "</table>";
$sql3 ="select sum(bcf) as totdue from baldue";
$sql4 = $conn->query($sql3);
$row1=$sql4->fetch_assoc();
$totdue =$row1['totdue'];
$totdue1 = number_format($totdue,2);
echo "<br>";
echo "<div style='font-weight: bold'>Total Due.....$totdue1</div>";
echo "<hr>";
$sql5="select baldue.pcode,receivables.description,bbf,amtdue,paid,bcf from baldue left join receivables on baldue.pcode=receivables.pcode
 order by baldue.pcode";
$sql6=$conn->query($sql5);

echo "<div id='msg3' style='display: none;'>"; 
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
while ($row2=$sql6->fetch_assoc()) {
	$pcode=$row2['pcode'];
	$description = $row2['description'];
	$amtdue = number_format($row2['bcf'],2);
	$paid = 0;
	echo "<tr>";
	echo "<td class='td'><input type=text class='pcode' value='$pcode' readonly></td>";
	echo "<td class='td'><input type='text' class='descript' value='$description' readonly></td>";
	echo "<td class='td'><input type='text' class='amtdue' value='$amtdue' readonly></td>";
	echo "<td class='td'><input type='paid' class='paid' value='$paid'></td>";
	echo "</tr>";
	
}
	echo "</table>";
	echo "<br><br>";
	echo "<div style='text-align: center'>";
	echo "<button type='button' name='btn2' id='btn2' class='button1' onclick='writedata()'>Save</button>";
	echo "<button type='button' name='btn4' id='btn4' class='button1' onclick='recptprint()' disabled>Print</button>";
	echo "<button type='button' name='btn3' id='btn3' class='button1'>Cancel</button>";
	echo "</div>";
	echo "</div>";
?>