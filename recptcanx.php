<!DOCTYPE HTML>
<html>
<head>
<title>Opening Deposits</title>
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
<h3 class='header'> Cancel Receipt</h3>
<div class='mypara'>
<table>
<tr><th>Receipt Number</th>
<td><input type='text' name='recptno' id='recptno' value='' onblur='serch(this.value)'></td>
</tr>
</table>
</div>
<div class='mypara'>
<div id='dtls'>Receipt details come here</div>
</div>
</div>
<script>
function serch(str) {
  if (str == "") {
    document.getElementById("dtls").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("dtls").innerHTML = this.responseText;
  }
  xhttp.open("GET", "getrecpt.php?q="+str);
  xhttp.send();
}
</script>

<script>
function canx() {
var recptno = document.getElementById('recptno').value;
frmdata= 'recptno='+recptno;
alert(frmdata);
$.ajax({
		 type: "POST",
		 url: "canxrecpt.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 		 		 });
		
}
</script>

<div class='side'>
</div>
</div>
</body>
</html>
