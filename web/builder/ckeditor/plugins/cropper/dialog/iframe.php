<!DOCTYPE html>
<html>
<head>
	<meta http-Equiv="Cache-Control" Content="no-cache">
    <meta http-Equiv="Pragma" Content="no-cache">
    <meta http-Equiv="Expires" Content="0">

	<script src="jquery-1.9.1.js"></script>
	<script src="jcanvas.min.js"></script>
	
	<link  href="dist/cropper.css" rel="stylesheet">
	<script src="dist/cropper.js"></script>
	
	<style type="text/css">
		body,html{margin:0px;padding:0px;font-family:Arial;font-size:12px;}
		table td{white-space:nowrap}
	</style>
</head>
<body>

<div id="page">

	<table width="100%">
		<tr>
			<td>Width: <span id="width">0</span>px</td>
			<td>Height: <span id="height">0</span>px</td>
			<td width="100%"></td>
			<td><a href="#" id="zoomin" title="Zoom In">
				<img alt="search-plus" src="search-plus.png"/>
			</a></td>
			<td><a href="#" id="zoomout" title="Zoom Out">
				<img alt="search-plus" src="search-minus.png"/>
			</a></td>
		</tr>
	</table>

	<div class="container" style="max-height:400px;">
        <img alt="" src="<?= $_GET['imageLink'];?>"/>
	</div>
	
</div>
	
<!--<img class="prev" src="" />


<a href="#" id="get">ffff</a>

<div class="prev2">

</div>-->

<script type="text/javascript">

var image = $('.container > img');

/*if(parent.window.imageLink){
	$(image).attr('src',parent.window.imageLink);
}
else{
	$('#page').text('Image not selected');
}*/

var cropper;

$(document).ready(function(){

    /*if(cropper){
        cropper = $(image).cropper('reset',true);
        console.log('hi');
    }*/

	cropper =  $(image).cropper({
		crop: function(data) {
			$('#width').text( Math.round(data.width) );
			$('#height').text( Math.round(data.height) );
		}
	});

    console.log(cropper);

	$('#zoomin').click(function(){
		image.cropper('zoom', 0.1);
		return false;
	});
	$('#zoomout').click(function(){
		image.cropper('zoom', -0.1);
		return false;
	});


	$('#get').click(function(){

		/*var croppedCanvas = $('img').cropper('getCroppedCanvas');
		var croppedImage = croppedCanvas.toDataURL();*/

		var canvas = $(cropper).cropper('getCroppedCanvas');
		var croppedImage = croppedCanvas.toDataURL();

		
		//$(canvas).css('border','6px solid #555');
		//$(canvas).css('border-radius','20px');
		
		//canvas.lineWidth = 5;
		
		

		/*$(canvas).drawArc({

		  radius: 50
		});
		*/
		
		//console.log(canvas);
		
		//$('.prev').attr('src',canvas.toDataURL() );
		
	
		
		$('.prev2').append( canvas );
		

	//	console.log( $('.prev2 canvas').get(0).toDataURL() );
		
	//	$('.prev').attr('src', $('.prev2 canvas').get(0).toDataURL() );
		
		//console.log( canvas.toDataURL() );
		
		//console.log ( $(cropper).cropper("getDataURL"));
	});

});

function getData(){

	var croppedCanvas = $(cropper).cropper('getCroppedCanvas');

    console.log(croppedCanvas);

//    document.location.reload();

  //  $(cropper).cropper('destroy');
	return croppedCanvas.toDataURL();
}

</script>

</body>
</html>