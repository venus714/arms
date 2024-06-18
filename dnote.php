<?php
$nmonth=date("m");
$nyear = date("Y");
$plotcode ='1';
require 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plots = 'select plotcode,plotname from plots';
$rez = $conn->query($plots);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Generate Demand Notes</title>
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
		border: 1px solid black;
		}
	
	.th {
		border: none;
	}
	
	.right {
		text-align: right;
		padding-right: 10px;
	}
	.tr1 {
		border-top: 1px solid black;
		border-bottom: 1px solid black;
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
<h4 class='header'>Generate Demand Notes</h4>
<div id='msg'></div>
<div class='mypara'>
<form method='POST' action='dnotepdf.php' autocomplete='off'>
<input type='hidden' autocomplete='false'>
<table>
<tr>
<th class='th'> Property</th>
<td class='th'><select  name='plotcode' id='plotcode' style='width: 150px; height: 25px' onblur='showhse(this.value)'>
<?php
while ($row=$rez->fetch_assoc()) {
	$plotcode=$row['plotcode'];
	$plotname = $row['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
?>
</select></td>
<th class='th'><input type='checkbox' name='chk1' id='chk1' value='' onclick='enableunits()' disabled>One Unit</th>
<td class='th'><div id='hsehint'>
<select name='hsecode' style='width: 150px; height: 25px' disabled>
<option>select a unit</option>
</select>
</div>
</td>
</tr>
</table>
<br><br>
<div class='hz'>
<button type='button' name='ok' id='ok' onclick='generate()' class='button1'>Okay</button>
<input type='submit' name='pdf' id ='pdf' value='SEND TO PDF' class='button1' disabled>
</div>
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
	if (document.getElementById('chk1').checked)
	{
		document.getElementById('chk1').value=1;
	} else {
		document.getElementById('chk1').value=0;
	}
	var check =document.getElementById('chk1').value;
	var tenantcode = document.getElementById('hsecode').value;
	
	var frmdata ='plotcode='+plotcode + '&check='+check+'&tenantcode='+tenantcode;
	//alert(frmdata)
	
	if (plotcode=='')
	{
		alert('Enter Propery Name Name');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "gendnotes.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 dataType: "text",
		success: function(data) {
		$('#mydata').html(data);
		}
		 		 		 });
		//location.reload();
					}	 
		//return false;
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