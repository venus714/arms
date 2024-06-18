<?php
$str1='110001101101010';
$array1 = str_split($str1);
//print_r($array1);
echo "<table border='1'>";

foreach($array1 as $values)
{
if ($values=='1') {
echo "<tr><td><input type='checkbox' name='chk1' value='$values' checked>";
} else {
echo "<tr><td><input type='checkbox' name='chk1' value='$values'>";
}	
//echo "$values";

echo "</td></tr>";
}
?>