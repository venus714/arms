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
	
	$sql1 = "select * from billsumm";
	$sql2 = $conn->query($sql1);
	
	$summ1 ="select sum(arrears) as arrears,sum(amtdue) as amtdue,sum(arrears+amtdue) as totdue
	from monthbill group by nmonth,nyear";
	$summ2 = $conn->query($summ1);
	
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
		
	}
	.hz1 {
		text-align: center;
		padding: 1 px;
	}
	.right {
		text-align: right;
		padding-right: 10px;
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
	</style>
	</head>
	<body>
	<h3 class="hz1">'.$cname.'</h3>
	<p class="hz1">'.$bdescript.'</p>
	<p class="hz1">Telephone: '.$telephone.' Location: '.$location.'<p>
	<hr><table>';
	
	while ($row1 = $sql2->fetch_assoc())
	{
		$plotcode=$row1['plotcode'];
		$plotname=$row1['plotname'];
		$zarrears = number_format($row1['arrears'],2);
		$zamtdue = number_format($row1['amtdue'],2);
		$ztotdue = number_format($row1['totdue'],2);
	$html.='<tr><td colspan=5><p class="txt">'.$plotname.'</p></td></tr>
	<tr class="summary"><th>Unit Number</th><th>Tenant Name</th><th class="right">Arrears</th>
	<th class="right">Month Bill</th><th class="right">Total Due</th></tr>';
	$sql3 ="select housecode,tenant,arrears,amtdue,(arrears+amtdue) as totdue from monthbill where plotcode='$plotcode'";
	$sql4 = $conn->query($sql3);
	while ($row2 = $sql4->fetch_assoc())
	{
		$housecode=$row2['housecode'];
		$tenant = $row2['tenant'];
		$arrears = number_format($row2['arrears'],2);
		$amtdue = number_format($row2['amtdue'],2);
		$totdue = number_format($row2['totdue'],2);
	$html.='<tr><td>'.$housecode.'</td><td>'.$tenant.'</td><td class="right">'.$arrears.'</td>
	<td class="right">'.$amtdue.'</td><td class="right">'.$totdue.'</td><tr>';
	}
	$html.='<tr class="summary"><th colspan=2>Sub Totals</th><th class="right">'.$zarrears.'</th><th class="right">'.$zamtdue.'</td>
	<th class="right">'.$ztotdue.'</th></tr>';
	}
	while ($zow=$summ2->fetch_assoc())
	{
		$xarrears= number_format($zow['arrears'],2);
		$xamtdue = number_format($zow['amtdue'],2);
		$xtotdue = number_format($zow['totdue'],2);
	$html.='<tr class="summary"><th colspan=2>Grand Totals</th><th class="right">'.$xarrears.'</th><th class="right">'.$xamtdue.'</th>
	<th class="right">'.$xtotdue.'</th></tr>';
	}
	$html.='</table>';
	$html.='</body></html>';
	require 'vendor/autoload.php';
	use Dompdf\Dompdf;

	$dompdf = new Dompdf();
	$dompdf->loadHTML($html);
	$dompdf->setpaper('A5','portrait');
	$dompdf->render();
	$dompdf->stream('monthbills',array("attachement"=>0));
	?>
