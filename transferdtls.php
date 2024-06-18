<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
//$stmt->bind_param("i", $_GET['q']);
$str1 = $conn->prepare("select * from tenants where tenantcode=?");
$str1->bind_param('i', $_GET['q']);
$str1->execute();
$str2=$str1->get_result();

$row = $str2->fetch_assoc();
$plotcode = $row['plotcode'];
$str3 = "select housecode,houseid from houseunits where plotcode=$plotcode and occupied='0'";
$str4 = $conn->query($str3);
$housecode1= $row['housecode'];
$houseid1 = $row['houseid'];
$tenantcode= $row['tenantcode'];
$tenant = $row['tenant'];
$idno = $row['idno'];
$phone = $row['phone'];
$email = $row['email'];
$rent = $row['rent'];
$datein = $row['datein'];
$transdate = date('Y-m-d');

echo "<div class='mypara'>";
echo "<h3 class='header'>Tenants Details</h3>";
echo "<form method='post' action='' autocomplete='off'>";
echo "<input type='hidden' id ='hsecode1' name='hsecode1' value ='$housecode1' autocomplete='false'>";
echo "<input type='hidden' id ='hseid1' name='hseid1' value ='$houseid1' autocomplete='false'>";
echo "<table>";
echo "<tr>";
echo "<th>Tenant Name</th>";
echo "<td><input type='text' name='tenant' id='tenant' value='$tenant' readonly></td>";
echo "<th>ID Number</th>";
echo "<td><input type='text' name='idno' id='idno' value=' $idno' readonly></td>";
echo "</tr>";
echo "<tr>";
echo "<th> Phone Number</th>";
echo "<td><input type='text' name='phone' id='phone' value='$phone' readonly></td>";
echo "<th> Email Address</th>";
echo "<td><input type='text' name='email' id = 'email' value='$email' readonly></td>";
echo "</tr>";
echo "<th>Date MoveIn</th>";
echo "<td><input type='text' name='datein' id='datein' value = '$datein' readonly></td>";
echo "<th>Rent Per Month</th>";
echo "<td><input type = 'text' id='rent' name='rent' value='$rent' readonly>";
echo "</td></tr>";
echo "<tr>";

echo "<th>Vacant Units</th>";
echo "<td><select name='hseid1' id='hseid2' style='width:200px;height:25px;' onblur='dataupdate(this.value)'>";

while ($row2 = $str4->fetch_assoc())
	{
	$housecode= $row2['housecode'];
	$houseid = $row2['houseid'];
echo "<option value='$houseid'>$housecode</option>";
	}
echo "</select></td>";

echo "<th>Date Transfered</th>";
echo "<td><input type='text' name='dtrans' id='dtrans' value='$transdate'></td>";
echo "</tr>";
echo "<tr>";
echo "<th></th>";
echo "<td>";
echo "<div id ='hseid'>";
echo "</div>";
echo "</td>";
echo "</tr>";
echo "<th></th>";
echo "<td><button type='button' name='save' id='save'  onclick='writedata()' disabled>Confirm Vacation</button></td>";
echo "<th> <input type = 'reset' name='reset' id='reset' onclick='revert()' disabled></th>";
echo "</tr>";
echo "</table>";
echo "<br>";
echo "</form>";
echo "</div>";
?>