<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plotcode = $_POST['plotcode'];
$houseid =$_POST['housecode'];
$tenant =$_POST['tenant'];
$datein = $_POST['datein'];
$rent = $_POST['rent'];
$idno= $_POST['idno'];
$phone =$_POST['phone'];
$email=$_POST['email'];
$nextkin = $_POST['nextkin'];
$kinrelation = $_POST['kinrelation'];
$kinphone = $_POST['kinphone'];
$kinemail = $_POST['kinemail'];
$movedout='0';
$gender = $_POST['gender'];
$quarter = $_POST['quarter'];
$opt = $_POST['opt'];

$hseno ="select housecode from houseunits where houseid='$houseid' and occupied='0'";
$unit = $conn->query($hseno);

$row = $unit->fetch_assoc();
$housecode = $row['housecode'];
if ($opt=='1')
{

$qry1="select * from tenants where houseid='$houseid' and movedout='0'";
$ans1= $conn->query($qry1);

if($ans1->num_rows>0)
{
	echo "<span style='color: Red;font-weight: bold;padding-left: 10px;'>Unit Already Occupied</span>";
}
else { 

$sql=$conn->prepare("insert into tenants(plotcode,housecode,houseid,tenant,datein,rent,quarter,gender,
idno,phone,email,movedout,nextkin,kinrelation,kinphone,kinemail) 
values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$sql->bind_param("issssiissssissss",$plotcode,$housecode,$houseid,$tenant,$datein,$rent,$quarter,$gender,
$idno,$phone,$email,$movedout,$nextkin,$kinrelation,$kinphone,$kinemail);
$sql->execute();

$marked = "update houseunits set occupied = '1' where houseid='$houseid'";
$conn->query($marked);

echo "<span style='color: green;font-weight: bold;padding-left: 10px;'>Record Inserted Successfully</span>";
}
} else {
	$update1 = "update tenants set tenant='$tenant',idno='$idno',phone='$phone',
	email='$email',nextkin='$nextkin',kinrelation='$kinrelation',kinphone='$kinphone',
	kinemail = '$kinemail',datein='$datein' where houseid='$houseid'";
	$update2 = $conn->query($update1);
	echo "<span style='color: green;font-weight: bold;padding-left: 10px;'>Record Updated Successfully. $houseid</span>";
}
?>