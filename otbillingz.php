<?php
include 'configure.php';
	$mdate=date("Y/m/d");
	$plotcode = $_POST['plotcode'];
	$nmonth = $_POST['nmonth'];
	$nyear = $_POST['nyear'];
	$pcode = $_POST['pcode'];
	$day = '01';
	$str1 =$nyear.'/'.$nmonth.'/'.$day;
	$date1 = date_create($str1);
	$datedue = date_format($date1,'Y/m/d');
	
//Establishing Connection with Server..
	//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$sql ="select * from bills where plotcode='$plotcode' and nmonth='$nmonth' and nyear='$nyear' and pcode='$pcode'";
	$rez = $conn->query($sql);
	if ($rez->num_rows>0)
	{ 
	echo "<span style='color:red; font-weight:bold;padding-left: 10px;'>Period Already Billed</span>";
	}
	else {
	$sql1 = "select plotcode,housecode,lread,cread,rate,amount,pcode from billothers where plotcode='$plotcode' and pcode='$pcode'";
	$sql2 = $conn->query($sql1);
	
	while ($row=$sql2->fetch_assoc())
	{
		$plotcode=$row['plotcode'];
		$housecode= $row['housecode'];
		$amtdue = $row['amount'];
		$lread = $row['lread'];
		$cread = $row['cread'];
		$rate = $row['rate'];
	$sql3 = "insert into bills(plotcode,housecode,pcode,amtdue,nyear,nmonth,trans_date,datedue,rate,lread,cread) 
	values('$plotcode','$housecode','$pcode','$amtdue','$nyear','$nmonth','$mdate','$datedue','$rate','$lread','$cread')";
	$sql4 = $conn->query($sql3);
	}
echo "<span style='color:green; font-weight:bold;padding-left: 10px'>Billing Done Successfully</span>";
	}
?>