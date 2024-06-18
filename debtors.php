<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$mdate = date('Y-m-d');
$sql1 = "select pcode,description from receivables";
$sql2 = $conn->query($sql1);

$qr1 = "select plotcode,plotname from plots";
$qr2 = $conn->query($qr1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Debtors</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

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
	
	.right {
		text-align: center;
		padding-right: 10px;
	}
	
	
	.tr1 {
		border-top: 1px solid black;
		border-bottom: 1px solid black;
	}
	
	.chkbox {
		width: 20px;
		height: 20px;
	}
	.th {
		border: none;
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
<h4 class='hz'>Generate Debtors List</h4>
<form method='post' action='debtorspdf.php'>
<table>
<tr>
<th class='th'>As at Date</th>
<td class='th'><input type='date' name='date1' id='date1' value='<?php echo $mdate;?>'></td>

<th class='th'>Payment Code</th>
<td class='th'><select name='itemcode' id ='itemcode' style='width: 150px;height: 25px'>
<?php
while ($row = $sql2->fetch_assoc())
{
	$pcode = $row['pcode'];
	echo "<option value='$pcode'>$pcode</option>";
}
?>
</select></td></tr>
<tr><th class='th'>One Property</th><td class='th'><input type='checkbox' name='chk1' id='chk1' class='chkbox' onclick='enableprop()'></td>
<th class='th'>Property</th>
<td class='th'><select name='plotcode' id='plotcode' style='width: 125px;height: 25px;' disabled>
<?php 
while ($rowz=$qr2->fetch_assoc())
{
	$plotcode=$rowz['plotcode'];
	$plotname=$rowz['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
?>
</select></tr>
</table>
<br><br>
<div class='hz'>
<button type='button' name='btn1' id='btn1' onclick='debtlist()' class='bitton1'>Generate Debtors</button>
<input type='submit' name='btn2' id='btn2' class='button1' disabled value ='TO PDF'>
</form>
</div>
</div>
<div id='mydata' class='mypara'></div>
</div>
<script>
function debtlist()
{
	document.getElementById('btn2').disabled=false;
	var date1 = document.getElementById('date1').value;
	var pcode = document.getElementById('itemcode').value;
	if (document.getElementById('chk1').checked)
	{
		document.getElementById('chk1').value=1;
	} else {
		document.getElementById('chk1').value=0;
	}
	var check =document.getElementById('chk1').value;
	var plotcode = document.getElementById('plotcode').value;
	
	frmdata ='date1='+date1+'&pcode='+pcode +'&plotcode='+plotcode +'&check='+check;
	//alert(frmdata);
	if (date1=='')
	{
		alert('Pick a Date');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "gendebtors.php", //call storeemdata.php to store form data
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
function enableprop()
{
	var x=document.getElementById('chk1');
	if (x.checked==true)
	{
		document.getElementById('plotcode').disabled=false;
	} else { document.getElementById('plotcode').disabled=true;
	}
	
}
</script>
<div class='side'>
<h3 class='header'>Right SideBar</h3>
</div>
</div>