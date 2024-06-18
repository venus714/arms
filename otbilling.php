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
	$sql1 = "select plotcode,housecode,lread,cread,rate,amount from billothers where plotcode='$plotcode' and pcode='$pcode'";
	$sql2 = $conn->query($sql1);
	
	$sql5 = "select plotcode,housecode,tenant,tenantcode from tenants where plotcode='$plotcode' and movedout!='1'";
	$sql6 = $conn->query($sql5);
	
	$arrear1 ="select tenant,tenantcode, sum(amtdue) as arrears from bills where plotcode='$plotcode' 
	and (nmonth<$nmonth or nyear<$nyear) and nyear<=$nyear and pcode= '$pcode' group by tenantcode";
	$arrear2 = $conn->query($arrear1);
	
	$adjust1 ="select tenant,tenantcode, sum(amount) as arrears from adjustments where plotcode='$plotcode' 
	and (nmonth<$nmonth or nyear<$nyear) and nyear<=$nyear and pcode= '$pcode' group by tenantcode";
	$adjust2 = $conn->query($adjust1);
	
	$balbf1 ="select tenant,tenantcode, sum(amount) as arrears from balancebf where plotcode='$plotcode' 
	and pcode= '$pcode' group by tenantcode";
	$balbf2 = $conn->query($balbf1);
	
	$recpt1 ="select tenantcode,sum(paid) as paid from receipts where plotcode ='$plotcode'
	and (nmonth<'$nmonth' or nyear<'$nyear') and nyear<='$nyear' and pcode='$pcode' and canx!='1' group by tenantcode";
	$recpt2 = $conn->query($recpt1);
	
	while ($row1=$sql2->fetch_assoc())
	{
		$plotcode= $row1['plotcode'];
		$housecode = $row1['housecode'];
		$amtdue = $row1['amount'];
		$lread = $row1['lread'];
		$cread = $row1['cread'];
		$rate = $row1['rate'];
	$sql3 = "insert into bills(plotcode,housecode,pcode,amtdue,nyear,nmonth,trans_date,datedue,rate,lread,cread) 
	values('$plotcode','$housecode','$pcode','$amtdue','$nyear','$nmonth','$mdate','$datedue','$rate','$lread','$cread')";
	$sql4 = $conn->query($sql3);	
	}
	while ($row2=$sql6->fetch_assoc())
	{
		$tenant = $row2['tenant'];
		$tenantcode = $row2['tenantcode'];
		$housecode = $row2['housecode'];
	$sql7="update bills SET tenant ='$tenant',tenantcode='$tenantcode' where plotcode='$plotcode' and housecode='$housecode'
	and nmonth='$nmonth' and nyear='$nyear' and pcode = '$pcode'";
	$sql8 = $conn->query($sql7);
	}
	while ($row3=$arrear2->fetch_assoc())
	{
	$tenantcode = $row3['tenantcode'];
	$arrears = $row3['arrears'];
	$arrear3="update bills SET arrears ='$arrears' where tenantcode='$tenantcode' and nmonth='$nmonth'
	and nyear='$nyear' and pcode = '$pcode'";
	$arrear4= $conn->query($arrear3);
	}
	
	while ($row31=$adjust2->fetch_assoc())
	{
	$tenantcode = $row31['tenantcode'];
	$arrears = $row31['arrears'];
	$arrear31="update bills SET arrears =arrears+'$arrears' where tenantcode='$tenantcode' and nmonth='$nmonth'
	and nyear='$nyear' and pcode = '$pcode'";
	$arrear41= $conn->query($arrear31);
	}
	
	while ($row32=$balbf2->fetch_assoc())
	{
	$tenantcode = $row32['tenantcode'];
	$arrears = $row32['arrears'];
	$arrear32="update bills SET arrears =arrears+'$arrears' where tenantcode='$tenantcode' and nmonth='$nmonth'
	and nyear='$nyear' and pcode = '$pcode'";
	$arrear42= $conn->query($arrear32);
	}
	
	while ($row4=$recpt2->fetch_assoc())
	{
	$tenantcode = $row4['tenantcode'];
	$paid = $row4['paid'];
	$recpt3="update bills SET arrears =arrears-'$paid' where tenantcode='$tenantcode' and nmonth='$nmonth'
	and nyear='$nyear' and pcode = '$pcode'";
	$recpt4= $conn->query($recpt3);
	}
	$null1 = "update bills SET tenant='VACANT',amtdue = 0, arrears=0 where ISNULL(tenantcode) and plotcode='$plotcode' and pcode='$pcode'";
	$null2 = $conn->query($null1);
	echo "<span style='color:green; font-weight:bold;padding-left: 10px'>Billing Done Successfully</span>";
	}
?>