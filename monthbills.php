<html>
<head>
<style>

.td {
	border: 1px solid black;
	text-align: right;
	padding-right: 15px;
}

.th {
	border: 1px solid black;
	text-align: left;
	padding-left: 15px;
}
.subhead {
	font-weight: bold;
	padding-left: 15px;
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
	$opt = $_POST['opt'];
	
	if ($opt=='1')
	{
	$sql1 = "create or replace view monthbill as select * from bills where plotcode='$plotcode' and nmonth='$nmonth' and nyear = '$nyear' and pcode='$pcode'";
	$sql2 = $conn->query($sql1);
	} else {
	$sql1 = "create or replace view monthbill as select * from bills where nmonth='$nmonth' and nyear = '$nyear' and pcode='$pcode'";
	$sql2 = $conn->query($sql1);
	}
	$sql3 = "create or replace view billsumm as select monthbill.plotcode,plots.plotname,sum(arrears) as arrears, sum(amtdue) as amtdue,
	sum(arrears+amtdue) as totdue from monthbill inner join plots on monthbill.plotcode=plots.plotcode group by monthbill.plotcode";
	$sql4 = $conn->query($sql3);
	
	$qry1 = "select * from billsumm";
	$qry2 = $conn->query($qry1);
		
	$summ1 ="select sum(arrears) as arrears,sum(amtdue) as amtdue,sum(arrears+amtdue) as totdue from monthbill
	group by nmonth,nyear";
	$summ2 = $conn->query($summ1);

	echo "<table class='table'>";
	 while ($row = $qry2->fetch_assoc())
	 {
		 $plotcode = $row['plotcode'];
		 $plotname= $row['plotname'];
		 $zarrears = number_format($row['arrears'],2);
		 $zamtdue = number_format($row['amtdue'],2);
		 $ztotdue = number_format($row['totdue'],2);
	 
	 echo "<tr><td colspan=5 class='subhead'>$plotname</td></tr>";
	 echo "<tr><th class='th'>Unit Num</th><th class='th'>Tenant Name</th><th class='td'>Arrears</th>
	 <th class='td'>Month Bill</th><th class='td'>Total Due</th></tr>";
	 
	 
	$query1 ="select * from monthbill where plotcode='$plotcode'";
	$query2 = $conn->query($query1);
	 while ($db = $query2->fetch_assoc())
	 {
		 $housecode = $db['housecode'];
		 $tenant = $db['tenant'];
		 $arrears = number_format($db['arrears'],2);
		 $amtdue = number_format($db['amtdue'],2);
		 $totdue1 = $db['arrears']+$db['amtdue'];
		 $totdue = number_format($totdue1,2);
	echo "<tr><td class='th'>$housecode</td><td class='th'>$tenant</td><td class='td'>$arrears</td>
	<td class='td'>$amtdue</td><td class='td'>$totdue</td></tr>";
	 }
	 echo "<tr><td colspan='2' class='th'>Sub Totals</td><td class='td'>$zarrears</td>";
	  echo "<td class='td'>$zamtdue</td><td class='td'>$ztotdue</td>";
	  echo "</tr>";
		 }
	  while ($rowz =$summ2->fetch_assoc())
	  {
		  $xarrears = number_format($rowz['arrears'],2);
		  $xamtdue = number_format($rowz['amtdue'],2);
		  $xtotdue = number_format($rowz['totdue'],2);
	 echo "<tr><td colspan=2 class='th'>Grand Total</td><td class='td'>$xarrears</td><td class='td'>$xamtdue</td><td class='td'>$xtotdue</td></tr>"; 	 
	  }
	  echo "</table>";
	  
?>