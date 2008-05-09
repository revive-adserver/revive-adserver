<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Load the required language files
Language_Loader::load('invocation');

/**
 * MAX_Admin_Invocation class is a common class for placingInvocationForm(s)
 * and generating invocation codes
 *
 */
class MAX_Admin_Invocation {

    var $defaultOptionValues = array(
        'thirdPartyServer' => 0,
        'cacheBuster'      => 1,
        'comments'         => 1,
    );

    function getAllowedVariables()
    {
        $aVariables = array(
            // IDs
            'affiliateid', 'bannerid', 'clientid', 'campaignid', 'zoneid',
            // Special vars
            'codetype', 'submitbutton',
            // Others
            'bannerUrl',
            'block',
            'blockcampaign',
            'cachebuster',
            'charset',
            'comments',
            'delay',
            'delay_type',
            'domains_table',
            'extra',
            'height',
            'hostlanguage',
            'iframetracking',
            'ilayer',
            'left',
            'location',
            'menubar',
            'parameters',
            'popunder',
            'raw',
            'refresh',
            'resizable',
            'resize',
            'scrollbars',
            'source',
            'status',
            'target',
            'template',
            'thirdpartytrack',
            'timeout',
            'toolbars',
            'top',
            'transparent',
            'uniqueid',
            'website',
            'what',
            'width',
            'withtext',
            'xmlrpcproto',
            'xmlrpctimeout',
        );

        // Add any plugin-specific option values to the global array...
        if (isset($invocationTag->defaultOptionValues)) {
            foreach($invocationTag->defaultOptionValues as $key => $default) {
                $aVariables[] = $key;
            }
        }

        return $aVariables;
    }

    /**
     * A method to assign invocation variables to the current object
     *
     * @param array $aParams The invocation parameters. If null, variables will be fetched from $GLOBALS
     */
    function assignVariables($aParams = null)
    {
        // Get all variables
        $globalVariables = $this->getAllowedVariables();

        // Check if we need to fetch variables from the global scope
        if (!isset($aParams)) {
            // Register globals
            call_user_func_array('phpAds_registerGlobal', $globalVariables);

            foreach($globalVariables as $makeMeGlobal) {
                global $$makeMeGlobal;
                // If values are unset, populate them from the Plugin/Parent object if present
                if (isset($$makeMeGlobal)) {
                    // Check the plugin first, fall-back to the parent
                    if (isset($invocationTag->defaultOptionValues[$makeMeGlobal])) {
                        $$makeMeGlobal = $invocationTag->defaultOptionValues[$makeMeGlobal];
                    } else if (isset($this->defaultOptionValues[$makeMeGlobal])) {
                        $$makeMeGlobal = $this->defaultOptionValues[$makeMeGlobal];
                    }
                }
                // also make this variable a class attribute
                // so plugins could have an access to these values (and modify them)
                $this->$makeMeGlobal =& $$makeMeGlobal;
            }
        } else {
            // Variables passed in as a parameter
            foreach($globalVariables as $makeMeGlobal) {
                if (isset($aParams[$makeMeGlobal])) {
                    $this->$makeMeGlobal = $aParams[$makeMeGlobal];
                }
            }
        }

    }

    /**
     * Generate bannercode (invocation code for banner)
     *
     * @param object $invocationTag    If null the invocation tag is factory by MAX_Plugin class,
     *                                 else this object is used
     * @param array  $aParams          Input parameters, if null globals will be fetched
     *
     * @return string    Generated invocation code
     */
    function generateInvocationCode(&$invocationTag, $aParams = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        // register all the variables
        $this->assignVariables($aParams);

        if($invocationTag === null) {
            $invocationTag = MAX_Plugin::factory('invocationTags', $this->codetype);
        }
        if($invocationTag === false) {
            OA::debug('Error while factory invocationTag plugin');
            exit();
        }

        // pass global variables as object attributes
        $invocationTag->setInvocation($this);

        // generate invocation code
        return $invocationTag->generateInvocationCode();
    }

    /**
     * Generate tracker code
     *
     * @return string  Generated tracker code
     */
    function generateTrackerCode($trackerId)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        global $trackerid;

        $variablesComment = '';
        $variablesQuerystring = '';

        $variables = Admin_DA::getVariables(array('tracker_id' => $trackerId), true);

