<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plotcode = $_POST['plotcode'];
$tenant = $_POST['tenant'];
$housecode1 = $_POST['housecode1'];
$housecode2 = $_POST['housecode2'];
$tenantcode = $_POST['tenantcode'];
$houseid1 = $_POST['houseid1'];
$houseid2 = $_POST['houseid2'];
$dtrans = $_POST['dtrans'];
$oldrent =	 $_POST['oldrent'];
$newrent =	 $_POST['newrent'];

$qry1="update tenants set houseid='$houseid2',housecode = '$housecode2' where tenantcode=$tenantcode";
$ans1= $conn->query($qry1);


$qry2="update houseunits set occupied='0' where houseid = '$houseid1'";
$ans2= $conn->query($qry2);

$qry3="update houseunits set occupied='1' where houseid = '$houseid2'";
$ans3= $conn->query($qry3);

$append = "insert into transfers(plotcode,oldhse,oldrent,newhse,newrent,trans_date,tenant) 
value('$plotcode','$housecode1','$oldrent','$housecode2','$newrent','$dtrans','$tenant')";
$appended = $conn->query($append);
?>