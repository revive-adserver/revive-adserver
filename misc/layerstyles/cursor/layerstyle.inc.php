<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Define constant used to place code generator
define('phpAds_adLayerLoaded', true);



/*********************************************************/
/* Output JS code for the layer                          */
/*********************************************************/

function phpAds_putLayerJS ($output, $uniqid)
{
?>

var phpAds_ns6 = document.getElementById && !document.all;

function phpAds_findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
  d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i>d.layers.length;i++) x=phpAds_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function phpAds_getMouseXPos(e)
{
	if (document.layers || phpAds_ns6)
	    return parseInt(e.pageX+10);
	else
		return (parseInt(event.clientX+10) + parseInt(document.body.scrollLeft));
}

function phpAds_getMouseYPos(e)
{
	if (document.layers || phpAds_ns6)
		return parseInt(e.pageY);
	else
		return (parseInt(event.clientY) + parseInt(document.body.scrollTop));
}

function phpAds_adlayers_place_<?php echo $uniqid; ?>(e)
{
	var c = phpAds_findObj('phpads_<?php echo $uniqid; ?>');

	if (!c)
		return false;
	
	if (c.style)
		c = c.style;

	var x = phpAds_getMouseXPos(e);
	var y = phpAds_getMouseYPos(e);

	if (document.all) {
		c.pixelLeft = x;
		c.pixelTop = y;
	} else {
		c.left = x;
		c.top = y;
	}

	c.visibility = 'visible';
}

if (document.layers)
{
	document.captureEvents(Event.MOUSEMOVE);
	document.onMouseMove = phpAds_adlayers_place_<?php echo $uniqid; ?>;
}
else
	document.onmousemove = phpAds_adlayers_place_<?php echo $uniqid; ?>;

<?php
}



/*********************************************************/
/* Return HTML code for the layer                        */
/*********************************************************/

function phpAds_getLayerHTML ($output, $uniqid)
{
	return '
<div id="phpads_'.$uniqid.'" style="position:absolute; width:'.$output['width'].'px; height:'.$output['height'].'px; z-index:99; left: 0px; top: 0px; visibility: hidden"> 
'.ereg_replace("</?a[^>]*>", '', $output['html']).'
</div>
';

}



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_placeLayerSettings ()
{
}



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_generateLayerCode ($parameters)
{
	global $phpAds_config;
	
	$parameters[] = 'layerstyle=cursor';
	
	$buffer = "<script language='JavaScript' type='text/javascript' src='".$phpAds_config['url_prefix']."/adlayer.php";
	if (sizeof($parameters) > 0)
		$buffer .= "?".implode ("&amp;", $parameters);
	$buffer .= "'></script>";
	
	return $buffer;
}



/*********************************************************/
/* Return $show var for generators                       */
/*********************************************************/

function phpAds_getlayerShowVar ()
{
	return array (
		'what' => true,
		'clientid' => true,
		'target' => true,
		'source' => true,
		'layerstyle' => true
	);
}

?>