<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plotcode = $_POST['plotcode'];
$houseid = $_POST['houseid'];
$housecode = $_POST['housecode'];
$tenantcode = $_POST['tenantcode'];
$dateout = $_POST['dateout'];
$daterev = $_POST['daterev'];
$tenant = $_POST['tenant'];
$rent = $_POST['rent'];

$qry1="update tenants set movedout='0',daterev='$daterev' where tenantcode = $tenantcode";
$ans1= $conn->query($qry1);

$qry2="update houseunits set occupied='1' where houseid = '$houseid'";
$ans2= $conn->query($qry2);

$append = "insert into reversed(plotcode,housecode,tenantcode,tenant,rent,dateout,daterev) 
value('$plotcode','$housecode','$tenantcode','$tenant','$rent','$dateout','$daterev')";
$appended = $conn->query($append);
?>