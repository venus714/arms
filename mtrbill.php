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
	$rate = $_POST['rate'];
	//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$query1 = "select housecode,lread,cread,rate,amount from billothers where plotcode='$plotcode' and pcode='$pcode'";
	$query2 = $conn->query($query1);
	if ($query2->num_rows>0)
	{
	 echo "<table class='table'>";
	 echo "<tr><th class='th'>Unit Num</th>";
	 echo "<th class='th'>Last Reading</th>";
	 echo "<th class='th'>Current Reading</th>";
	 echo "<th class='th'>Rate</th>";
	 echo "<th class='th' style='text-align: right'>Amount</th>";
	 echo "<th class='th'>Edit/Cancel</th>";
	 echo "<tr>";
	 while ($db = $query2->fetch_assoc())
	 {
		 $housecode = $db['housecode'];
		 $lread = $db['lread'];
		 $cread = $db['cread'];
		 $rate = $db['rate'];
		 $amount = $db['amount'];
		
	echo "<tr>";
	echo "<td class='td'><input type='text' name='hsecode[]' class='hsecode' value='$housecode' readonly></td>";
	echo "<td class='td'><input type='text' name='lread[]' class='lread' value='$lread' style='text-align:right' readonly></td>";
	echo "<td class='td'><input type='text' name='cread[]' class='cread' value='$cread' style='text-align:right'  onblur ='getamt()' readonly></td>";
	echo "<td class='td'><input type='text' name='rate[]' class='rate' value='$rate' style='text-align:right' readonly onblur ='getamt()'></td>";
	echo "<td class='td'><input type='text' name='amount[]' class='amount' value=$amount style='text-align:right' readonly></td>";
	echo "<td class='td'><input type='checkbox' name='chek1[]' class='chek1' value='0'></td>";
	echo "</tr>";
	 }
	 echo "</table>";
} else { 
	$sql1 = "insert into billothers (plotcode,housecode,pcode,rate,amount,lread,cread) 
	select plotcode,housecode,'$pcode' as pcode,'$rate' as rate,0000000.00 as amount,
	000000 as lread,000000 as cread from houseunits where plotcode='$plotcode'";
	$sql2 = $conn->query($sql1);
	$sql3 = "select housecode,lread,cread,rate,amount from billothers where plotcode=$plotcode and pcode='$pcode'";
	$sql4 = $conn->query($sql3);
	if ($sql4->num_rows>0)
	{
	 echo "<table class='table'>";
	 echo "<tr><th class='th'>Unit Num</th>";
	 echo "<th class='th'>Last Reading</th>";
	 echo "<th class='th'>Current Reading</th>";
	 echo "<th class='th'>Rate</th>";
	 echo "<th class='th' style='text-align: right'>Amount</th>";
	 echo "<th class='th'>Edit/Cancel</th>";
	 echo "<tr>";
	 while ($db1 = $sql4->fetch_assoc())
	 {
		 $housecode = $db1['housecode'];
		 $lread = $db1['lread'];
		 $cread = $db1['cread'];
		 $rate = $db1['rate'];
		 $amount = $db1['amount'];
		
	echo "<tr>";
	echo "<td class='td'><input type='text' name='hsecode[]' class='hsecode' value='$housecode' readonly></td>";
	echo "<td class='td'><input type='text' name='lread[]' class='lread' value='$lread' style='text-align:right' readonly></td>";
	echo "<td class='td'><input type='text' name='cread[]' class='cread' value='$cread' style='text-align:right' onblur ='getamt()' readonly></td>";
	echo "<td class='td'><input type='text' name='rate[]' class='rate' value='$rate' style='text-align:right' readonly></td>";
	echo "<td class='td'><input type='text' name='amount[]' class='amount' value=$amount style='text-align:right' readonly></td>";
	echo "<td class='td'><input type='checkbox' name='chek1[]' class='chek1' value='0'></td>";
	echo "</tr>";
	 }
	 echo "</table>";
} else {echo "No Data Available";}
	
}
?>