<?php
require "configure.php";
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
		$userid = $_POST['userid'];
		$str1 = $_POST['checker1'];
		$str2 = implode("",$str1);
		$checker1 = trim($str2);
		$checker = str_replace(',', '', $checker1);
				
	
            $sql ="update sysusers set useraccess='$checker' where id=$userid";
			$conn->query($sql);
		echo "<p style='color: green;font-weight: bold;text-align: center'>Update Done Successfully</p>";
				
		?>