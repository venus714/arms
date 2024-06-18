<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$plotcode = $_POST['plotcode'];
$rdate = $_POST['rdate'];
$nyear = $_POST['nyear'];
$nmonth = $_POST['nmonth'];
$pcode = $_POST['pcode'];
$remit = $_POST['remit'];
//$clerk ='Mercy';

$remit1 = "select max(rdate) as rdate from remittance where plotcode='$plotcode' and pcode='$pcode'";
$remit2 = $conn->query($remit1);
$remit3 = $remit2->fetch_assoc();
$dremit= $remit3['rdate'];

if($rdate==$dremit)
{
$rec1 = "select tenant,housecode,trans_date,recptno,paid,pcode from receipts where plotcode='$plotcode' 
and pcode IN ('01','DEP','EDP','WDP') and dremit='$rdate' and remitted='1'";
$rec2 = $conn->query($rec1);
$rec3 = "select sum(paid) as paid from receipts where plotcode='$plotcode'
and pcode IN ('01','DEP','EDP','WDP') and dremit='$rdate' and remitted='1' group by plotcode";
$rec4 = $conn->query($rec3);
$rowz = $rec4->fetch_assoc();
$zpaid1 = $rowz['paid'];
$zpaid = number_format($zpaid1,2);
echo "<table>";
echo "<tr><th>Date</th><th>Unit No</th><th>Tenant Name</th><th>Pcode</th><th class='right'>paid</th></tr>";
while ($row=$rec2->fetch_assoc())
{
	$hsecode=$row['housecode'];
	$tenant =$row['tenant'];
	$paycode = $row['pcode'];
	$paid1 = $row['paid'];
	$paid = number_format($paid1,2);
	$date = $row['trans_date'];
	
	echo "<tr><td>$date</td><td>$hsecode</td><td>$tenant</td><td>$paycode</td><td class='right'>$paid</td></tr>";
}
echo "<tr><th colspan=4>Total paid</th><td class='right'>$zpaid</td></tr>";
echo "</table>";
if ($remit=='1')
{	
$uprec1 ="update receipts set remitted='0' where plotcode=$plotcode and dremit='$rdate' and remitted='1' and pcode='$pcode'";
$uprec2 = $conn->query($uprec1);
$upadj1 = "update adjustments set remitted='0' where plotcode='$plotcode' and dremit='$rdate' and remitted='1' and pcode='$pcode'";
$upadj2 = $conn->query($upadj1);
if ($pcode=='01')
{
$disbur1 = "update disbursement set remitted='0' where plotcode='$plotcode' and dremit='$rdate' and remitted='1'";
$disbur2 = $conn->query($disbur1);
$adv1 = "update advance set remitted='0' where plotcode='$plotcode' and dremit='$rdate' and remitted='1'";
$adv2 = $conn->query($adv1);
$bnkexp1 = "update bankexp set remitted='0' where plotcode='$plotcode' and dremit='$rdate' and remitted='1'";
$bnkexp2 = $conn->query($bnkexp1);
}
$delrem1 = "delete from remittance where plotcode='$plotcode' and rdate='$rdate' and pcode='$pcode'";
$delrem2 = $conn->query($delrem1);
}} else {
	echo "<p style='font-weight: bold;color: red;text-align: center'>Not the latest Remittance</p>";
}
?>