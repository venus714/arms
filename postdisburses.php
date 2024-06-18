<?php
require "configure.php";
		//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
		$plotcode = $_POST['plotcode'];
		$nyear = $_POST['nyear'];
		$nmonth = $_POST['nmonth'];
		$narr1 = $_POST['descript'];
		$narr2 = implode(" ",$narr1);
		$narr = explode(",",$narr2);
		$amount1 = $_POST['amount'];
		$amount2 = implode(" ",$amount1);
		$amount = explode(",",$amount2);
		$zdate1 = $_POST['date2'];
		$zdate2 = implode(" ",$zdate1);
		$zdate = explode(",",$zdate2);
		$pv = '0';
		$remitted = '0';
		
		
	
		foreach ($narr as $key => $value)
	    //foreach ($_POST['empname'] as $key => $value)
		{
            //$empname = $_POST["empname"][$key];
			$narration = $narr[$key];
			$disburse = $amount[$key];
			$datepaid = $zdate[$key];
			//$datepaid = date_create($str1);
			//$datepaid = date_format($date1,'Y/m/d');
            $sql ="insert into disbursement(plotcode,nyear,nmonth,description,amount,trans_date,canx,pv,remitted) 
			values ('$plotcode','$nyear','$nmonth','$narration','$disburse','$datepaid','0','$pv','$remitted')";
			$sql2=$conn->query($sql);
		}
		?>