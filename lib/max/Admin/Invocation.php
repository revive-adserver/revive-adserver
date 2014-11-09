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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
if(!isset($GLOBALS['_MAX']['FILES']['/lib/max/Delivery/common.php'])) {
    require_once MAX_PATH . '/lib/max/Delivery/common.php';
}
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';
require_once LIB_PATH . '/Plugin/Component.php';
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
            'frame_width',
            'frame_height',
            'height',
            'hostlanguage',
            'iframetracking',
            'ilayer',
            'layerstyle',
            'left',
            'location',
            'menubar',
            'noscript',
            'parameters',
            'popunder',
            'raw',
            'refresh',
            'resizable',
            'resize',
            'scrollbars',
            'source',
            'ssl',
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
     * @param object $invocationTag    If null the invocation tag is factory by OX_Component class,
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
            $invocationTag = OX_Component::factoryByComponentIdentifier($this->codetype);
        }
        if($invocationTag === false) {
            OA::debug('Error while factory invocationTag plugin '.$this->codetype);
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

        $variables = Admin_DA::getVariables(array('trackerid' => $trackerId), true);

        $name = PRODUCT_NAME;
        if (!empty($GLOBALS['_MAX']['CONF']['ui']['applicationName'])) {
            $name = $GLOBALS['_MAX']['CONF']['ui']['applicationName'];
        }
        $buffer = "
<!--/*
  *
  *  " . $name . " Image Beacon Tracker Code
  *  - Generated with " . PRODUCT_NAME . " v" . VERSION . "
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
        $this->tabindex = 1;
        global $phpAds_TextDirection;

        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];

        $buffer = '';
        $this->zone_invocation = $zone_invocation;

        // register all the variables
        $this->assignVariables($aParams);
        if (is_array($extra)) {
            $this->assignVariables($extra);
        }

        // Check if affiliate is on the same server as the delivery code
        if (!empty($extra['website'])) {
            $server_max      = parse_url('http://' . $conf['webpath']['delivery'] . '/');
            $server_affilate = parse_url($extra['website']);
            // this code could be extremely slow if host is unresolved
            $this->server_same     = (@gethostbyname($server_max['host']) == @gethostbyname($server_affilate['host']));
        } else {
            $this->server_same = true;
        }

        // Hide when integrated in zone-advanced.php
        if (!is_array($extra) || !isset($extra['zoneadvanced']) || !$extra['zoneadvanced']) {
            $buffer .= "<form id='generate' name='generate' method='POST' onSubmit='return max_formValidate(this) && disableTextarea();'>\n";
        }

        // Invocation type selection
        if (!is_array($extra) || (isset($extra['delivery']) && ($extra['delivery']!=phpAds_ZoneInterstitial) && ($extra['delivery']!=phpAds_ZonePopup)) && ($extra['delivery']!=MAX_ZoneEmail)) {

            $invocationTags =& OX_Component::getComponents('invocationTags');

            $allowed = array();
            foreach($invocationTags as $pluginKey => $invocationTag) {
                if ($invocationTag->isAllowed($extra, $this->server_same)) {
                    $aOrderedComponents[$invocationTag->getOrder()] =
                        array(
                            'pluginKey' => $pluginKey,
                            'isAllowed' => $invocationTag->isAllowed($extra, $this->server_same),
                            'name' => $invocationTag->getName()
                        );
                }
            }

            ksort($aOrderedComponents);
            foreach ($aOrderedComponents as $order => $aComponent) {
                $allowed[$aComponent['pluginKey']] = $aComponent['isAllowed'];
            }

            if (!isset($this->codetype) || $allowed[$this->codetype] == false) {
                foreach ($allowed as $codetype => $isAllowed) {
                    $this->codetype = $codetype;
                    break;
                }
            }
            if (!isset($bannerUrl)) {
                $bannerUrl = 'http://www.example.com/INSERT_BANNER_URL.gif';
            }

            $buffer .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
            $buffer .= "<tr><td height='25' width='350'><b>". $GLOBALS['strChooseTypeOfBannerInvocation'] ."</b>";
            if ($this->codetype=="invocationTags:oxInvocationTags:adview"){
                $buffer .= "";
            }

            $buffer .= "</td></tr><tr><td height='35' valign='top'>";
            $buffer .= "<select name='codetype' onChange=\"disableTextarea();this.form.submit()\" accesskey=".$GLOBALS['keyList']." tabindex='".($this->tabindex++)."'>";

            $invocationTagsNames = array();
            foreach ($aOrderedComponents as $order => $aComponent) {
                $invocationTagsNames[$aComponent['pluginKey']] = $aComponent['name'];
            }
            foreach($invocationTagsNames as $pluginKey => $invocationTagName) {
                $buffer .= "<option value='".$pluginKey."'".($this->codetype == $pluginKey ? ' selected' : '').">".$invocationTagName."</option>";
            }
            $buffer .= "</select>";
            $buffer .= "&nbsp;<input type='image' src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/go_blue.gif' border='0'></td>";
        } else {
            $invocationTags =& OX_Component::getComponents('invocationTags');
            foreach($invocationTags as $invocationCode => $invocationTag) {
                if(isset($invocationTag->defaultZone) && $extra['delivery'] == $invocationTag->defaultZone) {
                    $this->codetype = $invocationCode;
                    break;
                }
            }
            if (!isset($this->codetype)) {
                $this->codetype = '';
            }
        }
        if ($this->codetype != '') {
            // factory plugin for this $codetype
            $invocationTag = OX_Component::factoryByComponentIdentifier($this->codetype);
            if($invocationTag === false) {
                OA::debug('Error while factory invocationTag plugin');
                exit();
            }
            $invocationTag->setInvocation($this);

            $buffer .= "</td></tr></table>";

            $buffer .= $invocationTag->getHeaderHtml( $this, $extra );
            $buffer .= $this->getTextAreaAndOptions($invocationTag, $extra);
        }
        // Put extra hidden fields
        if (is_array($extra)) {
            reset($extra);
            while (list($k, $v) = each($extra)) {
                $buffer .= "<input type='hidden' value='".htmlspecialchars($v,ENT_QUOTES)."' name='$k'>";
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

    public function getTextAreaAndOptions($invocationTag, $extra)
    {
        if(!$invocationTag->displayTextAreaAndOptions) {
            return '';
        }
        $buffer = "<hr />";

        $buffer .= "<div id='div-zone-invocation'>";
        $buffer .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
        $buffer .= "<td width='40'>&nbsp;</td><td><br />";

        $buffer .= "<br />";

        // Generate tag if the plugin agrees that it's ok to proceed
        if ($invocationTag->canGenerate()) {
            $buffer .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
            $buffer .= "<tr><td height='25'>";

            if ($this->codetype == 'invocationTags:oxInvocationTags:xmlrpc') {
                $buffer .= "
                    <div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/warning.gif' align='absmiddle'>
                        {$GLOBALS['strIABNoteXMLRPCInvocation']}
                    </div>";
            }

            if ($this->codetype == 'invocationTags:oxInvocationTags:local' && !$this->server_same) {
                $buffer .= "
                    <div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/warning.gif' align='absmiddle'>
                        {$GLOBALS['strWarningLocalInvocation']}
                        <br><p>{$GLOBALS['strIABNoteLocalInvocation']}</p>
                    </div>";
            }
            else if ($this->codetype == 'invocationTags:oxInvocationTags:local' && $this->server_same) {
                $buffer .= "
                    <div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/warning.gif' align='absmiddle'>
                {$GLOBALS['strIABNoteLocalInvocation']}
                    </div>";
            }

            // Supress the textarea if required by this plugin
            if (empty($invocationTag->suppressTextarea)) {
                $buffer .= "<img src='" . OX::assetPath() . "/images/icon-generatecode.gif' align='absmiddle'>&nbsp;<b>".$GLOBALS['strBannercode']."</b></td>";

                // Show clipboard button only on IE
                if (strpos ($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 &&
                    strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera') < 1) {
                    $buffer .= "<td height='25' align='right'><img src='" . OX::assetPath() . "/images/icon-clipboard.gif' align='absmiddle'>&nbsp;";
                    $buffer .= "<a href='javascript:max_CopyClipboard(\"bannercode\");'>".$GLOBALS['strCopyToClipboard']."</a></td></tr>";
                } else {
                    $buffer .= "<td>&nbsp;</td>";
                }
                $buffer .= "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
                $buffer .= "<tr><td colspan='2'>";

                $buffer .= "<textarea id='bannercode' name='bannercode' class='code-gray' rows='15' cols='80' style='width:95%; border: 1px solid black' readonly>";
                $buffer .= htmlspecialchars($this->generateInvocationCode($invocationTag));
                $buffer .= "</textarea>";

                $buffer .= "
                    <script type='text/javascript'>
                    <!--
                    $(document).ready(function() {
                        $('#bannercode').selectText();
                    });
                    //-->
                    </script>";
            } else {
                $buffer .= $this->generateInvocationCode($invocationTag);
            }
            $buffer .= "</td></tr>";
            $buffer .= "</table><br />";
            $buffer .= phpAds_ShowBreak($print = false);
            $buffer .= "<br />";


            $generated = true;
        } else {
            $generated = false;
        }

        // Hide when integrated in zone-advanced.php
        if (!(is_array($extra) && isset($extra['zoneadvanced']) && $extra['zoneadvanced'])) {
            // Header
            // Parameters Section
            $buffer .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
            $buffer .= "<tr><td height='25' colspan='3'><img src='" . OX::assetPath() . "/images/icon-overview.gif' align='absmiddle'>&nbsp;<b>".$GLOBALS['strParameters']."</b></td></tr>";
            $buffer .= "<tr height='1'><td width='30'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='30'></td>";
            $buffer .= "<td width='200'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='200'></td>";
            $buffer .= "<td width='100%'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
        }

        $buffer .= $invocationTag->generateOptions($this);

        // Hide when integrated in zone-advanced.php
        if (!(is_array($extra) && isset($extra['zoneadvanced']) && $extra['zoneadvanced'])) {
            // Footer
            $buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
            $buffer .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
            $buffer .= "</table>";
            $buffer .= "<br /><br />";
            $buffer .= "<input type='hidden' value='".($generated ? 1 : 0)."' name='generate'>";
            if ($generated) {
                $buffer .= "<input type='submit' value='".$GLOBALS['strRefresh']."' name='submitbutton' tabindex='".($this->tabindex++)."'>";
            } else {
                $buffer .= "<input type='submit' value='".$GLOBALS['strGenerate']."' name='submitbutton' tabindex='".($this->tabindex++)."'>";
            }
        }

        $buffer .= "</td></tr></table>";
        $buffer .= "</div>";
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

    function generateJavascriptTrackerCode($trackerId, $append = false)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $variablemethod = 'default';
        $trackers = Admin_DA::getTrackers(array('tracker_id' => $trackerId), true);
        if (count($trackers)) {
            $variablemethod = $trackers[$trackerId]['variablemethod'];
        }

        $variables = Admin_DA::getVariables(array('trackerid' => $trackerId), true);
        $variablesQuerystring = '';

        $name = PRODUCT_NAME;
        if (!empty($GLOBALS['_MAX']['CONF']['ui']['applicationName'])) {
            $name = $GLOBALS['_MAX']['CONF']['ui']['applicationName'];
        }
        $buffer = "<!--/*
  *
  *  " . $name . " JavaScript Tracker Code
  *  - Generated with " . PRODUCT_NAME . " v" . VERSION . "
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
    var {$varprefix}p = (location.protocol=='https:'?'https:".MAX_commonConstructPartialDeliveryUrl($conf['file']['conversionjs'], true)."':'http:".MAX_commonConstructPartialDeliveryUrl($conf['file']['conversionjs'])."');\n
    var {$varprefix}r=Math.floor(Math.random()*999999);
    document.write (\"<\" + \"script language='JavaScript' \");
    document.write (\"type='text/javascript' src='\"+{$varprefix}p);
    document.write (\"?trackerid={$trackerId}";

        if ($append == true) {
            $buffer .= "&amp;append=1";
        } else {
            $buffer .= "&amp;append=0";
        }

        $buffer .= "&amp;r=\"+{$varprefix}r+\"'><\" + \"\\/script>\");
//]]>--></script><noscript>" . $this->_generateTrackerImageBeacon($trackerId) . "</noscript>";
        $buffer .= "\n";
        return $buffer;
    }

    function _generateTrackerImageBeacon($trackerId)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $variables = Admin_DA::getVariables(array('trackerid' => $trackerId), true);
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
