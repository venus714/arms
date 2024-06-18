<?php
$date2=date("Y-m-d");
$dys= strtotime("-3 months");
$date1 = date("Y-m-d",$dys);
$plotcode ='1';
require 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plots = 'select plotcode,plotname from plots';
$rez = $conn->query($plots);
$item1 ="select pcode from receivables order by pcode";
$item2 = $conn->query($item1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Tenant Statement</title>
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
<h4 class='header'>Generate Tenant Statement</h4>
<div id='msg'></div>
<div class='mypara'>
<form method='POST' action='statpdf.php' autocomplete='off'>
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
<th>Item Code</th>
<td><select  name='pcode' id='pcode' style='width: 100px;height: 25px'>
<?php
while ($row1=$item2->fetch_assoc()) {
	$pcode=$row1['pcode'];
	echo "<option value='$pcode'>$pcode</option>";
}
?>
</select></td>
</tr>
<tr>
<th><input type='checkbox' name='chk1' id='chk1' value='' onclick='enableunits()' disabled>One Premises</th>
<td><div id='hsehint'>
<select name='hsecode' style='width: 150px; height: 25px' disabled>
<option>select a unit</option>
</select>
</div>
</td>
</tr>

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
	var pcode = document.getElementById("pcode").value;
	if (document.getElementById('chk1').checked)
	{
		document.getElementById('chk1').value=1;
	} else {
		document.getElementById('chk1').value=0;
	}
	var check =document.getElementById('chk1').value;
	var tenantcode = document.getElementById('hsecode').value;
	//alert(plotcode);
	var frmdata ='plotcode='+plotcode + '&date1='+ date1 + '&date2=' +date2 +'&pcode='+pcode+'&check='+check+'&tenantcode='+tenantcode;
	//alert(frmdata);
	if (plotcode==''){
		alert('Enter All the details');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "genstat.php", //call storeemdata.php to store form data
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

<script>
function showhse(str) {
	document.getElementById('chk1').disabled=false;
  if (str == "") {
    document.getElementById("hsehint").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("hsehint").innerHTML = this.responseText;
  }
  xhttp.open("GET", "gethse.php?q="+str);
  xhttp.send();
}

</script>
<script>
function enableunits()
{
	var x=document.getElementById('chk1');
	if (x.checked==true)
	{
		document.getElementById('hsecode').disabled=false;
	} else { document.getElementById('hsecode').disabled=true;
	}
	
}
</script>
</body>
</html>