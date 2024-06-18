<?php
	include 'configure.php';
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
		
	$com1= "select * from setup";
	$com2 = $conn->query($com1);
	$zrow =$com2->fetch_assoc();
	$cname = $zrow['cname'];
	$bdescript=$zrow['bdescript'];
	$telephone = $zrow['telephone'];
	$location = $zrow['location'];
	
	$sql1 = "select * from mydebtors";
	$sql2 = $conn->query($sql1);
	
	$html='<!DOCTYPE HTML>
	<html>
	<head>
	<title>Debtors</title>
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
		padding: 20px;
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
	<body>
	<h3 class="hz1">'.$cname.'</h3>
	<p class="hz1">'.$bdescript.'</p>
	<p class="hz1">Telephone: '.$telephone.' Location: '.$location.'<p>
	<hr>';
	
	while ($row1 = $sql2->fetch_assoc())
	{
		$plotcode=$row1['plotcode'];
		$plotname=$row1['plotname'];
		$zarrears = $row1['arrears'];
		$zotarrears = $row1['otarrears'];
	$html.='<table><tr><td colspan=5>'.$plotname.'</td></tr>
	<tr><th>Unit Number</th><th>Tenant Name</th><th>Telephone</th><th class="right">Rent Arrears</th>
	<th class="right">Other Arrears</th></tr>';
	$sql3 ="select housecode,tenant,phone,arrears,otarrears from debtorz where plotcode='$plotcode'";
	$sql4 = $conn->query($sql3);
	while ($row2 = $sql4->fetch_assoc())
	{
		$housecode=$row2['housecode'];
		$tenant = $row2['tenant'];
		$phone = $row2['phone'];
		$arrears = $row2['arrears'];
		$otarrears = $row2['otarrears'];
	$html.='<tr><td>'.$housecode.'</td><td>'.$tenant.'</td><td>'.$phone.'</td>
	<td class="right">'.number_format($arrears,2).'</td><td class="right">'.number_format($otarrears,2).'</td><tr>';
	}
	$html.='<tr><th colspan=3>Sub Totals</th><th class="right">'.number_format($zarrears,2).'</th>
	<th class="right">'.number_format($zotarrears,2).'</th></tr>
	</table><p class="breal"></p>';
	}
	$html.='</body></html>';
	require 'vendor/autoload.php';
	use Dompdf\Dompdf;

	$dompdf = new Dompdf();
	$dompdf->loadHTML($html);
	$dompdf->setpaper('A4','portrait');
	$dompdf->render();
	$dompdf->stream('alldebtors',array("attachement"=>0));
	?>
