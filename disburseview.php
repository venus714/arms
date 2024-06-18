<?php
$nmonth=date("m");
$nyear = date("Y");
$mdate = date("dd/mm/yy");
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
    $sql1 = "select plotcode,plotname from plots";
	$sql2 = $conn->query($sql1);
?>

<html>
<head>
<title>Disbursements</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<script src ="https://code.jquery.com/jquery-3.3.1.js"></script>

<style>
table {
    border: 1px solid;
	width: 100%;
}

th,td {
	border: 1px solid;
	padding: 5px;
}
table {
	  border-collapse: collapse;
	 
}
input[type="text"],input[type="date"] {
     width: 100%; 
     height: 30px;
	 box-sizing: border-box;
     -webkit-box-sizing:border-box;
     -moz-box-sizing: border-box;
}
textarea {
	width: 100%;
}

.empname {color: red;}
</style>
</head>
<body>
<div class='menu'>
<?php include 'mymenu.php';?>
</div>
<?php include 'myheader3.php';?>
<div class='row'>
<div class='side'>
<div class='mypara'>
<form method='post'>
<label>Property</label><br>
<select name='plotcode' id='plotcode' style='width: 150px;height: 25px;'>
<?php
while ($row=$sql2->fetch_assoc())
{
	$plotcode = $row['plotcode'];
	$plotname = $row['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
?>
</select><br><br>
<label>Month</label><br>
<input type='text' name='nmonth' id='nmonth' value='<?php echo $nmonth;?>'><br><br>
<label>Year</label><br>
<input type='text' name='nyear' id='nyear' value='<?php echo $nyear;?>'><br><br>
<button type='button' name='btn1' onclick='viewdata()'>Execute</button>
</form>
</div>
</div>
<div class='middle'>
<div class='mypara'>
<div id='msg'>
</div>	 
 </div>
 </div>
 <script>
function viewdata() {
	document.getElementById('btn1').disabled=false;
	document.getElementById('btn2').disabled=false;
	var plotcode = document.getElementById("plotcode").value;
	var nmonth = document.getElementById("nmonth").value;
	var nyear = document.getElementById("nyear").value;
	var frmdata ='plotcode='+plotcode + '&nmonth='+nmonth + '&nyear=' +nyear;
	//alert(frmdata);
	if (nyear=='')
	{
		alert('Enter Propery Name Name');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "disbursedtls.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 dataType: "text",
		success: function(data) {
		$('#msg').html(data);
		}
		 		 		 });
		//location.reload();
					}	 
		//return false;
}
</script>
<script>
function zdelete()
{
	var plotcode = document.getElementById("plotcode").value;
	var nmonth = document.getElementById("nmonth").value;
	var nyear = document.getElementById("nyear").value;
	
	var checker =document.getElementsByClassName('chek1');
	for (i=0;i<checker.length;i++)
	{
		if (checker[i].checked==true)
		{
		checker[i].value='1';
	}}
	checkz = Array.from(checker);
	for (i=0;i<checker.length;i++)
	{ 
	checkz[i]= checker[i].value;
	}
	
	var idnum =document.getElementsByClassName('idno');
	idnum1 = Array.from(idnum);
	for (i=0;i<idnum.length;i++)
	{ 
	idnum1[i]= idnum[i].value;
	}
	formdata = 'checkz[]=' +checkz + '&idnum1[]='+idnum1+'&plotcode='+plotcode+'&nyear='+nyear+'&nmonth='+nmonth;
	alert (formdata);
	
		
	$.ajax({
		 type: "POST",
		 url: "deledisburses.php", 
		 data: formdata,
		 cache:false,
		 success: function(data) {
		$('#msg').html(data);
		}

		 		 		 });
				 
}
</script>

<script>
function zedit()
{
	var plotcode = document.getElementById("plotcode").value;
	var nmonth = document.getElementById("nmonth").value;
	var nyear = document.getElementById("nyear").value;
	document.getElementById("btn1").disabled=true;
	document.getElementById("btn2").disabled=true;
	document.getElementById("btn3").disabled=false;
	
	var checker =document.getElementsByClassName('chek1');
	for (i=0;i<checker.length;i++)
	{
		if (checker[i].checked==true)
		{
		checker[i].value='1';
	}}
	checkz = Array.from(checker);
	for (i=0;i<checker.length;i++)
	{ 
	checkz[i]= checker[i].value;
	}
	//alert(checkz);
	
	var amt = document.getElementsByClassName('amount');
	var narr = document.getElementsByClassName('narrative');
	var datez = document.getElementsByClassName('date1');
	
	//alert(checkz);
	for (i=0;i<checker.length;i++)
	{ 
	if (checkz[i]=='1') {
	amt[i].readOnly=false;
	amt[i].style.color='red';
	narr[i].readOnly=false;
	narr[i].style.color='red';
	datez[i].readOnly=false;
	datez[i].style.color='red';
	}
	}
	}
</script>

</script>

<script>
function zsave()
{
	var plotcode = document.getElementById("plotcode").value;
	var nmonth = document.getElementById("nmonth").value;
	var nyear = document.getElementById("nyear").value;
	document.getElementById("btn1").disabled=false;
	document.getElementById("btn2").disabled=false;
	document.getElementById("btn3").disabled=true;
	
	var checker =document.getElementsByClassName('chek1');
	for (i=0;i<checker.length;i++)
	{
		if (checker[i].checked==true)
		{
		checker[i].value='1';
	}}
	checkz = Array.from(checker);
	for (i=0;i<checker.length;i++)
	{ 
	checkz[i]= checker[i].value;
	}
	
	var idnum =document.getElementsByClassName('idno');
	idnum1 = Array.from(idnum);
	for (i=0;i<idnum.length;i++)
	{ 
	idnum1[i]= idnum[i].value;
	}
	
	
	var narr =document.getElementsByClassName('narrative');
	narr1 = Array.from(narr);
	for (i=0;i<narr.length;i++)
	{ 
	narr1[i]= narr[i].value;
	}
	
	var amt =document.getElementsByClassName('amount');
	amt1 = Array.from(amt);
	for (i=0;i<amt.length;i++)
	{ 
	amt1[i]= amt[i].value;
	}
	
	
	var zdate =document.getElementsByClassName('date1');
	zdate1 = Array.from(zdate);
	for (i=0;i<zdate.length;i++)
	{ 
	zdate1[i]= zdate[i].value;
	}
	
	formdata = 'checkz[]=' +checkz + '&idnum1[]='+idnum1+'&plotcode='+plotcode+'&nyear='+nyear+'&nmonth='+nmonth+
	'&narr1[]='+narr1+'&amt1[]='+amt1 + '&zdate1[]='+zdate1;
		
		
	$.ajax({
		 type: "POST",
		 url: "savedisburses.php", 
		 data: formdata,
		 cache:false,
		 success: function(data) {
		$('#msg').html(data);
		}

		 		 		 });
}
</script>


 <div class='side'>
 <div class='mypara'>
 <h4 class='hz' style='color: blue'>Actions</h4>
 <form class='hz'>
 <button type='button' name='btn1' id='btn1' disabled onclick='zdelete()'>Cancel Disburse</button>
 <br><br>
 <button type='button' name='btn2' id='btn2' disabled onclick='zedit()'>Edit Disburse</button>
 <br><br>
 <button type='button' name='btn3' id='btn3' disabled onclick='zsave()'>Save Changes</button>
 <br><br>
 </form>
 </div>
 </div>
 </div>
</body> 
</html>