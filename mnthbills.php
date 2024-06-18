<?php
$nmonth=date("m");
$nyear = date("Y");
$plotcode ='1';
require 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plots = 'select plotcode,plotname from plots';
$rez = $conn->query($plots);
$pcode1 = "select pcode from receivables";
$pcode2 = $conn->query($pcode1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Month Bills</title>
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
	</style>
</head>
<body>
<div class='menu'>
<?php include 'mymenu.php';?>
</div>
<?php include 'myheader3.php';?>

<div class='row'>
<div class='side'>
<h3> Left Side Bar</h3>
</div>

<div class='middle'>
<h4 class='header'>Previw/Print Month Bills</h4>
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
<th>Item Name</th>
<td><select name ='pcode' id='pcode' style='width:100px;height: 25px;'>
<?php
while ($row1=$pcode2->fetch_assoc()) 
{
	$pcode= $row1['pcode'];
echo "<option value='$pcode'>$pcode</option>";
}
?>
</select><td>
</tr>
</tr>
<th>Month</th>
<td><input type='text' name='nmonth' id='nmonth' value='<?php echo $nmonth;?>'></td>
<th>Year</th>
<td><input type='text' name='nyear' id='nyear' value='<?php echo $nyear;?>'></td>
</tr>
<tr>
<th></th>
<td></td>
<td><button type='button' name='viw' id ='viw'>View</button></td>
<td> </td>
</tr>
</table>
<br>
</form>
</div>
<div id='mydata' class='mypara'>
</div>
</div>
<div class='side'>
<h3> Right SideBar</h3>
</div>
</div>
<script>
		
		$(document).ready(function() {
		$('#viw').click(function(e) {
		e.preventDefault();
		var nmonth = $('#nmonth').val();
		var nyear = $('#nyear').val();
		var plotcode = $('#plotcode').val();
		var pcode = $('#pcode').val();
		//alert(plotcode);
		$.ajax({
			method: 'post',
			url: 'otmonthbill',
			data: {'plotcode':plotcode,'nmonth': nmonth,'nyear': nyear,'pcode': pcode},
			dataType: "text",
			success: function(response) {
				$('#mydata').html(response);
			}
					
		});
		});
		});
</script>
</body>
</html>