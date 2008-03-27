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

require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

/**
 * MAX_Admin_Invocation_Publisher class is a class for placingInvocationForm(s)
 * and generating invocation codes for publishers
 *
 */
class MAX_Admin_Invocation_Publisher extends MAX_Admin_Invocation {

    /**
     * Set default values for options used by this invocation type
     *
     * @var array Array of $key => $defaultValue
     */
    var $defaultOptionValues = array('comments' => 1);

    /**
     * Place invocation form - generate form with group of options for every plugin,
     * look into max/docs/developer/plugins.zuml for more details
     *
     * @param array $extra
     * @param boolean $zone_invocation
     *
     * @return string  Generated invocation form
     */
    function placeInvocationForm($extra = '', $zone_invocation = false)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];

        $globalVariables = array(
            'affiliateid', 'codetype', 'size', 'text', 'dest'
        );

        $buffer = '';

        $this->zone_invocation = $zone_invocation;

        foreach($globalVariables as $makeMeGlobal) {
            global $$makeMeGlobal;
            // also make this variable a class attribute
            // so plugins could have an access to these values and modify them
            $this->$makeMeGlobal =& $$makeMeGlobal;
        }

        $invocationTypes =& MAX_Plugin::getPlugins('invocationTags');
        foreach($invocationTypes as $pluginKey => $invocationType) {
            if (!empty($invocationType->publisherPlugin)) {
                $available[$pluginKey] = $invocationType->publisherPlugin;
                $names[$pluginKey] = $invocationType->getName();
                if (!empty($invocationType->default)) {
                    $defaultPublisherPlugin = $invocationType->name;
                }
            }
        }

        $affiliateid = $this->affiliateid;


        if (count($available) == 1) {
            // Only one publisher invocation plugin available
            $codetype = $defaultPublisherPlugin;
        } elseif (count($available) > 1) {
            // Multiple publisher invocation plugins available
            if (is_null($codetype)) {
                $codetype = $defaultPublisherPlugin;
            }

	        echo "<form name='generate' action='".$_SERVER['PHP_SELF']."' method='POST' onSubmit='return max_formValidate(this);'>\n";

	        // Show the publisher invocation selection drop down
            echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
            echo "<input type='hidden' name='affiliateid' value='{$affiliateid}'>";
            echo "<tr><td height='25' colspan='3'><b>". MAX_Plugin_Translation::translate('Please choose the type of invocation', 'invocationTags') ."</b></td></tr>";
            echo "<tr><td height='35'>";
            echo "<select name='codetype' onChange=\"this.form.submit()\" accesskey=".$GLOBALS['keyList']." tabindex='".($tabindex++)."'>";

            foreach($names as $pluginKey => $invocationTypeName) {
                echo "<option value='".$pluginKey."'".($codetype == $pluginKey ? ' selected' : '').">".$invocationTypeName."</option>";
            }

            echo "</select>";
            echo "&nbsp;<input type='image' src='" . MAX::assetPath() . "/images/".$GLOBALS['phpAds_TextDirection']."/go_blue.gif' border='0'>";
            echo "</td></tr></table>";

			echo "</form>";

            echo phpAds_ShowBreak($print = false);
            echo "<br />";
        } else {
            // No publisher invocation plugins available
            $code = 'Error: No publisher invocation plugins available';
        }
        if (!empty($codetype)) {
            $invocationTag = MAX_Plugin::factory('invocationTags', $codetype);
            if($invocationTag === false) {
                OA::debug('Error while factory invocationTag plugin');
                exit();
            }
            $code = $this->generateInvocationCode($invocationTag);
        }

        $previewURL = 'http://' . $conf['webpath']['admin'] . "/affiliate-preview.php?affiliateid={$affiliateid}&codetype={$codetype}";
        foreach ($invocationTag->defaultOptionValues as $feature => $value) {
            if ($invocationTag->maxInvocation->$feature != $value) {
                $previewURL .= "&{$feature}=" . rawurlencode($invocationTag->maxInvocation->$feature);
            }
        }
        foreach ($this->defaultOptionValues as $feature => $value) {
            if ($this->$feature != $value) {
                $previewURL .= "&{$feature}=" . rawurlencode($this->$feature);
            }
        }

        echo "<form name='generate' action='".$previewURL."' method='get' target='_blank'>\n";
		echo "<input type='hidden' name='codetype' value='" . $codetype . "' />";

        // Show parameters for the publisher invocation list
        echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        echo "<tr><td height='25' colspan='3'><img src='" . MAX::assetPath() . "/images/icon-overview.gif' align='absmiddle'>&nbsp;<b>".$GLOBALS['strParameters']."</b></td></tr>";
        echo "<tr height='1'><td width='30'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='30'></td>";
        echo "<td width='200'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='200'></td>";
        echo "<td width='100%'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";

        echo $invocationTag->generateOptions($this);

        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
        //echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
        echo "</table>";
        // Pass in current values

        echo "<input type='hidden' name='affiliateid' value='{$affiliateid}' />";

        echo "<input type='submit' value='".$GLOBALS['strGenerate']."' name='submitbutton' tabindex='".($tabindex++)."'>";
        echo "</form>";
    }

    /**
     * Override the default options since PublisherInvocation options require different defaults
     *
     * @return array An array of options to show for all invocation plugins of this type
     */
    function getDefaultOptionsList()
    {
        return array('comments'  => MAX_PLUGINS_INVOCATION_TAGS_STANDARD);
    }
}

?>
