<?php
$plotname = '';
$town = "";
$estate = "";
$lrno = "";
$units = "";
$ptype = "";
$lordcode = "";
$mgtcom = "";
$mgtflat = "";
$rentvat = "";
$lordvat= "";
$status1='unchecked';
$status2 ='unchecked';
$xstat=0;
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$lld ="select lordcode,lordname from landlords";
$rez = $conn->query($lld);

$plot1 ="select plotcode,plotname from plots";
$plot2 = $conn->query($plot1);

if (isset($_POST['serch'])) {
$plotcode=$_POST['plotcode'];

$rec1= "select * from plots where plotcode='$plotcode'";
$rec2 = $conn->query($rec1);

$rw=$rec2->fetch_assoc();
$plotname= $rw['plotname'];
$town = $rw['town'];
$estate= $rw['estate'];
$lrno = $rw['lrno'];
$units = $rw['units'];
$mgtcom= $rw['mgtcom'];
$mgtflat = $rw['mgtflat'];
$rentvat = $rw['rentvat'];
$lordvat = $rw['lordvat'];
if ($rentvat='1')
{
	$status1 ='checked';
} else {
	$status1='unchecked';
}


if ($lordvat=1)
{
	$status2='$checked';
} else {$status2='unchecked';
}}
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
<form method='post'>
<h3 class='header'> Search Property</h3>
<label>Property Name</label><br>
<select name='propcode' id='propcode' style='width: 150px;height: 25px'>
<?php
while ($rz=$plot2->fetch_assoc())
{
	$propcode=$rz['plotcode'];
	$propname=$rz['plotname'];
echo "<option value='$propcode'>$propname</option>";
}
?>
</select>
<br><br>
<button type='button' name='serch' id='serch'>Search</button>
</form>
</div>
<div class='middle'>
<h4 class='header'>Property Details</h4>
<div id='mydata'>
<div class='mypara'>
<form method='post' action='' autocomplete='off'>
<input type='hidden' autocomplete='false'>
<table>
<tr>
<th> Property Name</th>
<td><input type='text' name='plotname' id='plotname' value="<?php echo $plotname;?>" readonly></td>
<th>Lr Number</th>
<td><input type='text' name='lrno' id='lrno' value='<?php echo $lrno;?>' readonly></td>
</tr>
<tr>
<th>Town</th>
<td><input type='text' name='town' id='town' value='<?php echo $town;?>' readonly></td>
<th>Estate/Location</th>
<td><input type='text' name='estate' id='estate'value='<?php echo $estate;?>' readonly></td>
</tr>
<tr>
<th>No. of Units</th>
<td><input type='text' name='units' id='units' value='<?php echo $units;?>' readonly></td>
<th>Property Type</th>
<td><select  name='ptype' id='ptype' style='width:150px;height: 25px;' readonly>
<option value='1'>Residential</option>
<option value ='2'>Commercial</option>
</select>
</td>
</tr>

<tr>
<th> Rent Mngt Comm</th>
<td><input type='text' name='mgtcom' id='mgtcom' value='<?php echo $mgtcom;?>'readonly></td>
<th>Rent Mngt Flat</th>
<td><input type='text' name='mgtflat' id = 'mgtflat' value='<?php echo $mgtflat;?>' readonly></td>
</tr>
<tr>
<th>landlord</th>
<td><select  name='lordcode' id = 'lordcode' style ='width:150px; height:25px;'>
<?php
if ($rez->num_rows>0) {
while ($row = $rez->fetch_assoc())
{
	$lordcode = $row['lordcode'];
	$lordname = $row['lordname'];
	echo "<option value='$lordcode'>$lordname</option>";
}
}
?>
</select></td>
</tr>
<tr>
<td><input type='hidden' id='h1' name='h1' value='<?php echo $xstat;?>'></td>
<td><input type ='checkbox' id ='rentvat' name ='rentvat' value='1' <?php echo $status1;?>>Rent Vat</td>
<th></th>
<td><input type ='checkbox' id ='lordvat' name ='lordvat' value='1' <?php echo $status2;?>>LandLord Vat</td>
</tr>
<td><button type='button' name='add' id='add' onclick='writable()'>Add</button></td>
<td><button type='button' name='edit' id='edit' onclick='editable()' disabled>Edit</button></td>
<td><button type='button' name='save' id='save' onclick='writedata()' disabled>Save</button></td>
<th> <input type = 'reset' name='reset' id='reset' value='Reverse' onclick='revert()' disabled></th>

