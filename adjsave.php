<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plotcode = $_POST['plotcode'];
$tenant = $_POST['tenant'];
$housecode = $_POST['housecode'];
$tenantcode = $_POST['tenantcode'];
$mdate = $_POST['mdate'];
$pcode = $_POST['pcode'];
$amount = $_POST['amount'];
$reason = $_POST['reason'];
$authority = $_POST['authority'];
$nmonth=date("m");
$nyear = date("Y");

$qry1="insert into adjustments(plotcode,housecode,tenantcode,tenant,pcode,amount,reason,authority,trans_date,nyear,nmonth,remitted)
value('$plotcode','$housecode','$tenantcode','$tenant','$pcode','$amount','$reason','$authority','$mdate','$nyear','$nmonth','0')";
$ans1= $conn->query($qry1);
?>