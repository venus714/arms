<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plotcode = $_POST['plotcode'];
$payee = $_POST['payee'];
$date1 = $_POST['date1'];
$paid = $_POST['paid'];
$narr = $_POST['narr'];
$invno = $_POST['invno'];
$authority = $_POST['authority'];
$cheque = $_POST['cheque'];
$clerk = $_POST['clerk'];
$nyear = date('Y');
$nmonth = date('m');
$pv = '1';

$qry1="insert into disbursement(plotcode,payee,trans_date,amount,invno,description,authority,chequeno,clerk,nyear,nmonth,pv,remitted,canx)
value('$plotcode','$payee','$date1','$paid','$invno','$narr','$authority','$cheque','$clerk','$nyear','$nmonth','$pv','0','01')";
$ans1= $conn->query($qry1);
?>