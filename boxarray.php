<html>
<body>
<div class="box">1</div>
<div class="box">2</div>
<div class="box">3</div>
<div class="box">4</div>
<div class="box">6</div>

<div id ='memo'></div>

<script>
    var boxes =  document.querySelectorAll('.box');
	const arr1 = Array.from(boxes);
	for(i=0;i<boxes.length;i++)
	{
		arr1[i] = boxes[i];
	}
	document.getElementById('memo').innerHTML= "the text is " + arr1[4].innerHTML;
</script>

</body>
</html>

