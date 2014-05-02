<?php

header("Content-type: image/png");

$im = imagecreate(200, 200);

$white = imagecolorallocate($im, 255, 255, 255);

$black = imagecolorallocate($im, 0, 0, 0);

imagefill($im, 0, 0, $white);

imagettftext($im, 30, 45, 50, 150, $black, "Barcode39-small.ttf", "SAMPLE!");

imagepng($im);

imagedestroy($im);

?>