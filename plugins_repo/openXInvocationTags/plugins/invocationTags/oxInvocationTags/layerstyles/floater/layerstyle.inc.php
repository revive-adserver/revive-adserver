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

    //$richmedia  = $agent['agent'] == 'IE' && $agent['version'] > 5.0 &&
    //			  $agent['platform'] == 'Win'
    //			  ? true : false;
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
    global $ltr, $loop, $speed, $pause, $shiftv;
    global $limited, $lmargin, $rmargin;

    // Register input variables
    MAX_commonRegisterGlobalsArray(['ltr', 'loop', 'speed', 'pause',
                           'shiftv', 'limited', 'lmargin', 'rmargin']);


    if (!isset($ltr)) {
        $ltr = 't';
    }
    if (!isset($loop)) {
        $loop = 'n';
    }
    if (!isset($speed)) {
        $speed = 3;
    }
    if (!isset($pause)) {
        $pause = 10;
    }
    if (!isset($shiftv)) {
        $shiftv = 0;
    }

    if ($limited == 't') {
        if (!isset($lmargin) || !isset($rmargin)) {
            $limited = 'f';
            $lmargin = $rmargin = '';
        }
    } ?>

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

function MAX_floater_setclip_<?php echo $uniqid; ?>(o, top, right, bottom, left)
{
	if (o.style)
	{
		o.style.clip = "rect(" + top + "px " + right + "px " + bottom + "px " + left + "px)";
	}
	else
	{
		o.clip.top = top+'px'; o.clip.right = right+'px'; o.clip.bottom = bottom+'px'; o.clip.left = left+'px';
	}
}

function MAX_floater_setpos_<?php echo $uniqid; ?>(c, left, width)
{
	if (document.all && !window.innerWidth)
	{
		c.pixelLeft = left; c.pixelWidth = width;
	}
	else
	{
		c.left = left+'px'; c.width = width+'px';
	}
}

