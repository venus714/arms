<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$refno = $_POST['refno'];
$advance = $_POST['advance'];
$date1 = $_POST['date1'];
$narrative =$_POST['narrative'];
$sql="update bankexp set amount='$advance',trans_date='$date1',narrative='$narrative' where id='$refno'";
$result = $conn->query($sql);
echo "<p style='color: green;text-align: center;font-weight: bold;'>Update Successfully done</p>";
?>