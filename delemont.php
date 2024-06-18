<?php
	$mdate=date("Y/m/d");
	$plotcode = $_POST['plotcode'];
	$nmonth = $_POST['nmonth'];
	$nyear = $_POST['nyear'];
	$pcode = $_POST['pcode'];
	$day = '01';
	$str1 =$nyear.'/'.$nmonth.'/'.$day;
	$date1 = date_create($str1);
	$datedue = date_format($date1,'Y/m/d');
	
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$sql1 ="select * from bills where plotcode='$plotcode' and nmonth='$nmonth' and nyear='$nyear' and pcode='$pcode'";
	$rez = $conn->query($sql1);
	if ($rez->num_rows<1)
	{ 
	echo "<span style='color:red; font-weight:bold;padding-left: 10px;'>Period Bill Does Not Exist</span>";
	}
	else {
	$del1 = " delete from bills where plotcode=$plotcode and nmonth=$nmonth and nyear=$nyear and pcode='$pcode'";
	$del2 = $conn->query($del1);
	
	echo "<span style='color:green; font-weight:bold;padding-left: 10px'>Bill Deleted Successfully</span>";
	}
?>