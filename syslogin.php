<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Login screen</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<style>
.zform {
	width:60%;
	margin-left:auto;
	margin-right: auto;
}
</style>
</head>
<?PHP
$username = "";
$password = "";
$errorMessage = "";
$qID='';
$imgname='';
if (isset($_POST['Submit1'])) {
//if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	require 'configure.php';
	$db_found = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if ($db_found) {
	$SQL = $db_found->prepare('SELECT * FROM sysusers WHERE username = ?');
	$SQL->bind_param('s', $username);
	$SQL->execute();
	$result = $SQL->get_result();

		if ($result->num_rows == 1) {

			$db_field = $result->fetch_assoc();
			$idno=$db_field['id'];
			$access = $db_field['useraccess'];

			if (password_verify($password, $db_field['password'])) {
				
				
				$_SESSION['login'] = $access;
				header ("Location: dashboard.php");
			}
			else {
				$errorMessage = "Login FAILED";
				//session_start();
				$_SESSION['login'] = '';
			}
		}
		else {
			$errorMessage = "Username FAILED";
		}
	}
}
?>
<div>
<?php include 'myheader3.php';?>
</div>
<body>
<div class='header'>
<h2 style='text-align:center;'>Login to Access the System</h2>
</div>

<div class='row'>
<div class='sidebar' style='height: 500px'>
<h3 style='color: blue'>LOGIN</h3>
<div class='gallery1'>
<img src='../images/login1.jpg'>
</div>
</div>

<div class='middlebar'>
<div class='mypara' style='text-align: center'>
<img src='../images/login2.jpg'>
<br><br><br>
<FORM NAME ="form1" METHOD ="POST" ACTION ="syslogin.php" autocomplete='off'>
<input type='hidden' autocomplete='false'>
<input autocomplete="false" name="hidden" type="text" style="display:none;">
<label>Username:</label><br> 
<INPUT TYPE = 'TEXT' Name ='username'  value="<?php echo $username;?>"<br><br><br>
<label>Password:</label><br>
<INPUT TYPE = 'password' Name ='password'  value="<?php echo $password;?>"><br>
<br>
<INPUT TYPE = 'Hidden' Name = 'h1'  VALUE = <?PHP print $qID; ?>>
<INPUT TYPE = "Submit" Name = "Submit1"  VALUE = "Login">
</FORM>
<P>
<?PHP print $errorMessage;?>
</div>
</div>

<div class='sidebar'>
<h3></h3>
</div>
</div>

</body>
</html>