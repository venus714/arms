<?php
$date2=date("Y-m-d");
$dys= strtotime("-3 months");
$date1 = date("Y-m-d",$dys);
require 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plots = 'select plotcode,plotname from plots';
$rez = $conn->query($plots);
$accno1 = "select accno,bankname from banks";
$accno2 = $conn->query($accno1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Receipt per Bank</title>
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
<h3> Left Side Bar</h3>
</div>

<div class='middle2'>
<h4 class='header'>Payments by Bank</h4>
<!--<div id='msg'></div>-->
<div class='mypara'>
<form method='POST' action='recptbankpdf.php' autocomplete='off'>
<input type='hidden' autocomplete='false'>
<table>
<tr>
<th>Bank Name</th>
<td><select name ='accno' id='accno' style='width:200px;height: 25px;'>
<?php
while ($row1=$accno2->fetch_assoc()) 
{
	$accno= $row1['accno'];
	$bankname = $row1['bankname'];
echo "<option value='$accno'>$bankname</option>";
}
?>
</select><td>
</tr>
</tr>
<th>First Date</th>
<td><input type='date' name='date1' id='date1' value='<?php echo $date1;?>'></td>
<th>End Date</th>
<td><input type='date' name='date2' id='date2' value='<?php echo $date2;?>'></td>
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
<div class='side3'>
</div>
</div>
<script>
		
		$(document).ready(function() {
		$('#viw').click(function(e) {
		e.preventDefault();
		document.getElementById('pdf').disabled=false;
		var date1 = $('#date1').val();
		var date2 = $('#date2').val();
		var plotcode = $('#plotcode').val();
		var accno = $('#accno').val();
		if (document.getElementById('chk1').checked)
		{
		var opt=1;
		} else { 
		var opt=0;
		}
		//alert(opt);
		$.ajax({
			method: 'post',
			url: 'recptbank.php',
			data: {'plotcode':plotcode,'date1': date1,'date2': date2,'accno': accno,'opt': opt},
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