<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$date1 = $_POST['date1'];
$pcode = '01';
$check = $_POST['check'];
$plotcode = $_POST['plotcode'];

$item1 ="select description from receivables where pcode='$pcode'";
$item2 = $conn->query($item1);
$irow = $item2->fetch_assoc();
$itemname = $irow['description'];

$bbf1 = "create or replace view balbf as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid,
00000000 as otherdue,00000000 as otpaid from balancebf where pcode='$pcode'";
$bbf2 = $conn->query($bbf1);

$bbf3 = "create or replace view balbfz as select plotcode,tenantcode,tenant,housecode,00000000 as amtdue,00000000.00 as paid,
amtdue as otherdue,00000000 as otpaid from bills where pcode!='$pcode'";
$bbf4 = $conn->query($bbf3);

$adj1 = "create or replace view adjusts as select plotcode,tenantcode,tenant,housecode,amount as amtdue,00000000.00 as paid,
00000000 as otherdue,00000000 as otpaid from adjustments where pcode='$pcode' and trans_date<='$date1'";
$adj2 = $conn->query($adj1);

$adj3 = "create or replace view adjustz as select plotcode,tenantcode,tenant,housecode,00000000 as amtdue,00000000.00 as paid,
amount as otherdue,00000000 as otpaid from adjustments where pcode!='$pcode' and trans_date<='$date1'";
$adj4 = $conn->query($adj3);

$debt1 = "create or replace view pastbills as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid,
 00000000 as otherdue,00000000 as otpaid from bills where pcode='$pcode' and datedue<='$date1'";
$debt2 = $conn->query($debt1);

$debt3 = "create or replace view pastbillz as select plotcode,tenantcode,tenant,housecode,00000000 as amtdue,00000000.00 as paid,
 amtdue as otherdue,00000000 as otpaid from bills where pcode!='$pcode' and datedue<='$date1'";
$debt4 = $conn->query($debt3);

$recpt1 = "create or replace view pastpaid as select plotcode,tenantcode,tenant,housecode,00000000.00 as amtdue,paid,
00000000 as otherdue,00000000 as otpaid from receipts where pcode='$pcode' and canx!='1' and trans_date<='$date1'";
$recpt2 = $conn->query($recpt1);

$recpt3 = "create or replace view pastpaidz as select plotcode,tenantcode,tenant,housecode,00000000.00 as amtdue,00000000 as paid,
00000000 as otherdue,paid as otpaid from receipts where pcode!='$pcode' and canx!='1' and trans_date<='$date1'";
$recpt4 = $conn->query($recpt3);

$debt1 = "create or replace view debtors as select * from pastbills union all select * from pastpaid union all select * from pastbillz
union all select * from pastpaidz union all select * from adjusts union all select * from adjustz
union all select * from balbf union * select * from balbfz";
$debt2 = $conn->query($debt1);

$debt3 = "create or replace view debtorz as select debtors.plotcode,tenants.housecode,tenants.tenant,debtors.tenantcode,tenants.phone,
tenants.email,sum(amtdue-paid) as arrears,sum(otherdue-otpaid) as otarrears
from debtors left join tenants on debtors.tenantcode=tenants.tenantcode group by debtors.tenantcode having sum(amtdue+otherdue-paid-otpaid)>0";
$debtors4 = $conn->query($debt3);

if($check==1)
{
$debt1 = "create or replace view mydebtors as select debtorz.plotcode,plots.plotname,sum(arrears) as arrears,
sum(otarrears) as otarrears from debtorz inner join plots
on debtorz.plotcode=plots.plotcode where debtorz.plotcode = '$plotcode' group by debtorz.plotcode order by plots.plotcode";
$debt2 = $conn->query($debt1);
} else {
$debt1 = "create or replace view mydebtors as  select debtorz.plotcode,plots.plotname,sum(arrears) as arrears,
sum(otarrears) as otarrears from debtorz inner join plots on debtorz.plotcode=plots.plotcode group by debtorz.plotcode order by plots.plotcode";
$debt2 = $conn->query($debt1);
}

$plot1 ="select * from mydebtors";
$plot2 = $conn->query($plot1);

//echo "<p style='font-weight: bold;' colspan='4'>ITEM NAME :$itemname</P>";
echo "<table><tr class='tr1'><th>Unit No.</th><th>Tenant Name</th><th>Telephone</th><th class='right'>Rent Arrears</th>
<th class='right'>Other Arrears</th></tr>";
while ($db = $plot2->fetch_assoc())
{
	$plotname=$db['plotname'];
	$plotcode =$db['plotcode'];
	$zarrears = number_format($db['arrears'],2);
	$zotarrears = number_format($db['otarrears'],2);
echo "<tr><td colspan='5'style='font-weight: bold'>$plotname</td></tr>";
$debt3 = "select plotcode,housecode,tenant,tenantcode,phone,arrears,otarrears
from debtorz where plotcode='$plotcode' order by plotcode";
$debtors4 = $conn->query($debt3);

while($rowz = $debtors4->fetch_assoc())
{
	$plotcode=$rowz['plotcode'];
	$housecode = $rowz['housecode'];
	$tenant = $rowz['tenant'];
	$phone = $rowz['phone'];
	$arrears = number_format($rowz['arrears'],2);
	$otarrears = number_format($rowz['otarrears'],2);
echo "<tr><td>$housecode</td><td>$tenant</td><td>$phone</td><td class='right'>$arrears</td><td class='right'>$otarrears</td></tr>";
}
echo "<tr style ='border-top: 1px solid black'><td colspan='3' style='font-weight: bold'>Sub Total</td>
<td style='font-weight: bold' class='right'>$zarrears</td><td style='font-weight: bold' class='right'>$zotarrears</td></tr>";
}
echo "</table>";
?>