<!DOCTYPE html> 
<html lang="en" dir="ltr"> 

<head> 
	<meta charset="utf-8"> 
	<title> 
		How to get values from html input 
		array using JavaScript ? 
	</title> 
</head> 

<body style="text-align: center;"> 
	
	<h1 style="color: #af1bf9;"> 
		NiceSnippets 
	</h1> 

	<h3 id="mv">Input Array Elements</h3> 
	<form class="" action="index.html" method="post"> 
		<input type="text" name="array[]" value="" /><br> 
		<input type="text" name="array[]" value="" /><br> 
		<!--<input type="text" name="array[]" value="" /><br> 
		<input type="text" name="array[]" value="" /><br> 
		<input type="text" name="array[]" value="" /><br> -->
		<button type="button" name="button" onclick="ns()"> 
			Submit 
		</button> 
	</form> 
	<br> 

	<p id="var"></p> 
	<p id ='ans'></p>

	<script type="text/javascript"> 
		var v = "The respective values are :"; 
		function ns() { 
			var input = document.getElementsByName('array[]'); 
			var p =Array.from(input);
			for (var i = 0; i < input.length; i++) { 
				var p[i] = input[i].value; 
					} 
			
			document.getElementById("var").innerHTML = p[0]; 
			//document.getElementById("ans").innerHTML = q; 
			document.getElementById("mv").innerHTML = "Output"; 
		} 
	</script> 
</body> 

</html> 