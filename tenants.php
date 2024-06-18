<?php
$plotcode = '';
$housecode = '';
$tenant = "";
$rent = "";
$datein= "";
$idno = "";
$phone = "";
$email = "";
$nextkin = "";
$kinrelation='';
$kinphone = '';
$kinemail = '';
$datein = date('Y-m-d');
$gender = '';
$quarter = '';
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$zplots ="select plotcode,plotname from plots";
$rez = $conn->query($zplots);
$kplots ="select plotcode,plotname from plots";
$rezult = $conn->query($kplots);

$qtr = "select * from rentschedule";
$qtrz = $conn->query($qtr);

if(isset($_POST['submit']))
{
$houseid=$_POST['houseid'];
$str1 = $conn->prepare("select * from tenants where houseid=?");
$str1->bind_param('s', $houseid);
$str1->execute();
$str2=$str1->get_result();
if ($str2->num_rows > 0) {
$row = $str2->fetch_assoc();
$tenant = $row['tenant'];
$idno = $row['idno'];
$phone = $row['phone'];
$email = $row['email'];
$gender = $row['gender'];
$rent = $row['rent'];
$quarter = $row['quarter'];
$datein = $row['datein'];
$nextkin =$row['nextkin'];
$kinrelation = $row['kinrelation'];
$kinphone = $row['kinphone'];
$kinemail = $row['kinemail'];

} else {echo "<script>alert('Record not Found')</script>";}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Tenants Details</title>
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
		font-family: Arial;
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
<h3 class='header'> Search Tenant </h3>
<form method ='post'>
<select name='propcode' id ='propcode' style='width:150px;height:25px;' onchange="showhse(this.value)">
<?php 
	while ($row=$rez->fetch_assoc())
	{
		$plotcode=$row['plotcode'];
		$plotname=$row['plotname'];
	echo "<option value='$plotcode'>$plotname</option>";
	}
	?>
	</select>
	<br><br>
<label>Unit Number</label>
<div id='hsehint'>
<br>
<select disabled style='width: 150px; height: 25px'>
<option>Unit Number</option>
</select>
</div>
<br>
<button type='button' name='serch' id='serch' disabled>Search</button>
</form>
</div>

<div class='middle1'>
<h3 class='header'>Tenants Details</h3>
<div id='dtls'>Fill in Details</div>
<div id='mydata'>
<div class='mypara'>
<form method='post' action='' autocomplete='off'>
<input type='hidden' autocomplete='false'>
<table>
<th><label> Property Name</label></th>
<td><select name='plotcode' id ='plotcode' style='width:150px;height:25px;' disabled onblur="showunits(this.value)">
<?php 
	while ($row=$rezult->fetch_assoc())
	{
		$plotcode=$row['plotcode'];
		$plotname=$row['plotname'];
	echo "<option value='$plotcode'>$plotname</option>";
	}
	?>
	</select></td>
<th>Unit Number</th>
<td><div id='txthint'>
<select disabled style='width: 150px; height: 25px'>
<option>Unit Number</option>
</select>
</div>
</td>
</tr>
<tr>
<th><label>Tenant Name</label></th>
<td><input type='text' name='tenant' id='tenant' value='<?php echo $tenant;?>' readonly></td>
<th><label>Gender</label></th>
<td><select ' name='gender' id='gender' value='<?echo $gender;?>'>
<option value='M'>Male</option>
<option value ='F'>Female</option>
</select>
</td>
</tr>
<tr>
<th>ID Number</th>
<td><input type='text' name='idno' id='idno' value='<?php echo $idno;?>' readonly></td>
<th> Phone Number</th>
<td><input type='text' name='phone' id='phone' value='<?php echo $phone;?>' readonly></td>
</tr>
<tr>
<th> Email Address</th>
<td><input type='text' name='email' id = 'email' value='<?php echo $email;?>' readonly></td>
<th>Payment Schedule</th>
<td><select name='quarter' id ='quarter' value  = '<?php echo $quarter;?>'>
<?php
while ($row = $qtrz->fetch_assoc())
{
$nmonths = $row['nmonths'];
$description = $row['description'];
echo "<option value='$nmonths'>$description</option>";
}
?>
</select></td>
</tr>
<tr>
<th>Date MoveIn</th>
<td><input type='date' name='datein' id='datein' value = '<?php echo $datein;?>' readonly></td>
<th>Rent Per Month</th>

<td> <div id='txtrent'><input type = 'text' name='rent' id='rent' value='' readonly>
</div>
</td></tr>
<tr>
<th>Next of Kin</th>
<td><input type ='text' name='nextkin' id = 'nextkin' value = '<?php echo $nextkin;?>' readonly></td>
<th> Kin Relation</th>
<td><input type ='text' name='kinrelation' id = 'kinrelation' value = '<?php echo $kinrelation;?>' readonly></td>
</tr>
<tr>
<th>Kin Phone Number</th>
<td><input type ='text' name='kinphone' id = 'kinphone' value = '<?php echo $kinphone;?>' readonly></td>
<th> Kin Email</th>
<td><input type ='text' name='kinemail' id = 'kinemail' value = '<?php echo $kinemail;?>' readonly></td>
</tr>
<tr><th></th><td><input type='hidden' id='opt' name='opt' value=''></td></tr>
<tr>
<td><button type='button' name='add' id='add' onclick='writable()'>Add</button></td>
<td><button type='button' name='edit' id='edit'  onclick='editdata()' disabled>Edit</button></td>
<td><button type='button' name='save' id='save'  onclick='writedata()' disabled>Save</button></td>
<td><input type = 'reset' name='reset' id='reset' onclick='revert()' disabled></td>
</tr>
<table>
<br>
</form>
</div>
</div>
</div>
</div>

<script>
function writable()
{
	 document.getElementById("plotcode").disabled= false;
	 document.getElementById("plotcode").focus();
	 document.getElementById("save").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("tenant").readOnly= false;
	 document.getElementById("tenant").value= '';
	 document.getElementById("datein").readOnly= false;
	 document.getElementById("idno").readOnly= false;
	 document.getElementById("idno").value= '';
	 document.getElementById("phone").readOnly= false;
	 document.getElementById("phone").value= '';
	 document.getElementById("email").readOnly= false;
	 document.getElementById("email").value= '';
	 document.getElementById("nextkin").readOnly= false;
	 document.getElementById("nextkin").value= '';
	 document.getElementById("kinrelation").readOnly= false;
	 document.getElementById("kinrelation").value= '';
	 document.getElementById("kinphone").readOnly= false;
	 document.getElementById("kinphone").value= '';
	 document.getElementById("kinemail").readOnly= false;
	 document.getElementById("kinemail").value= '';
	 document.getElementById("opt").value= '1';
}
</script>

<script>
function editdata()
{
	 document.getElementById("save").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("edit").disabled= true;
	 document.getElementById("tenant").readOnly= false;
	 document.getElementById("tenant").focus();
	 document.getElementById("datein").readOnly= false;
	 document.getElementById("idno").readOnly= false;
	 document.getElementById("phone").readOnly= false;
	 document.getElementById("email").readOnly= false;
	 document.getElementById("nextkin").readOnly= false;
	 document.getElementById("kinrelation").readOnly= false;
	 document.getElementById("kinphone").readOnly= false;
	 document.getElementById("kinemail").readOnly= false;
	 document.getElementById("opt").value= '2';
	}
</script>


<script>
function writedata()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
	document.getElementById("reset").disabled= true;
	var plotcode= document.getElementById("plotcode").value;
	var housecode=document.getElementById("housecode").value;
	var tenant=document.getElementById("tenant").value;
	var idno=document.getElementById("idno").value;
	var rent =document.getElementById("rent").value;
	var datein=document.getElementById("datein").value;
	var phone=document.getElementById("phone").value;
	var email=document.getElementById("email").value;
	var nextkin=document.getElementById("nextkin").value;
	var kinrelation=document.getElementById("kinrelation").value;
	var kinphone=document.getElementById("kinphone").value;
	var kinemail=document.getElementById("kinemail").value;
	var gender=document.getElementById("gender").value;
	var quarter=document.getElementById("quarter").value;
	var opt= document.getElementById("opt").value;
	//alert(tenant);
	var formdata ='plotcode='+plotcode + '&housecode='+housecode + '&tenant='+tenant+'&idno='+idno+ '&phone='+phone+'&email='
	+email+'&nextkin='+nextkin+'&kinrelation='+kinrelation + '&kinphone='+kinphone +'&kinemail='+kinemail
	+'&datein='+datein + '&rent='+rent+'&gender='+gender + '&quarter='+ quarter+'&opt='+opt;
	
	//alert(tenant);
	
	if (tenant == '' ) {
		alert("Please Type something");
		//$('#message').html('<span style="color:red">Please Fill the Unit number</span>');
		return false;
	}
	else {

	// AJAX code to submit form.
	$.ajax({
		 type: "POST",
		 url: "postenants.php", //call storeemdata.php to store form data
		 data: formdata,
		 cache: false,
		 success: function(data) {
			 $('#dtls').html(data);
		 }
		 		 		 });
			}	 
		//return false;
}
</script>

<script>
		
		$(document).ready(function() {
		$('#serch').click(function(e) {
			e.preventDefault();
		var houseid = $('#houseid').val();
		var propcode = $('#propcode').val();
		//alert(plotcode);
		$.ajax({
			method: 'post',
			url: 'showdtls.php',
			data: {'propcode':propcode,'houseid': houseid,},
			dataType: "text",
			success: function(response) {
				$('#mydata').html(response);
			}
					
		});
		});
		});
</script>

<script>
function zerch()
{
document.getElementById("serch").disabled= false;
document.getElementById("serch").focus();
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
	document.getElementById('serch').disabled=false;
  }
  xhttp.open("GET", "gethouze.php?q="+str);
  xhttp.send();
}
</script>

<script>
function revert()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
	document.getElementById("reset").disabled= true;
}
</script>
</body>
</html>