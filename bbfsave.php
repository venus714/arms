<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plotcode = $_POST['plotcode'];
$tenant = $_POST['tenant'];
$housecode = $_POST['housecode'];
$tenantcode = $_POST['tenantcode'];
$mdate = $_POST['mdate'];
$pcode = $_POST['pcode'];
$amount = $_POST['amount'];
$nmonth=date("m");
$nyear = date("Y");

$qry1="insert into receipts(plotcode,housecode,tenantcode,tenant,pcode,amount,trans_date)
value('$plotcode','$housecode','$tenantcode','$tenant','$pcode','$amount','$mdate')";
$ans1= $conn->query($qry1);
?>