        $buffer = "
<!--/*
  *
  *  OpenX image beacon tracker code
  *  - Generated with OpenX v" . OA_VERSION . "
  *
  *  If this tag is being served on a secure (SSL) page, you must replace
  *  'http://{$conf['webpath']['delivery']}/...'
  * with
  *  'https://{$conf['webpath']['deliverySSL']}/...'
  *
  *  To help prevent caching of this tracker beacon, if possible,
  *  Replace %%RANDOM_NUMBER%% with a randomly generated number (or timestamp)
  *";
        if (!empty($variables)) {
            $buffer .= "
  *  In order for the adserver to track variables for this conversion,
  *  they must be provided by the client.
  *
  *  Additional variables may be added, however they must be added
  *  in the adserver as well before they will be logged.
  *
  *  The '%%VARIABLE_VALUE%%' should be replaced with the
  *  actual values for this sale.
  *";
            $variablesQuerystring = '';
            foreach ($variables as $variable) {
                $variablesQuerystring .= "&amp;{$variable['name']}=%%" . strtoupper($variable['name']) . "_VALUE%%";
            }
        }
        $buffer .= "
  *
  *  Place this code at the top of your thank-you page, just after the <body> tag.
  *
  */-->

" . $this->_generateTrackerImageBeacon($trackerId);
        $buffer .= "\n";
        return $buffer;
    }

    /**
     * Place invocation form - generate form with group of options for every plugin,
     * look into max/docs/developer/plugins.zuml for more details
     *
     * @param array $extra
     * @param boolean $zone_invocation
     * @param array  $aParams          Input parameters, if null globals will be fetched
     *
     * @return string  Generated invocation form
     */
    function placeInvocationForm($extra = '', $zone_invocation = false, $aParams = null)
    {
        global $phpAds_TextDirection;
        
        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];

        $buffer = '';
        $this->zone_invocation = $zone_invocation;

        // register all the variables
        $this->assignVariables($aParams);

        // Deal with special variables
        $codetype = $this->codetype;
        $submitbutton = $this->submitbutton;

        // Check if affiliate is on the same server as the delivery code
        if (!empty($extra['website'])) {
            $server_max      = parse_url('http://' . $conf['webpath']['delivery'] . '/');
            $server_affilate = parse_url($extra['website']);
            // this code could be extremely slow if host is unresolved
            $server_same     = (@gethostbyname($server_max['host']) == @gethostbyname($server_affilate['host']));
        } else {
            $server_same = true;
        }

        // Hide when integrated in zone-advanced.php
        if (!is_array($extra) || !isset($extra['zoneadvanced']) || !$extra['zoneadvanced']) {
            $buffer .= "<form id='generate' name='generate' action='".$_SERVER['PHP_SELF']."' method='POST' onSubmit='return max_formValidate(this) && disableTextarea();'>\n";
        }

        // Invocation type selection
        if (!is_array($extra) || (isset($extra['delivery']) && ($extra['delivery']!=phpAds_ZoneInterstitial) && ($extra['delivery']!=phpAds_ZonePopup)) && ($extra['delivery']!=MAX_ZoneEmail)) {

            $invocationTags =& MAX_Plugin::getPlugins('invocationTags');

            foreach($invocationTags as $pluginKey => $invocationTag) {
                $allowed[$pluginKey] = $invocationTag->isAllowed($extra, $server_same);
            }

            if (!isset($codetype) || $allowed[$codetype] == false) {
                reset($allowed);
                while (list($k,$v) = each($allowed))
                    if ($v) $codetype = $k;
            }

            if (!isset($codetype)) {
                $codetype = '';
            }
            if (!isset($bannerUrl)) {
                $bannerUrl = 'http://www.example.com/INSERT_BANNER_URL.gif';
            }

            $buffer .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
            $buffer .= "<tr><td height='25' width='350'><b>". MAX_Plugin_Translation::translate('Please choose the type of banner invocation', 'invocationTags') ."</b>";
            if ($codetype=="adview" || $codetype=="clickonly"){
                $buffer .= "";
            }

            $buffer .= "</td></tr><tr><td height='35' valign='top'>";
            $buffer .= "<select name='codetype' onChange=\"disableTextarea();this.form.submit()\" accesskey=".$GLOBALS['keyList']." tabindex='".($tabindex++)."'>";

            foreach($invocationTags as $pluginKey => $invocationTag) {
                if($allowed[$pluginKey]) {
                    $invocationTagsNames[$pluginKey] = $invocationTag->getName();
                }
            }
            // sort by name
            asort($invocationTagsNames);
            foreach($invocationTagsNames as $pluginKey => $invocationTagName) {
                $buffer .= "<option value='".$pluginKey."'".($codetype == $pluginKey ? ' selected' : '').">".$invocationTagName."</option>";
            }
            $buffer .= "</select>";
            $buffer .= "&nbsp;<input type='image' src='" . MAX::assetPath() . "/images/".$phpAds_TextDirection."/go_blue.gif' border='0'></td>";
        } else {
            $invocationTags =& MAX_Plugin::getPlugins('invocationTags');
            foreach($invocationTags as $invocationCode => $invocationTag) {
                if(isset($invocationTag->defaultZone) && $extra['delivery'] == $invocationTag->defaultZone) {
                    $codetype = $invocationCode;
                    break;
                }
            }
            if (!isset($codetype)) {
                $codetype = '';
            }
        }
        if ($codetype != '') {
            // factory plugin for this $codetype
            $invocationTag = MAX_Plugin::factory('invocationTags', $codetype);
            if($invocationTag === false) {
                OA::debug('Error while factory invocationTag plugin');
                exit();
            }
            $invocationTag->setInvocation($this);
            $buffer .= $invocationTag->generateBannerSelection();

            $buffer .= phpAds_ShowBreak($print = false);
            $buffer .= "<br />";

            // Code
            // Layer and popup invocation types require specific paramters to be provided before invcation is possible
            if ( empty($submitbutton) && ($codetype=='popup' || $codetype=='adlayer')) {
                $generated = false;
            } else {
                $buffer .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
                $buffer .= "<tr><td height='25'>";
                if ($codetype == "clickonly" && !$this->zone_invocation) {
                    if ($bannerid == 0) {
                        $this->ads = array();
                    } else {
                        $this->ads = array($bannerid => $aAd);
                    }
                } elseif ($codetype == 'local' && !$server_same) {
                    $buffer .= "
                        <div class='errormessage'><img class='errormessage' src='" . MAX::assetPath() . "/images/warning.gif' align='absmiddle'>
                            <span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
                            is on the same physical machine as the adserver</span><br />
                            Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
                            and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)
                        </div>";
                }

                // Supress the textarea if required by this plugin
                if (empty($invocationTag->suppressTextarea)) {
                    $buffer .= "<img src='" . MAX::assetPath() . "/images/icon-generatecode.gif' align='absmiddle'>&nbsp;<b>".$GLOBALS['strBannercode']."</b></td>";

                    // Show clipboard button only on IE
                    if (strpos ($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 &&
                        strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera') < 1) {
                        $buffer .= "<td height='25' align='right'><img src='" . MAX::assetPath() . "/images/icon-clipboard.gif' align='absmiddle'>&nbsp;";
                        $buffer .= "<a href='javascript:max_CopyClipboard(\"bannercode\");'>".$GLOBALS['strCopyToClipboard']."</a></td></tr>";
                    } else {
                        $buffer .= "<td>&nbsp;</td>";
                    }
                    $buffer .= "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
                    $buffer .= "<tr><td colspan='2'>";

                    $buffer .= "<textarea id='bannercode' name='bannercode' class='code-gray' rows='15' cols='80' style='width:95%; border: 1px solid black' readonly>";
                    $buffer .= htmlspecialchars($this->generateInvocationCode($invocationTag));
                    $buffer .= "</textarea>";
                } else {
                    $buffer .= $this->generateInvocationCode($invocationTag);
                }
                $buffer .= "</td></tr>";
                $buffer .= "</table><br />";
                $buffer .= phpAds_ShowBreak($print = false);
                $buffer .= "<br />";

                $generated = true;
            }
            // Hide when integrated in zone-advanced.php
            if (!(is_array($extra) && isset($extra['zoneadvanced']) && $extra['zoneadvanced'])) {
                // Header
                // Parameters Section
                $buffer .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
                $buffer .= "<tr><td height='25' colspan='3'><img src='" . MAX::assetPath() . "/images/icon-overview.gif' align='absmiddle'>&nbsp;<b>".$GLOBALS['strParameters']."</b></td></tr>";
                $buffer .= "<tr height='1'><td width='30'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='30'></td>";
                $buffer .= "<td width='200'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='200'></td>";
                $buffer .= "<td width='100%'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
            }

            $buffer .= $invocationTag->generateOptions($this);

            // Hide when integrated in zone-advanced.php
            if (!(is_array($extra) && isset($extra['zoneadvanced']) && $extra['zoneadvanced'])) {
                // Footer
                $buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
                $buffer .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
                $buffer .= "</table>";
                $buffer .= "<br /><br />";
                $buffer .= "<input type='hidden' value='".($generated ? 1 : 0)."' name='generate'>";
                if ($generated) {
                    $buffer .= "<input type='submit' value='".$GLOBALS['strRefresh']."' name='submitbutton' tabindex='".($tabindex++)."'>";
                } else {
                    $buffer .= "<input type='submit' value='".$GLOBALS['strGenerate']."' name='submitbutton' tabindex='".($tabindex++)."'>";
                }
            }
        }
        // Put extra hidden fields
        if (is_array($extra)) {
            reset($extra);
            while (list($k, $v) = each($extra)) {
                $buffer .= "<input type='hidden' value='$v' name='$k'>";
            }
        }
        // Hide when integrated in zone-advanced.php
        if (!is_array($extra) || !isset($extra['zoneadvanced']) || !$extra['zoneadvanced']) {
            $buffer .= "</form><br /><br />";
        }

        // Disable bannercode before submitting the form (causes problems with mod_security)
        $buffer .= "<script type='text/javascript'>
            function disableTextarea() {
                var form = findObj('generate');
                if (typeof(form.bannercode) != 'undefined') {
                    form.bannercode.disabled = true;
                }
                form.submit();
            }
            </script>
        ";

        return $buffer;
    }

    /**
     * Present options common to all invocation methods
     *
     * @return string HTML to display options
     */
    function getDefaultOptionsList()
    {
        $options = array (
            'spacer'                    => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'thirdPartyServer'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'cacheBuster'               => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'comments'                  => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
        );
        return $options;
    }

    function generateJavascriptTrackerCode($trackerId)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $variablemethod = 'default';
        $trackers = Admin_DA::getTrackers(array('tracker_id' => $trackerId), true);
        if (count($trackers)) {
            $variablemethod = $trackers[$trackerId]['variablemethod'];
        }

        $variables = Admin_DA::getVariables(array('tracker_id' => $trackerId), true);
        $variablesQuerystring = '';

        $buffer = "<!--/*
  *
  *  OpenX JavaScript tracker code
  *  - Generated with OpenX v" . OA_VERSION . "
  *
  *  To help prevent caching of the <noscript> beacon, if possible,
  *  Replace %%RANDOM_NUMBER%% with a randomly generated number (or timestamp)
  *
  */-->
