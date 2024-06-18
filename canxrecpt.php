<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$recptno = $_POST['recptno'];
$qry1="update receipts set canx='1' where recptno='$recptno'";
$ans1= $conn->query($qry1);
?>