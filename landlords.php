<?php
$lordname = '';
$email = '';
$phone = '';
$vatno = '';
$xstat=0;
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$lld1 = "select lordcode,lordname from landlords";
$lld2 = $conn->query($lld1);

if (isset($_POST['save'])) {
	$mdate=date("Y/m/d");
	$lordname = $_POST['lordname'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$vatno = $_POST['vatno'];
	//$ownerid=12;
	
	$data = $conn->prepare("insert into landlords(lordname,phone,email,vatno,datecreate) VALUES (?,?,?,?,?)");
	$data->bind_param('sssss', $lordname,$phone,$email,$vatno,$mdate);
	$data->execute();
	//$result2 = $data2->get_result();
}
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
<h3 class='header'>Search Landlord</h3>
<form method='post'>
<label>Landlord Name</label><br>
<select name='lordcode' id='lordcode' style='width: 150px;height: 25px'>
<?php 
while ($lld = $lld2->fetch_assoc())
{
	$lordcode= $lld['lordcode'];
	$lldname = $lld['lordname'];
echo "<option value='$lordcode'>$lldname</option>";
}
?>
</select>
<br><br>
<button type='button' name='serch' id='serch'>Search</button>
<br><br>
</form>
</div>

<div class='middle'>
<h4 class='header'>Landlord Details</h4>
<div id='mydata'>
<div class='mypara'>
<form method='post' action='' autocomplete='off'>
<input type='hidden' id='xstat' name='xstat' value="<?php echo $xstat;?>">
<table>
<tr>
<th> Landlord Name</th>
<td><input type='text' name='lordname' id='lordname' value="<?php echo $lordname;?>" readonly></td>
<th>Telephone No.</th>
<td><input type='text' name='phone' id='phone' value='<?php echo $phone;?>' readonly></td>
</tr>
<tr>
<th>Email Address</th>
<td><input type='text' name='email' id='email' value='<?php echo $email;?>' readonly></td>
<th>Vat Number</th>
<td><input type='text' name='vatno' id='vatno'value='<?php echo $vatno;?>' readonly></td>
</tr>
<tr>
<td><button type='button' name='add' id='add' onclick='writable()'>Add</button></td>
<td><button type='button' name='edit' id='edit' onclick='editable()' disabled>Edit</button></td>
<td><button type='button' name='save' id= "save" onclick='writedata()' disabled> Save</button></td>
<th> <input type = 'reset' name='reset' id='reset' onclick='revert()' disabled></th>

</tr>
</table>
<br>
</form>
</div>
</div>
</div>
<div class='side'>
<h3 class='header'> Right SideBar</h3>
</div>
</div>
<script>
function writable()
{
	 document.getElementById("save").disabled= false;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("lordname").readOnly= false;
	 document.getElementById("lordname").value= '';
	 document.getElementById("lordname").focus();
	 document.getElementById("phone").readOnly= false;
	 document.getElementById("phone").value= '';
	 document.getElementById("email").readOnly= false;
	 document.getElementById("email").value= '';
	 document.getElementById("vatno").readOnly= false;
	 document.getElementById("vatno").value= '';
	 document.getElementById("xstat").value= '1';
	 }
</script>

<script>
function editable()
{
	 document.getElementById("save").disabled= false;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("edit").disabled= true;
	  document.getElementById("lordname").readOnly= false;
	 document.getElementById("lordname").focus();
	 document.getElementById("phone").readOnly= false;
	 document.getElementById("email").readOnly= false;
	 document.getElementById("vatno").readOnly= false;
	 document.getElementById("xstat").value= '2';
	 }
</script>

<script>
function writedata()
{
	document.getElementById("add").disabled= false;
	document.getElementById("reset").disabled= true;
	document.getElementById("save").disabled= true;
	var lordname = document.getElementById("lordname").value;
	var lordcode = document.getElementById("lordcode").value;
	var phone = document.getElementById("phone").value;
	var email = document.getElementById("email").value;
	var vatno = document.getElementById("vatno").value;
	var vatno = document.getElementById("vatno").value;
	var xstat = document.getElementById("xstat").value;
	document.getElementById("lordname").readOnly=true;
	document.getElementById("phone").readOnly=true;
	document.getElementById("email").readOnly=true;
	 document.getElementById("vatno").readOnly=true;
	//alert(lordname);
	var frmdata ='lordname='+lordname + '&lordcode='+lordcode+'&phone='+phone + '&email=' +email + '&vatno=' + vatno+'&xstat='+xstat;
	alert(frmdata);
	if (lordname=='')
	{
		alert('Enter Landlord Name');
		return false;
	}else
	{
		$.ajax({
		 type: "POST",
		 url: "postlord.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		 		 		 });
			}	 
		//return false;
		
}
</script>
<script>
		
		$(document).ready(function() {
		$('#serch').click(function(e) {
			e.preventDefault();
		var lordcode = $('#lordcode').val();
		var xstat = $('#xstat').val();
		//alert(plotcode);
		$.ajax({
			method: 'post',
			url: 'lordtls.php',
			data: {'lordcode': lordcode,'xstat': xstat},
			dataType: "text",
			success: function(response) {
				$('#mydata').html(response);
			}
					
		});
		});
		});
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