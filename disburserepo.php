<html>
<head>
<style>
.right {
	text-align:right;
	padding-right:10px;
}
.th {
	border: 1px solid black;
	padding-left: 5px;
}

.td {
	border: 1px solid black;
	padding-right: 10px;
	text-align: right;
}
</style>
</head>
</html>
<?php
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE );
$plotcode = $_POST['plotcode'];
$date1 = $_POST['date1'];
$date2 = $_POST['date2'];


$disbur1 = "create or replace view disburses as select * from disbursement where plotcode='$plotcode'
and trans_date between '$date1' and '$date2'";
$disbur2 = $conn->query($disbur1);

$qry1 = "select trans_date,amount,description from disburses";
$qry2 = $conn->query($qry1); 
$summ1 = "select sum(amount) as amount from disburses group by plotcode";
$summ2 = $conn->query($summ1);

echo "<table><tr><th class='th'>Date</th><th class='th'>Description</th> <th class='td'>Amount</th></tr>";
while ($db=$qry2->fetch_assoc())
{
$date = $db['trans_date'];
$description = $db['description'];
$amount= number_format($db['amount'],2);
echo "<tr><td class='th'>$date</td><td class='th'>$description</td><td class='td'>$amount</td></tr>";
}
$row1=$summ2->fetch_assoc();
$zamount = number_format($row1['amount'],2);
echo "<tr><th colspan=2 class='th'>Totals</th><td class='td'>$zamount</td></tr>";
echo "</table>";
?>