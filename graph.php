<?php   
/* This is a special version of this script for phpAdsNew. It's not pretty, I know !/*

require("gd.php");

/**************************************************************************/  
/* you must supply to this script 3 parameters :  title,width and data.   */  
/* - title is the title of the graph                                      */  
/* - width is the width of the generated graph                            */  
/* - data is used for the values to be displayed                          */  
/*     to split the data you have to use separators "^" and "^^"          */  
/*     -> item_title^value^^                                              */   
/* ---------------------------------------------------------------------- */  
/* call this script directly in the browser or in your html page with the */  
/* img tag.                                                               */  
/* example 1 :                                                            */  
/* graph.php3?title=foo&width=500&data=a^15^^b^20^^                       */  
/* example 2 :                                                            */  
/* <html>                                                                 */  
/*  ...                                                                   */  
/*  <img src="graph.php3?title=foo&width=500&data=a^15^^b^20^^">          */  
/*  ...                                                                   */  
/* </html>                                                                */  
/* ---------------------------------------------------------------------- */  
/* you can use as many data items as you want                             */  
/* you need the GD library in your php module                             */  
/* don't forget to encode you parameters (unicode)                        */  
/* Steve Maranda steve_maranda@teluq.uquebec.ca                           */  
/* Have fun !                                                             */  

//data  
$data = urldecode($data);  

//start positions of graph  
$x = 27;  
$y = 12;

//right margin  
$right_margin=5;  

$bar_width = 5;  
$total = 0;  
$max = 0;  

$unit = (($width-$x)-$right_margin) / 100;  

$items= explode("^^",$data);  

//calculate total  
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

//calculate height of graph  
$height=38;

Header("Content-type:  $gdimageformat");  

$im = imagecreate($width,$height);  
    
// Allocate colors  
$white=ImageColorAllocate($im,204,204,204);  
$yellow=ImageColorAllocate($im,240,240,70);  
$blue=ImageColorAllocate($im,0,64,128);  
$bar=ImageColorAllocate($im,64,100,168);  

//background  
imagecolortransparent($im,$white);
ImageFilledRectangle($im,0,0,$width,$height,$white);

//date  
//ImageString($im,1,$width-150,17,date("D M jS Y h:i:s A"),$white);  
   
//line  
Imageline($im,$x,$y-5,$x,$height-15,$bar);

//draw data  
while (list($key,$item) = each($items))  
      {  
      if ($item)  
         {  
         $pos = strpos($item,"^");  
         $item_title = substr($item,0,$pos);  
         $value = substr($item,$pos+1,strlen($item));  

         //display percent  
         ImageString($im,3,$x-28,$y-2,intval(round(($value/$total)*100))."%",$blue);  

         //value right side rectangle  
         $px = $x + ( intval(round(($value/$total)*100)) * $unit);  

         //draw rectangle value  
         ImageFilledRectangle($im,$x,$y-2,$px,$y+$bar_width,$bar);  

         //draw empty rectangle  
         ImageRectangle($im,$px+1,$y-2,($x+(100*$unit)),$y+$bar_width,$bar);  

         //display numbers  
         ImageString($im,2,($x+(92*$unit))-40,$y+12,$value."/".$total,$blue);

         }  
      $y=$y+($bar_width+20);
	// Display modified image  
	showimage($im);

	// Release allocated ressources  
	ImageDestroy($im);  
	exit();
      }  

?>
