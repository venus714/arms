<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$sql= "select plotcode,plotname from plots";
$result=$conn->query($sql);
?>


<!DOCTYPE HTML>
<html>
<head>
<title>LandLord Details</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

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
	</style>
</head>
<body>
<div class='menu'>
<?php include 'mymenu.php';?>
</div>
<?php include 'myheader3.php';?>

<div class='row'>
<div class='side'>
<h3 class='header3'>Left SideBar</h3>
Property Name: <select name='plotcode' id='plotcode' style='width: 15opx;height: 25px' onblur='listenants(this.value)'>
<?php
while ($row=$result->fetch_assoc())
{
	$plotcode= $row['plotcode'];
	$plotname= $row['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
?>
</select>
</div>
<div class='middle'>
<h4 class='hz'>Units Details</h4>
<div id='tntdtls'>
</div>
</div>
<script>
function listenants(str) {
  if (str == "") {
    document.getElementById("tntdtls").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("tntdtls").innerHTML = this.responseText;
  }
  xhttp.open("GET", "listunits.php?q="+str);
  xhttp.send();
}
</script>
<div class='side'>
<h3 class='header'>Right SideBar</h3>
</div>
</div>
</body>
</html>