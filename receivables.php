<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$qry1 = "select * from receivables";
$qry2 = $conn->query($qry1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Receivables</title>
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
		text-align: left;
		
			}
	
	.table,.td,.th {
	border: 1px solid blue;
	border-collapse: collapse;
}
	</style>
</head>
<body>
<div class='row'>
<div class='side' style='background-color: rgb(0,150,255)'>
<div class='gallery1'>
<img src= '../images/apart4.jfif'>
</div>
</div>
<?php include 'myheader.php';?>
<div class='side' style='background-color: rgb(0,150,255)'>
<div class='gallery1'>
<img src= '../images/apart6.jfif'>
</div>
</div>
</div>
<div class='menu'>
<?php include 'mymenu.php';?>
</div>
<div class='row'>
<div class='middle'>
<div class='mypara'>
<h4 class='header'>Add Receivable Items</h4>
<form method='post'>
<table>
<tr>
<th>Receivable Code</th>
<td><input type='text' name='pcode' id='pcode' value='' readonly></td>
<td></td>
</tr>
<th>Receivable Description</th>
<td><input type='text' name='pname' id='pname' value='' readonly></td>
<td></td>
</tr>
<th style='text-align: right';><button type='button' name='add' id='add' onclick='writable()'>Add</button></th>
<td style='text-align: center';><button type='button' name='save' id='save' onclick='writedata()'disabled>Save</button></td>
<td><input type='reset' name='reset' id='reset' value='Reset' onclick='revert()' disabled></td>
</table>
</form>
</div>
</div>

<script>
function writable()
{
	 document.getElementById("save").disabled= false;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("pcode").readOnly= false;
	 document.getElementById("pcode").value= '';
	 document.getElementById("pcode").focus();
	 document.getElementById("pname").readOnly= false;
	 document.getElementById("pname").value= '';
}
</script>

<script>
function revert()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
	document.getElementById("reset").disabled= true;
	document.getElementById("pcode").readOnly= true;
	document.getElementById("pname").readOnly= true;
	document.getElementById("pcode").value= '';
	document.getElementById("pname").value= '';
	document.getElementById("add").focus();
}
</script>

<script>
function writedata()
{
	document.getElementById("add").disabled= false;
	document.getElementById("reset").disabled= true;
	document.getElementById("save").disabled= true;
	var pcode = document.getElementById("pcode").value;
	var pname = document.getElementById("pname").value;
	document.getElementById("pcode").readOnly=true;
	document.getElementById("pname").readOnly=true;
	
	var frmdata ='pcode='+pcode + '&pname='+pname;
	if (pcode=='')
	{
		alert('Enter Receivable Details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "payitems.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 success: function(data) {
			 $('#msg').html(data);
		 }
		 		 		 });
			}	 
		//return false;
		
}
</script>

<div class='middlebar'>
<h3 class='header'> List of Receivables</h3>
<div id='msg'>
<table class='table'>
<tr>
<th class='th'>Pay Code</th><th class='th'>Payment Name</th>
</tr>
<?php
while ($row=$qry2->fetch_assoc())
{
	$pcode= $row['pcode'];
	$description = $row['description'];
echo "<tr>";
echo "<td class='td'>$pcode</td><td class='td'>$description</td>";
echo "</tr>";
}
echo "</table>";
?>
</div>
</div>
</div>
</body>
</html>