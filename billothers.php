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
<title>Setup OtherBills</title>
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
		padding: 10px;
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
<select name='pcode' id='pcode' style='width: 150px; height: 25px'>
<?php
while ($row1=$paycodes->fetch_assoc())
{
	$pcode=$row1['pcode'];
	echo "<option value='$pcode'>$pcode</option>";
}
?>
</select></td>
</tr>
<th></th><td></td><th></th><td><button type='button' name='btn1' id='btn1' onclick='retrieve()'>Retrieve</button></td>
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
	
	var frmdata ='propcode='+propcode + '&pcode='+pcode ;
	//alert(frmdata);
	if (propcode=='')
	{
		alert('Enter the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "otbill.php", 
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
function billadd()
{
	document.getElementById('btn2').disabled= true;
	document.getElementById('btn3').disabled= true;
	document.getElementById('btn4').disabled= false;
	var checker =document.getElementsByClassName('chek1');
	var amt = document.getElementsByClassName('amount');
	for (i=0;i<checker.length;i++)
	{
		if (checker[i].checked==false)
		{
		checker[i].checked= true;
		checker[i].value='1';
		checker[i].disabled=true;
		
	}}
	for (i=0;i<amt.length;i++)
	{ 
	amt[i].readOnly=false;
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
	amt[i].readOnly=false;
	amt[i].style.color='red';
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


var frmdata ='plotcode='+plotcode + '&hzecode1[]='+hzecode1+'&amt1[]='+amt1 +'&checkz[]='+checkz+'&pcode='+pcode;
	//alert(frmdata);
	if (plotcode=='')
	{
		alert('Enter the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "otbillsave.php", 
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