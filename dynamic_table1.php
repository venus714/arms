<?php
    if(isset($_POST['submit']))
    {
		require "configure.php";
		$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
		$emp = $_POST['empname'];
		var_dump ($emp);
	    foreach ($_POST['empname'] as $key => $value) 
        {
            $empname = $_POST["empname"][$key];
            $phone = $_POST["phone"][$key];
            $department = $_POST["department"][$key];
				$sql =("insert into persons(empname,phone,department) values ('$empname','$phone','$department')");
			$conn->query($sql)==true;
	    }
	}		
?>

<html>
<head>
<title>Onclick increase Table Rows</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">

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
		}
}
function deleteRows(){
	var table = document.getElementById('emptbl');
	var rowCount = table.rows.length;
	if(rowCount > '2'){
		var row = table.deleteRow(rowCount-1);
		
	}
	else{
		alert('There should be atleast one row');
	}
}

function savedata() {
	var empname=[];
	var phone =[];
	
	$('.empname').each(function(){
		empname.push($this).text();
	})
	
	$('.phone').each(function(){
		empname.push($this).text();
	})
		
	document.getElementById('test').innerHTML= empname;
	//alert(empname[1].value);
	//var formdata1 ='empname1[]='+ empname + '&phone[]='+phone;
	//var empname = JSON.stringify(empname);
	//console.log('empname');
	
	if (empname == '' ) {
		alert("Please Type the Name");
		return false;
	}
	else { //alert(town);


	// AJAX code to submit form.
	$.ajax({
		 type: "POST",
		 url: "postdtls.php", //call storeemdata.php to store form data
		 data: {empname:empname,phone: phone},
		 cache: false,
		 		 		 });
			}	 
		//return false;
}
</script>
<style>
table, td, th {
  border: 1px solid;
}

table {
   border-collapse: collapse;
}
.empname {color: red;}
</style>
</head>
<body>
<form action="" method="post">
<div id='test'></div>    
	<table id="emptbl">
		<tr>
			<th>Employee Name</th>
			<th>Phone</th>
			<th>Department</th> 
		</tr> 
		<tr> 
			<td id = "col0" class='empname'><input type="text" class ='empname' name="empname[]" value="" /></td> 
			<td id = "col1" class='empname'><input type="text" class='phone' name="phone[]" value="" /></td> 
			<td id="col2"> 
			<select name="department[]" class="department"> 
			<option value="0">Select Department</option> 
			<option value="1">Sales</option>
			<option value="2">IT</option>
			<option value="3">Warehouse</option>
			</select> 
		     </td> 
		    </tr>  
	</table> 
	<br>
	<table> 
		<tr> 
			<td><input type="button" value="Add Row" onclick="addRows()"></td> 
			<td><input type="button" value="Delete Row" onclick="deleteRows()"></td> 
			<td><input type="submit" name = 'submit' id='sub'value="Submit"></td>
			<td><input type="button" name='save' id='save' value="Save Data" onclick="savedata()"></td>
			</tr>  
	</table> 
 </form> 
</body> 
</html>