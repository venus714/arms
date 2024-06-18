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
$check = $_POST['check'];
$tenantcode=$_POST['tenantcode'];

/*$item1 ="select description from receivables where pcode='$pcode'";
$item2 = $conn->query($item1);
$irow = $item2->fetch_assoc();
$itemname = $irow['description'];
*/

$bbf1 = "create or replace view balbf as select tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from balancebf where plotcode='$plotcode' and trans_date<'$date1' NOT ISNULL('tenantcode' group by tenantcode)";
$bbf2 = $conn->query($bbf1);

$adj1 = "create or replace view adjusts as select tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from bills where plotcode='$plotcode' and trans_date<'$date1'";
$adj2 = $conn->query($adj1);


$debt1 = "create or replace view pastbills as select tenantcode,tenant,housecode,sum(amtdue) as amtdue,00000000.00 as paid 
from bills where plotcode='$plotcode' and datedue<'$date1' and NOT ISNULL(tenantcode) group by tenantcode";
$debt2 = $conn->query($debt1);

$recpt1 = "create or replace view pastpaid as select tenantcode,tenant,housecode,00000000.00 as amtdue,paid 
from receipts where plotcode='$plotcode' and trans_date<'$date1'";
$recpt2 = $conn->query($recpt1);

$debt1 = "create or replace view balcf1 as select * from pastbills union all select * from pastpaid
union all select * from adjusts union all select * from balbf";
$debt2 = $conn->query($debt1);

$debt3 = "create or replace view allbalcf as select housecode,tenant,tenantcode,'000' as pcode,'$date1' as trans_date,00000000.00 as amtdue,00000000.00 as paid,
sum(amtdue-paid) as balcf,'BALANCE BF' as descript,'BBF' as refno  from balcf1 group by tenantcode";
$debtors4 = $conn->query($debt3);

$bill1 = "create or replace view allbilldebits as select housecode,tenant,tenantcode,bills.pcode,datedue as trans_date,amtdue,00000000.00 as paid,
00000000.00 as balcf,concat(receivables.description,' BILL') as descript,bills.id+1000 as refno from bills 
left join receivables on bills.pcode=receivables.pcode where plotcode='$plotcode' and datedue between '$date1' and '$date2'";
$bill2 = $conn->query($bill1);

$adj1 = "create or replace view alladjustdebits as select housecode,tenant,tenantcode,adjustments.pcode,trans_date,amount as amtdue,00000000.00 as paid,
00000000.00 as balcf, concat(receivables.description, ' ADJ') as descript,adjustments.id+1000 as refno from adjustments 
left join receivables on adjustments.pcode=receivables.pcode where plotcode='$plotcode' and trans_date between '$date1' and '$date2'";
$adj2 = $conn->query($adj1);


$recpt1 = "create or replace view allrecptcredit as select housecode,tenant,tenantcode,receipts.pcode,trans_date,00000000.00 as amtdue,paid,
00000000.00 as balcf, concat(receivables.description,' PAYMENT') as descript,recptno+1000 as refno from receipts left join receivables on receipts.pcode=receivables.pcode
where plotcode='$plotcode' and trans_date between '$date1' and '$date2'";
$recpt2 = $conn->query($recpt1);

$stat1 ="create or replace view alltenantstat as select * from allbalcf union all select * from allbilldebits union all select * from alladjustdebits
union all select * from allrecptcredit";
$stat2 = $conn->query($stat1);

$viw1 = "create or replace view statsumm as select tenantcode,housecode,tenant,sum(amtdue+balcf-paid) as balcf from alltenantstat 
where !ISNULL(tenantcode) group by tenantcode order by housecode";
$viw2 = $conn->query($viw1);

$stat1 ="create or replace view alltenantstat as select * from allbalcf union all select * from allbilldebits union all select * from alladjustdebits
union all select * from allrecptcredit";
$stat2 = $conn->query($stat1);
if ($check=='1')
{
$viw1 = "create or replace view statsumm as select tenantcode,housecode,tenant,sum(amtdue+balcf-paid) as balcf from alltenantstat 
where tenantcode=$tenantcode and !ISNULL(tenantcode) group by tenantcode";
$viw2= $conn->query($viw1);
} else {
$viw1 = "create or replace view statsumm as select tenantcode,housecode,tenant,sum(amtdue+balcf-paid) as balcf from alltenantstat 
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
$sql1 ="select trans_date,descript,refno,pcode,amtdue,paid,balcf+amtdue-paid as balcf from alltenantstat where tenantcode='$tenantcode' order by trans_date";
$sql2 = $conn->query($sql1);
echo "<table><tr>";
echo "<tr><th class='th'>Date</th><th class='th'>Narrative</th><th class='th'>Ref No.</th><th class='th'>Pay Code</th><th class='td'>Debit</th>
<th class='td'>Credit</th><th class='td'>Balance</th></tr>";
$bal=0;
while ($rowz=$sql2->fetch_assoc())
{
	$trans_date = $rowz['trans_date'];
	$descript1 = strtolower($rowz['descript']);
	$descript =ucwords($descript1);
	$refno = $rowz['refno'];
	$pcode = $rowz['pcode'];
	$debit = number_format($rowz['amtdue'],2);
	$credit=number_format($rowz['paid'],2);
	$balcf1 = $rowz['balcf']+$bal;
    $balcf = number_format($balcf1,2);

echo "<tr><td class='th'>$trans_date</td><th class='th' style='font-weight: normal'>$descript</th><td class='th'>$refno</td><td class='th'>$pcode</td>
<td class='td'>$debit</td><td class='td'>$credit</td><td class='td' >$balcf</td></tr>";
$bal=$balcf1;
}
echo "<tr><td colspan='6' class='th' style='font-weight:bold'>Balance Cf</td><td class='td' style='font-weight:bold'>$zbalcf</td></tr>";
echo "</table>";
$lap=$lap+1;
}
?>