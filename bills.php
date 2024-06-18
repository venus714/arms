<?php
$nmonth=date("m");
$nyear = date("Y");
$plotcode ='1';
require 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plots = 'select plotcode,plotname from plots';
$rez = $conn->query($plots);

$bill1 = "select bills.plotcode,plots.plotname,housecode,tenant,arrears,amtdue from bills
left join plots on bills.plotcode=plots.plotcode where bills.plotcode='$plotcode'
and nyear='$nyear' and nmonth='$nmonth'";
$bill2 = $conn->query($bill1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Generate Rent Bill</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<script src ="https://code.jquery.com/jquery-3.3.1.js"></script>
<style> 
	table {
		width: 100%;
	}
	th,td {
		padding: 10px;
		text-align: left;
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
<h3 class='header'> Left Side Bar</h3>
</div>

<div class='middle'>
<h4 class='header'>Generate Rent Bill</h4>
<div id='msg'></div>
<div class='mypara'>
<form method='POST' action='' autocomplete='off'>
<input type='hidden' autocomplete='false'>
<table>
<tr>
<th> Property Name</th>
<td><select  name='plotcode' id='plotcode'>
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
<td><input type='text' name='nmonth' id='nmonth' value='<?php echo $nmonth;?>' style='width: 80px;'></td>
<th>Year</th>
<td><input type='text' name='nyear' id='nyear' value='<?php echo $nyear;?>' style='width: 80px;' ></td>
</tr>
<tr>
<th></th>
<td><button type='button' name='ok' id='ok' onclick='generate()'>Okay</button></td>
<td><button type='button' name='viw' id ='viw'>View</button></td>
<td> <input type = 'reset' name='reset' id='reset' onclick='revert()' disabled></td>
</tr>
</table>
<br>
</form>
</div>
<div id='mydata' class='mypara'>
</div>
</div>
<div class='side'>
<h3 class='header'> Right SideBar</h3>
</div>
</div>
<script>
function generate() {
	var plotcode = document.getElementById("plotcode").value;
	var nmonth = document.getElementById("nmonth").value;
	var nyear = document.getElementById("nyear").value;
	//alert(plotcode);
	var frmdata ='plotcode='+plotcode + '&nmonth='+nmonth + '&nyear=' +nyear;
	if (plotcode=='')
	{
		alert('Enter Propery Name Name');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "billing.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 dataType: "text",
		success: function(data) {
		$('#msg').html(data);
		}
		 		 		 });
		//location.reload();
					}	 
		//return false;
}
</script>

<script>
		
		$(document).ready(function() {
		$('#viw').click(function(e) {
			e.preventDefault();
		var nmonth = $('#nmonth').val();
		var nyear = $('#nyear').val();
		var plotcode = $('#plotcode').val();
		//alert(plotcode);
		$.ajax({
			method: 'post',
			url: 'monthbill',
			data: {'plotcode':plotcode,'nmonth': nmonth,'nyear': nyear},
			dataType: "text",
			success: function(response) {
				$('#mydata').html(response);
			}
					
		});
		});
		});
</script>
	
<script>
function revert()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
}
</script>
</body>
</html>