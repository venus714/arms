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
	$pcode = $_POST['pcode'];
	$opt = $_POST['opt'];
	
	if ($opt=='1')
	{
	$sql1 = "create or replace view recpts as select * from receipts where plotcode='$plotcode' 
	and trans_date between '$date1' and '$date2' and pcode='$pcode'";
	$sql2 = $conn->query($sql1);
	} else {
	$sql1 = "create or replace view recpts as select * from receipts where trans_date between '$date1' and '$date2' and pcode='$pcode'";
	$sql2 = $conn->query($sql1);
	}
	
	$qry1 = "create or replace view recptitem as select recpts.plotcode,plots.plotname,housecode,tenant,trans_date,depdate,recptno,paid,'1' as xstat
	from recpts left join plots on recpts.plotcode=plots.plotcode order by trans_date";
	$qry2 = $conn->query($qry1);
	
	$sql3 = "select trans_date,housecode,tenant,plotname,paid,recptno from recptitem";
	$sql4 = $conn->query($sql3);
	
	$qry3 = "select sum(paid) as paid from recptitem group by xstat";
	$qry4 = $conn->query($qry3);
	
	echo "<table class='table'>";
	echo "<tr><th class='th'>Date Recpted</th><th class='th'>Unit No</th><th class='td'>Property</th><th class='td'>Tenant Name</th>
	 <th class='th'>Refno</th><th class='td'>Amount Paid</th></tr>";
	 
	 while ($row=$sql4->fetch_assoc())
	 {
		 $trans_date= $row['trans_date'];
		 $housecode = $row['housecode'];
		 $tenant = $row['tenant'];
		 $plotname= $row['plotname'];
		 $paid = number_format($row['paid'],2);
		 $recptno = $row['recptno'];
	echo "<tr><td class='th'>$trans_date</td><td class='th'>$housecode</td><td class='th'>$plotname</td>
	<td class='th'>$tenant</td><td class='th'>$recptno</td><td class='td'>$paid</td></tr>";
	 }
	 $row2 = $qry4->fetch_assoc();
	 $zpaid = number_format($row2['paid'],2);
	 echo "<tr><td class='th' colspan=5>Total Paid</td><td class='td'>$zpaid</td></tr>";
	  echo "</table>";
?>