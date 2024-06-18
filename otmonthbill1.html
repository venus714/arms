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
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$plotcode = $_POST['plotcode'];
	$nmonth = $_POST['nmonth'];
	$nyear = $_POST['nyear'];
	$pcode = $_POST['pcode'];
	$tenantcode = $_POST['tenantcode'];

if($conn->connect_error){
  die("Error in DB connection: ".$conn->connect_errno." : ".$conn->connect_error);    
}
else
{
	$query1 = "select * from bills where tenantcode='$tenantcode' and nmonth='$nmonth' and nyear = '$nyear' and pcode='$pcode'";
	$query2 = $conn->query($query1);
	if ($query2->num_rows>0)
	{
	 echo "<table class='table'>";
	 echo "<tr><th class='th'>Unit Num</th><th class='th'>Tenant Name</th><th class='th'>Arrears</th>
	 <th class='th'>Month Bill</th><th class='th'>Total Due</th></tr>";
	 echo "<tr>";
	 while ($db = $query2->fetch_assoc())
	 {
		 $housecode = $db['housecode'];
		 $tenant = $db['tenant'];
		 $arrears = $db['arrears'];
		 $amtdue = $db['amtdue'];
		 $totdue = $arrears+$amtdue;
	echo "<td class='td'>$housecode</td><td class='td'>$tenant</td><td class='td'>$arrears</td>
	<td class='td'>$amtdue</td><td class='td'>$totdue</td></tr>";
	 }
	 echo "</table>";
} else { echo "No Data found";}
	}
?>