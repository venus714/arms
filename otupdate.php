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
	$housecode=$_POST['housecode'];
	$amount = $_POST['amount'];
		
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$query1 = "update billothers set amount=$amount where plotcode='$plotcode' and housecode='$housecode' and pcode='$pcode'";
	$query2 = $conn->query($query1);
	 
	
	$sql3 = "select housecode,amount from billothers where plotcode=$plotcode and pcode='$pcode'";
	$sql4 = $conn->query($sql3);
	 echo "<table class='table'>";
	 echo "<tr><th class='th'>Unit Num</th><th class='th'>Amount</th>";
	 echo "<tr>";
	 while ($db1 = $sql4->fetch_assoc())
	 {
		 $housecode = $db1['housecode'];
		 $amount = $db1['amount'];
		
	echo "<tr><td class='td'>$housecode</td><td class='td'>$amount</td></tr>";
	 }
	 echo "</table>";

?>