function MAX_floater_grow_<?php echo $uniqid; ?>()
{
	var o = MAX_findObj('MAX_<?php echo $uniqid; ?>');

	if (!o)
		return false;

	if (o.style)
		c = o.style;
	else
		c = o;

	ww = MAX_getClientSize()[0]

	if(!document.all&&!window.opera) ww-=16

	var w = <?php echo $output['width']; ?>;
	var h = <?php echo $output['height']; ?>;

<?php
    if ($limited == 't') {
        if ($lmargin == '') {
            ?>
	var ml = 0;
<?php
        } elseif ($lmargin > 0) {
            ?>
	var ml = <?php echo $lmargin; ?>;
<?php
        } else {
            ?>
	var ml = ww + <?php echo $lmargin; ?>;
<?php
        }

        if ($rmargin == '') {
            ?>
	var mr = ww;
<?php
        } elseif ($rmargin > 0) {
            ?>
	var mr = <?php echo $rmargin; ?>;
<?php
        } else {
            ?>
	var mr = ww + <?php echo $rmargin; ?>;
<?php
        }
    } else {
        ?>
	var mr = ww;
	var ml = 0;
<?php
    }

    if (strstr($_SERVER['HTTP_USER_AGENT'], 'Opera 6')) {
        ?>
	mr = mr - w; ml = ml + w;

	if (mr + w > ml)
<?php
    } else {
        ?>
	if (mr > ml)
<?php
    } ?>
	{
		var shift = <?php echo 3 * ($speed - 1) + 1; ?>;
		var iw = mr - ml + w; var is = ml - w;
		var cr = w; var cl = 0;

		if (document.all && !window.innerWidth)
			ll = c.pixelLeft;
		else
			ll = parseInt(c.left);

<?php
    if ($ltr == 't') {
        ?>
		if (c.visibility == 'hidden' || c.visibility == 'hide')
		{
			MAX_floater_setclip_<?php echo $uniqid; ?>(o, 0, w, h, w);
			MAX_floater_setpos_<?php echo $uniqid; ?>(c, is, w);
			c.visibility = 'visible';
		}
		else
		{
			if (ll < mr - shift)
			{
				ll += shift;
				if (ml > ll) cl = ml - ll;
				if (ll > mr - w) cr = mr - ll;

				MAX_floater_setpos_<?php echo $uniqid; ?>(c, ll, cr);
				MAX_floater_setclip_<?php echo $uniqid; ?>(o, 0, cr, h, cl);
			}
			else
			{
				c.visibility = 'hidden';
				window.clearInterval(MAX_adlayers_timerid_<?php echo $uniqid; ?>);

				if (<?php echo $loop == 'n' ? 'true' : 'MAX_adlayers_counter_' . $uniqid . ' < ' . $loop; ?>)
					window.setTimeout('MAX_floater_<?php echo $uniqid; ?>()', <?php echo $pause * 1000; ?>);
			}
		}
<?php
    } else {
        ?>
		if (c.visibility == 'hidden' || c.visibility == 'hide')
		{
			MAX_floater_setclip_<?php echo $uniqid; ?>(o, 0, 1, h, 0);
			MAX_floater_setpos_<?php echo $uniqid; ?>(c, mr - 1, 1);
			c.visibility = 'visible';
		}
		else
		{
			if (ll > is + shift)
			{
				ll -= shift;
				if (ml > ll) cl = ml - ll;
				if (ll > mr - w) cr = mr - ll;

				MAX_floater_setclip_<?php echo $uniqid; ?>(o, 0, cr, h, cl);
				MAX_floater_setpos_<?php echo $uniqid; ?>(c, ll, cr);
			}
			else
			{
				c.visibility = 'hidden';
				MAX_floater_setclip_<?php echo $uniqid; ?>(o, 0, w, h, 0);
				window.clearInterval(MAX_adlayers_timerid_<?php echo $uniqid; ?>);

				if (<?php echo $loop == 'n' ? 'true' : 'MAX_adlayers_counter_' . $uniqid . ' < ' . $loop; ?>)
					window.setTimeout('MAX_floater_<?php echo $uniqid; ?>()', <?php echo $pause * 1000; ?>);
			}
		}
<?php
    } ?>
	}
}


function MAX_floater_<?php echo $uniqid; ?>()
{
	MAX_adlayers_timerid_<?php echo $uniqid; ?> = window.setInterval('MAX_floater_grow_<?php echo $uniqid; ?>()', 50);
	MAX_adlayers_counter_<?php echo $uniqid; ?>++;
}

var MAX_adlayers_counter_<?php echo $uniqid; ?> = 0;
var MAX_adlayers_timerid_<?php echo $uniqid; ?> = null;

MAX_floater_<?php echo $uniqid; ?>();

<?php
}



/*-------------------------------------------------------*/
/* Return HTML code for the layer                        */
/*-------------------------------------------------------*/

function MAX_layerGetHtml($output, $uniqid)
{
    global $transparent, $backcolor, $shiftv;

    // Register input variables
    MAX_commonRegisterGlobalsArray(['transparent', 'backcolor', 'shiftv']);


    if (!isset($transparent)) {
        $transparent = 't';
    }
    if (!isset($backcolor)) {
        $backcolor = '#FFFFFF';
    }
    if (!isset($shiftv)) {
        $shiftv = '0';
    }

    // return HTML code
    return '<div id="MAX_' . $uniqid . '" style="position:absolute; width:' . $output['width'] . 'px; height:' . $output['height'] .
        'px; z-index:99; left: 0px; top: ' . $shiftv . 'px; visibility: hidden; overflow: hidden' .
        ($transparent == 't' ? '' : '; background-color: "' . $backcolor . '; layer-background-color: "' . $backcolor) . '">' .
        $output['html'] . '</td></tr></table></div>';
}

?>