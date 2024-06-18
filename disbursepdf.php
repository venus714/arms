<?php
	include 'configure.php';
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$mdate=date("Y/m/d");
	$plotcode = $_POST['plotcode'];
	$date1 = $_POST['date1'];
	$date2 = $_POST['date2'];
	
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
	
	
	
	$sql1 = "select trans_date,description,amount from disburses order by trans_date";
	$sql2 = $conn->query($sql1);
	
	$summ1 = "select sum(amount) as amount from disburses group by plotcode";
	$summ2 = $conn->query($summ1);
	
	
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
	$html.='<h3 class="hz1">'.$cname.'</h3>
	<p class="hz1">'.$bdescript.'</p>
	<p class="hz1">Telephone: '.$telephone.' Location: '.$location.'<p>
	<hr>
	<br><br>
	<p>Disbursements for period '.$date1.' to '.$date2.'</p><br>
	<p>Property Name: '.$plotname.'</p>
	<table>
	<tr><th class="hz1">Date</th><th class="hz1">description</th><th class="right">Amount</th></tr>';
	while ($row=$sql2->fetch_assoc())
	{
		$trans_date=$row['trans_date'];
		$description = $row['description'];
		$amount=number_format($row['amount'],2);
	$html.='<tr><td class="hz1">'.$trans_date.'</td><td class="hz1">'.$description.'</td> 
	<td class="right">'.$amount.'</td></tr>';
	}
	$row1 = $summ2->fetch_assoc();
	$zamount = number_format($row1['amount'],2);
	$html.='<tr><td class="hz1" colspan=2>Totals....<td class="right">'.$zamount.'</td></tr>
	</table>
	</body></html>';
	
require 'vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHTML($html);
$dompdf->setpaper('A5','portrait');
$dompdf->render();
$dompdf->stream('disburses',array("attachement"=>0));
?>