<?php
$date2=date("Y-m-d");
$dys= strtotime("-3 months");
$date1 = date("Y-m-d",$dys);
$nmonth=date("m");
$nyear = date("Y");
$plotcode ='1';
$advance='';
require 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plots = 'select plotcode,plotname from plots';
$rez = $conn->query($plots);
$rez1 = $conn->query($plots);
$rez2 = $conn->query($plots);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Rent Remittance Report</title>
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
<div class='sidebar'>
<div class='mypara'>
<h3 class='hz'>Amend Advances</h3>
<table>
<tr><th> Ref No.</th><td><input type='search' id='refno' name='refno' value=''></td></tr>
<tr><th colspan=2 class='hz'><button type='button' id='serch' name='serch' onclick='serch()'>Search</button></th></tr>
</table>
</div>
<!--<div id='adv1'></div>-->
<div id='adved'>
</div>

</div>

<script>
function serch()
{
	var refno = document.getElementById('refno').value;
	var frmdata = 'refno='+refno;
//alert(frmdata);
if (refno==''){
		alert('Enter Refno');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "advedit.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 dataType: "text",
		success: function(data) {
		$('#adved').html(data);
		}
		 		 		 });
						}	 


}
</script>
<script>
function editdata()
{
	document.getElementById('date1').readOnly = false;
	document.getElementById('adv').readOnly = false;
	document.getElementById('narr').readOnly = false;
	document.getElementById('btnedit').disabled = true;
	document.getElementById('btnupdate').disabled = false;
}
function updatedata()
{
	var date1= document.getElementById('date1').value;
	var advance = document.getElementById('adv').value;
	var narrative = document.getElementById('narr').value;
	var refno = document.getElementById('refno').value;
	document.getElementById('btnedit').disabled = false;
	document.getElementById('btnupdate').disabled = true;
	var frmdata = 'date1='+date1+'&advance='+advance+'&narrative='+narrative+'&refno='+refno;
	
	//alert(frmdata);
	
	if (refno==''){
		alert('Enter Refno');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "advupdate.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 dataType: "text",
		success: function(data) {
		$('#adv1').html(data);
		}
		 		 		 });
						}	 
}
</script>

<div class='middlebar'>
<div class='mypara'>
<h3 class='hz'>Add Advances</h3>
<table>
<tr><th>Property Name</th>
<td><select  name='plotcode' id='plotcode' style='width: 150px;height: 25px' disabled>
<?php
while ($row1=$rez->fetch_assoc()) {
	$plotcode=$row1['plotcode'];
	$plotname = $row1['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
?>
</select></td>
</tr>
<tr><th>Month</th>
<td><input type='text' name='nmonth' id='nmonth' value='<?php echo $nmonth;?>' readonly></td></tr>
<tr><th> Year</th>
<td><input type='text' name='nyear' id='nyear' value='<?php echo $nyear;?>' readonly></td></tr>
<tr><th>Date </th>
<td><input type='date' name='date1' id='date1' value='<?php echo $date2;?>' readonly></td></tr>
<tr><th> Amount</th>
<td><input type='text' name='adv' id='adv' value='<?php echo $advance;?>' readonly></td></tr>
<tr><th> Narrative</th>
<td><textarea id='narr' rows='5' cols='30' readonly></textarea></td></tr>
</table>
<table>
<tr><th style='text-align: right'><button type='button' id='btn1' onclick='addnew()'>Add</button></th>
<th style='text-align:center'><button type='button' id='btn2' onclick='savenew()' disabled>Save</button></th>
<th style='text-align: center'><input type='reset' id='btn3' name='btn3' value='Reset' disabled></th></tr>
</table>
</div>
</div>
<script>
function addnew() {
	document.getElementById('plotcode').disabled=false;
	document.getElementById("nmonth").readOnly= false;
	document.getElementById("nyear").readOnly= false;
	document.getElementById("date1").readOnly= false;
	document.getElementById("adv").readOnly= false;
	document.getElementById("adv").value= '';
	document.getElementById("narr").readOnly= false;
	document.getElementById("narr").value= '';
	document.getElementById("btn1").disabled= true;
	document.getElementById("btn2").disabled= false;
	document.getElementById("btn3").disabled= false;
}
</script>

<script>
function savenew()
{
	var plotcode= document.getElementById('plotcode').value;
	var nmonth = document.getElementById('nmonth').value;
	var nyear = document.getElementById('nyear').value;
    var date1 = document.getElementById('date1').value;
	var advance = document.getElementById('adv').value;
	var narrative = document.getElementById('narr').value;
	document.getElementById("btn1").disabled= false;
	document.getElementById("btn2").disabled= true;
	document.getElementById("btn3").disabled= true;
	var frmdata ='plotcode='+plotcode+'&nmonth='+nmonth+'&nyear='+nyear+'&date1='+date1+'&advance='+advance+'&narrative='+narrative;
//alert(frmdata);
if (plotcode==''){
		alert('Enter All the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "advsave.php", //call storeemdata.php to store form data
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

<div class='sidebar'>
<div class='mypara'>
<h3 class='hz'>Display Advances</h3>
<table>
<tr><th>Property Name</th>
<td><select  name='plotcode2' id='plotcode2' style='width: 150px;height: 25px'>
<?php
while ($row2=$rez2->fetch_assoc()) {
	$plotcode2=$row2['plotcode'];
	$plotname2 = $row2['plotname'];
echo "<option value='$plotcode2'>$plotname2</option>";
}
?>
</select></td>
</tr>
<tr><th>Month</th>
<td><input type='text' name='nmonth2' id='nmonth2' value='<?php echo $nmonth;?>'></td></tr>
<tr><th> Year</th>
<td><input type='text' name='nyear2' id='nyear2' value='<?php echo $nyear;?>'></td></tr>
<tr><th colspan=2 style='text-align: center'><button type='button' id='disp' onclick='display()'>Display</button></th></tr>
</table>
</div>
<div id='mydata'></div>
</div>
</div>
<script>
function display()
{
	var plotcode2= document.getElementById('plotcode2').value;
	var nmonth2 = document.getElementById('nmonth2').value;
	var nyear2 = document.getElementById('nyear2').value;
    frmdata ='plotcode2='+plotcode2+'&nmonth2='+nmonth2+'&nyear2='+nyear2;
	//alert(frmdata);
	if (plotcode2==''){
		alert('Enter All the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "advpop.php", //call storeemdata.php to store form data
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
