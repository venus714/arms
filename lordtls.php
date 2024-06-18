<?php
require "configure.php";
$xstat=0;
$lordcode=$_POST['lordcode'];
$str1 = $conn->prepare("select * from landlords where lordcode=?");
$str1->bind_param('i', $lordcode);
$str1->execute();
$str2=$str1->get_result();

if ($str2->num_rows > 0) {
$row = $str2->fetch_assoc();
$lordname = $row['lordname'];
$email = $row['email'];
$phone = $row['phone'];
$vatno = $row['vatno'];

echo "<div class='mypara'>";
echo "<form method='post' action='' autocomplete='off'>";
echo "<input type='hidden' id='xstat' name='xstat'>";
echo "<table><tr>";
echo "<th> Landlord Name</th>";
echo "<td><input type='text' name='lordname' id='lordname' value='$lordname' readonly></td>";
echo "<th>Telephone No.</th>";
echo "<td><input type='text' name='phone' id='phone' value='$phone' readonly></td></tr>";
echo "<tr><th>Email Address</th>";
echo "<td><input type='text' name='email' id='email' value='$email' readonly></td>";
echo "<th>Vat Number</th>";
echo "<td><input type='text' name='vatno' id='vatno'value='$vatno' readonly></td></tr>";
echo "<tr><td><button type='button' name='add' id='add' onclick='writable()'>Add</button></td>";
echo "<td><button type='button' name='edit' id='edit' onclick='editable()'>Edit</button></td>";
echo "<td><button type='button' name='save' id= 'save' onclick='writedata()' disabled> Save</button></td>";
echo "<th> <input type = 'reset' name='reset' id='reset' onclick='revert()' disabled></th></tr>";
echo "</table><br>";
echo "</form>";
echo "</div>";
}
?>