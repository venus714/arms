<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$qtr = $_POST['qtr'];
$nmonth = $_POST['nmonth'];

$qry1="select * from rentschedule where nmonths= $nmonth";
$ans1= $conn->query($qry1);

if($ans1->num_rows > 0)
{
	
echo "<span style='color: Red;font-weight: bold;padding-left: 10px;'>Quarter Already Posted</span>";
}
else { 
$sql=$conn->prepare("insert into rentschedule(description,nmonths) values(?,?)");
$sql->bind_param("ss",$qtr,$nmonth);
$sql->execute();
echo "<span style='color: green;font-weight: bold;padding-left: 10px;'>Record Inserted Successfully</span>";
}
?>