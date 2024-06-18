<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$menuname = strtoupper($_POST['menuname']);

$sql=$conn->prepare("insert into mainmenu(menuname) values(?)");
$sql->bind_param("s",$menuname);
$sql->execute();
$qry1 = "select * from mainmenu";
$qry2 = $conn->query($qry1);
echo "<table class='table'>";
echo "<tr>";
echo "<th class='th'>Menu Name</th>";
echo "</tr>";
while ($row=$qry2->fetch_assoc())
{
	$menuname = $row['menuname'];
echo "<tr>";
echo "<td class='td'>$menuname</td>";
echo "</tr>";
}
echo "</table>";
?>