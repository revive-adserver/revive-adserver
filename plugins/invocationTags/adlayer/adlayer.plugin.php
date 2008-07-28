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

/**
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 * @author     Radek Maciaszek <radek@m3.net>
 *
 */

define('PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE', 'geocities');

require_once MAX_PATH . '/plugins/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_adlayer_adlayer extends Plugins_InvocationTags
{

    /**
     * Use only for factory default plugin
     * @see MAX_Admin_Invocation::placeInvocationForm()
     */
    var $defaultZone = phpAds_ZoneInterstitial;

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Interstitial or Floating DHTML Tag', $this->module, $this->package);
    }

    /**
     * Return the English name of the plugin. Used when
     * generating translation keys based on the plugin
     * name.
     *
     * @return string An English string describing the class.
     */
    function getNameEN()
    {
        return 'Interstitial or Floating DHTML Tag';
    }

    /**
     * Return setting configuration file code - required for plugins
     * that store a value in the configuration file.
     *
     * Value returned should be NULL if the plugin does not store
     * a value in the configuration file, otherwise it should be a
     * string in the form "level_key".
     *
     * @return string The setting "code".
     */
    function getSettingCode()
    {
        return 'allowedTags_adlayer';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed($extra)
    {
        $isAllowed = parent::isAllowed($extra);
        if(is_array($extra) || (is_array($extra) && $extra['delivery'] == phpAds_ZoneText)) {
            return false;
        } else {
            return $isAllowed;
        }
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    function getOptionsList()
    {
        if (empty($this->maxInvocation->layerstyle)) {
            $this->maxInvocation->layerstyle = PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE;
        }
        $invocation = $this->getInvocationLayer($this->maxInvocation->layerstyle);
        if($invocation !== false) {
            return $invocation->getlayerShowVar();
        } else {
            return array();
        }
    }

    /**
     * Return invocation code for this plugin (codetype)
     *
     * @return string
     */
    function generateInvocationCode()
    {
        parent::prepareCommonInvocationData();

        $mi = &$this->maxInvocation;
        $buffer = $mi->buffer;

        if(empty($mi->layerstyle)) {
            $mi->layerstyle = PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE;
        }
        $invocation = $this->getInvocationLayer($mi->layerstyle);
        if($invocation !== false) {
            $buffer .= $invocation->generateLayerCode($this->maxInvocation)."\n";
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
    function getInvocationLayer($style = PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE)
    {
        return $this->factoryLayer($style, 'invocation');
    }

    /**
     * Factory the specific layer for invocation tag plugin
     *
     * @static
     * @param string $layerName    Name of the invocation tag layer
     *
     * @return object              Plugin object or false if any error occured
     *
     */
    function factoryLayer($style = PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE, $type = 'invocation')
    {
        $fileName = MAX_PATH . "/plugins/{$this->module}/{$this->package}/layerstyles/{$style}/{$type}.inc.php";

        if(!file_exists($fileName)) {
            MAX::raiseError("Unable to include the {$fileName} file");
            return false;
        } else {
            include_once $fileName;
        }
        $className = "Plugins_" . ucfirst($this->module) . '_' . ucfirst($this->package) . '_Layerstyles_'
            . ucfirst($style) . '_' . ucfirst($type);
        if (!class_exists($className)) {
            MAX::raiseError("Plugin file included but class '$className' doesn't exists");
            return false;
        }

        $obj = new $className;
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
    function layerstyle()
    {
        $option = '';
        $layerstyles = array();

        $layerStylesFolder = MAX_PATH . '/plugins/invocationTags/adlayer/layerstyles';

        $stylesdir = opendir($layerStylesFolder);
        while ($stylefile = readdir($stylesdir)) {
            if (is_dir($layerStylesFolder.'/'.$stylefile) &&
                file_exists($layerStylesFolder.'/'.$stylefile.'/invocation.inc.php')) {
                if (ereg('^[^.]', $stylefile)) {
                    $layerstyles[$stylefile] = isset($GLOBALS['strAdLayerStyleName'][$stylefile]) ?
                        $GLOBALS['strAdLayerStyleName'][$stylefile] :
                        str_replace("- ", "-",
                            ucwords(str_replace("-", "- ", $stylefile)));
                }
            }
        }
        closedir($stylesdir);
        asort($layerstyles, SORT_STRING);
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>". MAX_Plugin_Translation::translate('Style', 'invocationTags') ."</td><td width='370'>";
        $option .= "<select name='layerstyle' onChange='this.form.submit()' style='width:175px;' tabindex='".($this->maxInvocation->tabindex++)."'>";
        reset($layerstyles);
        while (list($k, $v) = each($layerstyles)) {
            $option .= "<option value='$k'".($this->maxInvocation->layerstyle == $k ? ' selected' : '').">$v</option>";
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
    function layercustom()
    {
        if (empty($this->maxInvocation->layerstyle)) {
            $this->maxInvocation->layerstyle = PLUGINS_INVOCATIONS_TAGS_ADLAYER_DEFAULT_LAYERSTYLE;
        }
        $invocation = $this->getInvocationLayer($this->maxInvocation->layerstyle);
        if($invocation !== false) {
            return $invocation->placeLayerSettings();
        } else {
            return false;
        }
    }

}

?>