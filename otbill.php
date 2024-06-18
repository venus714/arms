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
	$plotcode = $_POST['propcode'];
	$pcode = $_POST['pcode'];
		
	//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$query1 = "select housecode,amount from billothers where plotcode='$plotcode' and pcode='$pcode'";
	$query2 = $conn->query($query1);
	if ($query2->num_rows>0)
	{
	 echo "<table class='table'>";
	 echo "<tr><th class='th'>Unit Num</th>";
	 echo "<th class='th' style='text-align: right'>Amount</th>";
	 echo "<th class='th'>Edit/Cancel</th>";
	 echo "<tr>";
	 while ($db = $query2->fetch_assoc())
	 {
		 $housecode = $db['housecode'];
		 $amount = $db['amount'];
		
	echo "<tr>";
	echo "<td class='td'><input type='text' name='hsecode[]' class='hsecode' value='$housecode' readonly></td>";
	echo "<td class='td'><input type='text' name='amount[]' class='amount' value=$amount style='text-align:right' readonly></td>";
	echo "<td class='td'><input type='checkbox' name='chek1[]' class='chek1' value='0'></td>";
	echo "</tr>";
	 }
	 echo "</table>";
} else { 
	$sql1 = "insert into billothers (plotcode,housecode,pcode,amount,lread,cread,rate) 
	select plotcode,housecode,'$pcode' as pcode,0000000.00 as amount,000000 as lread,000000 as cread,0000 as rate
	from houseunits where plotcode='$plotcode'";
	$sql2 = $conn->query($sql1);
	$sql3 = "select housecode,amount from billothers where plotcode=$plotcode and pcode='$pcode'";
	$sql4 = $conn->query($sql3);
	if ($sql4->num_rows>0)
	{
	 echo "<table class='table'>";
	 echo "<tr><th class='th'>Unit Num</th><th class='th' style='text-align: center'>Amount</th>";
	 echo "<tr>";
	 while ($db1 = $sql4->fetch_assoc())
	 {
		 $housecode = $db1['housecode'];
		 $amount = $db1['amount'];
		
	echo "<tr>";
	echo "<td class='td'><input type='text' name='hsecode[]' class='hsecode' value='$housecode' readonly></td>";
	echo "<td class='td'><input type='text' name='amount[]' class='amount' value=$amount style='text-align: center' readonly></td>";
	echo "<td class='td'><input type='checkbox' name='chek1[]' class='chek1' value='0'></td>";
	echo "</tr>";
	 }
	 echo "</table>";
} else {echo "No Data Available";}
	
}
?>