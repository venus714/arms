<!DOCTYPE html>
<html>
<body>

<h2>JavaScript HTML DOM</h2>

<p>Hello World!</p>

<p>Hello Norway!</p>

<p>Hello China!</p>

<p id="demo"></p>

<script>
const myNodelist = document.querySelectorAll("p");
const arr1=Array.from(myNodelist);
for (i=0;i<length.myNodelist;i++)
{
	arr1[i] = myNodelist[i];
	}
document.getElementById("demo").innerHTML = "The innerHTML of the second paragraph is: " + arr1[2].innerHTML;
</script>

</body>
</html>
