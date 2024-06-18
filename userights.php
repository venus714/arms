<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$sql1 ="select distinct submenu.menuid,mainmenu.menuname from submenu inner join mainmenu on submenu.menuid=mainmenu.id";
$sql2 = $conn->query($sql1);
$user1 = "select id,username from sysusers where ulevel!='1'";
$user2 = $conn->query($user1);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Property Details</title>
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
		border-collapse=collapse;
	}
	th,td {
		padding: 10px;
		text-align: left;
		border: 1px solid black;
	}
	</style>
</head>
<body>
<div>
<?php include 'mymenu.php';?>
</div>
<?php include 'myheader3.php';?>
<div class='row'>
<div class='side'>
</div>
<div class='middle'>
<div class='mypara'>
<?php
echo "<div id ='ur'>"; 
echo "<table>";
while ($row = $sql2->fetch_assoc())
{	
	$menuname=$row['menuname'];
	$menuid = $row['menuid'];
echo "<tr><td colspan='3' style='font-weight: bold'>$menuname</td>";
$qry1 = "select id,subname, stat from submenu where menuid='$menuid'";
$qry2 = $conn->query($qry1);
while ($rowz=$qry2->fetch_assoc())
{
	$subname= $rowz['subname'];
	$stat = $rowz['stat'];
	$id = $rowz['id'];
echo "<tr><td style='width: 30%'>$id</td><td style='width: 40%'>$subname</td>";
echo "<td style='width: 30%'><input type='checkbox' name[]='stat' class='stat' value='$stat'></td></tr>";
}}
echo "</table>";
echo "</div>";
?>
</div>
</div>
<script>
function showrights()
 {
	document.getElementById('btn1').disabled=false;
	var userid = document.getElementById('user').value;
	var frmdata= 'userid='+userid;
	//alert(frmdata);
	$.ajax({
		 type: "POST",
		 url: "getrights.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 success: function(data) {
		$('#ur').html(data);
		}

		 		 		 });
			}	 
</script>

<div class='side'>
<div class='mypara'>
<label>User Name</label>
<br><br>
<select name='user' id='user' style='width: 150px;height: 24px;' onblur='showrights()'>
<?php
while ($xow = $user2->fetch_assoc())
{
	$userid = $xow['id'];
	$username = $xow['username'];
echo "<option value='$userid'>$username</option>";
}
?>
</select>
<br><br><br>
<div class='hz'>
<button type='button' id='btn1' name='save' class='button1' onclick='writedata()' disabled>Save</button>
</div>
<div id='msg1'></div>
<br><br><br>
</div>
</div>
</div>
<script>
function writedata()
{
var userid = document.getElementById('user').value;
var checker = document.getElementsByClassName('stat');
var checker1 = Array.from(checker);

for (i=0;i<checker.length;i++)
	{
		if (checker[i].checked==true)
		{
		checker[i].value='1';
		} else {
			checker[i].value='0';
		//checker[i].disabled=true;
		
	}}


for (i=0;i<checker.length;i++)
		{
			checker1[i]= checker[i].value;
}
//var text = checker1[].join();
frmdata = 'userid='+userid + '&checker1[]='+checker1;
//alert(text);

$.ajax({
		 type: "POST",
		 url: "saverights.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 success: function(data) {
		$('#msg1').html(data);
		}

		 		 		 });
				
}
</script>

</body>
</html>