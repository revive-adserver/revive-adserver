<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
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
				  
	$richmedia  = $agent['agent'] == 'IE' && $agent['version'] > 5.0 &&
				  $agent['platform'] == 'Win'
				  ? true : false;
	
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
	global $ltr, $loop, $speed, $pause, $shiftv;
	global $limited, $lmargin, $rmargin, $HTTP_SERVER_VARS;
	
	// Register input variables
	phpAds_registerGlobal ('ltr', 'loop', 'speed', 'pause',
					       'shiftv', 'limited', 'lmargin', 'rmargin');
	
	
	if (!isset($ltr)) $ltr = 't';
	if (!isset($loop)) $loop = 'n';
	if (!isset($speed)) $speed = 3;
	if (!isset($pause)) $pause = 10;
	if (!isset($shiftv)) $shiftv = 0;
	
	if ($limited == 't')
	{
		if (!isset($lmargin) || !isset($rmargin))
		{
			$limited = 'f';
			$lmargin = $rmargin = '';
		}
	}
	
?>

function phpAds_findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
  d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i>d.layers.length;i++) x=phpAds_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}



function phpAds_floater_setclip_<?php echo $uniqid; ?>(o, top, right, bottom, left) 
{
	if (o.style)
	{
		o.style.clip = "rect(" + top + " " + right + " " + bottom + " " + left + ")";
	}
	else 
	{
		o.clip.top = top; o.clip.right = right; o.clip.bottom = bottom; o.clip.left = left;
	}
}

function phpAds_floater_setpos_<?php echo $uniqid; ?>(c, left, width)
{
	if (document.all && !window.innerWidth)	
	{
		c.pixelLeft = left; c.pixelWidth = width;
	}
	else
	{
		c.left = left; c.width = width;
	}
}

function phpAds_floater_grow_<?php echo $uniqid; ?>()
{
	var o = phpAds_findObj('phpads_<?php echo $uniqid; ?>');

	if (!o)
		return false;
	
	if (o.style)
		c = o.style;
	else
		c = o;

	if (window.innerWidth)
		ww = window.innerWidth - 16;
	else
		ww = document.body.clientWidth;

	var w = <?php echo $output['width']; ?>;
	var h = <?php echo $output['height']; ?>;
	
<?php
	if ($limited == 't')
	{
		if ($lmargin == '')
		{
?>
	var ml = 0;
<?php
		}
		elseif ($lmargin > 0)
		{
?>
	var ml = <?php echo $lmargin; ?>;
<?php
		}
		else
		{
?>
	var ml = ww + <?php echo $lmargin; ?>;
<?php
		}
		
		if ($rmargin == '')
		{
?>
	var mr = ww;
<?php
		}
		elseif ($rmargin > 0)
		{
?>
	var mr = <?php echo $rmargin; ?>;
<?php
		}
		else
		{
?>
	var mr = ww + <?php echo $rmargin; ?>;
<?php
		}
	}
	else
	{
?>
	var mr = ww;
	var ml = 0;
<?php
	}
	
	if (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Opera 6'))
	{
?>
	mr = mr - w; ml = ml + w;
	
	if (mr + w > ml)
<?php
	}
	else
	{
?>
	if (mr > ml)
<?php
	}
?>
	{
		var shift = <?php echo 3*($speed-1)+1; ?>;
		var iw = mr - ml + w; var is = ml - w;
		var cr = w; var cl = 0;
		
		if (document.all && !window.innerWidth)
			ll = c.pixelLeft;
		else
			ll = parseInt(c.left);
		
<?php
	if ($ltr == 't')
	{
?>
		if (c.visibility == 'hidden' || c.visibility == 'hide')
		{
			phpAds_floater_setclip_<?php echo $uniqid; ?>(o, 0, w, h, w);
			phpAds_floater_setpos_<?php echo $uniqid; ?>(c, is, w);
			c.visibility = 'visible';
		}
		else
		{
			if (ll < mr - shift)
			{
				ll += shift;
				if (ml > ll) cl = ml - ll;
				if (ll > mr - w) cr = mr - ll;
				
				phpAds_floater_setpos_<?php echo $uniqid; ?>(c, ll, cr);
				phpAds_floater_setclip_<?php echo $uniqid; ?>(o, 0, cr, h, cl);
			}
			else
			{
				c.visibility = 'hidden';
				window.clearInterval(phpAds_adlayers_timerid_<?php echo $uniqid; ?>);
	
				if (<?php echo $loop == 'n' ? 'true' : 'phpAds_adlayers_counter_'.$uniqid.' < '.$loop; ?>)
					window.setTimeout('phpAds_floater_<?php echo $uniqid; ?>()', <?php echo $pause*1000; ?>);
			}
		}
<?php
	}
	else
	{
?>
		if (c.visibility == 'hidden' || c.visibility == 'hide')
		{
			phpAds_floater_setclip_<?php echo $uniqid; ?>(o, 0, 1, h, 0);
			phpAds_floater_setpos_<?php echo $uniqid; ?>(c, mr - 1, 1);
			c.visibility = 'visible';
		}
		else
		{
			if (ll > is + shift)
			{
				ll -= shift;
				if (ml > ll) cl = ml - ll;
				if (ll > mr - w) cr = mr - ll;
				
				phpAds_floater_setclip_<?php echo $uniqid; ?>(o, 0, cr, h, cl);
				phpAds_floater_setpos_<?php echo $uniqid; ?>(c, ll, cr);
			}
			else
			{
				c.visibility = 'hidden';
				phpAds_floater_setclip_<?php echo $uniqid; ?>(o, 0, w, h, 0);
				window.clearInterval(phpAds_adlayers_timerid_<?php echo $uniqid; ?>);
	
				if (<?php echo $loop == 'n' ? 'true' : 'phpAds_adlayers_counter_'.$uniqid.' < '.$loop; ?>)
					window.setTimeout('phpAds_floater_<?php echo $uniqid; ?>()', <?php echo $pause*1000; ?>);
			}
		}
<?php
	}
?>
	}
}


function phpAds_floater_<?php echo $uniqid; ?>()
{
	phpAds_adlayers_timerid_<?php echo $uniqid; ?> = window.setInterval('phpAds_floater_grow_<?php echo $uniqid; ?>()', 50);
	phpAds_adlayers_counter_<?php echo $uniqid; ?>++;
}

var phpAds_adlayers_counter_<?php echo $uniqid; ?> = 0;
var phpAds_adlayers_timerid_<?php echo $uniqid; ?> = null;

phpAds_floater_<?php echo $uniqid; ?>();

<?php
}



/*********************************************************/
/* Return HTML code for the layer                        */
/*********************************************************/

function phpAds_getLayerHTML ($output, $uniqid)
{
	global $transparent, $backcolor, $shiftv;
	
	// Register input variables
	phpAds_registerGlobal ('transparent', 'backcolor', 'shiftv');
	
	
	if (!isset($transparent)) $transparent = 't';
	if (!isset($backcolor)) $backcolor = '#FFFFFF';
	if (!isset($shiftv)) $shiftv = '0';
	
	// return HTML code
	return '<div id="phpads_'.$uniqid.'" style="position:absolute; width:'.$output['width'].'px; height:'.$output['height'].
		'px; z-index:99; left: 0px; top: '.$shiftv.'px; visibility: hidden; overflow: hidden'.
		($transparent == 't' ? '' : '; background-color: "'.$backcolor.'; layer-background-color: "'.$backcolor).'">'.
		$output['html'].'</td></tr></table></div>';
}

?>