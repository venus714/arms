<?php
	include 'configure.php';
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$mdate=date("Y/m/d");
	$plotcode = $_POST['plotcode'];
	$pcode = $_POST['pcode'];
	
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
	
	$itemcode1 = "select description from receivables where pcode='$pcode'";
	$itemcode2 =$conn->query($itemcode1);
	$pname = $itemcode2->fetch_assoc();
	$description = $pname['description'];
	
	$sql1 = "select * from statsumm order by housecode";
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
		font-size: 10px;
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
		$zbalcf = number_format($row1['balcf'],2);
		
	
	$html.='<h3 class="hz1">'.$cname.'</h3>
	<p class="hz1">'.$bdescript.'</p>
	<p class="hz1">Telephone: '.$telephone.' Location: '.$location.'<p>
	<hr>
	<h4 style="text-align: center">'.$description.' statement<h4>';
	$html.='<p>Tenant Name: '.$tenant.'</p>
	<p>Unit Number: '.$housecode.'</p>
	<p>Property Name: '.$plotname.'</p>';
	$qr1 = "select trans_date,refno,descript,amtdue,paid,amtdue+balcf-paid as balcf from tenantstat where tenantcode='$tenantcode' order by trans_date";
	$qr2 = $conn->query($qr1);
	$html.='<table>
	<tr><th class="hz1">Date</th><th class="hz1">Narrative</th><th class="hz1">Ref No.</th><th class="hz1">Debit</th><th class="hz1">Credit</th><th class="hz1">Balance</th></tr>';
	$bal=0;
	while ($row=$qr2->fetch_assoc())
	{
		$trans_date=$row['trans_date'];
		$refno = $row['refno'];
		$descript = $row['descript'];
		$debit=number_format($row['amtdue'],2);
		$credit= number_format($row['paid'],2);
		$balcf1 =  $row['balcf'] +$bal;
		$balcf = number_format($balcf1,2);
		
	$html.='<tr><td class="hz1">'.$trans_date.'</td><td class="hz1">'.$descript.'</td><td class="hz1">'.$refno.'</td> 
	<td class="right">'.$debit.'</td><td class="right">'.$credit.'</td><td class="right">'.$balcf.'</td></tr>';
	$bal = $balcf1;}
	$html.='<tr><td class="hz1" colspan=5>Balance CF<td class="right">'.$zbalcf.'</td></tr>';
	$html.='</table><br><p class="break">Pay rent by the 5th of Month</p>';
	}
	$html.='</body></html>';
	
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHTML($html);
$dompdf->setpaper('A5','portrait');
$dompdf->render();
$dompdf->stream('tenantstat',array("attachement"=>0));
?>