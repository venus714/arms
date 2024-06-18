<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$plotcode = $_POST['plotcode'];
$unitcode =trim(strtoupper($_POST['housecode']));
$housecode =$_POST['housecode'];
$rent =$_POST['rent'];
$catcode= $_POST['catcode'];
$wateracc =$_POST['wateracc'];
$elecacc=$_POST['elecacc'];
$area = $_POST['area'];
$str1 = trim(strval($plotcode));
$houseid = trim($str1.$unitcode);
$vacant = '0';
$xstat= $_POST['xstat'];

if ($xstat=='1')
{
$qry1="select * from houseunits where houseid= '$houseid'";
$ans1= $conn->query($qry1);

if($ans1->num_rows > 0)
{
	
	echo "<span style='color: Red;font-weight: bold;padding-left: 10px;'>Unit No Already in Use</span>";
}
else { 
//$response['success'] = true;
$sql=$conn->prepare("insert into houseunits(plotcode,housecode,houseid,rent,wateracc,elecacc,catcode,area,occupied) values(?,?,?,?,?,?,?,?,?)");
$sql->bind_param("ississiii",$plotcode,$unitcode,$houseid,$rent,$wateracc,$elecacc,$catcode,$area,$vacant);
$sql->execute();
echo "<span style='color: green;font-weight: bold;padding-left: 10px;'>Unit Added Successfully</span>";
}} else {
$sql1 = "update houseunits set rent='$rent',wateracc='$wateracc',elecacc='$elecacc' where plotcode='$plotcode' and housecode='$housecode'";
$sql2 = $conn->query($sql1);
echo "<span style='color: green;font-weight: bold;padding-left: 10px;'>Unit Updated Successfully</span>";
}
?>