";
        $varbuffer = '';
        if (!empty($variables)) {
            foreach ($variables as $id => $variable) {
                if (($variablemethod == 'default' || $variablemethod == 'js') && $variable['variablecode']) {
                    $varcode    = stripslashes($variable['variablecode']);
                    $varbuffer .= "    {$varcode};\n";
                }
                $variablesQuerystring .= "&amp;{$variable['name']}=%%" . strtoupper($variable['name']) . "_VALUE%%";
            }
        }

        if (!empty($varbuffer)) {
            $varprefix = $conf['var']['prefix'];
            $buffer .= "
<!--/*
  *
  *  In order for the adserver to track variables for this conversion,
  *  they must be provided by the client.
  *
  *  Additional variables may be added, however they must be added
  *  in the adserver as well before they will be logged.
  *
  *  The '%%VARIABLE_VALUE%%' should be replaced with the
  *  actual values for this sale.
  *
  *  NOTE: In order to track variables from the <noscript> section,
  *  the above replacement must be performed within the img tag as well.
  *
  *  The following values have been pre-configured in the adserver
  *
  */-->

<script type='text/javascript'><!--//<![CDATA[
";
            $buffer .= $varbuffer;
            $buffer .= "//]]>--></script>
";
        }

        $buffer  .= "
<!--/*
  *
  *  Place this code at the top of your thank-you page, just after the <body> tag,
  *  below any definitions of Javascript variables that need to be tracked.
  *
  */-->

