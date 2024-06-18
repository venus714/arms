<?php
require "configure.php";
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
		$plotcode = $_POST['plotcode'];
		$savel ="insert into receipts(plotcode) value('$plotcode')";
		$save2=$conn->query($savel);
	?>