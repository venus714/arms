<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);

$recno1 ='select MAX(recptno) as recptno from receipts';
$recno2 = $conn->query($recno1);
$db1 = $recno2->fetch_assoc();
$recptno = $db1['recptno'];

$header1="select cname,bdescript,location,telephone,email from setup";
$header= $conn->query($header1);
$row=$header->fetch_assoc();
$cname=$row['cname'];
$bdescript=$row['bdescript'];
$location=$row['location'];
$telephone=$row['telephone'];
$email = $row['email'];

$tenant1 ="select housecode,tenantcode,tenant,recptno,trans_date,plotname from receipts inner join plots on 
receipts.plotcode=plots.plotcode where recptno='$recptno'"; 
$tenant2 =$conn->query($tenant1);
$row1=$tenant2->fetch_assoc();
$tenant=$row1['tenant'];
$recptno = $row1['recptno'];
$plotname = $row1['plotname'];
$hsecode = $row1['housecode'];
$date1 = $row1['trans_date'];


$sql1 = "select exprent,paid,pcode,descript from receipts where recptno='$recptno'";
$result = $conn->query($sql1);

$qr1 = "select sum(exprent) as exprent, sum(paid) as paid,sum(exprent-paid) as balance from receipts
where recptno='$recptno' group by tenantcode";
$result1 = $conn->query($qr1);
$row3 = $result1->fetch_assoc();
$totdue = $row3['exprent'];
$totpaid = $row3['paid'];
$balcf = $row3['balance'];


$html='<!DOCTYPE HTML>
<html>
<head>
<title>Payment Voucher</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">

<style>
*{
	box-sizing: border-box;
	} 
	table {
		width: 100%;
		border-collapse: collapse;
	}
	th,td {
		padding: 10px;
		text-align: left;
		border: 1px solid black;
	}
	p {
		padding: 1px;
	}
	
	.zentre {
		text-align: center;
	}
	
	.zright {
		text-align: right;
	}
.box1 {
  float: left;
  width: 40%;
  padding: 1px;
}

.box2 {
  float: left;
  width: 20%;
  padding: 1px;
}

.clearfix::after {
  content: "";
  clear: both;
  display: table;
}
</style>
</head>
<body>
<p class="zentre">'.$cname.'</p>
<p style="text-align: center">'.$bdescript.'</p>
<p style="text-align: center">Telephone Nos :'.$telephone.' Email Address : ' .$email.'</p>
<p style="text-align: center">'.$location.'</p>
<hr>
<p style="text-align: center">Receipt</p>
<br>
<div class="clearfix">
<div class="box1">
<p> Payeee Name : '.$tenant.'</p>
<p> Unit Number: '.$hsecode.'</p>
<p> Property Name: '.$plotname.'</p>
</div>
<div class="box2">
</div>
<div class="box1">
<p class="zright"> Receipt No : '.$recptno.'</p>
<p class="zright"> Date Receipted : '.$date1.'</p>
</div>
</div>

<table><tr><th>Pay Code</th><th>Description</th><th>Amount due</th><th>Amount Paid</th><th>Balance</th></tr>';
while ($row2=$result->fetch_assoc())
{
$pcode=$row2['pcode'];
$descript=$row2['descript'];
$exprent=$row2['exprent'];
$paid=$row2['paid'];
$balance=$row2['exprent']-$row2['paid'];
$html.='<tr><td>'.$pcode.'</td><td>'.$descript.'</td><td>'.$exprent.'</td><td>'.$paid.'</td><td>'.$balance.'</td></tr>';
}
$html.='<tr><td colspan="2">Summation Totals..</td><td>'.$totdue.'</td><td>'.$totpaid.'</td><td>'.$balcf.'</td></tr>
</table></body></html>';

require 'vendor/autoload.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHTML($html);
$dompdf->setpaper('A5','portrait');
$dompdf->render();
$dompdf->stream('myrecept',array("attachement"=>0));
?>