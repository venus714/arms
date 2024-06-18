<?php
$plotcode = '';
$housecode = '';
$tenant = "";
$rent = "0.00";
$datein= "";
$idno = "";
$phone = "";
$email = "";
$nextkin = "";
$kinrelation='';
$kinphone = '';
$kinemail = '';
$datein = date('0000/00/00');
$gender = '';
$quarter = '';
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$zplots ="select plotcode,plotname from plots";
$rez = $conn->query($zplots);
$kplots ="select plotcode,plotname from plots";
$rezult = $conn->query($kplots);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Reverse Tenant MoveOut</title>
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
<h3 class='header'>Left SideBar</h3>
</div>

<div class='middle'>
<h3 class='header'> Remverse Tenant MoveOut</h3>
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
<option>Unit Number</option>
</select>
</div>
</td>
</tr>
<tr>
<th>Vacated Tenants</th>
<td>
<div id='xhint'>
<select disabled style='width: 150px; height: 25px'>
<option>Tenant Name</option>
</select>
</div>
</td>
</tr>
</table>
</form>
</div>
<br>
<div id ='tnthint'>
Tenants Details
</div>
</div>

<div class='side'>
<h3 class='header'>Right Side Bar</h3>
</div>
</div>

<script>
function writedata()
{
	document.getElementById("save").disabled= true;
	document.getElementById("reset").disabled= true;
	var plotcode = document.getElementById("propcode").value;
	var houseid = document.getElementById("houseid").value;
	var housecode = document.getElementById("hsecode").value;
	var tenant= document.getElementById("tenant").value;
	var rent = document.getElementById("rent").value;
	var dateout =document.getElementById("dateout").value;
	var daterev =document.getElementById("daterev").value;
	var tenantcode= document.getElementById("xcode").value;

	//alert(housecode);

	if (daterev == '' ) {
		alert("Please Select a date");
		//$('#message').html('<span style="color:red">Please Fill the Unit number</span>');
		return false;
	}
	else {
		var formdata ='houseid='+houseid + '&dateout=' + dateout+ '&tenantcode='+ tenantcode+'&tenant='+ tenant + 
		'&plotcode='+plotcode + '&rent=' + rent +'&housecode=' +housecode +'&daterev=' +daterev;
	// AJAX code to submit form.
	$.ajax({
		 type: "POST",
		 url: "tenantrev.php", //call storeemdata.php to store form data
		 data: formdata,
		 cache: false,
		 		 		 });
			}	 
		//return false;
}
</script>

<script>
function zenable()
{
document.getElementById("save").disabled= false;
document.getElementById("reset").setfocus= false;
}
</script>

<script>
function zerch()
{
document.getElementById("serch").disabled= false;
}
</script>

<script>
function myfunction()
{
	var x =document.getElementById("plotcode").value
	document.getElementById("h1").value=x
	document.getElementById("add").disabled= false;
	document.getElementById("add").setfocus= true;
	document.getElementById("plotcode").disabled= true;
	
}
</script>

<script>
function showunits(str) {
  if (str == "") {
    document.getElementById("txthint").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("txthint").innerHTML = this.responseText;
  }
  xhttp.open("GET", "getunits.php?q="+str);
  xhttp.send();
}
</script>

<script>
function showrent(str) {
  if (str == "") {
    document.getElementById("txtrent").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("txtrent").innerHTML = this.responseText;
  }
  xhttp.open("GET", "getrent.php?q="+str);
  xhttp.send();
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
  xhttp.open("GET", "getvacated.php?q="+str);
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
  xhttp.open("GET", "xtenantdtls.php?q="+str);
  xhttp.send();
}
</script>

<script>
function xdisplay(str) {
  if (str == "") {
    document.getElementById("xhint").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("xhint").innerHTML = this.responseText;
  }
  xhttp.open("GET", "xtenants.php?q="+str);
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