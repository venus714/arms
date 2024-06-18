<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
if (isset($_POST['pdf']))
{
$xcode=$_POST['h1'];
} else {
$xcode='1';
}

$prop1 = "select plotcode,plotname,lordname from plots left join landlords 
on plots.lordcode=landlords.lordcode where plotcode='$xcode'";
$prop2 = $conn->query($prop1);
$rowz = $prop2->fetch_assoc();
$plotname = $rowz['plotname'];
$lordname = $rowz['lordname'];

$qr1 = "select * from premtenants";
$qr2 = $conn->query($qr1);

$html='<!DOCTYPE HTML>
<html>
<head>
<title>Tenants Details</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">

<style> 
	table {
		width: 100%;
		border-collapse: collapse;
	}
	th,td {
		padding: 10px;
		text-align: left;
		border: 1px solid black;
	}
	.zentre {
		text-align: center;
	}
	</style>
</head>
<body>
<h3 class="zentre">Tenants List</h3>
<p>Property Name: '.$plotname.'</p>
<p>Landlord Name: '.$lordname.'</p>

<table><tr><th>Unit No.</th><th>Tenant Name</th><th>Phone Number</th><th>Month Rent</th></tr>';
while ($row=$qr2->fetch_assoc())
{
	$housecode=$row['housecode'];
	$tenant = $row['tenant'];
	$rent = $row['rent'];
	$phone = $row['phone'];

$html.='<tr><td>'.$housecode.'</td><td>'.$tenant.'</td><td>'.$phone.'</td><td>'.$rent.'</td></tr>';
}
$html.='</table>
</body>
</html>';

require 'vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHTML($html);
$dompdf->setpaper('A5','portrait');
$dompdf->render();
$dompdf->stream('tntlist',array("attachement"=>0));
?>