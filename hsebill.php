<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );

$sql1 = "select housecode from houseunits WHERE plotcode = ? ";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("i", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();
echo "<button type='button' name='btn1' id='btn1' onclick='house()' disabled>Update Amount</button><br><br>";
echo "<select name='zcode' id = 'zcode' style='width:150px;height:25px;' onblur='enabler()' disabled>";
while ($row=$result1->fetch_assoc()) {
	$housecode=$row['housecode'];
	echo "<option value='$housecode'>$housecode</option>";
}
	echo "</select>";
	echo "<br><br>";
	echo "<label>Enter Amount</label><br>";
	echo "<input type='text' name='amt' id='amt' disabled>";
	echo "<br><br>";
	echo "<button type='button' name='btn2' id='btn2' onclick='getamount()' disabled>Save</button>";
?>