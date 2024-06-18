<?php
		require "configure.php";
		//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
		$plotcode = $_POST['plotcode'];
		$pcode = $_POST['pcode'];
		$check1 = $_POST['checkz'];
		$check2 = implode(" ",$check1);
		$check3 = explode(",",$check2);
		$hsecode1 = $_POST['hzecode1'];
		$hsecode2 = implode(" ",$hsecode1);
		$hsecode3 = explode(",",$hsecode2);
		$amt1 = $_POST['amt1'];
		$amt2 = implode(" ",$amt1);
		$amt3 = explode(",",$amt2);
		$lread1 = $_POST['lread1'];
		$lread2 = implode(" ",$lread1);
		$lread3 = explode(",",$lread2);				
		$cread1 = $_POST['cread1'];
		$cread2 = implode(" ",$cread1);
		$cread3 = explode(",",$cread2);	
		$rate1 = $_POST['rate1'];
		$rate2 = implode(" ",$rate1);
		$rate3 = explode(",",$rate2);	
		
		foreach ($hsecode3 as $key => $value)
	    {
           	$hsecode = $hsecode3[$key];
			$check = $check3[$key];
			$amt = $amt3[$key];
			$lread = $lread3[$key];
			$cread = $cread3[$key];
			$rate = $rate3[$key];
						
            $sql ="update billothers set lread=$lread,cread=$cread,rate=$rate,amount=$amt where plotcode='$plotcode' and housecode= '$hsecode' and $check='1'";
			$sql2=$conn->query($sql);
		}
		
		
	$query1 = "select housecode,lread,cread,rate,amount from billothers where plotcode='$plotcode' and pcode='$pcode'";
	$query2 = $conn->query($query1);
	
	 echo "<table class='table'>";
	 echo "<tr><th class='th'>Unit Num</th>";
	 echo "<th class='th'>Last Reading</th>";
	 echo "<th class='th'>Current Reading</th>";
	 echo "<th class='th'>Rate</th>";
	 echo "<th class='th' style='text-align: right'>Amount</th>";
	 echo "<th class='th'>Edit/Cancel</th>";
	 echo "<tr>";
	 while ($db = $query2->fetch_assoc())
	 {
		 $housecode = $db['housecode'];
		 $lread = $db['lread'];
		 $cread = $db['cread'];
		 $rate = $db['rate'];
		 $amount = $db['amount'];
	echo "<tr>";
	echo "<td class='td'><input type='text' name='hsecode[]' class='hsecode' value='$housecode' readonly></td>";
	echo "<td class='td'><input type='text' name='lread[]' class='lread' value='$lread' style='text-align:right' readonly></td>";
	echo "<td class='td'><input type='text' name='cread[]' class='cread' value='$cread' style='text-align:right'  onblur ='getamt()' readonly></td>";
	echo "<td class='td'><input type='text' name='rate[]' class='rate' value='$rate' style='text-align:right' readonly></td>";
	echo "<td class='td'><input type='text' name='amount[]' class='amount' value=$amount style='text-align:right' readonly></td>";
	echo "<td class='td'><input type='checkbox' name='chek1[]' class='chek1' value='0'></td>";
	echo "</tr>";
	 }
	 echo "</table>";
?> 