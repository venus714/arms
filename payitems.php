<?php
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$pcode = $_POST['pcode'];
$pname = $_POST['pname'];

$qry1="select * from receivables where pcode= '$pcode'";
$ans1= $conn->query($qry1);

if($ans1->num_rows > 0)
{
	
echo "<span style='color: Red;font-weight: bold;padding-left: 10px;'>Pay Code Already in Use</span>";
}
else { 
$sql=$conn->prepare("insert into receivables(pcode,description) values(?,?)");
$sql->bind_param("ss",$pcode,$pname);
$sql->execute();
$qry1 = "select * from receivables";
$qry2 = $conn->query($qry1);
echo "<table class='table'>";
echo "<tr>";
echo "<th class='th'>Pay Code</th><th class='th'>Pay Name</th>";
echo "</tr>";
while ($row=$qry2->fetch_assoc())
{
	$pcode= $row['pcode'];
	$description = $row['description'];
echo "<tr>";
echo "<td class='td'>$pcode</td><td class='td'>$description</td>";
echo "</tr>";
}
echo "</table>";
}
?>