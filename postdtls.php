<?php
require "configure.php";
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
		$emp = $_POST['empname'];
		$empstr = implode(" ",$emp);
		$emparr = explode(",",$empstr);
		$tele = $_POST['phone'];
		$telestr = implode(" ",$tele);
		$phonearr = explode(",",$telestr);
		$dep = $_POST['depart'];
		$depstr = implode(" ",$dep);
		$deparr = explode(",",$depstr);
		
		//$str1 = "Jane,Peter,Isaac,Paul";
		//$str2 = explode(',', $str1);
		//$emp=array('john','jane','janet');
		//if (is_array( $_POST['empname1'])
		//$array1 = json_decode($_POST['empname']);
	//$sql ="insert into persons(empname) values ('$empname')";
		//	$conn->query($sql);
	
	
		foreach ($emparr as $key => $value)
	    //foreach ($_POST['empname'] as $key => $value)
		{
            //$empname = $_POST["empname"][$key];
			$empname = $emparr[$key];
			$phone = $phonearr[$key];
			$depart = $deparr[$key];
            $sql ="insert into persons(empname,idx,phone,department) values ('$empname','$key','$phone','$depart')";
			$conn->query($sql);
		}
				
		?>