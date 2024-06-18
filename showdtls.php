<?php
require "configure.php";
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$zplots ="select plotcode,plotname from plots";
$rez = $conn->query($zplots);
$kplots ="select plotcode,plotname from plots";
$rezult = $conn->query($kplots);

$qtr = "select * from rentschedule";
$qtrz = $conn->query($qtr);

$houseid=$_POST['houseid'];
$str1 = $conn->prepare("select * from tenants where houseid=?");
$str1->bind_param('s', $houseid);
$str1->execute();
$str2=$str1->get_result();


if ($str2->num_rows > 0) {
$row = $str2->fetch_assoc();
$plotcode = $row['plotcode'];
$housecode = $row['housecode'];
$houseid= $row['houseid'];
$tenant = $row['tenant'];

$idno = $row['idno'];
$phone = $row['phone'];
$email = $row['email'];
$gender = $row['gender'];
$rent = number_format($row['rent'],2);
$quarter = $row['quarter'];
$datein = $row['datein'];
$nextkin =$row['nextkin'];
$kinrelation = $row['kinrelation'];
$kinphone = $row['kinphone'];
$kinemail = $row['kinemail'];
$opt = '2';

echo "<div class='mypara'>";
echo "<form method='post' action='' autocomplete='off'>";
echo "<input type='hidden' autocomplete='false'>";
echo "<table>";
echo "<tr><td><input type='hidden' name='plotcode' id='plotcode' value='$plotcode'></td>";
echo "<td><input type='hidden' name='housecode' id='housecode' value='$houseid'></td></tr>"; 
echo "<tr>";
echo "<th><label>Tenant Name</label></th>";
echo "<td><input type='text' name='tenant' id='tenant' value='$tenant' readonly></td>";
echo "<th><label>Gender</label></th>";
echo "<td><select ' name='gender' id='gender' value='$gender'>'>";
echo "<option value='M'>Male</option>";
echo "<option value ='F'>Female</option>";
echo "</select>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th>ID Number</th>";
echo "<td><input type='text' name='idno' id='idno' value='$idno' readonly></td>";
echo "<th> Phone Number</th>";
echo "<td><input type='text' name='phone' id='phone' value='$phone' readonly></td>";
echo "</tr>";
echo "<tr>";
echo "<th> Email Address</th>";
echo "<td><input type='text' name='email' id = 'email' value='$email' readonly></td>";
echo "<th>Payment Schedule</th>";
echo "<td><select name='quarter' id ='quarter' value  = '$quarter'>";

while ($row = $qtrz->fetch_assoc())
{
$nmonths = $row['nmonths'];
$description = $row['description'];
echo "<option value='$nmonths'>$description</option>";
}
echo "</select></td>";
echo "</tr><tr>";
echo "<th>Date MoveIn</th>";
echo "<td><input type='date' name='datein' id='datein' value = '$datein' readonly></td>";
echo "<th>Rent Per Month</th>";
echo "<td> <div id='txtrent'><input type = 'text' name='rent' id='rent' value='$rent' readonly style='text-align: right'>";
echo "</div>";
echo "</td>";
echo "<tr>";
echo "<th>Next of Kin</th>";
echo "<td><input type ='text' name='nextkin' id = 'nextkin' value = '$nextkin' readonly></td>";
echo "<th> Kin Relation</th>";
echo "<td><input type ='text' name='kinrelation' id = 'kinrelation' value = '$kinrelation' readonly></td>";
echo "</tr>";
echo "<tr>";
echo "<th>Kin Phone Number</th>";
echo "<td><input type ='text' name='kinphone' id = 'kinphone' value = '$kinphone' readonly></td>";
echo "<th> Kin Email</th>";
echo "<td><input type ='text' name='kinemail' id = 'kinemail' value = '$kinemail' readonly></td>";
echo "</tr>";
echo "<td><input type='hidden' name='opt' id='opt' value='$opt'></td></tr>";
echo "<tr>";
echo "<td><button type='button' name='add' id='add' onclick='writable()'>Add</button></td>";
echo "<td><button type='button' name='edit' id='edit'  onclick='editdata()'>Edit</button></td>";
echo "<td><button type='button' name='save' id='save'  onclick='writedata()' disabled>Save</button></td>";
echo "<td><input type = 'reset' name='reset' id='reset' onclick='revert()' disabled></td>";
echo "</tr>";
echo "</table>";
echo "<br>";
echo "</form>";
echo "</div>";
}
?>