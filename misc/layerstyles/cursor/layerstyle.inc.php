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
/* Return misc capabilities                              */
/*********************************************************/

function phpAds_getLayerLimitations ()
{
	$agent = phpAds_getUserAgent();
	
	$compatible = $agent['agent'] == 'IE' && $agent['version'] < 5.0 ||
				  $agent['agent'] == 'Mozilla' && $agent['version'] < 5.0 ||
				  $agent['agent'] == 'Opera' && $agent['version'] < 5.0 
				  ? false : true;
				  
	$richmedia  = $agent['platform'] == 'Win' ? true : false;
	
	return array (
		'richmedia'  => $richmedia,
		'compatible' => $compatible
	);
}



/*********************************************************/
/* Output JS code for the layer                          */
/*********************************************************/

function phpAds_putLayerJS ($output, $uniqid)
{
	global $stickyness, $offsetx, $offsety, $hide, $transparancy, $delay, $trail;
	
	if (!isset($trail) || $trail == '') $trail = 0;
	if (!isset($stickyness) || $stickyness == '') $stickyness = 5;
	
	if (!isset($offsetx) || $offsetx == '') $offsetx = 10;
	if (!isset($offsety) || $offsety == '') $offsety = 10;
	
	if (!isset($hide) || $hide == '') $hide = 0;
	if (!isset($transparancy) || $transparancy == '') $transparancy = 0;
	if (!isset($delay) || $delay == '') $delay = 90;
?>



var phpAds_ns4 = (document.layers) ? true : false;
var phpAds_ie4 = (document.all) ? true : false;
var phpAds_ns6 = ((document.getElementById) && (!phpAds_ie4)) ? true : false;

var phpAds_<?php echo $uniqid; ?>_posX_old = 0;
var phpAds_<?php echo $uniqid; ?>_posX_new = 0;
var phpAds_<?php echo $uniqid; ?>_posY_old = 0;
var phpAds_<?php echo $uniqid; ?>_posY_new = 0;
var phpAds_<?php echo $uniqid; ?>_speedX = 0;
var phpAds_<?php echo $uniqid; ?>_speedY = 0;
var phpAds_<?php echo $uniqid; ?>_NoMove = 0;
var phpAds_<?php echo $uniqid; ?>_transparancy = 0;


if (phpAds_ie4 || phpAds_ns6) { document.onmousemove = phpAds_storePos_<?php echo $uniqid; ?>; }
if (phpAds_ns4) { window.captureEvents(Event.MOUSEMOVE); onmousemove = phpAds_storePos_<?php echo $uniqid; ?>; }


if (phpAds_ie4)
	window.setInterval('phpAds_followMouse_<?php echo $uniqid; ?>()',1);
else
	window.setInterval('phpAds_followMouse_<?php echo $uniqid; ?>()',25);


function phpAds_storePos_<?php echo $uniqid; ?>(e) {

	if (phpAds_ie4)
	{
		phpAds_<?php echo $uniqid; ?>_posX_new = window.event.x;
		phpAds_<?php echo $uniqid; ?>_posY_new = window.event.y + document.body.scrollTop;
	}
	else if (phpAds_ns4)
	{
		phpAds_<?php echo $uniqid; ?>_posX_new = e.pageX;
		phpAds_<?php echo $uniqid; ?>_posY_new = e.pageY;
	} 
	else if (phpAds_ns6) 
	{
		phpAds_<?php echo $uniqid; ?>_posX_new = e.clientX;
		phpAds_<?php echo $uniqid; ?>_posY_new = e.clientY;
	}
}


function phpAds_setVisibility_<?php echo $uniqid; ?>(transparancy)
{
	if (phpAds_ie4 && document.all.phpads_<?php echo $uniqid; ?>.filters)
	{
		if (transparancy >= <?php echo $transparancy; ?>)
		{
			document.all.phpads_<?php echo $uniqid; ?>.filters.item("DXImageTransform.Microsoft.Alpha").opacity = transparancy;
		}
		else
			transparancy = <?php echo $transparancy; ?>;
	}
	
	if (transparancy > 0)
	{	
		if (phpAds_ie4)        	{ document.all.phpads_<?php echo $uniqid; ?>.style.visibility = 'visible'; }
		else if (phpAds_ns4)   	{ document.layers['phpads_<?php echo $uniqid; ?>'].visibility = 'show'; }
		else if (phpAds_ns6) 	{ var elm = document.getElementById('phpads_<?php echo $uniqid; ?>'); elm.style.visibility='visible'; }
	}
	else
	{
		if (phpAds_ie4)        	{ document.all.phpads_<?php echo $uniqid; ?>.style.visibility = 'hidden'; }
		else if (phpAds_ns4)   	{ document.layers['phpads_<?php echo $uniqid; ?>'].visibility = 'hide'; }
		else if (phpAds_ns6) 	{ var elm = document.getElementById('phpads_<?php echo $uniqid; ?>'); elm.style.visibility='hidden'; };
	}

	phpAds_<?php echo $uniqid; ?>_transparancy = transparancy;
}


function phpAds_setPos_<?php echo $uniqid; ?>(x, y)
{
	if (phpAds_ie4)
	{
		document.all.phpads_<?php echo $uniqid; ?>.style.left = x;
		document.all.phpads_<?php echo $uniqid; ?>.style.top = y;
	}
 	else if (phpAds_ns4)
	{
		document.phpads_<?php echo $uniqid; ?>.moveTo (x, y); 
  	}
  	else if (phpAds_ns6)
	{
  		var elm = document.getElementById('phpads_<?php echo $uniqid; ?>');
  		elm.style.left = x;
  		elm.style.top = y;
  	}
}


function phpAds_followMouse_<?php echo $uniqid; ?>() {
	
	if (Math.abs(phpAds_<?php echo $uniqid; ?>_posX_new - phpAds_<?php echo $uniqid; ?>_posX_old) < 3 && 
		Math.abs(phpAds_<?php echo $uniqid; ?>_posY_new - phpAds_<?php echo $uniqid; ?>_posY_old) < 3) 
	{
		phpAds_<?php echo $uniqid; ?>_NoMove = phpAds_<?php echo $uniqid; ?>_NoMove + 1;
	} 
	else 
	{
		phpAds_<?php echo $uniqid; ?>_NoMove = 0;
	}
	
	
<?php 
if ($hide == 1) 
{
	?>
	var transparancy = 100;
	
	if (phpAds_<?php echo $uniqid; ?>_NoMove > <?php echo $delay; ?>) 
	{
		// Cursor is still, hide banner
		if (phpAds_<?php echo $uniqid; ?>_NoMove <= 10 + <?php echo $delay; ?>)
			transparancy = 100 - ((phpAds_<?php echo $uniqid; ?>_NoMove - <?php echo $delay; ?>) * 10);
		else
			transparancy = 0;
	}

	if (transparancy != phpAds_<?php echo $uniqid; ?>_transparancy)
		phpAds_setVisibility_<?php echo $uniqid; ?>(transparancy);	
	
	<?php
}
else
{
	?>
	phpAds_setVisibility_<?php echo $uniqid; ?>(100);	
	<?php
}
?>	
	if (phpAds_<?php echo $uniqid; ?>_NoMove < <?php echo $delay; ?>)
	{
	<?php
if ($trail == 1) 
{
	?>		// Calculate new position
		phpAds_<?php echo $uniqid; ?>_speedX = phpAds_<?php echo $uniqid; ?>_speedX * (<?php echo $stickyness; ?> / 10) + (phpAds_<?php echo $uniqid; ?>_posX_new - phpAds_<?php echo $uniqid; ?>_posX_old) / 30;
		phpAds_<?php echo $uniqid; ?>_speedY = phpAds_<?php echo $uniqid; ?>_speedY * (<?php echo $stickyness; ?> / 10) + (phpAds_<?php echo $uniqid; ?>_posY_new - phpAds_<?php echo $uniqid; ?>_posY_old) / 30;
		phpAds_<?php echo $uniqid; ?>_posX_old = phpAds_<?php echo $uniqid; ?>_posX_old + phpAds_<?php echo $uniqid; ?>_speedX;
		phpAds_<?php echo $uniqid; ?>_posY_old = phpAds_<?php echo $uniqid; ?>_posY_old + phpAds_<?php echo $uniqid; ?>_speedY;
	<?php
}
else
{
	?>
		phpAds_<?php echo $uniqid; ?>_posX_old = phpAds_<?php echo $uniqid; ?>_posX_new;
		phpAds_<?php echo $uniqid; ?>_posY_old = phpAds_<?php echo $uniqid; ?>_posY_new;
	<?php
}
?>
		// Set position of banner
		phpAds_setPos_<?php echo $uniqid; ?> (
			phpAds_<?php echo $uniqid; ?>_posX_old + <?php echo $offsetx; ?>,
			phpAds_<?php echo $uniqid; ?>_posY_old + <?php echo $offsety; ?>
		);
	}
}

<?php
}



/*********************************************************/
/* Return HTML code for the layer                        */
/*********************************************************/

function phpAds_getLayerHTML ($output, $uniqid)
{
	return '
<div id="phpads_'.$uniqid.'" style="position:absolute; width:'.$output['width'].'px; height:'.$output['height'].'px; z-index:99; left: 0px; top: 0px; visibility: hidden; filter: progid:DXImageTransform.Microsoft.Alpha(opacity=100);"> 
'.$output['html'].'
</div>
';

}

?>