<?php
		require "configure.php";
		//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
		$mdate = date('Y/m/d');
		$plotcode = $_POST['plotcode'];
		$nyear = $_POST['nyear'];
		$nmonth = $_POST['nmonth'];
		$check1 = $_POST['checkz'];
		$check2 = implode(" ",$check1);
		$check3 = explode(",",$check2);
		$id1 = $_POST['idnum1'];
		$id2 = implode(" ",$id1);
		$id3 = explode(",",$id2);
		$narr1 = $_POST['narr1'];
		$narr2 = implode(" ",$narr1);
		$narr3 = explode(",",$narr2);
		$amt1 = $_POST['amt1'];
		$amt2 = implode(" ",$amt1);
		$amt3 = explode(",",$amt2);
		$zdate1 = $_POST['zdate1'];
		$zdate2 = implode(" ",$zdate1);
		$zdate3 = explode(",",$zdate2);
				
		foreach ($id3 as $key => $value)
	    {
           	$idno = $id3[$key];
			$check = $check3[$key];
			$narr = $narr3[$key];
			$amt = $amt3[$key];
			$zdate = $zdate3[$key];
			
            $sql ="update disbursement set description= '$narr',amount=$amt,trans_date='$zdate' where id= '$idno' and $check='1'";
			$sql2=$conn->query($sql);
		}
		$str1= "select id,description,amount,trans_date from disbursement where plotcode=$plotcode and nmonth=$nmonth and nyear=$nyear and canx!='1'";
		$str2 = $conn->query($str1);

	echo "<table>";
	echo "<tr>";
	echo "<th>Recno</th>";
	echo "<th>Narrative</th>";
	echo "<th>Amount</th>";
	echo "<th>Date</th>";
	echo "<th>Select</th>";
	echo "</tr>";
	while ($row = $str2->fetch_assoc())
	{
	$id= $row['id'];
	$narrative = $row['description'];
	$amount = $row['amount'];
	$trans_date = $row['trans_date'];
	echo "<tr>";
	echo "<td style='width: 5%;'><input type='text' name='idno[]' class='idno' value='$id' readonly></td>";
	echo "<td style='width: 50%'><textarea readonly name='narrative[]' class='narrative'>$narrative</textarea></td>";
	echo "<td style='width: 20%;text-align:right;'><input type='text' name='amount[]' class='amount' value='$amount' readonly></td>";
	echo "<td style='width: 20%'><input type='text' name='date1[]' class='date1' value=$trans_date readonly></td>";
	echo "<td style='width: 5%'><input type ='checkbox' name='chek1[]' class='chek1' value='0' onclick='zmark()'></td>";
	echo "</tr>";
	}
	echo "</table>";
?> 