<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$plotcode = $_POST['plotcode'];
$rdate = $_POST['rdate'];
$nyear = $_POST['nyear'];
$nmonth = $_POST['nmonth'];
$pcode = $_POST['pcode'];


$mgt1 ="select plotname,lordcode,mgtcom,lordvat from plots where plotcode='$plotcode'";
$mgt2 = $conn->query($mgt1);
$mgt3 = $mgt2->fetch_assoc();
$mgtcom=$mgt3['mgtcom'];
$lordvat = $mgt3['lordvat'];
$lordcode = $mgt3['lordcode'];
$plotname = $mgt3['plotname'];

$vat1="select vat from setup";
$vat2 = $conn->query($vat1);
$vat3 = $vat2->fetch_assoc();
$vat4 = $vat3['vat'];
$vatrate= $vat4/100;

$remit1 = "select rdate,mgtfee,vat,chequeno,clerk,statype from remittance where plotcode='$plotcode' and rdate='$rdate' and pcode='$pcode'";
$remit2 = $conn->query($remit1);
$remit3 = $remit2->fetch_assoc();
$chqno= $remit3['chequeno'];
$clerk = $remit3['clerk'];
$statype= $remit3['statype'];
$mgtfee1 = $remit3['mgtfee'];
$mgtvat1 = $remit3['vat'];
$mgtfee = number_format($mgtfee1,2);
$mgtvat = number_format($mgtvat1,2);

$bbf1 = "create or replace view balbf as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from balancebf where plotcode = $plotcode and pcode='$pcode'";
$bbf2 = $conn->query($bbf1);

$adj1 = "create or replace view adjusts as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from adjustments where plotcode = $plotcode and pcode='$pcode' and dremit<'$rdate'";
$adj2 = $conn->query($adj1);

$debt1 = "create or replace view pastbills as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from bills where plotcode =$plotcode and pcode='$pcode' and (nmonth<$nmonth or nyear<$nyear) and nyear<=$nyear";
$debt2 = $conn->query($debt1);

$recpt1 = "create or replace view pastpaid as select plotcode,tenantcode,tenant,housecode,00000000.00 as amtdue,paid 
from receipts where plotcode=$plotcode and pcode='$pcode' and dremit<'$rdate'";
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
00000000.00 as amtdue,paid,00000000.00 as deposit from receipts where plotcode = '$plotcode' and pcode='$pcode' 
and dremit = '$rdate' and canx !='1' and remitted='1'";
$paid2 = $conn->query($paid1);

$dep1 = "create or replace view depopaid as select plotcode,tenantcode,tenant,housecode,00000000.00 as arrears,
00000000.00 as amtdue,00000000.00 paid,paid as deposit from receipts where plotcode = '$plotcode' 
and pcode IN ('DEP','EDP','WDP') and canx !='1' and dremit = '$rdate'  and remitted='1'";
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
	$zpaid = number_format($row['paid'],2);
	$zrent = $row['paid'];
	$zbcf = number_format($row['bcf'],2);
	$ztotpaid1 = $row['paid'];
	$ztotpaid = number_format($ztotpaid1,2);
	
echo "<tr class='tr1'><th colspan=2>Totals...</th><th class='right'>$zarrears</th><th class='right'>$zamtdue</th>
<th class='right'>$ztotdue</th><th class='right'>$zpaid</th><th class='right'>$zbcf</th></tr>";
echo "</table>";
echo "<br><br>";
echo "<p style='margin-left: 30px;font-weight: bold;text-decoration: underline'> Summary</p>";
echo "<div class='row'>";
echo "<div class='rightside'>";
$mgtfee = number_format($mgtfee1,2);
$znetpay1 = $ztotpaid1-$mgtfee1-$mgtvat;
$znetpay = number_format($znetpay1,2);
echo "<table>";
echo "<tr><th colspan='2'><label style='text-decoration: underline'>Collections</label></th></tr>";
echo "<tr><th> Total Rent Collected</th>";
echo "<td class='right'> $zpaid </td></tr>";
echo "<tr><th><label style='text-decoration: underline'>Deductions</label></th></tr>";
echo "<tr><th>Management Fee</th>";
echo "<td class='right'>$mgtfee</td></tr>";
echo "<tr><th>MNGT Fee VAT</th>";
echo "<td class='right'>$mgtvat</td></tr>";
echo "<tr><th> Net Payable</th>";
echo "<td class='right'>$znetpay</td></tr>";
echo "</table>";
echo "</div>";
echo "<div class='midside'>";
echo "</div>";
echo "<div class='rightside'>";
echo "<table>";
echo "<tr><th>Prepared By: </th>";
echo "<td>$clerk</td></tr>";
echo "<tr><th>Approved By: </th>";
echo "<td><p>______________________</p></td></tr>";
echo "<tr><th>Cheque No. </th>";
echo "<td>$chqno</td></tr>";
echo "<tr><th>Statement Type </th>";
echo "<td>$statype</td></tr>";
echo "<tr><th>Date Remitted: </th>";
echo "<td>$rdate</td></tr>";
echo "</table>";
echo "</div>";
echo "</div>";
?>