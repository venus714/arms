<?php
	include 'configure.php';
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$mdate=date("Y/m/d");
	$plotcode = $_POST['plotcode'];
	$nmonth = $_POST['nmonth'];
	$nyear = $_POST['nyear'];
		
	$com1= "select * from setup";
	$com2 = $conn->query($com1);
	$zrow =$com2->fetch_assoc();
	$cname = $zrow['cname'];
	$bdescript=$zrow['bdescript'];
	$telephone = $zrow['telephone'];
	$location = $zrow['location'];
	
	$plot1 = "select plotname from plots where plotcode='$plotcode'";
	$plot2 = $conn->query($plot1);
	$plot3 = $plot2->fetch_assoc();
	$plotname=$plot3['plotname'];
	
	
	$sql1 = "select tenant,housecode,tenantcode,sum(arrears) as arrears,sum(amtdue) as amtdue,sum(totdue) as totdue 	from invsumm group by tenantcode";
	$sql2 = $conn->query($sql1);
	
	$html='<!DOCTYPE HTML>
	<html>
	<head>
	<title>Invoices</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="mystyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="datascript.js"></script>
	<style> 
	table {
		width: 100%;
		border-collapse: collapse;
	}
	th,td {
		padding: 5 px;
		text-align: left;
		border: 1px solid black;
	}
	.hz1 {
		text-align: center;
		padding: 1 px;
	}
	.right {
		text-align: right;
		padding-right: 10px;
	}
	
	.break {
		page-break-after: always;
	}
	</style>
	</head>
	<body>';
	while ($row1 = $sql2->fetch_assoc())
	{
		$tenant=$row1['tenant'];
		$housecode=$row1['housecode'];
		$tenantcode = $row1['tenantcode'];
		$zarrears = number_format($row1['arrears'],2);
		$zamtdue = number_format($row1['amtdue'],2);
	    $ztotdue= number_format($row1['totdue'],2);
	
	$html.='<h3 class="hz1">'.$cname.'</h3>
	<p class="hz1">'.$bdescript.'</p>
	<p class="hz1">Telephone: '.$telephone.' Location: '.$location.'<p>
	<hr>
	<h4 style="text-align: center">Invoice<h4>';
	$html.='<p>Tenant Name: '.$tenant.'</p>
	<p>Unit Number: '.$housecode.'</p>
	<p>Property Name: '.$plotname.'</p>';
	$qr1 = "select arrears,amtdue,arrears+amtdue as totdue,pcode from invoices where tenantcode='$tenantcode'";
	$qr2 = $conn->query($qr1);
	$html.='<table>
	<tr><th class="hz1">Pay code</th><th class="right">Arrears</th><th class="right">Month Bill</th><th class="right">Total Due</th></tr>';
	while ($row=$qr2->fetch_assoc())
	{
		$pcode=$row['pcode'];
		$arrears=number_format($row['arrears'],2);
		$amtdue= number_format($row['amtdue'],2);
		$totdue =  number_format($row['totdue'],2);
		
	$html.='<tr><td class="hz1">'.$pcode.'</td><td class="right">'.$arrears.'</td><td class="right">'.$amtdue.'</td><td class="right">'.$totdue.'</td></tr>';
	}
	$html.='<tr><td class="hz1">Total Due</td><td class="right">'.$zarrears.'</td><td class="right">'.$zamtdue.'</td><td class="right">'.$ztotdue.'</td></tr>';
	$html.='</table><br><p class="break">Pay by the 5th of Month</p>';
	}
	$html.='</body></html>';
	
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHTML($html);
$dompdf->setpaper('A5','portrait');
$dompdf->render();
$dompdf->stream('myinvoice',array("attachement"=>0));
?>