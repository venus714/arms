<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$menuid = strtoupper($_POST['menuname']);
$subname =strtoupper($_POST['submenu']);

$sql1= "insert into submenu(menuid,subname) values('$menuid','$subname')";
$sql2 = $conn->query($sql1);
$qry1 = "select menuname,subname from submenu inner join mainmenu on submenu.menuid=mainmenu.id";
$qry2 = $conn->query($qry1);

echo "<table class='table'>";
echo "<tr>";
echo "<th class='th'>Menu Name</th><th>Sub Menu</th>";
echo "</tr>";
while ($row=$qry2->fetch_assoc())
{
	$menuname = $row['menuname'];
	$subname = $row['subname'];
echo "<tr>";
echo "<td class='td'>$menuname</td><td class='td'>$subname</td>";
echo "</tr>";
}
echo "</table>";
?>