<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$mdate=date("Y/m/d");
	$plotcode = $_POST['plotcode'];
	$nmonth = $_POST['nmonth'];
	$nyear = $_POST['nyear'];
	$check = $_POST['check'];
	$tenantcode= $_POST['tenantcode'];
	$pcode = '01';
	$day = '01';
	$str1 =$nyear.'/'.$nmonth.'/'.$day;
	$date1 = date_create($str1);
	$datedue = date_format($date1,'Y/m/d');
	
	$view1 ="create or replace view invoices as select housecode,tenantcode,tenant,pcode,amtdue,arrears,datedue from bills
	where plotcode='$plotcode' and nmonth='$nmonth' and nyear='$nyear'";
	$view2 = $conn->query($view1);
	
	if ($check=='1')
	{
	$sql1 = "create or replace view invsumm as select housecode,tenant,tenantcode,sum(arrears) as arrears,sum(amtdue) as amtdue,sum(amtdue+arrears) as totdue 
	from invoices where tenantcode=$tenantcode group by tenantcode";
	$sql2 = $conn->query($sql1);
	} else {
	$sql1 = "create or replace view invsumm as select housecode,tenant,tenantcode,sum(arrears) as arrears,sum(amtdue) as amtdue,sum(amtdue+arrears) as totdue 
	from invoices group by tenantcode";
	$sql2 = $conn->query($sql1);
	}
	
	$sql3 ="select * from invsumm";
	$sql4 = $conn->query($sql3);
	
	while ($rowz = $sql4->fetch_assoc())
	{
		$housecode=$rowz['housecode'];
		$tenant = $rowz['tenant'];
		$tenantcode=$rowz['tenantcode'];
		$zamtdue1 = $rowz['amtdue'];
		$zamtdue = number_format($zamtdue1,2);
		$zarrears1 = $rowz['arrears'];
		$zarrears = number_format($zarrears1,2);
		$ztotdue1 = $zamtdue1+$zarrears1;
		$ztotdue = number_format($ztotdue1,2);
		
	echo "<table><tr style='border-bottom: 1px solid black'><th>Unit Number: $housecode</th><th> Tenant Name: $tenant</th></tr></table>";
	echo "<table>";
	echo "<tr style='border-bottom: 1px solid black'><th>Pay code</th><th class='right'>Arrears</th><th class='right'>Month Bill</th><th class='right'>Total Due</th></tr>";
	$view3 = "select pcode,arrears,amtdue, arrears+amtdue as totdue,datedue from invoices where tenantcode='$tenantcode'";
	$view4 = $conn->query($view3);
	while ($row=$view4->fetch_assoc())
	{
		$pcode=$row['pcode'];
		$arrears1=$row['arrears'];
		$arrears= number_format($arrears1,2);
		$amtdue1= $row['amtdue'];
		$amtdue = number_format($amtdue1,2);
		$totdue1 = $amtdue1+$arrears1;
		$totdue = number_format($totdue1,2);	
		echo "<tr><td>$pcode</td><td class='right'>$arrears</td><td class='right'>$amtdue</td><td class='right'>$totdue</td></tr>";
	}
		echo "<tr class='tr1' style='font-weight: bold'><td>Totals</td><td class='right'>$zarrears</td><td class='right'>$zamtdue</td><td class='right'>$ztotdue</td></tr>";
		echo "</table>";
		echo "<br><br>";
	}
?>