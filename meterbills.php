<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$zplots ="select plotcode,plotname from plots";
$myplots = $conn->query($zplots);

$payitems ="select pcode,description from receivables where pcode!='01'";
$paycodes = $conn->query($payitems);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Setup Meter Bills</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<script src ="https://code.jquery.com/jquery-3.3.1.js"></script>
<style> 
	table {
		width: 100%;
	}
	th,td {
		padding: 5px;
	}
	
	input[type="text"],input[type="number"] {
     width: 100%; 
     height: 30px;
	 box-sizing: border-box;
     -webkit-box-sizing:border-box;
     -moz-box-sizing: border-box;
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
<h3 class='header'>Left SideBar</h3>
</div>
<div class='middle'>
<div class='mypara'>
<form method='post' action=''>
<table>
<tr><th>Property Name</th>
<td><select name='propcode' id ='propcode' style='width:150px;height:25px;'>
<?php 
	while ($row=$myplots->fetch_assoc())
	{
		$plotcode=$row['plotcode'];
		$plotname=$row['plotname'];
	echo "<option value='$plotcode'>$plotname</option>";
	}
	?>
	</select></td>
<th>Payment Code</th>
<td>
<select name='pcode' id='pcode' style='width: 100px; height: 25px'>
<?php
while ($row1=$paycodes->fetch_assoc())
{
	$pcode=$row1['pcode'];
	echo "<option value='$pcode'>$pcode</option>";
}
?>
</select></td>

</tr>
<th>Rate Per Unit</th>
<td> <input type='text' name='rate' id='rate' value='0' style='width: 100px;text-align: right;height: 25px;'></td>
<th></th><td><button type='button' name='btn1' id='btn1' onclick='retrieve()'>Retrieve</button></td>
</table>
</form>
</div>
<div id='mydata' class='mypara'>
</div>
</div>
<script>
function retrieve() {
	document.getElementById('btn1').disabled=false;
	var propcode = document.getElementById("propcode").value;
	var pcode = document.getElementById("pcode").value;
	var rate = document.getElementById("rate").value;

	var frmdata ='propcode='+propcode + '&pcode='+pcode + '&rate='+rate;
	//alert(frmdata);
	if (propcode=='')
	{
		alert('Enter the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "mtrbill.php", 
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

<script>
function getamt()
{
	var lread = document.getElementsByClassName('lread');
	var cread = document.getElementsByClassName('cread');
	var rate = document.getElementsByClassName('rate');
	var amount = document.getElementsByClassName('amount');
	
	for (i=0;i<cread.length;i++)
	{
	amount[i].value=(cread[i].value-lread[i].value)*rate[i].value;
	}
}
</script>

<script>
function billadd()
{
	document.getElementById('btn2').disabled= true;
	document.getElementById('btn3').disabled= true;
	document.getElementById('btn4').disabled= false;
	var checker =document.getElementsByClassName('chek1');
	var amt = document.getElementsByClassName('amount');
	var lread = document.getElementsByClassName('lread');
	var cread = document.getElementsByClassName('cread');
	var rate = document.getElementsByClassName('rate');
	
	for (i=0;i<checker.length;i++)
	{
		if (checker[i].checked==false)
		{
		checker[i].checked= true;
		checker[i].value='1';
		checker[i].disabled=true;
	}}
	
	for (i=0;i<lread.length;i++)
	{ 
	lread[i].readOnly=false;
	}
	
	for (i=0;i<cread.length;i++)
	{ 
	cread[i].readOnly=false;
	}
	
	for (i=0;i<rate.length;i++)
	{ 
	rate[i].readOnly=false;
	}
}

function billedit()
{
	document.getElementById('btn2').disabled=true;
	document.getElementById('btn3').disabled=true;
	document.getElementById('btn4').disabled= false;
	var checker =document.getElementsByClassName('chek1');
	var checkz =Array.from(checker);
	var amt = document.getElementsByClassName('amount');
	var lread = document.getElementsByClassName('lread');
	var cread = document.getElementsByClassName('cread');
	var rate = document.getElementsByClassName('rate');
	
	for (i=0;i<checker.length;i++)
	{
		if (checker[i].checked==true)
		{
		checker[i].value='1';
		checker[i].disabled=true;
		
	}}
	for (i=0;i<checker.length;i++)
	{ 
	checkz[i]=checker[i].value;
	}
	
	for (i=0;i<checker.length;i++)
	{ 
	if (checkz[i]=='1') {
	amt[i].style.color='red';
	lread[i].readOnly=false;
	lread[i].style.color='red';
	cread[i].readOnly=false;
	cread[i].style.color='red';
	rate[i].readOnly=false;
	rate[i].style.color='red';
	}
	}
}
</script>

<script>
function billsave()
{
	document.getElementById('btn2').disabled=false;
	document.getElementById('btn3').disabled=false;
	document.getElementById('btn4').disabled=true;
	
	var plotcode = document.getElementById("propcode").value;
	var pcode = document.getElementById("pcode").value;
	
	var checker =document.getElementsByClassName('chek1');
	var checkz =Array.from(checker);

	var amt = document.getElementsByClassName('amount');
	var amt1 =Array.from(amt);
	
	
	var hzecode = document.getElementsByClassName('hsecode');
	var hzecode1 =Array.from(hzecode);
	
	var lread = document.getElementsByClassName('lread');
	var lread1 =Array.from(lread);
	
	var cread = document.getElementsByClassName('cread');
	var cread1 =Array.from(cread);
	
	var rate = document.getElementsByClassName('rate');
	var rate1 =Array.from(rate);
	
	for (i=0;i<checker.length;i++)
	{
		if (checker[i].checked==true)
		{
		checker[i].value='1';
		checker[i].disabled=true;
		
	}}
	
	for (i=0;i<checker.length;i++)
	{ 
	checkz[i]=checker[i].value;
	}
	
	for (i=0;i<amt.length;i++)
	{ 
	amt1[i]=amt[i].value;
	}
	
	for (i=0;i<hzecode.length;i++)
	{ 
	hzecode1[i]=hzecode[i].value;
	}

	for (i=0;i<lread.length;i++)
	{ 
	lread1[i]=lread[i].value;
	}

	for (i=0;i<cread.length;i++)
	{ 
	cread1[i]=cread[i].value;
	}
	
	for (i=0;i<rate.length;i++)
	{ 
	rate1[i]=rate[i].value;
	}

var frmdata ='plotcode='+plotcode +'&pcode='+pcode + '&hzecode1[]='+hzecode1+'&amt1[]='+amt1 +'&checkz[]='+checkz+
'&lread1[]='+lread1 + '&cread1[]='+cread1 + '&rate1[]='+rate1;
	//alert(frmdata);
	if (plotcode=='')
	{
		alert('Enter the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "mtrbillsave.php", 
		 data: frmdata,
		 cache: false,
		 success: function(data) {
		$('#mydata').html(data);
		}
		 });
		
					}	 
	}

</script>

<div class='side'>
<div class='mypara' style='text-align:center'>
<h4 class='hz' style='color: blue'>Actions</h4>
<button type='button' id='btn2' onclick='billadd()'>Add Amounts</button><br><br>
<button type='button' id='btn3' onclick='billedit()'>Edit Amounts</button><br><br>
<button type='button' id='btn4' onclick='billsave()'>Save Changes</button><br><br>
</div>
</div>
</div>
</body>
</html>