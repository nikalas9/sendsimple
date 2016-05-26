<?php
// Set the content-type
include('icons.data.php');

$font = './fontawesome-webfont.ttf';
$iKey = lcfirst($_GET['iKey']);
list($r, $g, $b) = sscanf($_GET['outputColorParam'],"%02x%02x%02x");
//$outputColorParam = array('r'=>128, 'g'=>128, 'b'=>128);
$outputSize = (int)$_GET['outputSize'];

$size = $width = $height = $outputSize*3;
$fontSize = $outputSize;
$padding = (int)ceil(($outputSize/25));

$iParam = $icons[$iKey];
$text = $iParam['code'];


// Create the image
$im = imagecreatetruecolor($width, $height);
imagealphablending($im, false);

// Create some colors
$fontC = imagecolorallocate($im, $r, $g, $b);

//$bgc = imagecolorallocatealpha($im, 255, 0, 255, 127);
$bgc = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefilledrectangle($im, 0, 0, $width,$height, $bgc);
imagealphablending($im, true);

// Add the text
list($fontX, $fontY) = ImageTTFCenter($im, $text, $font, $fontSize);
imagettftext($im, $fontSize, 0, $fontX, $fontY, $fontC, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagealphablending($im,false);
imagesavealpha($im,true);			
imagetrim($im, $bgc, $padding);
imagecanvas($im, $outputSize, $bgc, $padding);

ob_start(); // buffers future output
imagepng($im); // writes to output/buffer
$b64 = base64_encode(ob_get_contents()); // returns output
ob_end_clean(); // clears buffered output

imagedestroy($im);

//echo sprintf('<img src="data:image/png;base64,%s" alt="%s" />',$b64,$iKey);
			
echo $b64;


function mkdir_recursive($pathname, $mode)
{
    is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname), $mode);
    return is_dir($pathname) || @mkdir($pathname, $mode);
}

function ImageTTFCenter($image, $text, $font, $size, $angle = 45) 
{
    $xi = imagesx($image);
    $yi = imagesy($image);

    // First we create our bounding box for the first text
	$box = imagettfbbox($size, $angle, $font, $text);

	$xr = abs(max($box[2], $box[4]));
    $yr = abs(max($box[5], $box[7]));

    // compute centering
    $x = intval(($xi - $xr) / 2);
    $y = intval(($yi + $yr) / 2);

	//echo $x;echo '|';	echo $y;exit;
    return array($x, $y);
}

function imagetrim(&$im, $bg, $pad=null){

    // Calculate padding for each side.
    if (isset($pad)){
        $pp = explode(' ', $pad);
        if (isset($pp[3])){
            $p = array((int) $pp[0], (int) $pp[1], (int) $pp[2], (int) $pp[3]);
        }else if (isset($pp[2])){
            $p = array((int) $pp[0], (int) $pp[1], (int) $pp[2], (int) $pp[1]);
        }else if (isset($pp[1])){
            $p = array((int) $pp[0], (int) $pp[1], (int) $pp[0], (int) $pp[1]);
        }else{
            $p = array_fill(0, 4, (int) $pp[0]);
        }
    }else{
        $p = array_fill(0, 4, 0);
    }

    // Get the image width and height.
    $imw = imagesx($im);
    $imh = imagesy($im);

    // Set the X variables.
    $xmin = $imw;
    $xmax = 0;

    // Start scanning for the edges.
    for ($iy=0; $iy<$imh; $iy++){
        $first = true;
        for ($ix=0; $ix<$imw; $ix++){
            $ndx = imagecolorat($im, $ix, $iy);
            if ($ndx != $bg){
                if ($xmin > $ix){ $xmin = $ix; }
                if ($xmax < $ix){ $xmax = $ix; }
                if (!isset($ymin)){ $ymin = $iy; }
                $ymax = $iy;
                if ($first){ $ix = $xmax; $first = false; }
            }
        }
    }

    // The new width and height of the image. (not including padding)
    $imw = 1+$xmax-$xmin; // Image width in pixels
    $imh = 1+$ymax-$ymin; // Image height in pixels

    // Make another image to place the trimmed version in.
    $im2 = imagecreatetruecolor($imw+$p[1]+$p[3], $imh+$p[0]+$p[2]);

    // Make the background of the new image the same as the background of the old one.
    $bg2 = imagecolorallocatealpha($im2, ($bg >> 16) & 0xFF, ($bg >> 8) & 0xFF, $bg & 0xFF, 127);
    imagefill($im2, 0, 0, $bg2);
	imagealphablending($im2, true);

    // Copy it over to the new image.
    imagecopy($im2, $im, $p[3], $p[0], $xmin, $ymin, $imw, $imh);

    // To finish up, we replace the old image which is referenced.
	imagealphablending($im2,false);
	imagesavealpha($im2,true);
    $im = $im2;
	//imagedestroy($im2);
}

function imagecanvas(&$im, $size, $bg, $padding)
{
	$srcW = imagesx($im);
    $srcH = imagesy($im);
	
	$srcRatio = $srcW/$srcH;
	
	$im2 = imagecreatetruecolor($size, $size);
	$bg2 = imagecolorallocatealpha($im2, ($bg >> 16) & 0xFF, ($bg >> 8) & 0xFF, $bg & 0xFF, 127);
	//imagefilledrectangle($im2, 0, 0, $size,$size, $bg2);
	imagefill($im2, 0, 0, $bg2);
	imagealphablending($im2, true);
	
	// init
	$dstX = $dstY = $srcX = $srcY = 0;
	$dstW = $dstH = $size;

	// if source size is smaller than output size
	if($srcW < $size && $srcH < $size)
	{
		$dstW = $srcW; $dstH = $srcH;
	}
	// if source is bigger than output
	else
	{
		// use padding
		// if horizontal long
		if($srcW > $srcH)
		{
			$dstW = $size - $padding;
			$dstH = (int)(($dstW/$srcW)*$srcH);
		}
		// if vertically long or equal(square)
		else
		{
			$dstH = $size - $padding;
			$dstW = (int)(($dstH/$srcH)*$srcW);
		}	
	}
	
	$dstX = (int)(($size - $dstW)/2);
	$dstY = (int)(($size - $dstH)/2);
	
	// imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
	imagecopyresampled($im2, $im, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH);
	
	imagealphablending($im2,false);
	imagesavealpha($im2,true);
	$im = $im2;
	//imagedestroy($im2);
}

?>


