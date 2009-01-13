<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * @package    MaxDelivery
 * @subpackage TestSuite Data
 * @author     Monique Szpak <monique@m3.net>
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
        'appendtype' => 0,
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
