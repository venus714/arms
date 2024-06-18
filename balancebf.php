<?php
$plotcode = '';
$housecode = '';
$tenant = "";

require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$zplots ="select plotcode,plotname from plots";
$rez = $conn->query($zplots);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Adjustments</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="datascript.js"></script>
<style> 
	table {
		width: 100%;
	}
	th,td {
		padding: 10px;
		text-align: left;
	}
	.upper {
		text-transform: uppercase;
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
</div>

<div class='middle'>
<h3 class='header'> Opening Balances Balances</h3>
<div class='mypara'>
<form method ='post'>
<table>
<tr><th>Property Name</th>
<td><select name='propcode' id ='propcode' style='width:150px;height:25px;' onblur="showhse(this.value)">
<?php 
	while ($row=$rez->fetch_assoc())
	{
		$plotcode=$row['plotcode'];
		$plotname=$row['plotname'];
	echo "<option value='$plotcode'>$plotname</option>";
	}
	?>
	</select></td>
<th>Unit Number</th>
<td>
<div id='hsehint'>
<select disabled style='width: 150px; height: 25px'>
<option>Unit No.</option>
</select>
</div>
</td>
</tr></table>
</form>
</div>
<br>
<div id ='tnthint'>
Balances Details
</div>
</div>
<div class='side'>
<h3>Right Side Bar</h3>
</div>
</div>

<script>
function writedata()
{
	document.getElementById("btn1").disabled= true;
	document.getElementById("btn2").disabled= true;
	var plotcode= document.getElementById("propcode").value;
	var housecode= document.getElementById("hsecode1").value;
	var pcode= document.getElementById("itemcode").value;
	var tenantcode = document.getElementById("tntcode").value;
	var tenant = document.getElementById("tenant").value;
	var amount = document.getElementById("amt").value;
	var mdate = document.getElementById("mdate").value;
	
	//alert(houseid2);
	if (housecode == '' ) {
		alert("Please Select a house");
		//$('#message').html('<span style="color:red">Please Fill the Unit number</span>');
		return false;
	}
	else { 
	var formdata = 'housecode='+ housecode + '&plotcode='+plotcode+'&tenantcode='+tenantcode+'&tenant='+tenant+'&amount='+amount+'&pcode='+pcode+
	'&mdate='+mdate 
	
	//alert(formdata);
	
	// AJAX code to submit form.
	$.ajax({
		 type: "POST",
		 url: "bbfsave.php", //call storeemdata.php to store form data
		 data: formdata,
		 cache: false,
		 		 		 });
			}	 
		//return false;
}

</script>


<script>
function showhse(str) {
  if (str == "") {
    document.getElementById("hsehint").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("hsehint").innerHTML = this.responseText;
  }
  xhttp.open("GET", "getenant.php?q="+str);
  xhttp.send();
}
</script>


<script>
function getitem(str) {
  if (str == "") {
    document.getElementById("itemname").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("itemname").innerHTML = this.responseText;
  }
  xhttp.open("GET", "getitem.php?q="+str);
  xhttp.send();
}
</script>


<script>
function zdisplay(str) {
  if (str == "") {
    document.getElementById("tnthint").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("tnthint").innerHTML = this.responseText;
  }
  xhttp.open("GET", "tntdtlz.php?q="+str);
  xhttp.send();
}
</script>

<script>
function dataupdate(str) {
  document.getElementById("save").disabled = false;
  document.getElementById("reset").disabled = false;
  if (str == "") {
    document.getElementById("hseid").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("hseid").innerHTML = this.responseText;
  }
  xhttp.open("GET", "housedtls.php?q="+str);
  xhttp.send();
}
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