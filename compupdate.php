<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$cname = $_POST['cname'];
$bdescript = $_POST['bdescript'];
$location = $_POST['location'];
$email = $_POST['email'];
$website = $_POST['website'];
$telephone = $_POST['telephone'];
$vatno = $_POST['vatno'];
$pin = $_POST['pin'];

$qry1="update setup set cname='$cname',bdescript='$bdescript',location='$location',telephone='$telephone',
email='$email',website='$website',vatno='$vatno',pin='$pin'";
$conn->query($qry1)
?>