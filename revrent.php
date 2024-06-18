<?php
$date2=date("Y-m-d");
$dys= strtotime("-3 months");
$date1 = date("Y-m-d",$dys);
$nmonth=date("m");
$nyear = date("Y");
$plotcode ='1';
require 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plots = 'select plotcode,plotname from plots';
$rez = $conn->query($plots);
$pcode1 ="select pcode from receivables";
$pcode2 = $conn->query($pcode1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Remitted Rent Statement</title>
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
<h4 class='header'>Reverse Remitted Rent Statement</h4>
<div id='msg'></div>
<div class='mypara'>
<form method='POST' action='remit2pdf.php' autocomplete='off'>
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
<th>Pay Code</th>
<td><select name='pcode' id='pcode' style='width: 150px; height: 25px'>
<?php
while ($row1=$pcode2->fetch_assoc())
{
	$pcode=$row1['pcode'];
echo "<option value='$pcode'>$pcode</option>";
}
?>
</select></td>
</tr>
<tr>
<th> Month Remitted</th>
<td><input type='text' name=nmonth id='nmonth' value='<?php echo $nmonth;?>'></td>
<th> Year</th>
<td><input type='text' name=nyear id='nyear' value='<?php echo $nyear;?>' onblur='dremit()'></td>
</tr>
<tr>
<th>Date Remitted</th>
<td id='remdate'> <input type='text' value=''></td>
<th>Reverse Remittance</th>
<td><input type='checkbox' name='chk1' id='chk1'>Check To Reverse</td>
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
function dremit()
{
	var plotcode=document.getElementById('plotcode').value;
	var nmonth = document.getElementById('nmonth').value;
	var nyear = document.getElementById('nyear').value;
	var pcode = document.getElementById('pcode').value;
	
	var frmdata = 'plotcode='+plotcode+'&nmonth='+nmonth+'&nyear='+nyear+'&pcode='+pcode;
//alert(frmdata);
if (plotcode==''){
		alert('Enter All the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "dateremitted2.php", 
		 data: frmdata,
		 cache: false,
		 dataType: "text",
		success: function(data) {
		$('#remdate').html(data);
		}
		 		 		 });
						}	 
		
}
</script>

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
	var rdate = document.getElementById("dremit").value;
	var nmonth = document.getElementById("nmonth").value;
	var nyear = document.getElementById("nyear").value;
	var pcode = document.getElementById('pcode').value;
	if (document.getElementById('chk1').checked)
	{
		remit='1';
	} else { 
		remit='0';
	}
	var frmdata ='plotcode='+plotcode + '&rdate='+ rdate + '&nmonth='+nmonth + '&nyear='+nyear+'&pcode='+pcode
	+'&remit='+remit;
	
	//alert(frmdata);
	if (plotcode==''){
		alert('Enter All the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "revremit.php", //call storeemdata.php to store form data
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