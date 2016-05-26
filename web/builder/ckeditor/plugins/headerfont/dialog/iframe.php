<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" />
	<script src="jquery-1.9.1.js"></script>
	<script type="text/javascript" src="jscolor/jscolor.js"></script>
</head>
<body>


<?php
$fonts = array();
$folder = 'fonts';
$files = scandir($folder);
foreach($files as $key => $dir){
	if($dir == '.') continue;
	if($dir == '..') continue;
	if(file_exists($folder.'/'.$dir.'/METADATA.json')){
		$fonts[$key] = json_decode( file_get_contents($folder.'/'.$dir.'/METADATA.json'),1 );
		$fonts[$key]['dir'] = $dir;
	}
}
?>

<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="vertical-align:top;width:56%;padding-right:20px;">
			
			<!--Script:<br>
			<select id="script">
				<option value="">Select</option>
				<option value="cyrillic">Cyrillic</option>
				<option value="cyrillic-ext">Cyrillic Extended</option>
				<option value="devanagari">Devanagari</option>
				<option value="greek">Greek</option>
				<option value="greek-ext">Greek Extended</option>
				<option value="latin">Latin</option>
				<option value="latin-ext">Latin Extended</option>
				<option value="vietnamese">Vietnamese</option>
			</select>
			<br>-->
			
			Font Family:<br>
			<select id="fonts" style="margin-bottom:6px;">
				<option value="">Select</option>
				<?php foreach($fonts as $font):?>
				<option data-script="<?= implode(',',$font['subsets']);?>" value="<?=$font['dir'];?>"><?=$font['name'];?></option>
				<?php endforeach;?>
			</select>
			<br>
			
			<?php foreach($fonts as $font):?>
			<select id="fontType_<?=$font['dir'];?>" class="fontType" style="display:none;">
				<?php foreach($font['fonts'] as $two):?>
				<option value="<?=$two['filename'];?>"><?=$two['postScriptName'];?></option>
				<?php endforeach;?>
			</select>
			<?php endforeach;?>
			
			<div style="border-top:1px solid #ccc; margin:10px 0px 10px 0px;"></div>
			
			<table border="0" cellspacing="4" cellpadding="0">
				<tr>
					<td>Font Color:</td>
					<td colspan="2" style="width:70px;">
						<input id="fontColor" value="000" class="color" type="text"/>
					</td>
				</tr>
				<tr>
					<td>Font Size:</td>
					<td style="width:50px;">
						<input id="fontSize" value="24" type="text"/>
					</td>
					<td>px</td>
				</tr>
			</table>

		</td>
		<td style="vertical-align:top;">
		
			<input id="shadow" type="checkbox">&nbsp;<b>Text shadow</b>
			<table border="0" cellspacing="4" cellpadding="0">
				<tr>
					<td>Shadow color:</td>
					<td colspan="2" style="width:50px;">
						<input id="shadowColor" class="color" value="555" type="text"/>
					</td>
				</tr>
				<tr>
					<td>Alpha:</td>
					<td colspan="2" style="width:50px;">
						<input id="shadowAlpha" value="100" type="text"/>
					</td>
				</tr>
				<tr>
					<td>Vertical position:</td>
					<td style="width:50px;">
						<input id="shadowVerticalPosition" value="0" type="text"/>
					</td>
					<td>px</td>
				</tr>
				<tr>
					<td>Horizontal position:</td>
					<td style="width:50px;">
						<input id="shadowHorizontalPosition" value="0" type="text"/>
					</td>
					<td>px</td>
				</tr>
			</table>
			
		</td>
	</tr>
</table>

<div style="border-top:1px solid #ccc; margin:10px 0px 10px 0px;"></div>


<table style="width:100%;margin-top:10px;" border="0" cellspacing="4" cellpadding="0">
	<tr>
		<td style="width:80px;">Width:</td>
		<td style="width:50px;"><input id="width" value="300" type="text"/></td>
		<td>px<td>
	</tr>
	<tr>
		<td>Height:</td>
		<td style="width:50px;"><input id="height" value="40" type="text"/></td>
		<td>px<td>
	</tr>
	
	<tr>
		<td>Heading Text:</td>
		<td colspan="2"><textarea id="text" style="width:100%">Heading</textarea></td>
	</tr>
	<tr>
		<td colspan="3" style="padding-top:5px;"></td>
	</tr>
	<tr>
		<td></td>
		<td colspan="2">
			<button id="generate">Generate</button>
		</td>
	</tr>
</table>


<br>
<div>Preview</div>
<div class="preview">
	<img id="preview"  alt="" src=""/>
</div>



<script type="text/javascript">
$(function(){
	$('#script').change(function(){
		var script = $(this);
		$('#fonts option').each(function(){
			var params =  $(this).attr('data-script');
			if(params){
				if(params.indexOf($(script).val()) >= 0){
					$(this).show();
				}
				else{
					$(this).hide();
				}
			}
		});
	});
	
	$('#fonts').change(function(){
		$('.fontType').hide();
		$('#fontType_'+$(this).val() ).show();
	});
	
	$('.fontType').change(function(){
		//$('#preview').attr('src', 'generate.php?font='+$('#fonts').val()+'&name='+$(this).val()+'&text='+$('#text').val() );
	});
	
	/*$('#shadowColor').change(function(){
		$('#shadow').prop('checked',true);
	});*/
	$('#shadowVerticalPosition').change(function(){
		$('#shadow').prop('checked',true);
	});
	$('#shadowHorizontalPosition').change(function(){
		$('#shadow').prop('checked',true);
	});


	$('#generate').click(function(){

        var link = getLink(false);
		$('#preview').attr('src', link);
	});
});

function getText(){
    return $('#text').val();
}

function getLink(tempId){

    var params = [];
    params['font'] = encodeURIComponent($('#fonts').val());
    params['name'] = encodeURIComponent($('#fontType_'+$('#fonts').val()).val());
    params['text'] = encodeURIComponent($('#text').val());

    params['fontColor'] = $('#fontColor').val();
    params['fontSize'] = $('#fontSize').val();

    params['width'] = $('#width').val();
    params['height'] = $('#height').val();

    if($('#shadow').is(':checked')){
        params['shadow'] = 1;
        params['shadowColor'] = $('#shadowColor').val();
        params['shadowAlpha'] = $('#shadowAlpha').val();
        params['shadowVerticalPosition'] = $('#shadowVerticalPosition').val();
        params['shadowHorizontalPosition'] = $('#shadowHorizontalPosition').val();
    }

    if(tempId){
        params['tempId'] = tempId;
    }

    var link = 'generate.php?';
    for(var key in params){
        link = link + key + '=' + params[key]+'&';
    }

    return link;
}
</script>

</html>