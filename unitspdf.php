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

$sql1 = "select housecode,rent, unitcat.catname,occupied as xstatus
from houseunits left join unitcat on houseunits.catcode=unitcat.catcode where plotcode='$xcode'";
$result = $conn->query($sql1);

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
	.right {
		text-align: right;
		padding-right: 10px;
	}
	</style>
</head>
<body>
<h3 class="zentre">Units Occupancy</h3>
<p>Property Name: '.$plotname.'</p>
<p>Landlord Name: '.$lordname.'</p>

<table><tr><th>Unit No.</th><th class="right">Monthly Rent</th><th>Category Name</th><th>Occupancy</th></tr>';
while ($row= $result->fetch_assoc())
{
	$housecode=$row['housecode'];
	$xstatus = $row['xstatus'];
	$rent = number_format($row['rent'],2);
	$catname = $row['catname'];

$html.='<tr><td>'.$housecode.'</td><td class="right">'.$rent.'</td><td>'.$catname.'</td><td class="zentre">'.$xstatus.'</td></tr>';
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
$dompdf->stream('unitslist',array("attachement"=>0));
?>