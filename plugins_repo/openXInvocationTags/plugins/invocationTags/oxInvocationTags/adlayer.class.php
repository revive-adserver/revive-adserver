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
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 */

define('PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE', 'geocities');

require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_OxInvocationTags_adlayer extends Plugins_InvocationTags
{
    /**
     * Use only for factory default plugin
     * @see MAX_Admin_Invocation::placeInvocationForm()
     */
    public $defaultZone = phpAds_ZoneInterstitial;

    /**
     * Return name of plugin
     *
     * @return string
     */
    public function getName()
    {
        return $this->translate("Interstitial or Floating DHTML Tag");
    }

    /**
     * Return the English name of the plugin. Used when
     * generating translation keys based on the plugin
     * name.
     *
     * @return string An English string describing the class.
     */
    public function getNameEN()
    {
        return 'Interstitial or Floating DHTML Tag';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    public function isAllowed($extra = null)
    {
        $isAllowed = parent::isAllowed($extra);
        if (is_array($extra) || (is_array($extra) && $extra['delivery'] == phpAds_ZoneText)) {
            return false;
        } else {
            return $isAllowed;
        }
    }

    /**
     * Check if plugin has enough data to perform tag generation
     *
     * @return boolean
     */
    public function canGenerate()
    {
        return !empty($this->maxInvocation->submitbutton);
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    public function getOptionsList()
    {
        if (empty($this->maxInvocation->layerstyle)) {
            $this->maxInvocation->layerstyle = PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE;
        }
        $invocation = $this->getInvocationLayer($this->maxInvocation->layerstyle);
        if ($invocation !== false) {
            return $invocation->getlayerShowVar();
        } else {
            return [];
        }
    }

    /**
     * Return invocation code for this plugin (codetype)
     *
     * @return string
     */
    public function generateInvocationCode()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $aComments = [
            'Cache Buster Comment' => $this->translate("
  * Replace all instances of {random} with
  * a generated random number (or timestamp).
  *"),
            'Third Party Comment' => $this->translate("
  * Don't forget to replace the '{clickurl}' text with
  * the click tracking URL if this ad is to be delivered through a 3rd
  * party (non-Max) adserver.
  *"),
            ];
        if (isset($GLOBALS['layerstyle']) &&
            ($GLOBALS['layerstyle'] == 'geocities' || $GLOBALS['layerstyle'] == 'simple')) {
            $aComments['Comment'] = $this->translate(
                "
  *------------------------------------------------------------*
  * This interstitial invocation code requires the images from:
  * /www/images/layerstyles/%s/...
  * To be accessible via: http(s)://%s/layerstyles/%s/...
  *------------------------------------------------------------*",
                [$GLOBALS['layerstyle'], $conf['webpath']['images'], $GLOBALS['layerstyle']]
            );
        } else {
            $aComments['Comment'] = '';
        }

        parent::prepareCommonInvocationData($aComments);

        $mi = &$this->maxInvocation;
        $buffer = $mi->buffer;

        if (empty($mi->layerstyle)) {
            $mi->layerstyle = PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE;
        }
        $invocation = $this->getInvocationLayer($mi->layerstyle);
        if ($invocation !== false) {
            $buffer .= $invocation->generateLayerCode($this->maxInvocation) . "\n";
            return $buffer;
        } else {
            return false;
        }
    }

    /**
     * Factory the "invocation" layer
     *
     * @return string A string describing the class.
     */
    public function getInvocationLayer($style = PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE)
    {
        return $this->factoryLayer($style, 'invocation');
    }

    /**
     * Factory the specific layer for invocation tag plugin
     *
     * @static
     * @param string $layerName    Name of the invocation tag layer
     *
     * @return object              Plugin object or false if any error occurred
     *
     */
    public function factoryLayer($style = PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE, $type = 'invocation')
    {
        $fileName = dirname(__FILE__) . "/layerstyles/{$style}/{$type}.inc.php";

        if (!file_exists($fileName)) {
            MAX::raiseError("Unable to include the {$fileName} file");
            return false;
        } else {
            include_once $fileName;
        }
        $className = "Plugins_" . ucfirst($this->group) . '_' . ucfirst($this->component) . '_Layerstyles_'
            . ucfirst($style) . '_' . ucfirst($type);
        if (!class_exists($className)) {
            MAX::raiseError("Plugin file included but class '$className' doesn't exists");
            return false;
        }

        $obj = new $className();

        // Assign this component group's translation resource to the created layer object
        $obj->oTrans = $this->oTrans;
        return $obj;
    }

    /* -----------------------------------------------------------------------------------
     * Custom methods
     * -----------------------------------------------------------------------------------
     */

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    public function layerstyle()
    {
        $option = '';
        $layerstyles = [];

        $layerStylesFolder = dirname(__FILE__) . '/layerstyles';

        $stylesdir = opendir($layerStylesFolder);
        while ($stylefile = readdir($stylesdir)) {
            if (is_dir($layerStylesFolder . '/' . $stylefile) &&
                file_exists($layerStylesFolder . '/' . $stylefile . '/invocation.inc.php')) {
                if (preg_match('/^[^.]/D', $stylefile)) {
                    $layerstyles[$stylefile] = isset($GLOBALS['strAdLayerStyleName'][$stylefile]) ?
                        $GLOBALS['strAdLayerStyleName'][$stylefile] :
                        str_replace(
                            "- ",
                            "-",
                            ucwords(str_replace("-", "- ", $stylefile))
                        );
                }
            }
        }
        closedir($stylesdir);
        asort($layerstyles, SORT_STRING);
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>" . $this->translate("Style") . "</td><td width='370'>";
        $option .= "<select name='layerstyle' onChange='this.form.submit()' style='width:175px;' tabindex='" . ($this->maxInvocation->tabindex++) . "'>";
        reset($layerstyles);
        foreach ($layerstyles as $k => $v) {
            $option .= "<option value='$k'" . ($this->maxInvocation->layerstyle == $k ? ' selected' : '') . ">$v</option>";
        }
        $option .= "</select>";
        $option .= "</td></tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td></tr>";

        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    public function layercustom()
    {
        if (empty($this->maxInvocation->layerstyle)) {
            $this->maxInvocation->layerstyle = PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE;
        }
        $invocation = $this->getInvocationLayer($this->maxInvocation->layerstyle);
        if ($invocation !== false) {
            return $invocation->placeLayerSettings();
        } else {
            return false;
        }
    }
}
