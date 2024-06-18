<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$qry1 = "select * from rentschedule";
$qry2 = $conn->query($qry1);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Rent Schedule</title>
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
		text-align:left;
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
<h4 class='header'>Add Rent Schedule</h4>
<form method='post'>
<table>
<tr>
<th>Quarter Name</th>
<td><input type='text' name='qtr' id='qtr' value='' readonly></td>
<td></td>
</tr>
<th>Months in Quarter</th>
<td><input type='text' name='nmonth' id='nmonth' value='' readonly></td>
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
document.getElementById("qtr").onkeyup = function() {myFunction()};

function myFunction() {
  var x = document.getElementById("qtr");
  x.value = x.value.toUpperCase();
}
</script>

<script>
function writable()
{
	 document.getElementById("save").disabled= false;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("qtr").readOnly= false;
	 document.getElementById("qtr").value= '';
	 document.getElementById("qtr").focus();
	 document.getElementById("nmonth").readOnly= false;
	 document.getElementById("nmonth").value= '';
}
</script>

<script>
function revert()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
	document.getElementById("reset").disabled= true;
	document.getElementById("qtr").readOnly= true;
	document.getElementById("nmonth").readOnly= true;
	document.getElementById("qtr").value= '';
	document.getElementById("nmonth").value= '';
	document.getElementById("add").focus();
}
</script>

<script>
function writedata()
{
	document.getElementById("add").disabled= false;
	document.getElementById("reset").disabled= true;
	document.getElementById("save").disabled= true;
	var qtr = document.getElementById("qtr").value;
	var nmonth = document.getElementById("nmonth").value;
	document.getElementById("qtr").readOnly=true;
	document.getElementById("nmonth").readOnly=true;
	
	var frmdata ='qtr='+qtr + '&nmonth='+nmonth;
	if (qtr=='')
	{
		alert('Enter Rent Schedule all Details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "schedule.php", //call storeemdata.php to store form data
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
<h4 class='header'> Payment Schedule</h4>

<table class='table'>
<tr>
<th class='th'>Code</th>
<th class='th'>Description</th><th class='th'>No. of Months</th>
</tr>
<?php
while ($row=$qry2->fetch_assoc())
{
	$nmonths= $row['nmonths'];
	$description = $row['description'];
	$id = $row['id'];
echo "<tr>";
echo "<td class='td'>$id</td>";
echo "<td class='td'>$description</td><td class='td'>$nmonths</td>";
echo "</tr>";
}
echo "</table>";
?>
</div>
</div>
</div>
</body>
</html>