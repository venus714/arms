<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$qry1 = "select * from mainmenu";
$qry2 = $conn->query($qry1);

$sql1 = "select menuname,subname from submenu inner join mainmenu on submenu.menuid=mainmenu.id order by menuid";
$sql2 = $conn->query($sql1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Sub Menu Items</title>
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
<h4 class='header'>Add Sub Menu Items</h4>
<form method='post'>
<table>
<tr>
<th>Menu Name</th>
<td><select name='menuname' id='menuname' style='width: 150px; height: 24px;' disabled>
<?php
while ($row=$qry2->fetch_assoc())
{	
$id= $row['id'];
	$menuname= $row['menuname'];
echo "<option value='$id'>$menuname</option>";
}
?>
</select>	
</td>
<th>Sub Menu </th>
<td><input type='text' name='submenu' id='submenu' value='' readonly></td>
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
	 document.getElementById("menuname").disabled= false;
	 document.getElementById("menuname").value= '';
	 document.getElementById("menuname").focus();
	 document.getElementById("submenu").readOnly= false;
	 document.getElementById("submenu").value= '';
}
</script>

<script>
function revert()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
	document.getElementById("reset").disabled= true;
	document.getElementById("menuname").disabled= true;
	document.getElementById("menuname").value= '';
	document.getElementById("submenu").readOnly= true;
	document.getElementById("submenu").value= '';
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
	var submenu = document.getElementById("submenu").value;
	document.getElementById("menuname").disabled=true;
	document.getElementById("submenu").readOnly=true;
	var frmdata ='menuname='+menuname+'&submenu='+submenu;
	if (menuname=='')
	{
		alert('Enter Menu Name');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "subitems.php", //call storeemdata.php to store form data
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
<h4 class='hz'> List of Sub Menu Items</h4>
<div id='msg'>
<table class='table'>
<tr>
<th class='th'>Menu Name</th><th>Sub Menu</th>
</tr>
<?php
while ($row=$sql2->fetch_assoc())
{
	$subname = $row['subname'];
	$menuname = $row['menuname'];
echo "<tr>";
echo "<td class='td'>$menuname</td><td class='td'>$subname</td>";
echo "</tr>";
}
echo "</table>";
?>
</div>
</div>
</div>
</body>
</html>