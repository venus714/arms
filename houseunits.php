<?php
$plotcode = '';
$plotname = '';
$housecode = "";
$catcode = "";
$rent = "";
$wateracc = "";
$elecacc = "";
$area = "";
$itemcode = '';
$xstat= '0';
require "configure.php";
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBASE);
$myplots ="select plotcode,plotname from plots";
$rez = $conn->query($myplots);
$rez1 = $conn->query($myplots);
$mycat = "select catcode,catname from unitcat";
$rez1 = $conn->query($mycat);

$plot1 = "select plotcode,plotname from plots";
$plot2 = $conn->query($plot1);

if (isset($_POST['savemex'])) {
$plotcode = $_POST['h1'];
//$plotname =$_POST['plotname'];
//$housecode =strtoupper($_POST['hseno']);
$housecode =$_POST['unitno'];
$unitcode =$_POST['unitno'];
$rent =$_POST['rent'];
$catcode= $_POST['cat'];
$wateracc =$_POST['wateracc'];
$elecacc=$_POST['elecacc'];
$area = $_POST['area'];

$qry1="select * from houseunits where plotcode=$plotcode and housecode= $unitcode";
$ans1= $conn->query($qry1);
if($ans1->num_rows>0)
{
echo "<script>alert('Unit Numner Already Posted')</script>";
}
else { 

$sql=$conn->prepare("insert into houseunits(plotcode,housecode,rent,catcode,wateracc,elecacc,area) values(?,?,?,?,?,?,?)");
$sql->bind_param("ssiissi",$plotcode,$unitcode,$rent,$catcode,$wateracc,$elecacc,$area);
$sql->execute();
}
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Property Units</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="mystyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="datascript.js"></script>
<style> 
	table {
		width: 100%;
	}
	th,td {
		padding: 10px;
		text-align: left;
	}
	.upper {
		text-transform: uppercase;
	}
</style>
</head>
<body>
<div class='menu'>
<?php include 'mymenu.php';?>
</div>
<?php include 'myheader3.php';?>

<div class='row'>
<div class='side'>
<h3 class='header'>Search Property</h3>
<select name='propcode' id='propcode' style='width: 150px;height: 25px' onblur='showunits(this.value)'>
<?php
while ($rox = $plot2->fetch_assoc())
{
		$propcode=$rox['plotcode'];
		$propname=$rox['plotname'];
	echo "<option value='$propcode'>$propname</option>";
	}
	?>
	</select>
<br><br>
<label>Unit No. </label>
<br><br>
<div id='txthint'>
<select style='width: 150px;height: 25px'>
<option>Hseno</option>
</select>
</div>
</div>

<div class='middle'>
<h3 class='header'>Property Units</h3>
<div class='mypara'>
<form method='post' action='' autocomplete='off'>
<input type='hidden' autocomplete='false'>
<table>
<th><label> Select Property</label></th>
<td><select name='plotcode' id ='plotcode' style='width:150px;height:25px;' disabled onblur="myfunction()">
<?php 
	while ($row=$rez->fetch_assoc())
	{
		$plotcode=$row['plotcode'];
		$plotname=$row['plotname'];
	echo "<option value='$plotcode'>$plotname</option>";
	}
	?>
	</select></td>
<td><button type ='button' name='resume' id='resume' onclick='rezume()'>Select</button></td>
</tr>
</table>
</form>
</div>

<br>
<div class='mypara'>
<div id = 'msg' class='hz'></div>
<h4 class='header'>Units Details</h4>
<div id='txtrent'>
<form method='POST'  autocomplete='off'>
<input type='hidden' id='xstat' name='xstat' value="<?php echo $xstat;?>">
<table>
<tr>
<th>Unit No.</th>
<td><input type ='text' class='upper' name='unitno' id ='unitno' value='<?php echo $housecode;?>'>
<th>Unit Category</th>
<td><select name='cat' id='cat' style='width: 150px;height: 25px;' >
<?php 
while ($row1 = $rez1->fetch_assoc())
{
	$catcode= $row1['catcode'];
	$catname = $row1['catname'];
	echo "<option value = '$catcode'>$catname</option>";
}
?>
</tr>
</select></td>
</tr>
<tr>
<th>Rent Per Month</th>
<td><input type='text' name='rent' id='rent' value='<?php echo $rent;?>' readonly></td>
<th>Water Meter No.</th>
<td><input type='text' name='wateracc' id='wateracc' value='<?php echo $wateracc;?>' readonly></td>
</td>
</tr>
<tr>
<th> Electr Metre No.</th>
<td><input type='text' name='elecacc' id='elecacc' value='<?php echo $elecacc;?>' readonly></td>
<th>Area in SQR feet</th>
<td><input type='text' name='area' id = 'area' value='<?php echo $area;?>' readonly></td>
</tr>
<tr>
<td><input type = 'hidden' name='h1' id ='h1' value = '<?php echo $plotcode;?>'>
</tr>
<tr>
<td><button type='button' name='add' id='add' onclick='writable()' disabled>Add</button></td>
<td><button type='button' name='edit' id='edit' onclick='editable()' disabled>Edit</button></td>
<td><button type='button' name='save' id='save'  onclick='writedata()' disabled>Save Data</button></td>
<th> <input type = 'reset' name='reset' id='reset' onclick='revert()' disabled></th>

</tr>
</table>
<br>
</form>
</div>
</div>
</div>
<div class='side'>
<h3 class='header'>Right Side Bar</h3>
</div>
</div>

<script>
function writedata()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
	document.getElementById("reset").disabled= true;
	var plotcode= document.getElementById("h1").value;
	var housecode=document.getElementById("unitno").value;
	var rent=document.getElementById("rent").value;
	var wateracc=document.getElementById("wateracc").value;
	var elecacc=document.getElementById("elecacc").value;
	var area=document.getElementById("area").value;
	var catcode=document.getElementById("cat").value;
	//var houseid=document.getElementById("houseid").value;
	var xstat=document.getElementById("xstat").value;
	//alert(housecode);
	var frmdata ='plotcode='+plotcode + '&housecode='+housecode + '&rent='+rent+ '&wateracc='+
	wateracc+'&catcode='+catcode+'&elecacc='+elecacc+'&area='+area+'&xstat='+xstat;
	//alert(frmdata);
	if (housecode == '' ) {
		alert("Please Type something");
		//$('#message').html('<span style="color:red">Please Fill the Unit number</span>');
		return false;
	}
	else {

	// AJAX code to submit form.
	$.ajax({
		 type: "POST",
		 url: "postunits.php", //call storeemdata.php to store form data
		 data: frmdata,
		 cache: false,
		  success: function(data) {
			 $('#msg').html(data);
		 }
		 		 		 });
			}	 
		//return false;
}
</script>

