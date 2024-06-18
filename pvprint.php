<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$max1 ="select max(id) as refno from disbursement";
$max2 = $conn->query($max1);
$idno = $max2->fetch_assoc();
$refno=$idno['refno'];
$sql1 = "select id,description,trans_date,amount,invno,payee,authority,chequeno,clerk from disbursement where id='$refno'";
$result = $conn->query($sql1);
$sql2 = "select trans_date,payee,plotname from disbursement inner join plots on 
disbursement.plotcode=plots.plotcode where disbursement.id='$refno'";
$result1 = $conn->query($sql2);
$row2=$result1->fetch_assoc();
$payee=$row2['payee'];
$datep= $row2['trans_date'];
$plotname=$row2['plotname'];
$head1 = "select cname from setup";
$head2 = $conn->query($head1);
$hd1 = $head2->fetch_assoc();
$cname=$hd1['cname'];
//$row1=$result->fetch_assoc();
//$name='Joel';

$html='<!DOCTYPE HTML>
<html>
<head>
<title>Payment Voucher</title>
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
	</style>
</head>
<body>
<h2 style="text-align: center">'.$cname.'</h2>
<hr>
<h3 style="text-align: center">Payment Voucher</h3>
<br>
<p style="text-align: right">Date Prepared: '.$datep.'</p>
<p style="text-align: right">Reference No: '.$refno.'</p>

<p> Property Name: '.$plotname.'</p>
<p> Payeee Name : '.$payee.'</p>


<table><tr><th>Refno</th><th>Payment Description</th><th>Invoice No.</th><th>Amount Paid</th></tr>';
$row1=$result->fetch_assoc();
$chequeno = $row1['chequeno'];
$authority = $row1['authority'];
$clerk = $row1['clerk'];
$paid = $row1['amount'];
$invno = $row1['invno'];
$html.='<tr><td>'.$row1['id'].'</td><td>'.$row1['description'].'</td><td>'.$invno.'</td><td>'.$row1['amount'].'</td></tr>
</table>
<br><br>
<p> Prepared By: '.$clerk.'</p>
<p> Cheque No: '.$chequeno.'</p>
<p> Authority '.$authority.'</p>
<p> DIRECTOR/PROPERTY MANAGER/ACCOUNTANT</P>
<br>
<P>Checked By.....................................</P>
<P>Accountant</P>
<br><br>
<p> Receive in Payment of the account stated on the face hereby of the sum Kshs: '.$paid.'</p> 
</body>
</html>'; 


require 'vendor/autoload.php';
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHTML($html);
$dompdf->setpaper('A4','portrait');
$dompdf->render();
$dompdf->stream('myvoucher',array("attachement"=>0));
?>