<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/* you must supply to this script 3 parameters :  title,width and data. */
/* - title is the title of the graph                                    */
/* - width is the width of the generated graph                          */
/* - data is used for the values to be displayed                        */
/*     to split the data you have to use separators "^" and "^^"        */
/*     -> item_title^value^^                                            */
/************************************************************************/
/* call this script directly in the browser or in your html page with   */
/* the img tag.                                                         */
/* example 1 :                                                          */
/* graph-daily.php?title=foo&width=500&data=a^15^^b^20^^                */
/* example 2 :                                                          */
/* <html>                                                               */
/*  ...                                                                 */
/*  <img src="graph-daily.php?title=foo&width=500&data=a^15^^b^20^^">   */
/*  ...                                                                 */
/* </html>                                                              */
/************************************************************************/
/* you can use as many data items as you want                           */
/* you need the GD library in your php module                           */
/* don't forget to encode you parameters (unicode)                      */
/************************************************************************/



// Include required files
require ("../libraries/lib-io.inc.php");
require ("../libraries/lib-cache.inc.php");
require ("lib-gd.inc.php");


// Register input variables
phpAds_registerGlobal ('width', 'data');


/*********************************************************/
/* Prepare data for graph                                */
/*********************************************************/

// Prevent errors
if (!isset($width) || $width <= 0)
	exit;

// Decode data
$data = isset($data) ? urldecode($data) : '';  

// Start positions of graph  
$x = 27;  
$y = 12;

// Right margin  
$right_margin=5;  

$bar_width = 5;  
$total = 0;  
$max = 0;  

$unit = (($width-$x)-$right_margin) / 100;  

$items= explode("^^",$data);  

// Calculate total  
while (list($key,$item) = each($items))  
{  
	if ($item)  
	{  
		$pos = strpos($item,"^");  
		$value = substr($item,$pos+1,strlen($item));  
		$total = $total + $value;  
	}  
}  

reset($items);  

// Calculate height of graph  
$height=38;

$im = imagecreate($width,$height);  

// Allocate colors  
$white  = ImageColorAllocate ($im, 204, 204, 204);
$black  = ImageColorAllocate ($im,   0,   0,   0);
$yellow = ImageColorAllocate ($im, 240, 240,  70);
$line   = ImageColorAllocate ($im,   0,   0, 102);
$blue   = ImageColorAllocate ($im,  64, 100, 168);
$barViews    = ImageColorAllocate ($im,   0, 102, 204);
$barClicks   = ImageColorAllocate ($im, 153, 204, 255);

// Background  
imageColorTransparent($im,$white);
ImageFilledRectangle($im,0,0,$width,$height,$white);


// line
Imageline($im,$x,$y-5,$x,$height-17,$line);

//draw data
while (list($key,$item) = each($items))  
{
	if ($item)
	{
		$pos = strpos($item,"^");
		$item_title = substr($item,0,$pos);
		$value = substr($item,$pos+1,strlen($item));
		
		// display percent
		$percent = $total == 0 ? 0 : intval(round(($value/$total)*100));
		ImageString($im,3,$x-24,$y-4,$percent."%",$black);
		
		// value right side rectangle
		$percent = $total == 0 ? 0 : intval(round(($value/$total)*100));
		$px = $x + ($percent * $unit);
		
		if ($item_title == 'Views')
		{
			// draw rectangle value
			ImageFilledRectangle($im,$x,$y-2,$px,$y+$bar_width,$barViews);
		}
		else
		{
			ImageFilledRectangle($im,$x,$y-2,$px,$y+$bar_width,$barClicks);
		}
		
		// draw empty rectangle
		ImageRectangle($im,$x,$y-2,($x+(100*$unit)),$y+$bar_width,$line);
		
		// line
		Imageline($im,$px,$y-2,$px,$y+$bar_width,$line);
		
		// display numbers
		$fwidth = ImageFontWidth(2);
		$string = $value."/".$total;
		ImageString($im, 2, $x + (100 * $unit) - (strlen($string) * $fwidth) + 2, $y+12, $string, $black);
	}
	$y=$y+($bar_width+20);
	
	
	// IE workaround: Turn off outputbuffering
	// if zlib compression is turned on
	if (strpos ($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'MSIE') > 0 &&
		function_exists('ini_get') &&
		ini_get ("zlib.output_compression"))
		ob_end_clean ();
	
	// Send the content-type header
	phpAds_GDContentType();
	
	// Display modified image
	phpAds_GDShowImage($im);
	
	
	// Release allocated ressources  
	ImageDestroy($im);
	exit();
}

?>