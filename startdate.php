<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$plotcode = $_POST['plotcode'];
$pcode='01';

$zdate1 = "select MAX(rdate) as date1 from remittance where plotcode='$plotcode' and pcode=$pcode";
$zdate2 = $conn->query($zdate1);
$zdate3 = $zdate2->fetch_assoc();
$date1 = $zdate3['date1'];
echo "<input type='date' name='date1' id='date1' value='$date1'>";
?>