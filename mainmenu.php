<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$qry1 = "select * from mainmenu";
$qry2 = $conn->query($qry1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Main Menu Items</title>
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
<h4 class='header'>Add Menu Items</h4>
<form method='post'>
<table>
<tr>
<th>Menu Name</th>
<td><input type='text' name='menuname' id='menuname' value='' readonly></td>
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
	 document.getElementById("menuname").readOnly= false;
	 document.getElementById("menuname").value= '';
	 document.getElementById("menuname").focus();
}
</script>

<script>
function revert()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
	document.getElementById("reset").disabled= true;
	document.getElementById("menuname").readOnly= true;
	document.getElementById("menuname").value= '';
	document.getElementById("add").focus();
}
</script>

<script>
function writedata()
{
	document.getElementById("add").disabled= false;
	document.getElementById("reset").disabled= true;
	document.getElementById("save").disabled= true;
	var menuname = document.getElementById("menuname").value;
	document.getElementById("menuname").readOnly=true;
	
	var frmdata ='menuname='+menuname;
	if (menuname=='')
	{
		alert('Enter Menu Name');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "topmenu.php", //call storeemdata.php to store form data
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
<h4 class='hz'> List of Menu Items</h4>
<div id='msg'>
<table class='table'>
<tr>
<th class='th'>Menu Name</th>
</tr>
<?php
while ($row=$qry2->fetch_assoc())
{
	
	$menuname = $row['menuname'];
echo "<tr>";
echo "<td class='td'>$menuname</td>";
echo "</tr>";
}
echo "</table>";
?>
</div>
</div>
</div>
</body>
</html>