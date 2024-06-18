<html>
<head>
<style>
.right {
	text-align:right;
	padding-right:10px;
}
.th {
	border: 1px solid black;
}

.td {
	border: 1px solid black;
	padding-right: 10px;
	text-align: right;
}
</style>
</head>
</html>
<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$plotcode = $_POST['plotcode'];
$date1 = $_POST['date1'];
$date2 = $_POST['date2'];
$pcode = $_POST['pcode'];
$check = $_POST['check'];
$tenantcode= $_POST['tenantcode'];

$item1 ="select description from receivables where pcode='$pcode'";
$item2 = $conn->query($item1);
$irow = $item2->fetch_assoc();
$itemname = $irow['description'];

$bbf1 = "create or replace view balbf as select tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from balancebf where plotcode='$plotcode' and pcode='$pcode' and trans_date<'$date1' NOT ISNULL('tenantcode')";
$bbf2 = $conn->query($bbf1);

$adj1 = "create or replace view adjusts as select tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from bills where plotcode='$plotcode' and pcode='$pcode' and trans_date<'$date1'";
$adj2 = $conn->query($adj1);


$debt1 = "create or replace view pastbills as select tenantcode,tenant,housecode,sum(amtdue) as amtdue,00000000.00 as paid 
from bills where plotcode='$plotcode' and pcode='$pcode' and datedue<'$date1' and NOT ISNULL(tenantcode) group by tenantcode";
$debt2 = $conn->query($debt1);

$recpt1 = "create or replace view pastpaid as select tenantcode,tenant,housecode,00000000.00 as amtdue,sum(paid) as paid 
from receipts where plotcode='$plotcode' and pcode='$pcode' and trans_date<'$date1' group by tenantcode";
$recpt2 = $conn->query($recpt1);

$debt1 = "create or replace view balcf1 as select * from pastbills union all select * from pastpaid
union all select * from adjusts union all select * from balbf";
$debt2 = $conn->query($debt1);

$debt3 = "create or replace view balcf as select housecode,tenant,tenantcode,'$date1' as trans_date,00000000.00 as amtdue,00000000.00 as paid,
sum(amtdue-paid) as balcf,'BALANCE BF' as descript,'BBF' as refno  from balcf1 group by tenantcode";
$debtors4 = $conn->query($debt3);

$bill1 = "create or replace view billdebits as select housecode,tenant,tenantcode,datedue as trans_date,amtdue,00000000.00 as paid,
00000000.00 as balcf,'$itemname BILL' as descript,id+1000 as refno from bills where plotcode='$plotcode' and pcode='$pcode' and datedue between '$date1' and '$date2'";
$bill2 = $conn->query($bill1);

$adj1 = "create or replace view adjustdebits as select housecode,tenant,tenantcode,trans_date,amount as amtdue,00000000.00 as paid,
00000000.00 as balcf, '$itemname ADJ' as descript,id+1000 as refno from adjustments where plotcode='$plotcode' and pcode='$pcode' and trans_date between '$date1' and '$date2'";
$adj2 = $conn->query($adj1);

$recpt1 = "create or replace view recptcredit as select housecode,tenant,tenantcode,trans_date,00000000.00 as amtdue,paid,
00000000.00 as balcf, '$itemname PAYMENT' as descript,recptno as refno from receipts where plotcode='$plotcode' and pcode='$pcode' and trans_date between '$date1' and '$date2'";
$recpt2 = $conn->query($recpt1);

$stat1 ="create or replace view tenantstat as select * from balcf union all select * from billdebits union all select * from adjustdebits
union all select * from recptcredit";
$stat2 = $conn->query($stat1);


if ($check=='1')
{
$viw1 = "create or replace view statsumm as select tenantcode,housecode,tenant,sum(amtdue+balcf-paid) as balcf from tenantstat 
where tenantcode=$tenantcode and !ISNULL(tenantcode) group by tenantcode";
$viw2= $conn->query($viw1);
} else {
$viw1 = "create or replace view statsumm as select tenantcode,housecode,tenant,sum(amtdue+balcf-paid) as balcf from tenantstat 
where !ISNULL(tenantcode) group by tenantcode order by housecode";
$viw2= $conn->query($viw1);
}


$qr1= "select tenantcode,housecode,tenant,balcf from statsumm where !isnull(tenantcode)";
$qr2 = $conn->query($qr1);
$lap=0;
while ($db=$qr2->fetch_assoc())
{
$housecode = $db['housecode'];
$tenant = $db['tenant'];
$tenantcode= $db['tenantcode'];
$zbalcf = number_format($db['balcf'],2);
if ($lap>0) {echo '<br><br>';}
echo "<table><tr><th>Unit Number: $housecode</th><th> Tenant Name: $tenant</th></tr></table>";
$sql1 ="select trans_date,descript,refno,amtdue,paid,balcf+amtdue-paid as balcf from tenantstat where tenantcode='$tenantcode' order by trans_date";
$sql2 = $conn->query($sql1);
echo "<table><tr>";
echo "<tr><th class='th'>Date</th><th class='th'>Narrative</th><th class='th'>Ref No.</th><th class='td'>Debit</th><th class='td'>Credit</th><th class='td'>Balance</th></tr>";
$bal=0;
while ($rowz=$sql2->fetch_assoc())
{
	$trans_date = $rowz['trans_date'];
	$descript1 = strtolower($rowz['descript']);
	$descript =ucwords($descript1);
	$refno = $rowz['refno'];
	$debit = number_format($rowz['amtdue'],2);
	$credit=number_format($rowz['paid'],2);
	$balcf1 = $rowz['balcf']+$bal;
    $balcf = number_format($balcf1,2);
echo "<tr><td class='th'>$trans_date</td><th class='th' style='font-weight:normal'>$descript</th><td class='th'>$refno</td><td class='td'>$debit</td><td class='td'>$credit</td><td class='td' >$balcf</td></tr>";
$bal=$balcf1;
}
echo "<tr><td colspan='5' class='th' style='font-weight:bold'>Balance Cf</td><td class='td' style='font-weight:bold'>$zbalcf</td></tr>";
echo "</table>";
$lap=$lap+1;
}
?>