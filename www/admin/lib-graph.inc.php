<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Required files
require_once MAX_PATH . '/www/admin/lib-gdcolors.inc.php';
require_once MAX_PATH . '/www/admin/lib-gd.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/common.php';

/*-------------------------------------------------------*/
/* Create the legends                                    */
/*-------------------------------------------------------*/

function legend($im, $x, $y, $text, $fillcolor, $outlinecolor, $textcolor)
{
	ImageFilledRectangle($im,$x,$y,$x+10,$y+10,$fillcolor);
	ImageRectangle($im,$x,$y,$x+10,$y+10,$outlinecolor);
	imagestring($im, 2, $x+15, $y, $text, $textcolor);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$i = 0;
$totalViews  = 0;
$totalClicks = 0;
$maxViews  = 0;
$maxClicks = 0;

$count=array();
$maxlen=0;
$items_count=count($items);

for($x=0;$x<$items_count;$x++)
{
	// AdViews
	$count[$x] = $items[$x]["value1"];
	$totalViews += $items[$x]["value1"];

	if($items[$x]["value1"] > $maxViews)
		$maxViews = $items[$x]["value1"];

	// AdClicks
	$count2[$x] = $items[$x]["value2"];
	$totalClicks += $items[$x]["value2"];

	if($items[$x]["value2"] > $maxClicks)
		$maxClicks = $items[$x]["value2"];

	// Strings
	if(strlen($items[$x]['text']) > $maxlen)
		$maxlen=strlen($items[$x]['text']);
}

// Get next round number
if (strlen($maxViews) > 2)
	$maxViews = ceil($maxViews / pow(10, strlen($maxViews) - 2)) * pow(10, strlen($maxViews) - 2);
else
	$maxViews = 100;

if (strlen($maxClicks) > 2)
	$maxClicks = ceil($maxClicks / pow(10, strlen($maxClicks) - 2)) * pow(10, strlen($maxClicks) - 2);
elseif (strlen($maxClicks) > 1)
	$maxClicks = ceil($maxClicks / pow(10, strlen($maxClicks) - 1)) * pow(10, strlen($maxClicks) - 1);
else
	$maxClicks = 10;


// Use the same scale
if (defined('LIB_GRAPH_SAME_SCALE'))
{
	if ($maxViews > $maxClicks)
		$maxClicks = $maxViews;
	else
		$maxViews = $maxClicks;
}


// Margins
$leftMargin = strlen($maxViews) * imageFontWidth(2);
$rightMargin = strlen($maxClicks) * imageFontWidth(2);
$margin = $leftMargin + $rightMargin;


// Headers
$text["value1"] .= ": ".$totalViews;
$text["value2"] .= ": ".$totalClicks;

// Dimensions
if (!isset($height))
	$height=180;

if (!isset($width))
	$width = max($margin + 20 + 12 * $items_count, $margin + 50 + imageFontwidth(2) * (strlen($text["value1"]) + strlen($text["value2"])));


$im = imagecreate($width,$height);
$bgcolor = ImageColorAllocate($im,$bgcolors[0],$bgcolors[1],$bgcolors[2]);
$linecolor = ImageColorAllocate($im,$linecolors[0],$linecolors[1],$linecolors[2]);
$graycolor = ImageColorAllocate($im,$RGB['lgray'][0],$RGB['lgray'][1],$RGB['lgray'][2]);
$textcolor = ImageColorAllocate($im,$textcolors[0],$textcolors[1],$textcolors[2]);
$adviewscolor = ImageColorAllocate($im,$adviewscolors[0],$adviewscolors[1],$adviewscolors[2]);
$adclickscolor = ImageColorAllocate($im,$adclickscolors[0],$adclickscolors[1],$adclickscolors[2]);


for($x=0;$x<$items_count;$x++)
	imagestringup($im, 1, $leftMargin + 12 + ($x * 12), 130 + imageFontwidth(1) * $maxlen , $items[$x]["text"], $textcolor);


if ($maxViews == 0)
	$scaleViews = 100;
else
	$scaleViews = (double)100/(double)$maxViews;

if (defined('LIB_GRAPH_SAME_SCALE'))
	$scaleClicks = $scaleViews;
elseif ($maxClicks == 0)
	$scaleClicks = 50;
else
	$scaleClicks = (double)50/(double)$maxClicks;


imageline($im, $leftMargin + 10, 20, $leftMargin + 10 + ($items_count * 12), 20, $graycolor);
imageline($im, $leftMargin + 10, 45, $leftMargin + 10 + ($items_count * 12), 45, $graycolor);
imageline($im, $leftMargin + 10, 70, $leftMargin + 10 + ($items_count * 12), 70, $graycolor);
imageline($im, $leftMargin + 10, 95, $leftMargin + 10 + ($items_count * 12), 95, $graycolor);
imageline($im, $leftMargin + 10, 120, $leftMargin + 10 + ($items_count * 12), 120, $linecolor);


legend($im, $leftMargin + 10, 2, $text["value1"], $adviewscolor, $linecolor, $textcolor);
legend($im, $leftMargin + 40 + (imageFontwidth(2) * strlen($text["value1"])), 2, $text["value2"], $adclickscolor, $linecolor, $textcolor);

// Views
imagestring($im, 2, $leftMargin - (imageFontwidth(2) * strlen($maxViews)), 12, $maxViews, $textcolor);
imagestring($im, 2, $leftMargin - (imageFontwidth(2) * strlen('0')), 115, '0', $textcolor);

// Clicks
if (!defined('LIB_GRAPH_SAME_SCALE'))
{
	imagestring($im, 2, $leftMargin + 20 + ($items_count * 12), 63, $maxClicks, $textcolor);
	imagestring($im, 2, $leftMargin + 20 + ($items_count * 12), 115, '0', $textcolor);
}


for($x = 0;$x<$items_count;$x++)
{
	// AdViews
	ImageFilledRectangle($im, $leftMargin + 10 + ($x * 12), 120-(int)($count[$x]*$scaleViews), $leftMargin + 19 + ($x * 12), 120,$adviewscolor);
	ImageRectangle($im, $leftMargin + 10 + ($x * 12), 120-(int)($count[$x]*$scaleViews), $leftMargin + 19 + ($x * 12), 120,$linecolor);

	// AdClicks
	ImageFilledRectangle($im, $leftMargin + 12 + ($x * 12), 120-(int)($count2[$x]*$scaleClicks), $leftMargin + 21 + ($x * 12), 120,$adclickscolor);
	ImageRectangle($im, $leftMargin + 12 + ($x * 12), 120-(int)($count2[$x]*$scaleClicks), $leftMargin + 21 + ($x * 12), 120,$linecolor);
}

// IE workaround: Turn off outputbuffering
// if zlib compression is turned on
if (strpos ($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 &&
	function_exists('ini_get') && (
	ini_get ('zlib.output_compression') ||
	ini_get ('output_handler') == 'ob_gzhandler'))
	ob_end_clean ();


// Send the content-type header
phpAds_GDContentType();

// No caching
MAX_commonSetNoCacheHeaders();

// Display modified image
phpAds_GDShowImage($im);

// Release allocated ressources
ImageDestroy($im);

?>
