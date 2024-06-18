<?php
include 'configure.php';
$database=DBASE;

	$mdate=date("Y/m/d");
	$lordname = $_POST['lordname'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$vatno = $_POST['vatno'];
	//$ownerid=12;
	
//Establishing Connection with Server..
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
if($conn->connect_error){
  die("Error in DB connection: ".$conn->connect_errno." : ".$conn->connect_error);    
}
else
{
	echo 'connected...';
	$data = $conn->prepare("insert into landlords(lordname,phone,email,vatno,date) VALUES (?,?,?,?,?)");
	$data->bind_param('sssss', $lordname,$phone,$email,$vatno,$mdate);
	$data->execute();
	//$result2 = $data2->get_result();
}
?>