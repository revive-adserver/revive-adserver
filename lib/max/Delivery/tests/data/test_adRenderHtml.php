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

/**
 * @package    MaxDelivery
 * @subpackage TestSuite Data
 */

$zoneId		=	0;
$source		=	'';
$ct0		=	'';
$withText	=	false;
$logClick	=	true;
$logView	=	true;
$useAlt		=	false;
$loc		=	0;
$referer	= 	'http://some.referrer.com/';

$aBanner = array(
        'ad_id' => 4,
        'placement_id' => 1,
        'active' => 't',
        'name' => 'Test HTML (TangoZebra)',
        'type' => 'html',
        'contenttype' =>'',
        'pluginversion' => 0,
        'filename' =>'',
        'imageurl' =>'',
        'width' => 468,
        'height' => 60,
        'weight' => 1,
        'seq' => 0,
        'target' => '',
        'url' => '',
        'alt' => '',
        'status' => '',
        'bannertext' => '',
        'adserver' => '',
        'block' => 0,
        'capping' => 0,
        'session_capping' => 0,
        'compiledlimitation' => 'true',
        'append' => '',
        'prepend' => '',
        'bannertype' => 0,
        'alt_filename' => '',
        'alt_imageurl' => '',
        'alt_contenttype' => '',
        'htmltemplate' => '<!-- Tangozebra.  tag_version=4.1.0, name=Test Job - Do not switch off > Test Expand banner, advert_format=Expand Banner, advert_id=1750, site=m3_net -->
<script language="Javascript1.1" type="text/javascript">
<!--
var tz_rnd = Math.random();
var tz_redirector_00001750 = "";
var tz_vc_00001750 = "";
var tz_force_00001750=-1;
var tz_pv_00001750 = "";
var tz_bit1 = "<scr";var tz_bit2 = "</";
var tz_tag = tz_bit1 + \'ipt language="javascript1.1" type="text/javascript" \';
tz_tag += \'src="http://ad.uk.tangozebra.com/a/aj/s/1750/6068;\' + tz_rnd + \'?ad_m3_net.js\';
tz_tag += \'">\' + tz_bit2 + \'script>\';
document.write(tz_tag);
//-->
</script>
<noscript>
<a target=\'_new\' href=\'http://ad.uk.tangozebra.com/a/ac/c_noscript/1750/6068/2900;TIMESTAMP?http%3A%2F%2Fwww.tangozebra.com\'><img src=\'http://ad.uk.tangozebra.com/a/ai/v_noscript/1750/6068/2900/Example;TIMESTAMP?static.gif\' border=\'0\' width=\'468\' height=\'60\' alt=\'\'></a>
</noscript>',
    'htmlcache' => '<!-- Tangozebra.  tag_version=4.1.0, name=Test Job - Do not switch off > Test Expand banner, advert_format=Expand Banner, advert_id=1750, site=m3_net -->
<script language="Javascript1.1" type="text/javascript">
<!--
var tz_rnd = Math.random();
var tz_redirector_00001750="{clickurl}";
var tz_vc_00001750 = "";
var tz_force_00001750=-1;
var tz_pv_00001750="{logurl}";
var tz_bit1 = "<scr";var tz_bit2 = "</";
var tz_tag = tz_bit1 + \'ipt language="javascript1.1" type="text/javascript" \';
tz_tag += \'src="http://ad.uk.tangozebra.com/a/aj/s/1750/6068;\' + tz_rnd + \'?ad_m3_net.js\';
tz_tag += \'">\' + tz_bit2 + \'script>\';
document.write(tz_tag);
//-->
</script>
<noscript>
<a  href="{clickurl}http://ad.uk.tangozebra.com/a/ac/c_noscript/1750/6068/2900;TIMESTAMP?http%3A%2F%2Fwww.tangozebra.com"  target=\'{target}\'><img src=\'http://ad.uk.tangozebra.com/a/ai/v_noscript/1750/6068/2900/Example;TIMESTAMP?static.gif\' border=\'0\' width=\'468\' height=\'60\ alt=\'\'></a>
</noscript>'
);


$expect =
'<!-- Tangozebra.  tag_version=4.1.0, name=Test Job - Do not switch off > Test Expand banner, advert_format=Expand Banner, advert_id=1750, site=m3_net -->
<script language="Javascript1.1" type="text/javascript">
<!--
var tz_rnd = Math.random();
var tz_redirector_00001750="{clickurl}";
var tz_vc_00001750 = "";
var tz_force_00001750=-1;
var tz_pv_00001750="{logurl}";
var tz_bit1 = "<scr";var tz_bit2 = "</";
var tz_tag = tz_bit1 + \'ipt language="javascript1.1" type="text/javascript" \';
tz_tag += \'src="http://ad.uk.tangozebra.com/a/aj/s/1750/6068;\' + tz_rnd + \'?ad_m3_net.js\';
tz_tag += \'">\' + tz_bit2 + \'script>\';
document.write(tz_tag);
//-->
</script>
<noscript>
<a  href="{clickurl}http://ad.uk.tangozebra.com/a/ac/c_noscript/1750/6068/2900;TIMESTAMP?http%3A%2F%2Fwww.tangozebra.com"  target=\'{target}\'><img src=\'http://ad.uk.tangozebra.com/a/ai/v_noscript/1750/6068/2900/Example;TIMESTAMP?static.gif\' border=\'0\' width=\'468\' height=\'60\ alt=\'\'></a>
</noscript>';



?>
