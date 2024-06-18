<?php
	include 'configure.php';
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$mdate=date("Y-m-d");
	$plotcode = $_POST['plotcode'];
	$rdate = $_POST['dremit'];
	$pcode = $_POST['pcode'];
	$nyear = $_POST['nyear'];
	$nmonth = $_POST['nmonth'];
	
	$remit1 ="select mgtfee,vat,clerk,chequeno,statype from remittance where plotcode='$plotcode' and nyear='$nyear'
	and nmonth='$nmonth' and pcode='$pcode' and rdate='$rdate'";
	$remit2 = $conn->query($remit1);
	$remit3 = $remit2->fetch_assoc();
	$clerk = $remit3['clerk'];
	$chqno = $remit3['chequeno'];
	$statype = $remit3['statype'];
	$mgtfee = $remit3['mgtfee'];
	$mgtvat = $remit3['vat'];
	
	$com1= "select * from setup";
	$com2 = $conn->query($com1);
	$zrow =$com2->fetch_assoc();
	$cname = $zrow['cname'];
	$bdescript=$zrow['bdescript'];
	$telephone = $zrow['telephone'];
	$location = $zrow['location'];
	$vatrate= $zrow['vat'];
	
	$plot1 = "select plotname,lordcode,mgtcom,lordvat from plots where plotcode='$plotcode'";
	$plot2 = $conn->query($plot1);
	$plot3 = $plot2->fetch_assoc();
	$plotname=$plot3['plotname'];
	$lordcode = $plot3['lordcode'];
	$mgtcom = $plot3['mgtcom'];
	$lordvat = $plot3['lordvat'];
	
	$item1 = "select description from receivables where pcode='$pcode'";
	$item2 = $conn->query($item1);
	$item3 = $item2->fetch_assoc();
	$description1 = strtolower($item3['description']);
	$description = ucwords($description1);
	
	$sql1 = "select housecode,tenant,sum(arrears) as arrears,sum(amtdue) as amtdue,sum(paid) as paid,
	sum(arrears+amtdue) as totdue,	sum(arrears+amtdue-paid) as bcf from rentremit group by tenantcode";
	$sql2 = $conn->query($sql1);
	
	$summ1 = "select sum(arrears) as arrears,sum(amtdue) as amtdue,sum(paid) as paid,
	sum(arrears+amtdue) as totdue,sum(arrears+amtdue-paid) as bcf from rentremit group by plotcode";
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
	
	.th,.td {
		border: none;
	}
	.hz1 {
		text-align: center;
		padding: 1 px;
	}
	.right {
		text-align: right;
		padding-right: 5px;
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
	<p>Remittance Date: '.$rdate.' </p><br>
	<p>Property Name: '.$plotname.'</p>
	<p> Item Description: '.$description.'</p>
	<table>
	<tr><th class="hz1">Unit No</th><th class="hz1">Tenant Name</th><th class="right">Arrears</th><th class="right">Month Bill</th>
	<th class="right">Total Due</th><th class="right">Paid</th><th class="right">Bal CF</th></tr>';
	while ($row=$sql2->fetch_assoc())
	{
		$housecode=$row['housecode'];
		$tenant = $row['tenant'];
		$arrears=number_format($row['arrears'],2);
		$amtdue=number_format($row['amtdue'],2);
		$totdue=number_format($row['totdue'],2);
		$paid=number_format($row['paid'],2);
		$bcf=number_format($row['bcf'],2);
		$html.='<tr><td class="hz1">'.$housecode.'</td><td class="hz1">'.$tenant.'</td><td class="right">'.$arrears.'</td><td class="right">'.$amtdue.'</td> 
	<td class="right">'.$totdue.'</td><td class="right">'.$paid.'</td><td class="right">'.$bcf.'</td></tr>';
	}
	$rowz = $summ2->fetch_assoc();
		$zarrears=number_format($rowz['arrears'],2);
		$zamtdue=number_format($rowz['amtdue'],2);
		$ztotdue=number_format($rowz['totdue'],2);
		$zpaid1 = $rowz['paid'];
		$mgtfee1 = $zpaid1*$mgtcom/100;
		$mgtfee = number_format($mgtfee1,2);
		$zpaid=number_format($rowz['paid'],2);
		$zbcf=number_format($rowz['bcf'],2);
		if ($lordvat=='1')
		{
			$mgtvat1 = $mgtfee1*$vatrate/100;
		} else {
			$mgtvat1 = 0;
		}
		$mgtvat = number_format($mgtvat1,2);
		$netpayable1 = $zpaid1-$mgtfee1-$mgtvat1;
		$netpayable = number_format($netpayable1,2);
		
		$html.='<tr><th colspan=2 class="hz1">Totals </th><th class="right">'.$zarrears.'</th><th class="right">'.$zamtdue.'</th> 
	<th class="right">'.$ztotdue.'</th><th class="right">'.$zpaid.'</th><th class="right">'.$zbcf.'</th></tr></table>';
	$html.='<br><br><div style="clear: both;position: relative;">
	<div style="position: absolute;left: 5px;width: 30%;">
	<table><th colspan=2 class="th">Collections</th></tr>
	<tr><th class="th">Total Paid</th><td class="right td">'.$zpaid.'</td></tr>
	<tr><th class="th">Management Fee</th><td class="right td">'.$mgtfee.'</td></tr>
	<tr><th class="th">Management Fee VAT</th><td class="right td">'.$mgtvat.'</td></tr>
	<tr><th class="th">Net Payable</th><td class="right td">'.$netpayable.'</td></tr>
	</table>
	</div>
	<div style="margin-left: 31%">
	</div>
	<div style="margin-left: 61%">
	<table>
	<tr><th class="th">Prepared by</th><td class="td">'.$clerk.'</td></tr>
	<tr><th class="th">Approved by: </th><td class="td">___________________</td></tr>
	<tr><th class="th">Cheque/Ref No</th><td class="td">'.$chqno.'</td></tr>
	<tr><th class="th">Date Paid</th><td class="td">'.$rdate.'</td></tr>
	</table>
	</div>
	</body></html>';
require 'vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHTML($html);
$dompdf->setpaper('A4','portrait');
$dompdf->render();
$dompdf->stream('remitothers',array("attachement"=>0));
?>