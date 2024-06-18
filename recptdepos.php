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
	$date1 = $_POST['date1'];
	$date2 = $_POST['date2'];
	$opt = $_POST['opt'];
	
	if ($opt=='1')
	{
	$sql1 = "create or replace view recpts as select * from receipts where plotcode='$plotcode' 
	and depdate between '$date1' and '$date2'";
	$sql2 = $conn->query($sql1);
	} else {
	$sql1 = "create or replace view recpts as select * from receipts where depdate between '$date1' and '$date2'";
	$sql2 = $conn->query($sql1);
	}
	
	$qry1 = "create or replace view recptitem as select recpts.plotcode,plots.plotname,housecode,tenant,
	trans_date,depdate,accno,refno,pcode,recptno,paid,'1' as xstat
	from recpts left join plots on recpts.plotcode=plots.plotcode order by depdate";
	$qry2 = $conn->query($qry1);
	
	$sql3 = "select depdate,housecode,tenant,plotname,sum(paid) as paid,recptno,accno,refno from recptitem group by recptno";
	$sql4 = $conn->query($sql3);
	
	$qry3 = "select sum(paid) as paid from recptitem group by xstat";
	$qry4 = $conn->query($qry3);
	
	echo "<table class='table'>";
	echo "<tr><th class='th'>Date Deposited</th><th class='th'>Unit No</th><th class='th'>Property</th><th class='th'>Tenant Name</th>
	 <th class='th'>Recept No</th><th class='th'>Ref No</th><th class='th'>A/C No</th> <th class='td'>Amount Paid</th></tr>";
	 
	 while ($row=$sql4->fetch_assoc())
	 {
		 $depdate= $row['depdate'];
		 $housecode = $row['housecode'];
		 $tenant = $row['tenant'];
		 $plotname= $row['plotname'];
		 $accno = $row['accno'];
		 $paid = number_format($row['paid'],2);
		 $recptno = $row['recptno'];
		 $refno = $row['refno'];
	echo "<tr><td class='th'>$depdate</td><td class='th'>$housecode</td><td class='th'>$plotname</td><td class='th'>$tenant</td>
	<td class='th'>$recptno</td><td class='th'>$refno</td><td class='th'>$accno</td> <td class='td'>$paid</td></tr>";
	 }
	 $row2 = $qry4->fetch_assoc();
	 $zpaid = number_format($row2['paid'],2);
	 echo "<tr><td class='th' colspan=7>Total Paid</td><td class='td'>$zpaid</td></tr>";
	  echo "</table>";
?>