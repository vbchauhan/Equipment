<?php
$bcdata=@$_GET["bcdata"];
$fsize=@$_GET["fsize"];

if (strlen($bcdata)<=2)
	{
	print "USAGE: barcode39.php?<b>bcdata</b>=barcodedata&,<b>fsize</b>=[s,m,l]&<b>n</b>=1";
	print "<BR><BR>";
	print "&nbsp;&nbsp;&nbsp;&nbsp;<b>bcdata</b>&nbsp;&nbsp;=>&nbsp;&nbsp;data to be converted<BR>";
	print "&nbsp;&nbsp;&nbsp;&nbsp;<b>fsize</b>&nbsp;&nbsp;=>&nbsp;&nbsp;(s = small, l = large)<BR>";
	print "<BR>";
	exit;
	} //if (strlen($bcdata)<=2)

	$s = 25; // set default font size

// Display Barcode as .PNG image
If (strlen($bcdata)>=2) 
	{ // Make sure barcode data is present.
	
	// Set the content-type
	header("Content-type: image/png");

	// Get the length of the barcode data
	$bcdatalen=strlen($bcdata);
	
	//$barcodewidth=($bcdatalen*7+30);
	$barcodewidth=($bcdatalen*15+30);
	// Create the image
	$im = imagecreatetruecolor($barcodewidth+30, $s+20);

	// Set background color white
	imagefilledrectangle($im, 0, 0, $barcodewidth+30, $s+20, imagecolorallocate($im, 255, 255, 255));

	// Set Barcode Font Size
	$barcodefont='Barcode39-small.ttf';
	if ($fsize=='s') $barcodefont='Barcode39-small.ttf';
	if ($fsize=='l') $barcodefont='Barcode39-large.ttf';
	
	// Add the barcode to the image
	imagettftext($im, $s, 0, 10, $s, imagecolorallocate($im, 0, 0, 0), $barcodefont, '*'.strtoupper($bcdata).'*');

	// stream image
	imagepng($im);

	// destroy created image from memory
	imagedestroy($im);

	} //END If (strlen($barcode)>=24)

?>