<!--<td><input type='submit' name='save' id='save' onclick='save()' disabled></td<!>-->
</tr>
</table>
<br>
</form>
</div>
</div>
</div>
<div class='side'>
<h3 class='header'>Right Side Bar</h3>
</div>
</div>
<script>
function writable()
{
	 document.getElementById("save").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("edit").disabled= true;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("plotname").readOnly= false;
	 document.getElementById("plotname").value= '';
	 document.getElementById("plotname").focus();
	 document.getElementById("town").readOnly= false;
	 document.getElementById("town").value= '';
	 document.getElementById("estate").readOnly= false;
	 document.getElementById("estate").value= '';
	 document.getElementById("lrno").readOnly= false;
	 document.getElementById("lrno").value= '';
	 document.getElementById("units").readOnly= false;
	 document.getElementById("units").value= '';
	 document.getElementById("mgtcom").readOnly= false;
	 document.getElementById("mgtcom").value= '';
	 document.getElementById("mgtflat").readOnly= false;
	 document.getElementById("mgtflat").value= '';
	 document.getElementById("rentvat").checked = false;
	 document.getElementById("lordvat").checked = false;
	 document.getElementById("h1").value='1';
}
</script>
<script>
function editable()
{
	 document.getElementById("save").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("edit").disabled= true;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("plotname").readOnly= false;
	 document.getElementById("plotname").focus();
	 document.getElementById("town").readOnly= false;
	 document.getElementById("estate").readOnly= false;
	 document.getElementById("lrno").readOnly= false;
	 document.getElementById("units").readOnly= false;
	 document.getElementById("mgtcom").readOnly= false;
	 document.getElementById("mgtflat").readOnly= false;
	 document.getElementById("rentvat").checked = false;
	 document.getElementById("lordvat").checked = false;
	 document.getElementById("h1").value='2';
}
</script>

<script>
function writedata()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
	document.getElementById("reset").disabled= true;
	var plotcode = document.getElementById("propcode").value;
	var plotname = document.getElementById("plotname").value;
	var town = document.getElementById("town").value;
	var estate = document.getElementById("estate").value;
	var lrno = document.getElementById("lrno").value;
	var lordcode = document.getElementById("lordcode").value;
	var units = document.getElementById("units").value;
	var ptype = document.getElementById("ptype").value;
	var mgtcom = document.getElementById("mgtcom").value;
	var mgtflat = document.getElementById("mgtflat").value;
	var xstat = document.getElementById("h1").value;
	var yes = document.getElementById("rentvat");
	if (yes.checked==true)
	{ var rentvat =document.getElementById('rentvat').value;
	} else {var rentvat = '0';}
	var lord = document.getElementById("lordvat");
	if (lord.checked==true)
	{ var lordvat =document.getElementById('lordvat').value;
	} else {var lordvat = '0';}
	
	
	var formdata ='estate='+ estate + '&town=' + town+ '&plotname=' + plotname +'&lrno='+ lrno+'&units='+units+'&xstat='+xstat+
	'&ptype='+ptype + '&mgtcom='+mgtcom + '&lordcode='+lordcode+ '&mgtflat='+mgtflat +'&rentvat='+rentvat+'&lordvat='+lordvat
	+'&plotcode='+plotcode;
	//alert(formdata);
	if (plotname == '' ) {
		alert("Please Type property Name");
		
		return false;
	}
	else { //alert(town);


	// AJAX code to submit form.
	$.ajax({
		 type: "POST",
		 url: "postprop.php", //call storeemdata.php to store form data
		 data: formdata,
		 cache: false,
		 		 		 });
			}	 
		
}
</script>

<script>
function revert()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
}
</script>
<script>
		
		$(document).ready(function() {
		$('#serch').click(function(e) {
			e.preventDefault();
		var propcode = $('#propcode').val();
		//alert(plotcode);
		$.ajax({
			method: 'post',
			url: 'propdtls.php',
			data: {'propcode':propcode},
			dataType: "text",
			success: function(response) {
				$('#mydata').html(response);
			}
					
		});
		});
		});
</script>
</body>
</html>