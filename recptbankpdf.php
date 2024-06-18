<?php
	include 'configure.php';
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$date1 = $_POST['date1'];
	$date2 = $_POST['date2'];
	$accno = $_POST['accno'];
	$com1= "select * from setup";
	$com2 = $conn->query($com1);
	$zrow =$com2->fetch_assoc();
	$cname = $zrow['cname'];
	$bdescript=$zrow['bdescript'];
	$telephone = $zrow['telephone'];
	$location = $zrow['location'];
	
	$bank1 = "select bankname from banks where accno='$accno'";
	$bank2 = $conn->query($bank1);
	$drow =$bank2->fetch_assoc();
	$bankname1 = strtolower($drow['bankname']);
	$bankname = ucwords($bankname1);
	$sql3 = "select trans_date,housecode,tenant,plotname,refno,accno,sum(paid) as paid,recptno from recptitem group by recptno";
	$sql4 = $conn->query($sql3);
	
	$qry3 = "select sum(paid) as paid from recptitem group by xstat";
	$qry4 = $conn->query($qry3);
	
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
		padding: 5 px;
		text-align: left;
		font-size: 10px;
	}
	.hz1 {
		text-align: center;
		padding: 1 px;
	}
	.right {
		text-align: right;
		padding-right: 15px;
	}
	
	.left {
		text-align: left;
		padding-right: 15px;
	}
	
	.centre {
		text-align: center;
		padding-right: 15px;
	}
	
	.th,.td {
		border: 1px solid black;
		max-width: 30%;
		padding-left: 5px;
	}
	.summary {
		border-top: 1px solid black;
		border-bottom: 1px solid black;
	}
	
	
	.break {
		page-break-after: always;
	}
	
	.txt {
	text-decoration: underline;
	font-weight: bold;
	}
	
	.txt1 {
	text-decoration: underline;
	font-weight: bold;
	text-align: center;
	}
	</style>
	</head>
	<body>
	<h3 class="hz1">'.$cname.'</h3>
	<p class="hz1">'.$bdescript.'</p>
	<p class="hz1">Telephone: '.$telephone.' Location: '.$location.'<p>
	<hr>
	<br><br>
	<p class="txt1">Payments Deposited to  '.$bankname.'  betweem  '.$date1.' and '.$date2.'</p><br><br>
	<table><thead style="display: table-header-group">';
	
	
	$html.='<tr class="summary"><th>Date Deposited</th><th>Unit No</th><th class="centre">Property</th>
	<th class="centre">Tenant</th><th class="left">Recpt No</th><th class="left">Ref No</th><th class="left">A/C No</th> 
	<th class="right">Paid</th> </tr></thead>';
	while ($row2 = $sql4->fetch_assoc())
	{
		$trans_date = $row2['trans_date'];
		$plotname = $row2['plotname'];
		$housecode=$row2['housecode'];
		$tenant = $row2['tenant'];
		$recptno = $row2['recptno'];
		$refno = $row2['refno'];
		$accno = $row2['accno'];
		$paid = number_format($row2['paid'],2);
	$html.='<tr><td class="left">'.$trans_date.'</td><td class="left">'.$housecode.'</td><td class="left">'.$plotname.'</td>
	<td class="left">'.$tenant.'</td><td class="left">'.$recptno.'</td><td class="left">'.$refno.'</td>
	<td class="left">'.$accno.'</td> <td class="right">'.$paid.'</td></tr>';
	}
	$zow = $qry4->fetch_assoc();
	$zpaid= number_format($zow['paid'],2);
	$html.='<tr class="summary"><th colspan=7>Total Paid</th><th class="right">'.$zpaid.'</th></tr>
	</table>
	</body></html>';
	
	require 'vendor/autoload.php';
	use Dompdf\Dompdf;
	$dompdf = new Dompdf();
	$dompdf->loadHTML($html);
	$dompdf->setpaper('A4','portrait');
	$dompdf->render();
	$dompdf->stream('recptbank',array("attachement"=>0));
	?>