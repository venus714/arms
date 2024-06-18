<?php
	include 'configure.php';
	$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
	$mdate=date("Y-m-d");
	$plotcode = $_POST['plotcode'];
	$rdate = $_POST['dremit'];
	$nyear = $_POST['nyear'];
	$nmonth = $_POST['nmonth'];
	
	
	$com1= "select * from setup";
	$com2 = $conn->query($com1);
	$zrow =$com2->fetch_assoc();
	$cname = $zrow['cname'];
	$bdescript=$zrow['bdescript'];
	$telephone = $zrow['telephone'];
	$location = $zrow['location'];
	$vat = $zrow['vat'];
	
	$plot1 = "select plotname,mgtcom,lordvat from plots where plotcode='$plotcode'";
	$plot2 = $conn->query($plot1);
	$plot3 = $plot2->fetch_assoc();
	$plotname=$plot3['plotname'];
	$mgtcom = $plot3['mgtcom'];
	$lordvat = $plot3['lordvat'];
	
	$rem1 ="select rdate,amount,mgtfee,vat,clerk,chequeno,statype from remittance where plotcode='$plotcode' and rdate='$rdate'";
	$rem2 = $conn->query($rem1);
	$rem3 = $rem2->fetch_assoc();
	$chqno = $rem3['chequeno'];
	$clerk = $rem3['clerk'];
	$statype = $rem3['statype'];
	
	$sql1 = "select housecode,tenant,sum(arrears) as arrears,sum(amtdue) as amtdue,sum(paid) as paid,sum(deposit) as deposit,
	sum(arrears+amtdue) as totdue,	sum(arrears+amtdue-paid) as bcf from rentremit group by tenantcode";
	$sql2 = $conn->query($sql1);
	
	$summ1 = "select sum(arrears) as arrears,sum(amtdue) as amtdue,sum(paid) as paid,sum(deposit) as deposit,
	sum(arrears+amtdue) as totdue,sum(arrears+amtdue-paid) as bcf from rentremit group by plotcode";
	$summ2 = $conn->query($summ1);
	
	$exp1 = "select sum(amount) as amount from disbursement where plotcode='$plotcode' and dremit = '$rdate' group by plotcode";
	$exp2 = $conn->query($exp1);
	$exp3 =$exp2->fetch_assoc();
	$disburse1 = $exp3['amount'];
	$disburse = number_format($disburse1,2);


	$adv1 = "select sum(amount) as amount from advance where plotcode='$plotcode' and dremit = '$rdate' group by plotcode";
	$adv2 = $conn->query($adv1);
	$adv3 =$adv2->fetch_assoc();
	$advance1 = $adv3['amount'];
	$advance = number_format($advance1,2);

	$bnk1 = "select sum(amount) as amount from bankexp where plotcode='$plotcode' and dremit = '$rdate' group by plotcode";
	$bnk2 = $conn->query($bnk1);
	$bnk3 =$bnk2->fetch_assoc();
	$bankexp1 = $bnk3['amount'];
	$bankexp = number_format($bankexp1,2);

	
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
		padding-left: 10px;
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
	.row {
	display: flex;
	flex-direction: row;
	}

	.rightside {
		flex:40%;
		max-width: 40%;
		color: black;
		background-color:rgb(255,255,255);
		padding: 10px;
		}

	.midside {
		flex:20%;
		max-width: 20%;
		color: black;
		background-color:rgb(255,255,255);
		padding: 10px;
		}
	</style>
	</head>
	<body>';
	$html.='<h3 class="hz1">'.$cname.'</h3>
	<p class="hz1">'.$bdescript.'</p>
	<p class="hz1">Telephone: '.$telephone.' Location: '.$location.'<p>
	<hr>
	<br><br>
	<p>Remittance for period '.$rdate.'</p><br>
	<p>Property Name: '.$plotname.'</p>
	<table>
	<tr><th class="hz1">Unit No</th><th class="hz1">Tenant Name</th><th class="right">Deposits</th><th class="right">Arrears</th><th class="right">Month Bill</th>
	<th class="right">Total Due</th><th class="right">Paid</th><th class="right">Bal CF</th></tr>';
	while ($row=$sql2->fetch_assoc())
	{
		$housecode=$row['housecode'];
		$tenant = $row['tenant'];
		$arrears=number_format($row['arrears'],2);
		$amtdue=number_format($row['amtdue'],2);
		$totdue=number_format($row['totdue'],2);
		$paid=number_format($row['paid'],2);
		$deposit = number_format($row['deposit'],2);
		$bcf=number_format($row['bcf'],2);
	$html.='<tr><td class="hz1">'.$housecode.'</td><td class="hz1">'.$tenant.'</td><td class="right">'.$deposit.'</td>
	<td class="right">'.$arrears.'</td><td class="right">'.$amtdue.'</td> 
	<td class="right">'.$totdue.'</td><td class="right">'.$paid.'</td><td class="right">'.$bcf.'</td></tr>';
	}
	$rowz = $summ2->fetch_assoc();
		$zarrears=number_format($rowz['arrears'],2);
		$zamtdue=number_format($rowz['amtdue'],2);
		$ztotdue=number_format($rowz['totdue'],2);
		$zpaid=number_format($rowz['paid'],2);
		$zdeposit=number_format($rowz['deposit'],2);
		$zbcf=number_format($rowz['bcf'],2);
		$zpaid1=$rowz['paid'];
		$zdeposit1=$rowz['deposit'];
		$ztotpaid1 = $zpaid1+$zdeposit1;
		$ztotpaid = number_format($ztotpaid1,2);
		$mgtfee1 = $zpaid1*$mgtcom/100;
		$mgtfee = number_format($mgtfee1,2);
		if ($lordvat==1)
		{
			$mgtvat1 = $mgtfee1*$vat/100;
		}else {
			$mgtvat1 =0;
		}
		$mgtvat = number_format($mgtvat1,2);
		$totdeduct1 = $mgtfee1+$mgtvat1+$advance1+$bankexp1+$disburse1;
		$totdeduct = number_format($totdeduct1,2);
		$netpayable1 = $ztotpaid1-$totdeduct1;
		$netpayable = number_format($netpayable1,2);
		
	$html.='<tr><th colspan=2 class="hz1">Totals </th><th class="right">'.$zdeposit.'</th>
	<th class="right">'.$zarrears.'</th><th class="right">'.$zamtdue.'</th> 
	<th class="right">'.$ztotdue.'</th><th class="right">'.$zpaid.'</th><th class="right">'.$zbcf.'</th></tr></table>';
	$html.='<br><br><div style="clear: both;position: relative;">
	<div style="position: absolute;left: 5px;width: 40%;">
	<table><th colspan=2>Collections</th></tr>
	<tr><th>Rent Collected</th><td class="right">'.$zpaid.'</td></tr>
	<tr><th>Deposit Paid</th><td class="right">'.$zdeposit.'</td></tr>
	<tr><th>Total Collection</th><td class="right">'.$ztotpaid.'</td></tr>
	<tr><th colspan=2>Deductions</th></tr>
	<tr><th>Management Fee</th><td class="right">'.$mgtfee.'</td></tr>
	<tr><th>Management Fee VAT</th><td class="right">'.$mgtvat.'</td></tr>
	<tr><th>Advance to LLord</th><td class="right">'.$advance.'</td></tr>
	<tr><th>Bank Transfer Fee</th><td class="right">'.$bankexp.'</td></tr>
	<tr><th>Other Expenses</th><td class="right">'.$disburse.'</td></tr>
	<tr><th>Total Deductions</th><td class="right">'.$totdeduct.'</td></tr>
	<tr><th colspan=2>Payable to the Landlord</th></tr>
	<tr><th>Net Payable</th><td class="right">'.$netpayable.'</td></tr>
	</table>
	</div>
	<div style="margin-left: 41%;">
	</div>
	<div style="margin-left: 60%;">
	<table><tr><th class="th">Prepared BY: </th><td class="td">'.$clerk.'</td></tr>
	<tr><th class="th">Approved By:</th><td class="td">________________________</td></tr>
	<tr><th class="th">Cheque No:</th><td class="td">'.$chqno.'</td></tr>
	<tr><th class="th">Statement Type:</th><td class="td">'.$statype.'</td></tr>
	<tr><th class="th">Date Remitted: </th><td class="td">'.$rdate.'</td></tr>
	</table>
	</div></div>
	</body></html>';
require 'vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHTML($html);
$dompdf->setpaper('A4','portrait');
$dompdf->render();
$dompdf->stream('remit',array("attachement"=>0));
?>