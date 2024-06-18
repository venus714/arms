<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$catcode = $_POST['catcode'];
$catname = $_POST['catname'];

$qry1="select * from unitcat where catcode= '$catcode'";
$ans1= $conn->query($qry1);

if($ans1->num_rows > 0)
{
	
echo "<span style='color: Red;font-weight: bold;padding-left: 10px;'>Category Code Already in Use</span>";
}
else { 
//$response['success'] = true;
$sql=$conn->prepare("insert into unitcat(catcode,catname) values(?,?)");
$sql->bind_param("ss",$catcode,$catname);
$sql->execute();
echo "<span style='color: green;font-weight: bold;padding-left: 10px;'>Record Inserted Successfully</span>";
}
?>