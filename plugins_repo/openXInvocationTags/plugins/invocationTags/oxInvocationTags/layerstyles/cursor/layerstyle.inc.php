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

/*-------------------------------------------------------*/
/* Return misc capabilities                              */
/*-------------------------------------------------------*/

function MAX_layerGetLimitations()
{
    $agent = $GLOBALS['_MAX']['CLIENT'];

    $compatible = $agent['browser'] == 'ie' && $agent['maj_ver'] < 5 ||
                  $agent['browser'] == 'mz' && $agent['maj_ver'] < 1 ||
                  $agent['browser'] == 'fx' && $agent['maj_ver'] < 1 ||
                  $agent['browser'] == 'op' && $agent['maj_ver'] < 5
                  ? false : true;

    //$richmedia  = $agent['platform'] == 'Win' ? true : false;
    $richmedia = true;

    return [
        'richmedia' => $richmedia,
        'compatible' => $compatible
    ];
}



/*-------------------------------------------------------*/
/* Output JS code for the layer                          */
/*-------------------------------------------------------*/

function MAX_layerPutJs($output, $uniqid)
{
    global $stickyness, $offsetx, $offsety, $hide, $transparancy, $delay, $trail;

    // Register input variables
    MAX_commonRegisterGlobalsArray(['stickyness', 'offsetx', 'offsety', 'hide',
                           'transparancy', 'delay', 'trail']);


    if (!isset($trail) || $trail == '') {
        $trail = 0;
    }
    if (!isset($stickyness) || $stickyness == '') {
        $stickyness = 5;
    }

    if (!isset($offsetx) || $offsetx == '') {
        $offsetx = 10;
    }
    if (!isset($offsety) || $offsety == '') {
        $offsety = 10;
    }

    if (!isset($hide) || $hide == '') {
        $hide = 0;
    }
    if (!isset($transparancy) || $transparancy == '') {
        $transparancy = 0;
    }
    if (!isset($delay) || $delay == '') {
        $delay = 90;
    } ?>



var MAX_ns4 = (document.layers) ? true : false;
var MAX_ie4 = (document.all && !window.innerWidth) ? true : false;
var MAX_ns6 = ((document.getElementById) && (!MAX_ie4)) ? true : false;

var MAX_<?php echo $uniqid; ?>_posX_old = 0;
var MAX_<?php echo $uniqid; ?>_posX_new = 0;
var MAX_<?php echo $uniqid; ?>_posY_old = 0;
var MAX_<?php echo $uniqid; ?>_posY_new = 0;
var MAX_<?php echo $uniqid; ?>_speedX = 0;
var MAX_<?php echo $uniqid; ?>_speedY = 0;
var MAX_<?php echo $uniqid; ?>_NoMove = 0;
var MAX_<?php echo $uniqid; ?>_transparancy = 0;


if (MAX_ie4 || MAX_ns6) { document.onmousemove = MAX_storePos_<?php echo $uniqid; ?>; }
if (MAX_ns4) { window.captureEvents(Event.MOUSEMOVE); onmousemove = MAX_storePos_<?php echo $uniqid; ?>; }


if (MAX_ie4)
	window.setInterval('MAX_followMouse_<?php echo $uniqid; ?>()',1);
else
	window.setInterval('MAX_followMouse_<?php echo $uniqid; ?>()',50);


function MAX_storePos_<?php echo $uniqid; ?>(e) {

	if (MAX_ie4)
	{
		MAX_<?php echo $uniqid; ?>_posX_new = window.event.x;
		MAX_<?php echo $uniqid; ?>_posY_new = window.event.y + document.body.scrollTop;
	}
	else if (MAX_ns4)
	{
		MAX_<?php echo $uniqid; ?>_posX_new = e.pageX;
		MAX_<?php echo $uniqid; ?>_posY_new = e.pageY;
	}
	else if (MAX_ns6)
	{
		MAX_<?php echo $uniqid; ?>_posX_new = e.clientX;
		MAX_<?php echo $uniqid; ?>_posY_new = e.clientY;
	}
}


function MAX_setVisibility_<?php echo $uniqid; ?>(transparancy)
{
	if (transparancy >= <?php echo $transparancy; ?>)
	{
		if (MAX_ie4 && !window.opera)
		{
			document.all['MAX_<?php echo $uniqid; ?>'].style.filter = "DXImageTransform.Microsoft.Alpha(opacity="+transparancy+")";
		}
		else if( document.getElementById )
		{
		    document.getElementById( 'MAX_<?php echo $uniqid; ?>' ).style.opacity=transparancy/100;
		}
		else transparancy = <?php echo $transparancy; ?>;

	}

	if (transparancy > 0)
	{
		if (MAX_ie4)        	{ document.all.MAX_<?php echo $uniqid; ?>.style.visibility = 'visible'; }
		else if (MAX_ns4)   	{ document.layers['MAX_<?php echo $uniqid; ?>'].visibility = 'show'; }
		else if (MAX_ns6) 	{ document.getElementById('MAX_<?php echo $uniqid; ?>').style.visibility='visible'; }
	}
	else
	{
		if (MAX_ie4)        	{ document.all.MAX_<?php echo $uniqid; ?>.style.visibility = 'hidden'; }
		else if (MAX_ns4)   	{ document.layers['MAX_<?php echo $uniqid; ?>'].visibility = 'hide'; }
		else if (MAX_ns6) 	{ document.getElementById('MAX_<?php echo $uniqid; ?>').style.visibility='hidden'; };
	}

	MAX_<?php echo $uniqid; ?>_transparancy = transparancy;
}


function MAX_setPos_<?php echo $uniqid; ?>(x, y)
{
	if (MAX_ie4)
	{
		document.all.MAX_<?php echo $uniqid; ?>.style.left = x;
		document.all.MAX_<?php echo $uniqid; ?>.style.top = y;
	}
 	else if (MAX_ns4)
	{
		document.MAX_<?php echo $uniqid; ?>.moveTo (x, y);
  	}
  	else if (MAX_ns6)
	{
  		var elm = document.getElementById('MAX_<?php echo $uniqid; ?>');
  		elm.style.left = x+'px';
  		elm.style.top = y+'px';
  	}
}


function MAX_followMouse_<?php echo $uniqid; ?>() {

	if (Math.abs(MAX_<?php echo $uniqid; ?>_posX_new - MAX_<?php echo $uniqid; ?>_posX_old) < 3 &&
		Math.abs(MAX_<?php echo $uniqid; ?>_posY_new - MAX_<?php echo $uniqid; ?>_posY_old) < 3)
	{
		MAX_<?php echo $uniqid; ?>_NoMove = MAX_<?php echo $uniqid; ?>_NoMove + 1;
	}
	else
	{
		MAX_<?php echo $uniqid; ?>_NoMove = 0;
	}


<?php
if ($hide == 1) {
        ?>
	var transparancy = 100;

	if (MAX_<?php echo $uniqid; ?>_NoMove > <?php echo $delay; ?>)
	{
		// Cursor is still, hide banner
		if (MAX_<?php echo $uniqid; ?>_NoMove <= 10 + <?php echo $delay; ?>)
			transparancy = 100 - ((MAX_<?php echo $uniqid; ?>_NoMove - <?php echo $delay; ?>) * 10);
		else
			transparancy = 0;
	}

	if (transparancy != MAX_<?php echo $uniqid; ?>_transparancy)
		MAX_setVisibility_<?php echo $uniqid; ?>(transparancy);

	<?php
    } else {
        ?>
	MAX_setVisibility_<?php echo $uniqid; ?>(100);
	<?php
    } ?>
	if (MAX_<?php echo $uniqid; ?>_NoMove < <?php echo $delay; ?>)
	{
	<?php
if ($trail == 1) {
        ?>		// Calculate new position
		MAX_<?php echo $uniqid; ?>_speedX = MAX_<?php echo $uniqid; ?>_speedX * (<?php echo $stickyness; ?> / 10) + (MAX_<?php echo $uniqid; ?>_posX_new - MAX_<?php echo $uniqid; ?>_posX_old) / 30;
		MAX_<?php echo $uniqid; ?>_speedY = MAX_<?php echo $uniqid; ?>_speedY * (<?php echo $stickyness; ?> / 10) + (MAX_<?php echo $uniqid; ?>_posY_new - MAX_<?php echo $uniqid; ?>_posY_old) / 30;
		MAX_<?php echo $uniqid; ?>_posX_old = MAX_<?php echo $uniqid; ?>_posX_old + MAX_<?php echo $uniqid; ?>_speedX;
		MAX_<?php echo $uniqid; ?>_posY_old = MAX_<?php echo $uniqid; ?>_posY_old + MAX_<?php echo $uniqid; ?>_speedY;
	<?php
    } else {
        ?>
		MAX_<?php echo $uniqid; ?>_posX_old = MAX_<?php echo $uniqid; ?>_posX_new;
		MAX_<?php echo $uniqid; ?>_posY_old = MAX_<?php echo $uniqid; ?>_posY_new;
	<?php
    } ?>
		// Set position of banner
		MAX_setPos_<?php echo $uniqid; ?> (
			MAX_<?php echo $uniqid; ?>_posX_old + <?php echo $offsetx; ?>,
			MAX_<?php echo $uniqid; ?>_posY_old + <?php echo $offsety; ?>
		);
	}
}

<?php
}



/*-------------------------------------------------------*/
/* Return HTML code for the layer                        */
/*-------------------------------------------------------*/

function MAX_layerGetHtml($output, $uniqid)
{
    return '
<div id="MAX_' . $uniqid . '" style="position:absolute; width:' . $output['width'] . 'px; height:' . $output['height'] . 'px; z-index:99; left: 0px; top: 0px; visibility: hidden; filter: progid:DXImageTransform.Microsoft.Alpha(opacity=100);">
' . $output['html'] . '
</div>
';
}

?>