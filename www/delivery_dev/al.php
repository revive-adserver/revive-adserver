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

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
require_once MAX_PATH . '/lib/max/Delivery/flash.php';
require_once MAX_PATH . '/lib/max/Delivery/javascript.php';

###START_STRIP_DELIVERY
OA::debug('starting delivery script '.__FILE__);
###END_STRIP_DELIVERY

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('layerstyle'));
if (!isset($layerstyle) || empty($layerstyle)) $layerstyle = 'geocities';

// Include layerstyle
if (file_exists(MAX_PATH . $conf['pluginPaths']['plugins'] . 'invocationTags/oxInvocationTags/layerstyles/'.$layerstyle.'/layerstyle.inc.php')) {
    include MAX_PATH . $conf['pluginPaths']['plugins'] . 'invocationTags/oxInvocationTags/layerstyles/'.$layerstyle.'/layerstyle.inc.php';
} else {
    // Don't generate output when plugin layerstyleisn't available,just send javascript comment on fail
    echo '// Cannot load required layerstyle file. Check if openXInvocationTags plugin is installed';
    exit(1);
}

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(array('block', 'blockcampaign', 'exclude', 'mmm_fo', 'q'));

if (isset($context) && !is_array($context)) {
    $context = MAX_commonUnpackContext($context);
}
if (!is_array($context)) {
    $context = array();
}

$limitations = MAX_layerGetLimitations();

MAX_commonSendContentTypeHeader("application/x-javascript", $charset);
if ($limitations['compatible']) {
	$output = MAX_adSelect($what, $campaignid, $target, $source, $withtext, $charset, $context, $limitations['richmedia'], $GLOBALS['ct0'], $GLOBALS['loc'], $GLOBALS['referer']);

	MAX_cookieFlush();
	// Exit if no matching banner was found
	if (empty($output['html'])) {
	    exit;
	}
	$uniqid = substr(md5(uniqid('', 1)), 0, 8);

	// Block this banner for next invocation
    if (!empty($block) && !empty($output['bannerid'])) {
        $output['context'][] = array('!=' => 'bannerid:' . $output['bannerid']);
    }

    // Block this campaign for next invocation
    if (!empty($blockcampaign) && !empty($output['campaignid'])) {
        $output['context'][] = array('!=' => 'campaignid:' . $output['campaignid']);
    }

    // Block this campaign for next invocation
    if (!empty($blockcampaign) && !empty($output['campaignid'])) {
        $output['context'][] = array('!=' => 'campaignid:' . $output['campaignid']);
    }
    // Append any data to the context array
    if (!empty($output['context'])) {
        foreach ($output['context'] as $id => $contextArray) {
            if (!in_array($contextArray, $context)) {
                $context[] = $contextArray;
            }
        }
    }

	// Include the FlashObject script if required
    if ($output['contenttype'] == 'swf') {
        echo MAX_flashGetFlashObjectInline();
    }

    // Set document.context, if required
    $output['html'] .= (!empty($context)) ? "<script type='text/javascript'>document.context='".MAX_commonPackContext($context)."'; </script>" : '';

	echo MAX_javascriptToHTML(MAX_layerGetHtml($output, $uniqid), "MAX_{$uniqid}");
	MAX_layerPutJs($output, $uniqid);
    ob_flush();

}

?>
