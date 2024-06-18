<?php
include 'configure.php';
	
	//$ownerid=12;
	
//Establishing Connection with Server..
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
if($conn->connect_error){
  die("Error in DB connection: ".$conn->connect_errno." : ".$conn->connect_error);    
}
else
{
	$mdate=date("Y/m/d");
	$lordcode = $_POST['lordcode'];
	$lordname = $_POST['lordname'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$vatno = $_POST['vatno'];
	$xstat = $_POST['xstat'];
	if ($xstat=='1')
	{
	$data = $conn->prepare("insert into landlords(lordname,phone,email,vatno) VALUES (?,?,?,?)");
	$data->bind_param('ssss', $lordname,$phone,$email,$vatno);
	$data->execute();
	} else {
	$data1 = "update landlords set lordname='$lordname',phone='$phone',email='$email',vatno='$vatno' where lordcode='$lordcode'";
	$date2 = $conn->query($data1);
	}
}
?>