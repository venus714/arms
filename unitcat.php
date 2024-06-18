<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$qry1 = "select * from unitcat";
$qry2 = $conn->query($qry1);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>House Categories</title>
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
	border-collapse: collapse
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
<div id='msg' style='text-align: center';></div>
<h4 class='header'>Add Units Categories</h4>
<form method='post'>
<table>
<tr>
<th>Category Code</th>
<td><input type='text' name='catcode' id='catcode' value='' readonly></td>
<td></td>
</tr>
<th>Category Name</th>
<td><input type='text' name='catname' id='catname' value='' readonly></td>
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
document.getElementById("catname").onkeyup = function() {myFunction()};
function myFunction() {
  var x = document.getElementById("catname");
  x.value = x.value.toUpperCase();
}
</script>

<script>
function writable()
{
	 document.getElementById("save").disabled= false;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("catcode").readOnly= false;
	 document.getElementById("catcode").value= '';
	 document.getElementById("catcode").focus();
	 document.getElementById("catname").readOnly= false;
	 document.getElementById("catname").value= '';
}
</script>

<script>
function revert()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
	document.getElementById("reset").disabled= true;
	document.getElementById("catcode").readOnly= true;
	document.getElementById("catname").readOnly= true;
	document.getElementById("catcode").value= '';
	document.getElementById("catname").value= '';
	document.getElementById("add").focus();
}
</script>

<script>
function writedata()
{
	document.getElementById("add").disabled= false;
	document.getElementById("reset").disabled= true;
	document.getElementById("save").disabled= true;
	document.getElementById("add").focus();
	var catcode = document.getElementById("catcode").value;
	var catname = document.getElementById("catname").value;
	document.getElementById("catname").readOnly=true;
	
	var frmdata ='catcode='+catcode + '&catname='+catname;
	if (catcode=='')
	{
		alert('Enter Category Details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "catcodes.php", //call storeemdata.php to store form data
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
<div class='mypara'>
<h4 class='hz'> Payment Schedule</h4>

<table class='table'>
<tr>
<th class='th'>Cat Code</th><th class='th'>Cat Name</th>
</tr>
<?php
while ($row=$qry2->fetch_assoc())
{
	$catcode= $row['catcode'];
	$catname = $row['catname'];
echo "<tr>";
echo "<td class='td'>$catcode</td><td class='td'>$catname</td>";
echo "</tr>";
}
echo "</table>";
?>
</div>
</div>
</div>
</body>
</html>