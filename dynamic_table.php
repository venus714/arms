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
		if(i == 3){ 
			var radioinput = document.getElementById('col3').getElementsByTagName('input'); 
			for(var j = 0; j <= radioinput.length; j++) { 
				if(radioinput[j].type == 'radio') { 
					var rownum = rowCount;
					radioinput[j].name = 'gender['+rownum+']';
				}
			}
		}
	}
}
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

function savedata()
{
	var name =document.getElementsByClassName('empname');
	empname = Array.from(name);
	var v='';
	for (i=0;i<name.length;i++)
	{ 
	empname[i]=name[i].value;
	p=name[i];
	v = v + "name[" + i + "].value= "+ p.value + " "; 
	}
	
	var iphone =document.getElementsByClassName('phone');
	phone = Array.from(iphone);
	for (i=0;i<iphone.length;i++)
	{ 
	phone[i]= iphone[i].value;
	}
	
	var depart1 =document.getElementsByClassName('department');
	depart = Array.from(depart1);
	for (i=0;i<depart1.length;i++)
	{ 
	depart[i]= depart1[i].value;
	}
	
	document.getElementById('test').innerHTML= v;//empname;
	//alert(empname);
	const idx=empname.keys();
	formdata = 'empname[]=' +empname + '&phone[]='+phone + '&depart[]='+depart;
	alert (formdata);
	
	if (empname == '' ) {
		alert("Please Type the Name");
		return false;
	}
	else { //alert(town);


	// AJAX code to submit form.
	$.ajax({
		 type: "POST",
		 url: "postdtls.php", //call storeemdata.php to store form data
		 //data: { myData : JSON.stringify(formdata) },
		 data: formdata,
		 cache:false,
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
			<th>Gender</th> 
		</tr> 
		<tr> 
			<td id="col0"><input type="text" class ='empname' name="empname[]" value="" /></td> 
			<td id="col1"><input type="text" class='phone' name="phone[]" value="" /></td> 
			<td id="col2"> 
			<select name="department[]" class="department"> 
			<option value="0">Select Department</option> 
			<option value="1">Sales</option>
			<option value="2">IT</option>
			<option value="3">Warehouse</option>
			</select> 
		        </td> 
		     <td id="col3"> 
			<input type="radio" name="gender[0]" value="male" />Male 
			<input type="radio" name="gender[1]" value="female" />Female
			<input type="radio" name="gender[2]" value="others" />Others
		        </td> 
		</tr>  
	</table> 
	<br>
	<table> 
		<tr> 
			<td><input type="button" value="Add Row" onclick="addRows()"></td> 
			<td><input type="button" value="Delete Row" onclick="deleteRows()"></td> 
			<td><input type="submit" name = 'submit' id='sub'value="Submit"></td>
			<td><input type="button" name='save' value="Save Data" onclick="savedata()"></td>
			</tr>  
	</table> 
</div>
 </form>
</body> 
</html>