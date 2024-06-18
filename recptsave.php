<?php
require "configure.php";
		//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
		$plotcode = $_POST['plotcode'];
		$nmonth = $_POST['nmonth'];
		$nyear = $_POST['nyear'];
		$housecode = $_POST['hsecode1'];
		$tenantcode = $_POST['tenantcode1'];
		$tenant = $_POST['tenant1'];
		$modecode = $_POST['zmode'];
		$refno = $_POST['refno'];
		$depdate = $_POST['dbanked'];
		$mdate = $_POST['mdate'];
		$acno = $_POST['acno'];
		$recdesc = $_POST['recdesc'];
		$paycode1 = $_POST['pcode1'];
		$paycode2 = implode(" ",$paycode1);
		$pcode = explode(",",$paycode2);
		$narr1 = $_POST['descript1'];
		$narr2 = implode(" ",$narr1);
		$descript = explode(",",$narr2);
		$amount1 = $_POST['amtdue1'];
		$amount2 = implode(" ",$amount1);
		$amtdue = explode(",",$amount2);
		$zpaid1 = $_POST['paid1'];
		$zpaid2 = implode(" ",$zpaid1);
		$zpaid = explode(",",$zpaid2);
		
		$rec1 = "insert into recmaster(plotcode) value('$plotcode')";
		$rec2 = $conn->query($rec1);
		$recptno = $conn->insert_id;
		
		foreach ($pcode as $key => $value)
	    
		{
          	$paycode = $pcode[$key];
			$narr = $descript[$key];
			$exprent = $amtdue[$key];
			$paid = $zpaid[$key];
			
            $sql ="insert into receipts(plotcode,housecode,tenant,tenantcode,trans_date,depdate,pcode,descript,recdesc,recptno,exprent,paid,
			modecode,refno,accno,nmonth,nyear,canx,opendepo,remitted) 
			value('$plotcode','$housecode','$tenant','$tenantcode','$mdate','$depdate','$paycode','$narr','$recdesc','$recptno','$exprent',
			'$paid','$modecode','$refno','$acno','$nmonth','$nyear','0','0','0')";
			$sql2=$conn->query($sql);
			
		}
		echo "Receipt Number <input type='text' name='recno' id='recno' value='$recptno' 
		readonly style='width: 100px;height: 25px'>";
		?>