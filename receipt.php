<?php
$mdate=date('Y/m/d');
$nmonth=date("m");
$nyear = date("Y");
$plotcode ='1';
require 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plots = 'select plotcode,plotname from plots';
$rez = $conn->query($plots);

$paycode1= "select pcode,description from receivables";
$paycode = $conn->query($paycode1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Receipting</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<script src ="https://code.jquery.com/jquery-3.3.1.js"></script>
<style> 
	table {
		width: 100%;
		border: 1px solid black;
	}
	
	th,td {
		padding: 5px;
		text-align: left;
	}
	
	input[type="text"],input[type="date"] {
     width: 100%; 
     height: 30px;
	 box-sizing: border-box;
     -webkit-box-sizing:border-box;
     -moz-box-sizing: border-box;
}
	</style>
</head>
<script>
function addRows(){
	var table = document.getElementById('emptbl');
	var rowCount = table.rows.length;
	var cellCount = table.rows[0].cells.length; 
	var row = table.insertRow(rowCount);
	for(var i =0; i <= cellCount; i++){
		var cell = 'cell'+i;
		cell = row.insertCell(i);
		var copycel = document.getElementById('col'+i).innerHTML;
		cell.innerHTML=copycel;
}}
function deleteRows(){
	var table = document.getElementById('emptbl');
	var rowCount = table.rows.length;
	if(rowCount > '2'){
		var row = table.deleteRow(rowCount-1);
		rowCount--;
	}
	else{
		alert('There should be atleast one row');
	}
}

function clearows(){
	var table = document.getElementById('emptbl');
	var rowCount = table.rows.length;
	while (rowCount > '2'){
		var row = table.deleteRow(rowCount-1);
		rowCount--;
}
}
</script>

<body>
<div class='menu'>
<?php include 'mymenu.php';?>
</div>

<?php include 'myheader3.php';?>

<div class='row'>
<div class='sidebar'>
<div class='mypara'>
<form method='POST' action='' autocomplete='off'>
<input type='hidden' autocomplete='false'>
<table>
<tr>
<th>Date</th>
<td><input type='text' name='mdate' id='mdate' value='<?php echo $mdate;?>' readonly></td>
<tr>
<th>Property</th>
<td><select  name='plotcode' id='plotcode' disabled onblur='listenants(this.value)' style='width: 200px;height:25px'>
<?php
while ($row=$rez->fetch_assoc()) {
	$plotcode=$row['plotcode'];
	$plotname = $row['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
?>
</select><td>
</tr>
<th>Month</th>
<td><input type='text' name='nmonth' id='nmonth' value='<?php echo $nmonth;?>' style='width: 80px;' readonly onblur='zmonth()'></td>
</tr>
<th></th>
<td><input type='hidden' name='nyear' id='nyear' value='<?php echo $nyear;?>' style='width: 80px;' readonly></td>
</tr>

<tr>
<th>PayMode</th>
</tr>
<tr><th></th><td></td></tr>
<tr>
<th></th>
<td><input type='radio' id='mpesa' name='paymode' value='5' onclick='bankdtls()' disabled>Mpesa</td>
<tr>
<th></th>
<td><input type='radio' id='bank' name='paymode' value='3' onclick='bankdtls()' disabled>Banked</td>
<tr>
<th></th>
<td><input type='radio' id='cheque' name='paymode' value='3' onclick='bankdtls()' disabled>Cheque</td>
<tr>
<th></th>
<td><input type='radio' id='llord' name='paymode' value='4' onclick='bankdtls()' disabled>Landlord</td>
</tr>
<tr>
<th></th>
<td><input type='radio' id='cash' name='paymode' value='1' disabled>Cash</td>
</tr>
<tr>
<th>
<button type='button' name='btn1' id='btn1' onclick='propfocus()'>New</button>
</th>

</tr>
<tr><th></th><td></td></tr>
</table>
</form>
</div>
</div>

<div class='sidebar'>
<div id='msg'>
</div>
<br><br>
<div id='msg2'>
</div>
</div>

<div class='middlebar'>
<div id='msg1'>
</div>
<div id='msg3'>
</div>
</div>
</div>

<script>
function propfocus()
{
	document.getElementById('plotcode').disabled=false;
	document.getElementById('plotcode').focus();
	//document.getElementById('nmonth').readOnly=false;
}

function listenants(str) {
  document.getElementById('msg3').style.display="none";
  if (str == "") {
    document.getElementById("msg").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("msg").innerHTML = this.responseText;
  }
  xhttp.open("GET", "proptenants.php?q="+str);
  xhttp.send();
}

function zmonth()
{
	var status=document.getElementsByClassName('chk1');
	var tenant= document.getElementsByClassName('tenant');
	var hsecode= document.getElementsByClassName('hsecode');
	var tenantcode= document.getElementsByClassName('tenantcode');
	var plotcode = document.getElementById('plotcode').value;
	var nmonth = document.getElementById('nmonth').value;
	var paymode = document.getElementsByName('paymode');
	//document.getElementById('mpesa').focus();
	//document.getElementById('mpesa').checked=true;
	for (i=0;i<paymode.length;i++)
	{
		paymode[i].disabled=false;
	}
	
	for (i=0;i<status.length;i++)
	{
		if (status[i].checked==true){
		hsecode1=hsecode[i].value;
		tenant1=tenant[i].value;
		tenantcode1=tenantcode[i].value
		}}
		frmdata= 'hsecode1='+hsecode1+'&tenant1='+tenant1+'&tenantcode1='+tenantcode1+'&plotcode='+plotcode+'&nmonth='+nmonth;
		//alert(frmdata);
		
		$.ajax({
		 type: "POST",
		 url: "balcf.php", 
		 data: frmdata,
		 cache:false,
		 success: function(data) {
		$('#msg1').html(data);
		}

		 		 		 });
		}

function gmonth()
{
	var status=document.getElementsByClassName('chk1');
	var tenant= document.getElementsByClassName('tenant');
	var hsecode= document.getElementsByClassName('hsecode');
	document.getElementById('nmonth').readOnly=false;
	document.getElementById('nmonth').focus();
	for (i=0;i<status.length;i++)
	{
		if (status[i].checked==true){
		hsecode[i].style.color='blue';
		tenant[i].style.color='blue';
		}}
		}
function bankdtls()
{
	$.ajax({
		 type: "POST",
		 url: "bankdtls.php", 
		 //data: frmdata,
		 cache:false,
		 success: function(data) {
		$('#msg2').html(data);
		}

		 		 		 });
		}
function itemdtls()
{
	document.getElementById('msg3').style.display= "block";
}

function recptupdate()
{
	var totpaid = document.getElementById('chkamt').value;
	var recdesc = document.getElementById('desc').value;
	frmdata= 'totpaid='+totpaid + '&recdesc='+recdesc;
	//alert(frmdata);
	
	$.ajax({
		 type: "POST",
		 url: "recptupdate.php", 
		 data: frmdata,
		 cache:false,
		 success: function(data) {
		$('#msg3').html(data);
		}

		 		 		 });
		}

function writedata()
{
	document.getElementById('btn2').disabled=true;
	document.getElementById('btn3').disabled=true;
	document.getElementById('btn4').disabled=false;
	var mdate = document.getElementById('mdate').value;
	var plotcode = document.getElementById('plotcode').value;
	var nmonth = document.getElementById('nmonth').value;
	var nyear = document.getElementById('nyear').value;
	var refno = document.getElementById('ref').value;
	var dbanked = document.getElementById('dbanked').value;
	var acno = document.getElementById('acno').value;
	var recdesc = document.getElementById('desc').value;
	var chk =document.getElementsByName('chk1');
	var hsecode =document.getElementsByName('hsecode');
	var tenant =document.getElementsByName('tenant');
	var tenantcode =document.getElementsByName('tenantcode');
	var paymode=document.getElementsByName('paymode');
	var pcode = document.getElementsByClassName('pcode');
	var pcode1 = Array.from(pcode);
	var descript = document.getElementsByClassName('descript');
	var descript1 = Array.from(descript);
	var amtdue = document.getElementsByClassName('amtdue');
	var amtdue1 = Array.from(amtdue);
	var paid = document.getElementsByClassName('paid');
	var paid1 = Array.from(paid);
	
	for (i=0;i<chk.length;i++)
	{
		if(chk[i].checked)
		{
			hsecode1=hsecode[i].value;
			tenant1=tenant[i].value;
			tenantcode1=tenantcode[i].value;
		}
	}
	
	for (i=0;i<paymode.length;i++)
	{
		if(paymode[i].checked)
		{
			zmode=paymode[i].value;
		}
	}
	
	for (i=0;i<paymode.length;i++)
	{
		paymode[i].disabled=true;
	}
	
	for (i=0;i<pcode.length;i++)
		{
			pcode1[i]=pcode[i].value;
}
	
	for (i=0;i<descript.length;i++)
		{
			descript1[i]=descript[i].value;
}

for (i=0;i<amtdue.length;i++)
		{
			amtdue1[i]=amtdue[i].value;
}

for (i=0;i<paid.length;i++)
		{
			paid1[i]=paid[i].value;
}

	frmdata = 'plotcode='+plotcode+ '&mdate='+mdate +'&nmonth='+nmonth + '&nyear='+nyear + '&zmode='+zmode+'&hsecode1='+hsecode1+'&tenant1='+tenant1
	+'&tenantcode1='+tenantcode1+'&refno='+refno + '&dbanked='+dbanked + '&acno='+acno+ '&recdesc=' + recdesc+ '&zmode='+zmode
	+ '&pcode1[]='+ pcode1 + '&descript1[]='+descript1+ '&amtdue1[]='+amtdue1 + '&paid1[]='+paid1;
	//alert(frmdata);
	
	$.ajax({
		 type: "POST",
		 url: "recptsave.php", 
		 data: frmdata,
		 cache:false,
		 success: function(data) {
		$('#recptno').html(data);
		}
		 
		 });
		}
</script>
<script>
function recptprint()
{
	var recptno =document.getElementById('recno').value;
	
	frmdata = 'recptno='+recptno;
	//alert(frmdata);
	$.ajax({
		 type: "POST",
		 url: "recptprint.php", 
		 data: frmdata,
		 cache:false,
		 });
}
</script>
</body>
</html>