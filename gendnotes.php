<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$plotcode = $_POST['plotcode'];
	$check = $_POST['check'];
	$tenantcode= $_POST['tenantcode'];
	
	$bbf1 ="create or replace view dnbbf as select housecode,tenantcode,tenant,pcode,amount as arrears from balancebf
	where plotcode='$plotcode'";
	$bbf2 = $conn->query($bbf1);
	
	$adj1 ="create or replace view dnadjust as select housecode,tenantcode,tenant,pcode,amount as arrears from balancebf
	where plotcode='$plotcode'";
	$adj2 = $conn->query($adj1);
	
	$bill1 ="create or replace view dnbill as select housecode,tenantcode,tenant,pcode,amtdue as arrears from bills
	where plotcode='$plotcode'";
	$bill2 = $conn->query($bill1);
	
	$pay1 ="create or replace view dnpaid as select housecode,tenantcode,tenant,pcode,paid*-1 as arrears from receipts
	where plotcode='$plotcode' and canx!='1'";
	$pay2 = $conn->query($pay1);
	
	$dn1 = "create or replace view dnote1 as select * from dnbbf union all select * from dnadjust union all select * from dnbill
	union all select * from dnpaid";
	$dn2 = $conn->query($dn1);
	
	$dn3 = "create or replace view dnotes as select housecode,tenantcode,tenant,pcode,sum(arrears) as arrears
	from dnote1 group by tenantcode,pcode having sum(arrears)>0";
	$dn4 = $conn->query($dn3);
	
	$dn5 = "create or replace view dbnote as select housecode,tenantcode,tenant,dnotes.pcode,receivables.description,arrears
	from dnotes inner join receivables on dnotes.pcode=receivables.pcode";
	$dn6 = $conn->query($dn5);
	
	
	if ($check=='1')
	{
	$sql1 = "create or replace view dnsumm as select housecode,tenant,tenantcode,sum(arrears) as arrears 
	from dbnote where tenantcode=$tenantcode group by tenantcode";
	$sql2 = $conn->query($sql1);
	} else {
	$sql1 = "create or replace view dnsumm as select housecode,tenant,tenantcode,sum(arrears) as arrears
	from dbnote group by tenantcode";
	$sql2 = $conn->query($sql1);
	}
	
	$sql3 ="select * from dnsumm";
	$sql4 = $conn->query($sql3);
	
	while ($rowz = $sql4->fetch_assoc())
	{
		$housecode=$rowz['housecode'];
		$tenant = $rowz['tenant'];
		$tenantcode=$rowz['tenantcode'];
		$zarrears1 = $rowz['arrears'];
		$zarrears = number_format($zarrears1,2);
		
	echo "<table><tr style='border-bottom: 1px solid black'><th class='th'>Unit Number: $housecode</th><th class='th'> Tenant Name: $tenant</th></tr></table>";
	echo "<table>";
	echo "<tr style='border-bottom: 1px solid black'><th class='hz'>Item code</th><th>Item Description</th><th class='right'>Balance Due</th></tr>";
	$view3 = "select pcode,description,arrears from dbnote where tenantcode='$tenantcode'";
	$view4 = $conn->query($view3);
	while ($row=$view4->fetch_assoc())
	{
		$pcode=$row['pcode'];
		$description = $row['description'];
		$arrears1=$row['arrears'];
		$arrears= number_format($arrears1,2);
		echo "<tr><td class='hz'>$pcode</td><td>$description</td><td class='right'>$arrears</td></tr>";
	}
		echo "<tr class='tr1' style='font-weight: bold'><th></th><td>Totals</td><td class='right'>$zarrears</td></tr>";
		echo "</table>";
		echo "<br><br>";
	}
?>