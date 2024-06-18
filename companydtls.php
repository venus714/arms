<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$sql1= "select * from setup";
$result = $conn->query($sql1);
$row = $result->fetch_assoc();
$cname = $row['cname'];
$location = $row['location'];
$bdescript = $row['bdescript'];
$telephone = $row['telephone'];
$email = $row['email'];
$website = $row['website'];
$pin = $row['pin'];
$vatno = $row['vatno'];
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Payment Voucher</title>
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
<div class='mypara'>
<form>
<table>
<tr><th>Company Name</th>
<td><textarea name='cname' id='cname' cols='25' rows='4' readonly><?php echo $cname;?></textarea></td>
</td>
<th>Business Description</th>
<td><textarea name='narr' id='narr' cols='25' rows='4' readonly><?php echo $bdescript;?></textarea></td>
</tr>
<th>Business Location</th>
<td><textarea name='loc' id='loc' cols='25' rows='4' readonly><?php echo $location;?></textarea></td>
<th> Telephone Nos.</th>
<td><textarea name='tel' id='tel' cols='25' rows='4' readonly><?php echo $telephone;?></textarea></td>
</tr>
<th>Email Address</th>
<td><textarea name='email' id='email' cols='25' rows='4' readonly><?php echo $email;?></textarea></td>
<th> Website URL</th>
<td><textarea name='web' id='web' cols='25' rows='4' readonly><?php echo $website;?></textarea></td>
</tr>
<th>VAT No.</th>
<td><input type='text' name='vatno' id='vatno' value='<?php echo $vatno;?>' readonly>
<th>PIN</th>
<td><input type='text' name='pin' id='pin' value='<?php echo $pin;?>' readonly>
</tr>
</table>
<br><br>
<div class='hz'>
<button type='button' name='btn1' id='btn1' onclick='zedit()' class='button1'>Edit</button>
<button type='button' name='btn2' id='btn2' onclick='zave()' disabled class='button1'>Save</button>
<button type='reset' name='btn3' id='btn3' disabled class='button1'>Reset</button>
</div>
<br><br>
</form>
</div>
</div>

<script>
function zedit()
{
	document.getElementById('btn1').disabled=true;
	document.getElementById('btn2').disabled=false;
	document.getElementById('btn3').disabled=false;
	document.getElementById('cname').readOnly=false;
	document.getElementById('narr').readOnly=false;
	document.getElementById('loc').readOnly=false;
	document.getElementById('tel').readOnly=false;
	document.getElementById('email').readOnly=false;
	document.getElementById('web').readOnly=false;
	document.getElementById('vatno').readOnly=false;
	document.getElementById('pin').readOnly=false;
	document.getElementById('cname').focus();
}
</script>
<script>
function zave()
{
	document.getElementById('btn1').disabled=false;
	document.getElementById('btn2').disabled=true;
	document.getElementById('btn3').disabled=true;
	document.getElementById('cname').readOnly=true;
	document.getElementById('narr').readOnly=true;
	document.getElementById('loc').readOnly=true;
	document.getElementById('tel').readOnly=true;
	document.getElementById('email').readOnly=true;
	document.getElementById('web').readOnly=true;
	document.getElementById('vatno').readOnly=true;
	document.getElementById('pin').readOnly=true;
	var cname= document.getElementById('cname').value;
	var bdescript= document.getElementById('narr').value;
	var location = document.getElementById('loc').value;
	var telephone= document.getElementById('tel').value;
	var email = document.getElementById('email').value;
	var website = document.getElementById('web').value;
	var vatno = document.getElementById('vatno').value;
	var pin = document.getElementById('pin').value;
	
	frmdata='cname='+cname+'&bdescript='+bdescript+'&location='+location+'&telephone='+telephone+
	'&email='+email +'&website='+website+'&vatno='+vatno+'&pin='+pin;
	//alert(frmdata);
	
	if (cname=='')
	{
		alert('Enter Company Name');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "compupdate.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 		 		 });
			}	 
	}
</script>

<div class='side'>
</div>
</div>
</body>
</html>