<?php
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$code=$_GET['q'];

$sql1 = "select housecode,rent, unitcat.catname,occupied as xstatus
from houseunits left join unitcat on houseunits.catcode=unitcat.catcode where plotcode='$code'";
$result = $conn->query($sql1);

echo "<form method='POST' action='unitspdf.php'>";
echo "<table>";
echo "<tr><th>Unit No.</th><th class='right'>Monthly Rent</th><th>Unit Category</th><th>Occupancy Status</th></tr>";
while ($row=$result->fetch_assoc())
{
	$housecode=$row['housecode'];
	$rent = number_format($row['rent'],2);
	$catname = $row['catname'];
	$xstatus = $row['xstatus'];
echo "<tr><td>$housecode</td><td class='right'>$rent</td><td>$catname</td><td class='hz'>$xstatus</td><tr>";
}
echo "</table>";
echo "<br><br>";
echo "<div class='hz'>";
echo "<input type ='hidden' name='h1' value='$code'>";
echo "<input type='submit' name='pdf' value='TO PDF'>";
echo "</div>";
echo "<form>";
?>