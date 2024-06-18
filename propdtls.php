<?php
require "configure.php";
$xstat=0;
$plotcode=$_POST['propcode'];
$str1 = $conn->prepare("select * from plots where plotcode=?");
$str1->bind_param('i', $plotcode);
$str1->execute();
$str2=$str1->get_result();

$lld = "select lordcode,lordname from landlords";
$rez = $conn->query($lld);

if ($str2->num_rows > 0) {
$row = $str2->fetch_assoc();
$plotname = $row['plotname'];
$town = $row['town'];
$estate = $row['estate'];
$lrno = $row['lrno'];
$units = $row['units'];
$mgtcom = $row['mgtcom'];
$mgtflat = $row['mgtflat'];
$rentvat= $row['rentvat'];
$lordvat = $row['lordvat'];

if ($rentvat=1)
{
	$status1='checked';
} else {$status1='unchecked';}

if ($lordvat=1)
{
	$status2='checked';
} else {$status2='unchecked';}

echo "<div class='mypara'>";
echo "<form method='post' action='' autocomplete='off'>";
echo "<input type='hidden' autocomplete='false'>";
echo "<table>";
//echo "<tr><td><input type='text' id='propcode' name='propcode' value='$plotcode'></td></tr>";
echo "<tr><th> Property Name</th>";
echo "<td><input type='text' name='plotname' id='plotname' value='$plotname' readonly></td>";
echo "<th>Lr Number</th>";
echo "<td><input type='text' name='lrno' id='lrno' value='$lrno' readonly></td></tr>";
echo "<tr> <th>Town</th>";
echo "<td><input type='text' name='town' id='town' value='$town' readonly></td>";
echo "<th>Estate/Location</th>";
echo "<td><input type='text' name='estate' id='estate'value='$estate' readonly></td></tr>";
echo "<tr><th>No. of Units</th>";
echo "<td><input type='text' name='units' id='units' value='$units' readonly></td>";
echo "<th>Property Type</th>";
echo "<td><select  name='ptype' id='ptype' style='width:150px;height: 25px;' readonly>";
echo "<option value='1'>Residential</option>";
echo "<option value ='2'>Commercial</option>";
echo "</select>";
echo "</td></tr>";

echo "<tr><th> Rent Mngt Comm</th>";
echo "<td><input type='text' name='mgtcom' id='mgtcom' value='$mgtcom'readonly></td>";
echo "<th>Rent Mngt Flat</th>";
echo "<td><input type='text' name='mgtflat' id = 'mgtflat' value='$mgtflat' readonly></td>";
echo "</tr><tr><th>landlord</th>";
echo "<td><select  name='lordcode' id = 'lordcode' style ='width:150px; height:25px;'>";

if ($rez->num_rows>0) {
while ($row = $rez->fetch_assoc())
{
	$lordcode = $row['lordcode'];
	$lordname = $row['lordname'];
	echo "<option value='$lordcode'>$lordname</option>";
}
}
echo "</select></td></tr>";
echo "<tr><td><input type='hidden' id='h1' name='h1' value='$xstat'></td>";
echo "<td><input type ='checkbox' id ='rentvat' name ='rentvat' value='1' $status1>Rent Vat</td>";
echo "<th></th><td><input type ='checkbox' id ='lordvat' name ='lordvat' value='1' $status2>LandLord Vat</td></tr>";
echo "<td><button type='button' name='add' id='add' onclick='writable()'>Add</button></td>";
echo "<td><button type='button' name='edit' id='edit' onclick='editable()'>Edit</button></td>";
echo "<td><button type='button' name='save' id='save' onclick='writedata()' disabled>Save</button></td>";
echo "<th> <input type = 'reset' name='reset' id='reset' value='Reverse' onclick='revert()' disabled></th>";
echo "</tr></table><br>";
echo "</form>";
echo "</div>";
}
?>