<?php
include_once ('gd-text/Box.php');
include_once ('gd-text/Color.php');

$width = (int)$_GET['width'];
$height = (int)$_GET['height'];
$im = imagecreatetruecolor($width, $height);
//$backgroundColor = imagecolorallocate($im, 130, 130, 130);
//imagefill($im, 0, 0, $backgroundColor);
//imagecolortransparent($im, $backgroundColor);

// Transparent Background
imagealphablending($im, false);
$transparency = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $transparency);
imagesavealpha($im, true);


$box = new Box($im);
$box->setFontFace('fonts/'.$_GET['font'].'/'.$_GET['name']);

list($r, $g, $b) = sscanf($_GET['fontColor'],"%02x%02x%02x");
$fontSize = (int)$_GET['fontSize'];
$box->setFontSize($fontSize);
$box->setFontColor(new Color($r, $g, $b));

if($_GET['shadow']){
	list($r, $g, $b) = sscanf($_GET['shadowColor'],"%02x%02x%02x");
	$shadowAlpha = (int)$_GET['shadowAlpha'];
	$shadowVerticalPosition = (int)$_GET['shadowVerticalPosition'];
	$shadowHorizontalPosition = (int)$_GET['shadowHorizontalPosition'];
	$box->setTextShadow(new Color($r, $g, $b, $shadowAlpha), $shadowHorizontalPosition, $shadowVerticalPosition);
	$box->setTextAlign('left', 'top');
}

$box->draw( $_GET['text'] );

if($tempId = $_GET['tempId']){
    ob_start(); // buffers future output
    imagepng($im); // writes to output/buffer
    $b64 = base64_encode(ob_get_contents()); // returns output
    ob_end_clean(); // clears buffered output

    /*echo 'http://demo2.profweb.com.ua/index.php?r=temp/dataFileUpload&pk='.$tempId;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, '/index.php?r=temp/dataFileUpload&pk='.$tempId);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('data'=>$b64)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $link = curl_exec($curl);
    curl_close($curl);
    echo $link;*/

    echo $b64;
}
else{
    header("Content-type: image/png");
    imagepng($im);
}

imagedestroy($im);