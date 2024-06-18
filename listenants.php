<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$code=$_GET['q'];

$hse1 ="create or replace view hseunits as select housecode,'vacant' as tenant,rent,space(30) as phone from houseunits where plotcode='$code'";
$hse2=$conn->query($hse1);
$hse3 = "select * from hseunits";
$hse4 = $conn->query($hse3);

$tenant1 = "create or replace view mytenants as select housecode,tenant,00000000.00 as rent,phone from tenants where plotcode='$code'";
$tenant2 = $conn->query($tenant1);

$tenant4 ="create or replace view premtenantz as select * from mytenants union all select * from hseunits";
$tenant5 =$conn->query($tenant4);

$tenant5 = "create or replace view  premtenants as select housecode,tenant,sum(rent) as rent,phone from premtenantz group by housecode";
$tenant6 = $conn->query($tenant5);

$tenant7 = "select housecode,tenant,rent,phone from premtenants order by housecode";
$tenant8 = $conn->query($tenant7);

echo "<form method='POST' action='tenantspdf.php'>";
echo "<table>";
echo "<tr><th>Unit No.</th><th>Tenant Name</th><th>Phone Number</th><th>Month Rent</th></tr>";
while ($row=$tenant8->fetch_assoc())
{
	$housecode=$row['housecode'];
	$tenant = $row['tenant'];
	$rent = $row['rent'];
	$phone = $row['phone'];
echo "<tr><td>$housecode</td><td>$tenant</td><td>$phone</td><td>$rent</td><tr>";
}
echo "</table>";
echo "<br><br>";
echo "<div class='hz'>";
echo "<input type ='hidden' name='h1' value='$code'>";
echo "<input type='submit' name='pdf' value='TO PDF'>";
echo "</div>";
echo "<form>";
?>