<?php
include 'configure.php';

$cat1 = "select catcode,catname from unitcat";
$cat2 = $conn->query($cat1);

$sql1 = "select * from houseunits WHERE houseid = ?";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$result1=$stmt->get_result();
$row1 = $result1->fetch_assoc();
$rent = $row1['rent'];
$wateracc= $row1['wateracc'];
$elecacc= $row1['elecacc'];
$area = $row1['area'];
$housecode = $row1['housecode'];
$plotcode = $row1['plotcode'];
$xstat='0';
echo "<form method='POST'  autocomplete='off'>";
echo "<input type='hidden' id='xstat' name='xstat' value='$xstat'>";
echo "<table><tr><th>Unit No.</th>";
echo "<td><input type ='text'  id='unitno' name='unitno' value='$housecode' readonly></td>";
echo "<th>Unit Category</th><td><select name='cat' id='cat' style='width: 150px;height: 25px;'>";
while ($row1 = $cat2->fetch_assoc())
{
	$catcode= $row1['catcode'];
	$catname = $row1['catname'];
	echo "<option value = '$catcode'>$catname</option>";
}
echo "</select></td></tr>";
echo "<tr><th>Rent Per Month</th>";
echo "<td><input type='text' name='rent' id='rent' value='$rent' readonly></td>";
echo "<th>Water Meter No.</th>";
echo "<td><input type='text' name='wateracc' id='wateracc' value='$wateracc' readonly></td>";

echo "</tr>";
echo "<tr><th> Electr Metre No.</th>";
echo "<td><input type='text' name='elecacc' id='elecacc' value='$elecacc' readonly></td>";
echo "<th>Area in SQR feet</th>";
echo "<td><input type='text' name='area' id = 'area' value='$area' readonly></td></tr>";
echo "<tr><td><input type = 'hidden' name='h1' id ='h1' value = '$plotcode'>";
echo "</tr><td><button type='button' name='add' id='add' onclick='writable()' disabled>Add</button></td>";
echo "<td><button type='button' name='edit' id='edit' onclick='editable()'>Edit</button></td>";
echo "<td><button type='button' name='save' id='save'  onclick='writedata()' disabled>Save Data</button></td>";
echo "<th> <input type = 'reset' name='reset' id='reset' onclick='revert()' disabled></th>";
echo "</tr></table><br></form>";
?>