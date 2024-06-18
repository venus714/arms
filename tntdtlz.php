<?php
$amount='0';
$reason = '';
$authority='';
$mdate=date('Y/m/d');
$description = '';
//$nmonth=date("m");
//$nyear = date("Y");
include 'configure.php';
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
//$stmt->bind_param("i", $_GET['q']);
$str1 = $conn->prepare("select * from tenants where tenantcode=?");
$str1->bind_param('i', $_GET['q']);
$str1->execute();
$str2=$str1->get_result();

$item1 = "select * from receivables order by pcode";
$itemcode = $conn->query($item1);

$row = $str2->fetch_assoc();
$housecode= $row['housecode'];
$houseid1 = $row['houseid'];
$tenantcode= $row['tenantcode'];
$tenant = $row['tenant'];

echo "<div class='mypara'>";
//echo "<h3 class='header'>Tenants Details</h3>";
echo "<form method='post' action='' autocomplete='off'>";
echo "<input type='hidden' id ='hsecode1' name='hsecode1' value ='$housecode' autocomplete='false'>";

echo "<table>";
echo "<tr>";
echo "<th>Tenant Name</th>";
echo "<td><input type='text' name='tenant' id='tenant' value='$tenant' readonly></td>";
echo "</tr>";
echo "<tr>";
echo "<th>Item Code</th>";
echo "<td><select name='itemcode' id='itemcode' style='width:150px;height:25px' onblur='getitem(this.value)'>";
while ($row1=$itemcode->fetch_assoc())
{
	$pcode=$row1['pcode'];
echo "<option value='$pcode'>$pcode</option>";
}
echo "</select>";
echo "</td>";
echo "<th>Item Description</th>";
echo "<td>";
echo "<div id='itemname'><input type='text' name='descript' id='descript' value='$description' readonly></div>";
echo "</td>";
echo "</tr>";
echo "<tr><th>Amount</th>";
echo "<td><input type='text' name='amt' id='amt' value='$amount' class='right'></td>";
echo "<th>Date</th>";
echo "<td><input type='text' name=mdate id='mdate' value='$mdate' readonly></td>";
echo "</tr>";
echo "</table>";
echo "<br>";
echo "<div style='text-align: center'>";
echo "<button type='button' id='btn1' class='button1' onclick='writedata()'>Save</button>";
echo "<button type='reset' id='btn2' class='button1' onclick='revert()'>Reset</button>";
echo "</div>";
echo "</form>";
echo "</div>";
?>