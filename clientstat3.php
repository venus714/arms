<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$plotcode = $_POST['plotcode'];
$date1 = $_POST['date1'];
$date2 = $_POST['date2'];
$nyear = $_POST['nyear'];
$nmonth = $_POST['nmonth'];
$pcode = $_POST['pcode'];
$chqno = $_POST['chqno'];
$clerk = $_POST['clerk'];
$remit = $_POST['remit'];
$statype = $_POST['statype'];

$mgtrate1 ="select plotname,lordcode,mgtcom,lordvat from plots where plotcode='$plotcode'";
$mgtrate2 = $conn->query($mgtrate1);
$mgtrate3 = $mgtrate2->fetch_assoc();
$mgtcom = $mgtrate3['mgtcom'];
$lordvat = $mgtrate3['lordvat'];
$plotname = $mgtrate3['plotname'];
$lordcode = $mgtrate3['lordcode'];

$vatable1 = "select vat from setup";
$vatable2 = $conn->query($vatable1);
$vatable3 = $vatable2->fetch_assoc();
$vatrate = $vatable3['vat'];

$item1 = "select description from receivables where pcode='$pcode'";
$item2 = $conn->query($item1);
$db = $item2->fetch_assoc();
$description = $db['description']; 

$bbf1 = "create or replace view balbf as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from balancebf where plotcode = $plotcode and pcode='$pcode'";
$bbf2 = $conn->query($bbf1);

$adj1 = "create or replace view adjusts as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from adjustments where plotcode = $plotcode and pcode='$pcode' and trans_date<'$date2'";
$adj2 = $conn->query($adj1);

$debt1 = "create or replace view pastbills as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from bills where plotcode =$plotcode and pcode='$pcode' and (nmonth<$nmonth or nyear<$nyear) and nyear<=$nyear";
$debt2 = $conn->query($debt1);

$recpt1 = "create or replace view pastpaid as select plotcode,tenantcode,tenant,housecode,00000000.00 as amtdue,paid 
from receipts where plotcode=$plotcode and pcode='$pcode' and trans_date<'$date1'";
$recpt2 = $conn->query($recpt1);

$debt1 = "create or replace view debtors as select * from pastbills union all select * from pastpaid union all
select * from balbf union all selct * from adjusts";
$debt2 = $conn->query($debt1);

$debt3 = "create or replace view rentarrears as select plotcode,tenantcode,tenant,housecode,sum(amtdue-paid) as arrears,
00000000.00 as amtdue,00000000.00 as paid,00000000.00 as deposit from debtors  group by tenantcode";
$debtors4 = $conn->query($debt3);

$amtdue1 = "create or replace view rentdue as select plotcode,tenantcode,tenant,housecode,00000000.00 as arrears,
amtdue,00000000.00 as paid,00000000.00 as deposit from bills where plotcode = '$plotcode' and pcode='$pcode' and nmonth=$nmonth and nyear=$nyear";
$amtdue2 = $conn->query($amtdue1);

$paid1 = "create or replace view rentpaid as select plotcode,tenantcode,tenant,housecode,00000000.00 as arrears,
00000000.00 as amtdue,paid,00000000.00 as deposit from receipts where plotcode = '$plotcode'
 and pcode='$pcode' and trans_date between '$date1' and '$date2' and remitted='0'";
$paid2 = $conn->query($paid1);


$dep1 = "create or replace view depopaid as select plotcode,tenantcode,tenant,housecode,00000000.00 as arrears,
00000000.00 as amtdue,00000000.00 paid,paid as deposit from receipts where plotcode = '$plotcode' 
and pcode IN ('DEP','EDP','WDP') and trans_date between '$date1' and '$date2' and remitted='0'";
$dep22 = $conn->query($dep1);

$rem1 = "create or replace view rentremit as select * from rentarrears union all select * from rentdue union all
 select * from rentpaid union all select * from depopaid";
$rem2 = $conn->query($rem1);

$sql1 = "select plotcode,housecode,tenant, tenantcode,sum(arrears) as arrears,sum(amtdue) as amtdue,sum(paid) as paid,sum(deposit) as deposit,
sum(arrears+amtdue) as totdue,sum(arrears+amtdue-paid) as bcf from rentremit group by tenantcode";
$sql2 = $conn->query($sql1);

$sql3 = "select plotcode,sum(arrears) as arrears,sum(amtdue) as amtdue,sum(paid) as paid,sum(deposit) as deposit,
sum(arrears+amtdue) as totdue,sum(arrears+amtdue-paid) as bcf from rentremit group by plotcode";
$sql4 = $conn->query($sql3);


