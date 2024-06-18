<?php
$date2=date("Y-m-d");
$dys= strtotime("-1 months");
$date1 = date("Y-m-d",$dys);
$nmonth=date("m");
$nyear = date("Y");
//$plotcode ='1';
require 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plots = 'select plotcode,plotname from plots';
$rez = $conn->query($plots);
$item1 = "select pcode from receivables where pcode!='01'";
$item2 = $conn->query($item1);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Remittance Report</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<script src ="https://code.jquery.com/jquery-3.3.1.js"></script>
<style> 
	table {
		width: 100%;
		border-collapse: collapse;
	}
	th,td {
		padding: 10px;
		text-align: left;
		
	}
	.tr1 {
		border-top: 1px solid black;
		border-bottom: 1px solid black;
	</style>
</head>
<body>
<div class='menu'>
<?php include 'mymenu.php';?>
</div>
<?php include 'myheader3.php';?>

<div class='row'>
<div class='side6'>

</div>

<div class='middle3'>
<h4 class='header'>Remittance Report</h4>
<div id='msg'></div>
<div class='mypara'>
<form method='POST' action='remit3pdf.php' autocomplete='off'>
<input type='hidden' autocomplete='false'>
<table>
<tr>
<th> Property Name</th>
<td><select  name='plotcode' id='plotcode' style='width: 150px;height: 25px'>
<?php
while ($row=$rez->fetch_assoc()) {
	$plotcode=$row['plotcode'];
	$plotname = $row['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
?>
</select></td>
<th>Item Code</th>
<td><select  name='pcode' id='pcode' style='width: 150px;height: 25px'>
<?php
while ($row1=$item2->fetch_assoc()) {
	$pcode=$row1['pcode'];
	echo "<option value='$pcode'>$pcode</option>";
}
?>
</tr>
<tr>
<th> Month To Bill</th>
<td><input type='text' name=nmonth id='nmonth' value='<?php echo $nmonth;?>' style='width: 100px'></td>
<th> Year</th>
<td><input type='text' name=nyear id='nyear' value='<?php echo $nyear;?>' style='width: 100px'></td>
</tr>
<tr>
<th>Start Date</th>
<td><input type='date' name='date1' id='date1' value='<?php echo $date1;?>'></td>
<th>End Date</th>
<td><input type='date' name='date2' id='date2' value='<?php echo $date2;?>' ></td>
</tr>
<tr>
<th><label for="remit"> Remit Statement</label></th>
<td><input type='checkbox' name='remit' id='remit' onclick='writable()'>Select To Remit</td>
<th><label>Cheque/refno No</label></th>
<td><input type='text' id='chqno' name='chqno' value='' readonly></th></td>
</tr>
<tr>
<th>Cashier/Manager</th> 
<td><input type='text' id ='clerk' name='clerk' value='' readonly></td>
<th>Statement Type</th>
<td><select id='statype' name='statype' style='width: 150px; height: 25px'>
<option value='Normal Statement'>Normal</option>
<option value='Suplementary Stat'>Suplementary</option>
<option value='Advanced Statement'>Advanced</option>
</select>
</td>
</tr>

<tr>
<th></th>
<td><button type='button' name='ok' id='ok' onclick='generate()'>Okay</button></td>
<td><input type='submit' name='pdf' id ='pdf' value='SEND TO PDF' disabled></td>
</tr>
</table>
<br>
</form>
</div>
<div id='mydata' class='mypara'> List will come here</div>
</div>
<div class='side6'>

</div>
</div>
<script>
function writable()
{
	if (document.getElementById('remit').checked)
	{
	document.getElementById('chqno').readOnly = false;
	document.getElementById('clerk').readOnly = false;
	document.getElementById('statype').disabled = false;
	document.getElementById('chqno').focus();
	} else {
	document.getElementById('chqno').readOnly = true;
	document.getElementById('clerk').readOnly = true;
	document.getElementById('statype').disabled =true;
		
}}
</script>

<script>
function generate() {
	document.getElementById('pdf').disabled=false;
	var plotcode = document.getElementById("plotcode").value;
	var date1 = document.getElementById("date1").value;
	var date2 = document.getElementById("date2").value;
	var nmonth = document.getElementById("nmonth").value;
	var nyear = document.getElementById("nyear").value;
	var pcode = document.getElementById("pcode").value;
	var chqno = document.getElementById("chqno").value;
	var clerk = document.getElementById("clerk").value;
	var statype = document.getElementById("statype").value;
	if (document.getElementById("remit").checked)
	{
		remit='1';
	}else{remit='0';}
	
	var frmdata ='plotcode='+plotcode + '&date1='+ date1 + '&date2=' +date2+'&nmonth='+nmonth + '&nyear='+nyear+'&pcode='+pcode
	+'&chqno='+chqno+'&clerk='+clerk+'&statype='+statype+'&remit='+remit;
	//alert(frmdata);
	if (plotcode==''){
		alert('Enter All the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "clientstat3.php",
		 data: frmdata,
		 cache: false,
		 dataType: "text",
		success: function(data) {
		$('#mydata').html(data);
		}
		 		 		 });
						}	 
		
}
</script>
</body>
</html>