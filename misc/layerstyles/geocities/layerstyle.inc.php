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



// Define constant used to place code generator
define('phpAds_adLayerLoaded', true);



/*********************************************************/
/* Output JS code for the layer                          */
/*********************************************************/

function phpAds_putLayerJS ($output, $uniqid)
{
	global $align, $collapsetime, $padding;
	
	// Calculate layer size (inc. borders)
	$layer_width = $output['width'] + 4 + $padding*2;
	$layer_height = $output['height'] + 30 + $padding*2;
	
?>

function phpAds_findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
  d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i>d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function phpAds_adlayers_place_<?php echo $uniqid; ?>()
{
	var c = phpAds_findObj('phpads_c<?php echo $uniqid; ?>');
	var o = phpAds_findObj('phpads_o<?php echo $uniqid; ?>');

	if (!c || !o)
		return false;

	c = c.style;
	o = o.style;

	if (document.all) { 
<?php if ($align == 'left') { ?>
		c.pixelLeft = 0;
		o.pixelLeft = 0;
<?php } elseif ($align == 'center') { ?>
		c.pixelLeft = (document.body.clientWidth - <?php echo $layer_width; ?>) / 2;
		o.pixelLeft = (document.body.clientWidth - <?php echo $layer_width; ?>) / 2;
<?php } else { ?>
		c.pixelLeft = document.body.clientWidth - <?php echo $layer_width; ?>;
		o.pixelLeft = document.body.clientWidth - <?php echo $layer_width; ?>;
<?php } ?>
		c.pixelTop = 0 + document.body.scrollTop;
		o.pixelTop = 0 + document.body.scrollTop;
	} else {
<?php if ($align == 'left') { ?>
		c.left = 0;
		o.left = 0;
<?php } elseif ($align == 'center') { ?>
		c.left = (window.innerWidth + window.pageXOffset - <?php echo $layer_width; ?>) / 2;
		o.left = (window.innerWidth + window.pageXOffset - <?php echo $layer_width; ?>) / 2;
<?php } else { ?>
		c.left = window.innerWidth + window.pageXOffset - <?php echo $layer_width; ?>;
		o.left = window.innerWidth + window.pageXOffset - <?php echo $layer_width; ?>;
<?php } ?>
		c.top = 0 + window.pageYOffset;
		o.top = 0 + window.pageYOffset;
	}
}

function phpAds_geopop(what, ad)
{
	var c = phpAds_findObj('phpads_c' + ad);
	var o = phpAds_findObj('phpads_o' + ad);

	if (!c || !o)
		return false;

	c = c.style;
	o = o.style;

	switch(what)
	{
		case 'collapse':
			c.visibility = 'visible'; 
			o.visibility = 'hidden';

			if (phpAds_timerid[ad])
			{
				window.clearTimeout(phpAds_timerid[ad]);
				phpAds_timerid[ad] = false;
			}

			break;

		case 'expand':
			o.visibility = 'visible';
			c.visibility = 'hidden'; 

		break;

		case 'close':
			c.visibility = 'hidden'; 
			o.visibility = 'hidden';

		break;

		case 'open':
		
			phpAds_adlayers_place_<?php echo $uniqid; ?>();

			c.visibility = 'hidden';
			o.visibility = 'visible';
<?php

if (isset($collapsetime) && $collapsetime > 0)
	echo "\t\t\treturn window.setTimeout('phpAds_geopop(\\'collapse\\', \\'".$uniqid."\\')', ".($collapsetime * 1000).");";

?>

			break;
	}

	return false;
}


if (typeof phpAds_timerid == 'undefined')
	phpAds_timerid = new Array();

phpAds_timerid['<?php echo $uniqid; ?>'] = phpAds_geopop('open', '<?php echo $uniqid; ?>');

<?php
}



/*********************************************************/
/* Return HTML code for the layer                        */
/*********************************************************/

