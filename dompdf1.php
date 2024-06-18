<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$max1 ="select max(id) as refno from disbursement";
$max2 = $conn->query($max1);
$idno = $max2->fetch_assoc();
$refno=$idno['refno'];
$sql1 = "select id,description,trans_date,amount from disbursement where id='$refno'";
$result = $conn->query($sql1);

$html='<!DOCTYPE HTML>
<html>
<head>
<title>LandLord Details</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">

<style> 
	table {
		width: 100%;
	}
	th,td {
		padding: 10px;
		text-align: left;
	}
	</style>
</head>
<body>
<h2>Payment Voucher</h2>
<table>
<tr><th>Refno</th><th>Payment Description</th><th>Amount Paid</th></tr>';
$row1=$result->fetch_assoc();
$html.='<tr><td>'.$row1['id'].'</td><td>'.$row1['description'].'</td><td>'.$row1['amount'].'</td></tr>
</table>
</body>
</html>'; 
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHTML($html);
$dompdf->setpaper('A4','portrait');
$dompdf->render();
$dompdf->stream('pvoucher',array("attachement"=>0));
?>