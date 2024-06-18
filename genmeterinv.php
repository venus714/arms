<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$mdate=date("Y/m/d");
	$plotcode = $_POST['plotcode'];
	$nmonth = $_POST['nmonth'];
	$nyear = $_POST['nyear'];
	$check = $_POST['check'];
	$tenantcode= $_POST['tenantcode'];
	$pcode = $_POST['pcode'];
	$day = '01';
	$str1 =$nyear.'/'.$nmonth.'/'.$day;
	$date1 = date_create($str1);
	$datedue = date_format($date1,'Y/m/d');
	
	$view1 ="create or replace view metrebill as select housecode,tenantcode,tenant,pcode,amtdue,arrears,datedue,
	lread,cread,rate from bills where plotcode='$plotcode' and nmonth='$nmonth' and nyear='$nyear' and pcode='$pcode'";
	$view2 = $conn->query($view1);
	
	if ($check=='1')
	{
	$sql1 = "create or replace view metresumm as select housecode,tenant,tenantcode,sum(arrears) as arrears,sum(amtdue) as amtdue,sum(amtdue+arrears) as totdue 
	from metrebill where tenantcode=$tenantcode group by tenantcode";
	$sql2 = $conn->query($sql1);
	} else {
	$sql1 = "create or replace view metresumm as select housecode,tenant,tenantcode,sum(arrears) as arrears,sum(amtdue) as amtdue,sum(amtdue+arrears) as totdue 
	from metrebill group by tenantcode";
	$sql2 = $conn->query($sql1);
	}
	
	$sql3 ="select * from metresumm";
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
		
	echo "<table><tr><th class='th'>Unit Number: $housecode</th><th class='th'> Tenant Name: $tenant</th></tr></table>";
	echo "<table>";
	echo "<tr><td>Pay code</td><td class='right'>Arrears</td>
	<td class='right'>Prev Read</td><td class='right'>Current Read</td><td class='right'>Rate</td>
	<td class='right'>Month Bill</td><td class='right'>Total Due</td></tr>";
	$view3 = "select pcode,arrears,lread,cread,rate,amtdue, arrears+amtdue as totdue from metrebill where tenantcode='$tenantcode'";
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
		$lread = $row['lread'];
		$cread = $row['cread'];
		$rate = $row['rate'];
		echo "<tr><td>$pcode</td><td class='right'>$arrears</td>
		<td class='right'>$lread</td><td class='right'>$cread</td><td class='right'>$rate</td>
		<td class='right'>$amtdue</td><td class='right'>$totdue</td></tr>";
	}
		

		echo "</table>";
		echo "<br><br>";
	}
?>