function phpAds_getLayerHTML ($output, $uniqid)
{
	global $phpAds_config, $target;
	global $align, $collapsetime, $padding, $closetext;

	if (!isset($padding)) $padding = '2';

	// Calculate layer size (inc. borders)
	$layer_width = $output['width'] + 4 + $padding*2;
	$layer_height = $output['height'] + 30 + $padding*2;

	// Create imagepath
	$imagepath = $phpAds_config['url_prefix'].'/misc/layerstyles/geocities/images/';

	// return HTML code
	return '
<div id="phpads_c'.$uniqid.'" style="position:absolute; width:'.$layer_width.'px; height:'.$layer_height.'px; z-index:98; left: 0px; top: 0px; visibility: hidden"> 
	<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-style: ridge; border-color: #ffffff">
		<tr>
			<td bordercolor="#DDDDDD" bgcolor="#000099" align="right" style="padding: 3px 3px 2px"><img src="'.$imagepath.'expand.gif" width="12" height="12" hspace="3" onClick="phpAds_geopop(\'expand\', \''.$uniqid.'\')"><img src="'.$imagepath.'close.gif" width="12" height="12" onClick="phpAds_geopop(\'close\', \''.$uniqid.'\')"></td>
		</tr>
'.(strlen($output['url']) && strlen($output['alt']) ?
'		<tr>
			<td bgcolor="#FFFFCC" align="center" style="font-family: Arial, helvetica, sans-serif; font-size: 11px; padding: 2px"><a href="'.$output['url'].'" '.(isset($target) ? 'target="'.$target.'"' : '').'style="color: #0000ff">'.$output['alt'].'</a></td>
		</tr>
' : '').
'	</table>
</div>
<div id="phpads_o'.$uniqid.'" style="position:absolute; width:'.$layer_width.'px; height:'.$layer_height.'px; z-index:99; left: 0px; top: 0px; visibility: hidden"> 
	<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-style: outset; border-color: #ffffff">
		<tr> 
			<td bordercolor="#DDDDDD" bgcolor="#000099" align="right" style="padding: 3px 3px 2px"><img src="'.$imagepath.'expand-d.gif" width="12" height="12" hspace="3"><img src="'.$imagepath.'collapse.gif" width="12" height="12" onClick="phpAds_geopop(\'collapse\', \''.$uniqid.'\')"></td>
		</tr>
		<tr> 
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr> 
						<td align="center">
							<table border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
								<tr>
									<td width="'.$output['width'].'" height="'.$output['height'].'" align="center" valign="middle" style="padding: '.$padding.'px">'.$output['html'].'</td>
								</tr>
							</table>
						</td>
					</tr>'.(strlen($closetext) ? '
					<tr> 
						<td align="center" bgcolor="#FFFFFF" style="font-family: Arial, helvetica, sans-serif; font-size: 9px; padding: 1px"><a href="javascript:;" onClick="phpAds_geopop(\'collapse\', \''.$uniqid.'\')" style="color:#0000ff">'.$closetext.'</a></td>
					</tr>' : '').'
				</table>
			</td>
		</tr>
	</table>
</div>
';
}



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_placeLayerSettings ()
{
	global $align, $collapsetime, $padding, $closetext;
	
	if (!isset($align)) $align = 'right';
	if (!isset($collapsetime)) $collapsetime = '-';
	if (!isset($padding)) $padding = '2';
	if (!isset($closetext)) $closetext = $GLOBALS['strClose'];
	

	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strAlignment']."</td><td width='370'>";
	echo "<select name='align'>";
		echo "<option value='left'".($align == 'left' ? ' selected' : '').">".$GLOBALS['strLeft']."</option>";
		echo "<option value='center'".($align == 'center' ? ' selected' : '').">".$GLOBALS['strCenter']."</option>";
		echo "<option value='right'".($align == 'right' ? ' selected' : '').">".$GLOBALS['strRight']."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strAutoCollapseAfter']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='collapsetime' size='' value='".(isset($collapsetime) ? $collapsetime : '-')."' style='width:175px;'> ".$GLOBALS['strAbbrSeconds']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strCloseText']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='closetext' size='' value='".$closetext."' style='width:175px;'></td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strBannerPadding']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='padding' size='' value='".(isset($padding) ? $padding : '0')."' style='width:60px;'> pixels</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_generateLayerCode ($parameters)
{
	global $phpAds_config;
	global $align, $collapsetime, $padding, $closetext;
	
	$parameters[] = 'layerstyle=geocities';
	$parameters[] = 'align='.(isset($align) ? $align : 'right');
	$parameters[] = 'padding='.(isset($padding) ? (int)$padding : '2');

	if (isset($closetext)) $parameters[] = 'closetext='.urlencode($closetext);

	if (isset($collapsetime) && $collapsetime > 0)
		$parameters[] = 'collapsetime='.$collapsetime;
	
	$buffer = "<script language='JavaScript' src='".$phpAds_config['url_prefix']."/adlayer.php";
	if (sizeof($parameters) > 0)
		$buffer .= "?".implode ("&", $parameters);
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
		'layerstyle' => true,
		'layercustom' => true
	);
}

?>