<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require("lib-gdcolors.inc.php");
require("lib-gd.inc.php");



/*********************************************************/
/* Create the legends                                    */
/*********************************************************/

function legend($im, $x, $y, $text, $fillcolor, $outlinecolor, $textcolor)
{
	ImageFilledRectangle($im,$x,$y,$x+10,$y+10,$fillcolor);
	ImageRectangle($im,$x,$y,$x+10,$y+10,$outlinecolor);
	imagestring($im, 2, $x+15, $y, $text, $textcolor);
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$i=0;
$total=0;
$total2=0;
$max=0;

$count=array();
$maxlen=0;
$items_count=count($items);

for($x=0;$x<$items_count;$x++)
{
	$count[$x] = $items[$x]["value1"];
	$total += $items[$x]["value1"];
	if($items[$x]["value1"]>$max) $max=$items[$x]["value1"];

	$count2[$x] = $items[$x]["value2"];
	$total2 += $items[$x]["value2"];
	if($items[$x]["value2"]>$max) $max=$items[$x]["value2"];
	if(strlen($items[$x]['text'])>$maxlen) $maxlen=strlen($items[$x]['text']);
}

// comlete headers
$text["value1"] .= ": $total";
$text["value2"] .= ": $total2";

if (!isset($height))
{
	$height=180;
}
if (!isset($width))
{
	$width=max( 120 + 12 * $items_count , 120 + imageFontwidth(2) * ( strlen($text["value1"]) + strlen($text["value2"]) ) );
}

$im = imagecreate($width,$height);
$bgcolor = ImageColorAllocate($im,$bgcolors[0],$bgcolors[1],$bgcolors[2]);
$linecolor = ImageColorAllocate($im,$linecolors[0],$linecolors[1],$linecolors[2]);
$textcolor = ImageColorAllocate($im,$textcolors[0],$textcolors[1],$textcolors[2]);
$adviewscolor = ImageColorAllocate($im,$adviewscolors[0],$adviewscolors[1],$adviewscolors[2]);
$adclickscolor = ImageColorAllocate($im,$adclickscolors[0],$adclickscolors[1],$adclickscolors[2]);
     
for($x=0;$x<$items_count;$x++)
{
	imagestringup($im, 1, ($x)*12+52, 130+imageFontwidth(1)*$maxlen , $items[$x]["text"], $textcolor);
}
       
if ($max==0)
	$scale=100;
else
	$scale = (double)100/(double)$max;


imageline($im, 50, 20, 50+$items_count*12, 20, $linecolor);
imageline($im, 50, 45, 50+$items_count*12, 45, $linecolor);
imageline($im, 50, 70, 50+$items_count*12, 70, $linecolor);
imageline($im, 50, 95, 50+$items_count*12, 95, $linecolor);
imageline($im, 50, 120, 50+$items_count*12, 120, $linecolor);

legend($im, 50, 2, $text["value1"], $adviewscolor, $linecolor, $textcolor);
legend($im, 80+imageFontwidth(2)*strlen($text["value1"]), 2, $text["value2"], $adclickscolor, $linecolor, $textcolor);

imagestring($im, 2, 20, 12, $max, $textcolor);
imagestring($im, 2, 25, 115, "0", $textcolor);
for($x = 0;$x<$items_count;$x++)
{
	ImageFilledRectangle($im,$x*12+50,120-(int)($count[$x]*$scale),$x*12+59,120,$adviewscolor);
	ImageRectangle($im,$x*12+50,120-(int)($count[$x]*$scale),$x*12+59,120,$linecolor);
	ImageFilledRectangle($im,$x*12+52,120-(int)($count2[$x]*$scale),$x*12+61,120,$adclickscolor);
	ImageRectangle($im,$x*12+52,120-(int)($count2[$x]*$scale),$x*12+61,120,$linecolor);
}

// IE workaround: Turn off outputbuffering
// if zlib compression is turned on
if (strpos ($GLOBALS['HTTP_USER_AGENT'], 'MSIE') > 0 &&
	function_exists('ini_get') &&
	ini_get ("zlib.output_compression"))
	ob_end_clean ();


// Send the content-type header
phpAds_GDContentType();

// No caching
require("../lib-cache.inc.php");

// Display modified image
phpAds_GDShowImage($im);

// Release allocated ressources  
ImageDestroy($im);
?>
