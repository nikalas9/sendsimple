<!DOCTYPE html>
<html>
<head>
	<link href="imageEditor/dependencies/jquery-ui.min.css" rel="stylesheet">
	<link href="imageEditor/dependencies/bootstrap.min.css" rel="stylesheet">
	<link href="imageEditor/css/bootstrap-image-editor.css" rel="stylesheet">
</head>

<body>

<div id="editor-window"></div>

<script src="imageEditor/dependencies/jquery.min.js"></script>
<script src="imageEditor/dependencies/jquery-ui.js" ></script>
<script src="imageEditor/dependencies/bootstrap.min.js"></script>
<script src="imageEditor/dependencies/caman.full.js"></script>
<script src="imageEditor/js/bootstrap-image-editor.min.js"></script>

<script type="text/javascript">

    var el = $("#editor-window").imageEditor({
		'source': '<?= $_GET['imageLink'];?>',
		"maxWidth": 500
    });
	
	function getData(){
		
		var cel = $(el).find('canvas');
		
		var canvas  = document.getElementById( $(cel).attr('id') );
		var dataUrl = canvas.toDataURL();

        return dataUrl;
	}
</script> 

</body>
</html>