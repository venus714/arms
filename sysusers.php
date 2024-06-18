<?PHP
$username = "";
$email='';
$phone='';
$errorMessage='';
$password='';

require 'configure.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$password=$_POST['pwd'];
	$aclevel = $_POST['aclevel'];
	if ($aclevel=='1')
	{
		$useraccess=str_repeat('1',150);
	} else {
		$useraccess=str_repeat('0',150);
	}
	
	//$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DBASE);

	if ($conn) {		
		$sql = "SELECT * FROM sysusers WHERE username = '$username'";
		$result = mysqli_query($conn,$sql);
		 
		if (mysqli_num_rows($result) > 0) {
			//$errorMessage = "Phone No. already in use";
		echo '<br>';	
		echo "Name already in use";
		}
		else {
		$pwdhash = password_hash($password, PASSWORD_DEFAULT);
		$sql1 = "INSERT INTO sysusers(username,phone,email,password,ulevel,useraccess) 
		VALUES('$username','$phone','$email','$pwdhash','$aclevel','$useraccess')";
		if (mysqli_query($conn,$sql1)) {
		echo "Record Created";
		//header ("Location: chatlogin.php");
		} else {
		echo '<br>';
		echo "update failed";
		}
		}
	}
	else {
		$errorMessage = "Database Not Found";
	}
	echo $errorMessage;
}
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
<title>SignUp</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/mystyle.css">

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
<?php //include 'myheader3.php';?>


<div class='row'>
<div class='sidebar'>
<h3 class='header'>Left Sidebar</h3>
</div>
<div class='middlebar'>
<h3 class='header'>LOGIN YOUR CREDENTIALS</h3>
<div class='mypara'>
<form method='POST' autocomplete='false' ACTION="">
<input type='hidden' name='hide' autocomplete='nob'>
<input autocomplete="false" name="hidden" type="text" style="display:none;">
<table><tr>
<th>Login Name:</th>
<td><input type='text' name='username' value='<?php echo $username;?>' id='usrname' autocomplete='new-user' required></td>
</tr>
<th>Phone Number</th>
<td><input type='text' name='phone' value='<?php echo $phone;?>' id='phone' required autocomplete='new phone'></td>
</tr>
<th>Your Email:</th>
<td><input type='text' name='email' value='<?php echo $email;?>' id='email' autocomplete='email'></td>
</tr>
<th>PassWord</th>
<td><input type='password' name='pwd' value='123' id='pwd' autocomplete ='new-password'></td>
</tr>
<th>Access Level</th>
<td><select name='aclevel' id='aclevel' style='width: 150px;height:25px;'>
<option value='01'>Administrator</option>
<option value='02'>Manager</option>
<option value='03'>Accountant</option>
<option value='04'>User</option>
<option value='05'>Guest</option>
</select>
</td>
</tr>
</table>
<br>
<div class='hz'>
<input type='submit' name='submit' value='Submit' class='button1'>
<input type = 'reset' name='reset' value='Reset' class='button1'>
</div>
</form>
</div>
</div>
<div class='sidebar'>
<h3 class='header'>Right Sidebar</h3>
</div>
</div>
</body>
</html>