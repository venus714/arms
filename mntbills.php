<?php
$nmonth=date("m");
$nyear = date("Y");
$plotcode ='1';
require 'configure.php';
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
		border-collapse: collapse;
	}
	th,td {
		padding: 10px;
		text-align: left;
	}
	
	.chkbox {
		width: 20px;
		height: 20px;
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
<h4 class='header'>Previw/Print Month Bills</h4>
<div id='msg'></div>
<div class='mypara'>
<form method='POST' action='mntbillpdf.php' autocomplete='off'>
<input type='hidden' autocomplete='false'>
<table>
<tr>
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
<tr><th>One Property</th><td><input type='checkbox' name='chk1' id='chk1' class='chkbox' onclick='enableprop()'></td>
<th> Property Name</th>
<td><select  name='plotcode' id='plotcode' disabled>
<?php
while ($row=$rez->fetch_assoc()) {
	$plotcode=$row['plotcode'];
	$plotname = $row['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
?>
</select><td>
<tr>
<th></th>
<td></td>
</tr>
</table>
<div class='hz'>
<button type='button' name='viw' id ='viw' class='button1'>View</button>
<input type='submit' name='pdf' id='pdf' value='TOPDF'disabled class='button1'>
</div>
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
		
		$(document).ready(function() {
		$('#viw').click(function(e) {
		e.preventDefault();
		document.getElementById('pdf').disabled=false;
		var nmonth = $('#nmonth').val();
		var nyear = $('#nyear').val();
		var plotcode = $('#plotcode').val();
		var pcode = $('#pcode').val();
		if (document.getElementById('chk1').checked)
		{
		var opt=1;
		} else { 
		var opt=0;
		}
		//alert(opt);
		$.ajax({
			method: 'post',
			url: 'monthbills.php',
			data: {'plotcode':plotcode,'nmonth': nmonth,'nyear': nyear,'pcode': pcode,'opt': opt},
			dataType: "text",
			success: function(response) {
				$('#mydata').html(response);
			}
					
		});
		});
		});
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
</body>
</html>