echo "<p style='font-weight: bold'>STATEMENT FOR $description</p>";
echo "<table><tr class='tr1'><th>Unit No.</th><th>Tenant Name</th><th class='right'>Arrears</th><th class='right'>Month Bill</th>
<th class='right'>Total Due</th><th class='right'>Total Paid</th><th class='right'>Balance CF</th></tr>";

while($rowz = $sql2->fetch_assoc())
{
	$housecode = $rowz['housecode'];
	$tenant = $rowz['tenant'];
	$arrears = number_format($rowz['arrears'],2);
	$amtdue = number_format($rowz['amtdue'],2);
	$totdue = number_format($rowz['totdue'],2);
	$paid = number_format($rowz['paid'],2);
	$bcf = number_format($rowz['bcf'],2);
echo "<tr class='tr1'><td>$housecode</td><td>$tenant</td><td class='right'>$arrears</td><td class='right'>$amtdue</td>
<td class='right'>$totdue</td><td class='right'>$paid</td><td class='right'>$bcf</td></tr>";
}
$row = $sql4->fetch_assoc();
	$zarrears = number_format($row['arrears'],2);
	$zamtdue = number_format($row['amtdue'],2);
	$ztotdue = number_format($row['totdue'],2);
	$zpaid1 = $row['paid'];
	$zpaid = number_format($row['paid'],2);
	$zbcf = number_format($row['bcf'],2);
	$mgtfee1=$zpaid1*$mgtcom/100;
	$mgtfee = number_format($mgtfee1,2);
	$mgtvat1 = $mgtfee1*$vatrate/100;
	$mgtvat = number_format($mgtvat1,2);
	$ztotdeduct1 = $mgtfee1+$mgtvat1;
	$ztotdeduct = number_format($ztotdeduct1,2);
	$znetpay1 = $zpaid1-$ztotdeduct1;
	$znetpay = number_format($znetpay1,2);
echo "<tr class='tr1'><th colspan=2>Totals...</th><th class='right'>$zarrears</th><th class='right'>$zamtdue</th>
<th class='right'>$ztotdue</th><th class='right'>$zpaid</th><th class='right'>$zbcf</th></tr>";
echo "</table>";
echo "<br>";
echo "<p style='font-weight: bold;text-decoration:underline'> Summary</p>";
echo "<div class='row'>";
echo "<div class='rightside'>";
echo "<table>";
echo "<tr><th>Total Paid</th><td class='right'>$zpaid</td></tr>";
echo "<tr><th>Management Fee</th><td class='right'>$mgtfee</td></tr>";
echo "<tr><th>MNGT Fee VAT</th><td class='right'>$mgtvat</td></tr>";
echo "<tr><th>Total Deductions</th><td class='right'>$ztotdeduct</td></tr>";
echo "<tr><th>Net Payable</th><td class='right'>$znetpay</td></tr>";
echo "</table>";
echo "</div>";
echo "<div class='midside'>";
echo "</div>";
echo "<div class='rightside'>";
echo "<table>";
echo "<tr><th>Prepared By:</th><td>$clerk</td></tr>";
echo "<tr><th> Approved by</th><td>_____________________</td></tr>";
echo "<tr><th>Cheque/Ref No</th><td>$chqno</td></tr>";
echo "<tr><th>Statement Type</th><td>$statype</td></tr>";
echo "<tr><th>Date Paid</th><td>$date2</td></tr>";
echo "</table>";
echo "</div>";
echo "</div>";
if ($remit=='1')
{
	$remit1 = "insert into remittance(rdate,plotcode,plotname,lordcode,pcode,nmonth,nyear,gross,amount,chequeno,mgtfee,vat,clerk,statype) 
	values('$date2','$plotcode','$plotname','$lordcode','$pcode','$nmonth','$nyear','$zpaid1','$znetpay1','$chqno',
	'$mgtfee1','$mgtvat1','$clerk','$statype')";
	$remit2 = $conn->query($remit1);
	
	$rem1 = "update receipts set remitted='1', dremit='$date2' where plotcode='$plotcode' and canx!='1' and pcode='$pcode' 
	and trans_date between '$date1' and '$date2' and remitted!='1'";
	$rem2 = $conn->query($rem1);
	
	$adj1 ="update adjustments set remitted='1', dremit='$date2'  where plotcode='$plotcode' and trans_date between '$date1' and '$date2'
	AND pcode = '$pcode' ";
	$adj2 = $conn->query($adj1);
}
?>