<script type='text/javascript'><!--//<![CDATA[
    var {$varprefix}p=location.protocol=='https:'?'https:':'http:';
    var {$varprefix}r=Math.floor(Math.random()*999999);
    document.write (\"<\" + \"script language='JavaScript' \");
    document.write (\"type='text/javascript' src='\"+{$varprefix}p);
    document.write (\"".MAX_commonConstructPartialDeliveryUrl($conf['file']['conversionjs'])."\");
    document.write (\"?trackerid={$trackerId}&amp;r=\"+{$varprefix}r+\"'><\" + \"\\/script>\");
//]]>--></script><noscript>" . $this->_generateTrackerImageBeacon($trackerId) . "</noscript>";
        $buffer .= "\n";
        return $buffer;
    }

    function _generateTrackerImageBeacon($trackerId)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $variables = Admin_DA::getVariables(array('tracker_id' => $trackerId), true);
        $beacon  = "<div id='m3_tracker_{$trackerId}' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'>";
        $beacon .= "<img src='" . MAX_commonConstructDeliveryUrl($conf['file']['conversion']) . "?trackerid={$trackerId}";
        foreach ($variables as $variable) {
            $beacon .= "&amp;{$variable['name']}=%%" . strtoupper($variable['name']) . "_VALUE%%";
        }
        $beacon .= "&amp;cb=%%RANDOM_NUMBER%%' width='0' height='0' alt='' /></div>";
        return $beacon;
    }
}

?>
