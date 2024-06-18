<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$date1 = $_POST['date1'];
$pcode = $_POST['pcode'];
$check = $_POST['check'];
$plotcode = $_POST['plotcode'];

$item1 ="select description from receivables where pcode='$pcode'";
$item2 = $conn->query($item1);
$irow = $item2->fetch_assoc();
$itemname = $irow['description'];

$bbf1 = "create or replace view balbf as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from balancebf where pcode='$pcode'";
$bbf2 = $conn->query($bbf1);

$adj1 = "create or replace view adjusts as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from adjustments where pcode='$pcode' and trans_date<='$date1'";
$adj2 = $conn->query($adj1);


$debt1 = "create or replace view pastbills as select plotcode,tenantcode,tenant,housecode,amtdue,00000000.00 as paid 
from bills where pcode='$pcode' and datedue<='$date1'";
$debt2 = $conn->query($debt1);

$recpt1 = "create or replace view pastpaid as select plotcode,tenantcode,tenant,housecode,00000000.00 as amtdue,paid 
from receipts where pcode='$pcode' and trans_date<='$date1'";
$recpt2 = $conn->query($recpt1);

$debt1 = "create or replace view zdebtors as select * from pastbills union all select * from pastpaid union all
select * from adjusts union all select * from balbf";
$debt2 = $conn->query($debt1);

$debt3 = "create or replace view debtorz as select zdebtors.plotcode,tenants.housecode,tenants.tenant,zdebtors.tenantcode,tenants.phone,
tenants.email,sum(amtdue) as amtdue,sum(paid) as paid,sum(amtdue-paid) as arrears
from zdebtors left join tenants on zdebtors.tenantcode=tenants.tenantcode group by zdebtors.tenantcode having sum(amtdue-paid)>0";
$debtors4 = $conn->query($debt3);

if($check==1)
{
$debt1 = "create or replace view mydebtors as select debtorz.plotcode,plots.plotname,sum(arrears) as arrears from debtorz inner join plots
on debtorz.plotcode=plots.plotcode where debtorz.plotcode = '$plotcode' group by debtorz.plotcode order by plots.plotcode";
$debt2 = $conn->query($debt1);
} else {
$debt1 = "create or replace view mydebtors as  select debtorz.plotcode,plots.plotname,sum(arrears) as arrears from debtorz inner join plots
on debtorz.plotcode=plots.plotcode group by debtorz.plotcode order by plots.plotcode";
$debt2 = $conn->query($debt1);
}

$plot1 ="select * from mydebtors";
$plot2 = $conn->query($plot1);

echo "<p style='font-weight: bold;'>ITEM NAME :$itemname</P>";
echo "<table><tr class='tr1'><th>Unit No.</th><th>Tenant Name</th><th>Telephone</th><th class='right'>Arrears</th></tr>";
while ($db = $plot2->fetch_assoc())
{
	$plotname=$db['plotname'];
	$plotcode =$db['plotcode'];
	$zarrears = number_format($db['arrears'],2);
echo "<tr><td colspan='4'style='font-weight: bold'>$plotname</td></tr>";
$debt3 = "select plotcode,housecode,tenant,tenantcode,phone,arrears
from debtorz where plotcode='$plotcode' order by plotcode";
$debtors4 = $conn->query($debt3);

while($rowz = $debtors4->fetch_assoc())
{
	$plotcode=$rowz['plotcode'];
	$housecode = $rowz['housecode'];
	$tenant = $rowz['tenant'];
	$phone = $rowz['phone'];
	$arrears = number_format($rowz['arrears'],2);
echo "<tr><td>$housecode</td><td>$tenant</td><td>$phone</td><td class='right'>$arrears</td></tr>";
}
echo "<tr style ='border-top: 1px solid black'><td colspan='3' style='font-weight: bold'>Sub Total</td><td style='font-weight: bold' class='right'>$zarrears</td></tr>";
}
echo "</table>";
?>