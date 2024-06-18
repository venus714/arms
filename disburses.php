<?php
$date2=date("Y-m-d");
$dys= strtotime("-3 months");
$date1 = date("Y-m-d",$dys);
$plotcode ='1';
require 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plots = 'select plotcode,plotname from plots';
$rez = $conn->query($plots);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Disbursements Report</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
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
<h4 class='header'>Disbursements Report</h4>
<div id='msg'></div>
<div class='mypara'>
<form method='POST' action='disbursepdf.php' autocomplete='off'>
<input type='hidden' autocomplete='false'>
<table>
<tr>
<th> Property Name</th>
<td><select  name='plotcode' id='plotcode' style='width: 150px;height: 25px' onclick='showhse(this.value)'>
<?php
while ($row=$rez->fetch_assoc()) {
	$plotcode=$row['plotcode'];
	$plotname = $row['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
?>
</select></td>
</tr>
<tr>
<th>Start Date</th>
<td><input type='date' name='date1' id='date1' value='<?php echo $date1;?>'></td>
<th>End Date</th>
<td><input type='date' name='date2' id='date2' value='<?php echo $date2;?>' ></td>
</tr>
<tr>
<th></th>
<td><button type='button' name='ok' id='ok' onclick='generate()'>Okay</button></td>
<td><input type='submit' name='pdf' id ='pdf' value='SEND TO PDF' disabled></td>
</tr>
</table>
<br>
</form>
</div>
<div id='mydata' class='mypara'> List will come here</div>
</div>
<div class='side'>
<h3 class='header'> Right SideBar</h3>
</div>
</div>
<script>
function generate() {
	document.getElementById('pdf').disabled=false;
	var plotcode = document.getElementById("plotcode").value;
	var date1 = document.getElementById("date1").value;
	var date2 = document.getElementById("date2").value;
	//alert(plotcode);
	var frmdata ='plotcode='+plotcode + '&date1='+ date1 + '&date2=' +date2;
	//alert(frmdata);
	if (plotcode==''){
		alert('Enter All the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "disburserepo.php", //call storeemdata.php to store form data
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
</body>
</html>