<script>
function rezume()
{
document.getElementById("plotcode").disabled= false;
document.getElementById("plotcode").focus();
}
</script>

<script>
function myfunction()
{
	var x =document.getElementById("plotcode").value
	document.getElementById("h1").value=x
	document.getElementById("add").disabled= false;
	document.getElementById("add").focus();
	document.getElementById("plotcode").disabled= true;
	
}
</script>

<script>
function writable()
{
	 document.getElementById("save").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("unitno").readOnly= false;
	 document.getElementById("unitno").value= '';
	 document.getElementById("unitno").focus();
	 document.getElementById("rent").readOnly= false;
	 document.getElementById("rent").value= '';
	 document.getElementById("wateracc").readOnly= false;
	 document.getElementById("wateracc").value= '';
	 document.getElementById("elecacc").readOnly= false;
	 document.getElementById("elecacc").value= '';
	 document.getElementById("area").readOnly= false;
	 document.getElementById("area").value= '';
	 document.getElementById("xstat").value= '1';
}
</script>

<script>
function editable()
{
	 document.getElementById("save").disabled= false;
	 document.getElementById("add").disabled= true;
	 document.getElementById("edit").disabled= true;
	 document.getElementById("reset").disabled= false;
	 document.getElementById("unitno").readOnly= true;
	 document.getElementById("rent").readOnly= false;
	 document.getElementById("rent").focus();
	 document.getElementById("wateracc").readOnly= false;
	 document.getElementById("elecacc").readOnly= false;
	 document.getElementById("area").readOnly= false;
	 document.getElementById("xstat").value= '2';
}
</script>


<script>
function showunits(str) {
  if (str == "") {
    document.getElementById("txthint").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("txthint").innerHTML = this.responseText;
  }
  xhttp.open("GET", "getunitz.php?q="+str);
  xhttp.send();
}
</script>

<script>
function showrent(str) {
  if (str == "") {
    document.getElementById("txtrent").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("txtrent").innerHTML = this.responseText;
  }
  xhttp.open("GET", "getrentz.php?q="+str);
  xhttp.send();
}
</script>


<script>
function revert()
{
	document.getElementById("add").disabled= false;
	document.getElementById("save").disabled= true;
}
</script>
</body>
</html>