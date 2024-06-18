<?php
$nmonth=date("m");
$nyear = date("Y");
$mdate = date("Y-m-d");
include 'configure.php';
//$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
    $sql1 = "select plotcode,plotname from plots";
	$sql2 = $conn->query($sql1);
?>

<html>
<head>
<title>Disbursements</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<script src ="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
function addRows(){
	var table = document.getElementById('emptbl');
	var rowCount = table.rows.length;
	var cellCount = table.rows[0].cells.length; 
	var row = table.insertRow(rowCount);
	for(var i =0; i <= cellCount; i++){
		var cell = 'cell'+i;
		cell = row.insertCell(i);
		var copycel = document.getElementById('col'+i).innerHTML;
		cell.innerHTML=copycel;
}}
function deleteRows(){
	var table = document.getElementById('emptbl');
	var rowCount = table.rows.length;
	if(rowCount > '2'){
		var row = table.deleteRow(rowCount-1);
		rowCount--;
	}
	else{
		alert('There should be atleast one row');
	}
}

function clearows(){
	var table = document.getElementById('emptbl');
	var rowCount = table.rows.length;
	while (rowCount > '2'){
		var row = table.deleteRow(rowCount-1);
		rowCount--;
}
var narr=document.getElementsByClassName('narrative');
for (i=1;i<narr.length;i++)
narr[i].value='';
}

function savedata()
{
	var plotcode= document.getElementById('prop').value;
	var nyear= document.getElementById('nyear').value;
	var nmonth= document.getElementById('nmonth').value;
	document.getElementById('btn4').disabled=false;
	
	var narrative =document.getElementsByClassName('narrative');
	descript = Array.from(narrative);
	for (i=0;i<narrative.length;i++)
	{ 
	descript[i]=narrative[i].value;
	
	}
	
	var disburse =document.getElementsByClassName('amount');
	amount = Array.from(disburse);
	for (i=0;i<disburse.length;i++)
	{ 
	amount[i]= disburse[i].value;
	}
	
	var date1 =document.getElementsByClassName('date1');
	date2 = Array.from(date1);
	for (i=0;i<date1.length;i++)
	{ 
	date2[i]= date1[i].value;
	}
	
	
	formdata = 'descript[]=' +descript + '&amount[]='+amount + '&plotcode='+plotcode+'&nyear='+nyear + '&nmonth='+nmonth+'&date2[]='+date2;
		//alert(formdata);
	if (descript == '' ) {
		alert("Please Type the narrative");
		return false;
	}
	else { 
	
	$.ajax({
		 type: "POST",
		 url: "postdisburses.php", //call storeemdata.php to store form data
		 //data: { myData : JSON.stringify(formdata) },
		 data: formdata,
		 cache:false,
		 		 		 });
			}	 
		//return false;
}
</script>
<style>
table {
    border: 1px solid;
	width: 100%;
}

th,td {
	border: 1px solid;
	padding: 5px;
}
table {
	  border-collapse: collapse;
	 
}
input[type="text"],input[type="date"] {
     width: 100%; 
     height: 30px;
	 box-sizing: border-box;
     -webkit-box-sizing:border-box;
     -moz-box-sizing: border-box;
}
textarea {
	width: 100%;
}

.right {
	text-align: right;
	padding-right: 10px;
}

.empname {color: red;}
</style>
</head>
<body>
<div class='menu'>
<?php include 'mymenu.php';?>
</div>
<?php include 'myheader3.php';?>


<div class='row'>
<div class='side'>
<div class='mypara'>
<form method='post'>
<label>Property</label><br>
<select name='prop' id='prop' style='width: 150px;height: 25px;' onchange='clearows()'>
<?php
while ($row=$sql2->fetch_assoc())
{
	$plotcode = $row['plotcode'];
	$plotname = $row['plotname'];
echo "<option value='$plotcode'>$plotname</option>";
}
?>
</select><br><br>
<label>Month</label><br>
<input type='text' name='nmonth' id='nmonth' value='<?php echo $nmonth;?>'><br><br>
<label>Year</label><br>
<input type='text' name='nyear' id='nyear' value='<?php echo $nyear;?>'><br>
</form>
</div>
</div>
<div class='middle'>
<div id='mypara'></div>
<form action="" method="post">
	<table id="emptbl">
		<tr>
			<th style='width: 60%'>Narrative</th>
			<th style='width: 20%'>Amount</th>
			<th style='width: 20%'>Date</th> 
			</tr> 
		<tr> 
			<td id="col0"><textarea  class ='narrative' name="narrative[]"></textarea></td>
			<td id="col1"><input type="text" class='amount' name="amount[]" value=""></td> 
			<td id="col2"><input type="date" class='date1' name="date1[]" value="<?php echo $mdate;?>"></td>
			  
		</tr>
		</table>
		<br>
			<input type="button" value="Add Record" onclick="addRows()">
			<input type="button" value="Delete Record" onclick="deleteRows()">
			<input type="button" name='save' value="Save Data" onclick="savedata()">
			<input type="button" id='btn4' value="Clear Records" onclick="clearows()" disabled style='text-align: right'>
 </form> 
 </div>
 </div>
 <div class='side'>
 </div>
 </div>
</body> 
</html>