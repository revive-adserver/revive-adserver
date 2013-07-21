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

	return array (
		'richmedia'  => $richmedia,
		'compatible' => $compatible
	);
}



/*-------------------------------------------------------*/
/* Output JS code for the layer                          */
/*-------------------------------------------------------*/

function MAX_layerPutJs($output, $uniqid)
{
	global $align, $valign, $closetime, $padding;
	global $shifth, $shiftv, $closebutton;

	// Register input variables
	MAX_commonRegisterGlobalsArray(array('align', 'valign', 'closetime', 'padding',
						   'shifth', 'shiftv', 'closebutton'));


	if (!isset($padding)) $padding = 0;
	if (!isset($shifth)) $shifth = 0;
	if (!isset($shiftv)) $shiftv = 0;
	if (!isset($closebutton)) $closebutton = 'f';

	// Calculate layer size (inc. borders)
	$layer_width = $output['width'] + 2 + $padding*2;
	$layer_height = $output['height'] + 2 + ($closebutton == 't' ? 11 : 0) + $padding*2;

?>

function MAX_findObj(n, d) {
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
  d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i>d.layers.length;i++) x=MAX_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MAX_getClientSize() {
	if (window.innerHeight >= 0) {
		return [window.innerWidth, window.innerHeight];
	} else if (document.documentElement && document.documentElement.clientWidth > 0) {
		return [document.documentElement.clientWidth,document.documentElement.clientHeight]
	} else if (document.body.clientHeight > 0) {
		return [document.body.clientWidth,document.body.clientHeight]
	} else {
		return [0, 0]
	}
}

function MAX_adlayers_place_<?php echo $uniqid; ?>()
{
	var c = MAX_findObj('MAX_<?php echo $uniqid; ?>');

	if (!c)
		return false;

	_s='style'

	var clientSize = MAX_getClientSize()
	ih = clientSize[1]
	iw = clientSize[0]

	if(document.all && !window.opera)
	{
		sl = document.body.scrollLeft || document.documentElement.scrollLeft;
		st = document.body.scrollTop || document.documentElement.scrollTop;
		of = 0;
	}
	else
	{
		sl = window.pageXOffset;
		st = window.pageYOffset;

		if (window.opera)
			of = 0;
		else
			of = 16;
	}

<?php
	echo "\t\t c[_s].left = parseInt(sl+";

	switch($align){
	    case 'left': 		echo abs($shifth); break;
	    case 'center':		echo '(iw - '.$layer_width.') / 2 +'.$shifth; break;
	    default: 			echo 'iw - '.($layer_width+abs($shifth)); break;
	}

	echo ") + (window.opera?'':'px');" .
		"\n\t\t c[_s].top = parseInt(st+";

	switch($valign){
	    case 'middle': 		echo '(ih - '.$layer_height.') / 2 +'.$shiftv; break;
	    case 'bottom':		echo 'ih - '.($layer_height+abs($shiftv)); break;
	    default: 			echo abs($shiftv); break;
	}
	echo ") + (window.opera?'':'px');\n";
?>

	c[_s].visibility = MAX_adlayers_visible_<?php echo $uniqid; ?>;
    c[_s].display = MAX_adlayers_display_<?php echo $uniqid; ?>;
    if (MAX_adlayers_display_<?php echo $uniqid; ?> == 'none') {
        c.innerHTML = '&nbsp;';
    }
}


function MAX_simplepop_<?php echo $uniqid; ?>(what)
{
	var c = MAX_findObj('MAX_<?php echo $uniqid; ?>');

	if (!c)
		return false;

	if (c.style)
		c = c.style;

	switch(what)
	{
		case 'close':
			MAX_adlayers_visible_<?php echo $uniqid; ?> = 'hidden';
            MAX_adlayers_display_<?php echo $uniqid; ?> = 'none';
			MAX_adlayers_place_<?php echo $uniqid; ?>();
			window.clearInterval(MAX_adlayers_timerid_<?php echo $uniqid; ?>);
			break;

		case 'open':
			MAX_adlayers_visible_<?php echo $uniqid; ?> = 'visible';
            MAX_adlayers_display_<?php echo $uniqid; ?> = 'block';
			MAX_adlayers_place_<?php echo $uniqid; ?>();
			MAX_adlayers_timerid_<?php echo $uniqid; ?> = window.setInterval('MAX_adlayers_place_<?php echo $uniqid; ?>()', 10);

<?php

if (isset($closetime) && $closetime > 0)
	echo "\t\t\treturn window.setTimeout('MAX_simplepop_".$uniqid."(\\'close\\')', ".($closetime * 1000).");";

?>

			break;
	}
}


var MAX_adlayers_timerid_<?php echo $uniqid; ?>;
var MAX_adlayers_visible_<?php echo $uniqid; ?>;
var MAX_adlayers_display_<?php echo $uniqid; ?>;


MAX_simplepop_<?php echo $uniqid; ?>('open');
<?php
}



/*-------------------------------------------------------*/
/* Return HTML code for the layer                        */
/*-------------------------------------------------------*/

function MAX_layerGetHtml($output, $uniqid)
{
	global $target;
	global $align, $padding, $closebutton;
	global $backcolor, $bordercolor;
	global $nobg, $noborder;

	$conf = $GLOBALS['_MAX']['CONF'];

	// Register input variables
	MAX_commonRegisterGlobalsArray(array('align', 'padding', 'closebutton',
						   'backcolor', 'bordercolor',
						   'nobg', 'noborder'));


	if (!isset($padding)) $padding = '2';
	if (!isset($closebutton)) $closebutton = 'f';
	if (!isset($backcolor)) $backcolor = 'FFFFFF';
	if (!isset($bordercolor)) $bordercolor = '000000';
	if (!isset($nobg)) $nobg = 'f';
	if (!isset($noborder)) $noborder = 'f';

	// Calculate layer size (inc. borders)
	$layer_width = $output['width'] + 2 + $padding*2;
	$layer_height = $output['height'] + 2 + ($closebutton == 't' ? 11 : 0) + $padding*2;

	// Create imagepath
	$imagepath = 'http://' . $conf['webpath']['images'] . '/layerstyles/simple/';

	// return HTML code
	return '
<div id="MAX_'.$uniqid.'" style="position:absolute; width:'.$layer_width.'px; height:'.$layer_height.'px; z-index:99; left: 0px; top: 0px; visibility: hidden">
	<table cellspacing="0" cellpadding="0"'.($noborder == 't' ? '' : ' style="border-style: solid; border-width: 1px; border-color: #'.$bordercolor.'"').'>
'.($closebutton == 't' ?
'		<tr>
			<td'.($nobg == 't' ? '' : ' bgcolor="#'.$backcolor.'"').' align="right" style="padding: 2px"><a href="javascript:;" onClick="MAX_simplepop_'.$uniqid.'(\'close\'); return false;" style="color:#0000ff"><img src="'.$imagepath.'close.gif" width="7" height="7" alt="Close" border="0"></a></td>
		</tr>
' : '').
'		<tr>
			<td '.($nobg == 't' ? '' : ' bgcolor="#'.$backcolor.'"').' align="center">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="'.$output['width'].'" height="'.$output['height'].'" align="center" valign="middle" style="padding: '.$padding.'px">'.$output['html'].'</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
';
}

?>
