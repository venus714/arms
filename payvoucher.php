<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$sql1 = "select plotcode,plotname from plots";
$sql2 = $conn->query($sql1);

$date1=date('Y/m/d');
$nyear=date('Y');
$nmonth = date('m');
?>


<!DOCTYPE HTML>
<html>
<head>
<title>Payment Voucher</title>
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
	}
	th,td {
		padding: 10px;
		text-align: left;
	}
	.upper {
		text-transform: uppercase;
	}
	</style>
</head>
<body>
<div class='menu'>
<?php include 'mymenu.php';?>
</div>
<?php include 'myheader3.php';?>

<div class='row'>
<div class='side'>
</div>

<div class='middle'>
<form method='post' action='pvprint.php'>
<h3 class='header'> Payment Voucher</h3>
<div class='mypara'>
<table>
<tr><th>Property Name</th>
<td><select name='plotcode' id='plotcode' value='' style='width: 150px;height: 25px' disabled>
<?php
while ($row=$sql2->fetch_assoc())
{
	$plotcode=$row['plotcode'];
	$plotname=$row['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
echo "</select>";
?>
</td>
</tr>
</table>
</div>
<div class='mypara'>
<table>
<tr>
<th>Payee Name</th><td><input type='text' name='payee' id='payee' value='' readonly></td>
<th>Date</th><td><input type='text' name='date1' id='date1' value='<?php echo $date1;?>' readonly></td>
</tr>
<th>Amount Paid</th><td><input type='text' name='paid' id='paid' value='' readonly></td>
<th>Invoice No.</th><td><input type='text' name='invno' id='invno' value='' readonly></td>
<tr>
<th>Narrative</th><td><textarea id='narr' cols='20' rows='3' readonly></textarea></td>
<th>Authorised By</th><td><input type='text' id='auth' value='' readonly></td>
</tr>
<th>Cheque No.</th><td><input type='text' name='cheque' id='cheque' value='' readonly></td>
<th>Prepared By.</th><td><input type='text' name='clerk' id='clerk' value='' readonly></td>
</table>
<br><br>
<div class='hz'>
<button type='button' id='btn0' onclick='newpv()' class='button1'>Add</button>
<button type='button' id='btn1' onclick='savepv()' class='button1' disabled>Save</button>
<input type='submit' id='btn2' name='btn2' class='button1' value='Print' disabled>
<button type='reset' id='btn3' class='button1' disabled>Reset</button>
</form>
</div>
</div>
</div>
<script>
function newpv() {
  document.getElementById('plotcode').disabled=false;
  document.getElementById('plotcode').focus();
  document.getElementById('payee').readOnly=false;
  document.getElementById('paid').readOnly=false;
  document.getElementById('invno').readOnly=false;
  document.getElementById('narr').readOnly=false;
  document.getElementById('auth').readOnly=false;
  document.getElementById('cheque').readOnly=false;
  document.getElementById('clerk').readOnly=false;
  document.getElementById('btn0').disabled=true;
  document.getElementById('btn1').disabled=false;
  document.getElementById('btn2').disabled=true;
  document.getElementById('btn3').disabled=false;
  }
</script>

<script>
function savepv() {
document.getElementById('btn0').disabled=false;
document.getElementById('btn1').disabled=true;
document.getElementById('btn2').disabled=false;
document.getElementById('btn3').disabled=true;
var plotcode = document.getElementById('plotcode').value;
var payee = document.getElementById('payee').value;
var date1 = document.getElementById('date1').value;
var paid = document.getElementById('paid').value;
var invno = document.getElementById('invno').value;
var narr = document.getElementById('narr').value;
var authority = document.getElementById('auth').value;
var cheque = document.getElementById('cheque').value;
var clerk = document.getElementById('clerk').value;

frmdata= 'plotcode='+ plotcode + '&payee='+payee+'&date1='+date1+'&paid='+paid+'&invno='+invno+'&narr='+narr+
'&authority='+authority+'&cheque='+cheque+'&clerk='+clerk;
//alert(frmdata);

$.ajax({
		 type: "POST",
		 url: "pvsave.php",
		 data: frmdata,
		 cache: false,
		 		 		 });
		
}
</script>
<script>
function printpv()
{
$.ajax({
		 type: "POST",
		 url: "pvprint.php",
		  cache: false,
		 		 		 });
		
}
</script>

<div class='side'>
</div>
</div>
</body>
</html>
