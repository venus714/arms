<?php
include 'configure.php';
//$database='property';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$id=$_POST['userid'];

//get menu names
$sql1 ="select distinct submenu.menuid,mainmenu.menuname from submenu inner join mainmenu on submenu.menuid=mainmenu.id";
$sql2 = $conn->query($sql1);

$qry1 = "select useraccess from sysusers where id='$id'";
$result = $conn->query($qry1);
$row = $result->fetch_assoc();
$useraccess =trim($row['useraccess']);
$userarray = str_split($useraccess);
$id=1;
foreach($userarray as $key=>$value)
{
	$stat=$userarray[$key];
	$str1 = "update submenu set stat='$stat' where id='$id'";
	$str2 = $conn->query($str1);
	$id=$id+1;
}

echo "<table>";
while ($row = $sql2->fetch_assoc())
{	
	$menuname=$row['menuname'];
	$menuid = $row['menuid'];
echo "<tr><td colspan='3' style='font-weight: bold'>$menuname</td>";
$qry1 = "select id,subname, stat from submenu where menuid='$menuid'";
$qry2 = $conn->query($qry1);
while ($rowz=$qry2->fetch_assoc())
{
	$subname= $rowz['subname'];
	$stat = $rowz['stat'];
	$id = $rowz['id'];

echo "<tr><td style='width: 30%'>$id</td><td style='width: 40%'>$subname</td>";
if ($stat=='1')
{
echo "<td class='width: 30%'><div id='ur'><input type='checkbox' name[]='stat' class='stat' value='$stat' checked></div></td></tr>";
} else {
echo "<td class='width: 30%'><div id='ur'><input type='checkbox' name[]='stat' class='stat' value='$stat'></div></td></tr>";
}	
}}
echo "</table>";
?>