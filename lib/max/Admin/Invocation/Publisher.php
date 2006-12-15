<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
            $this->$makeMeGlobal = &$$makeMeGlobal;
        }

        $invocationTypes = &MAX_Plugin::getPlugins('invocationTags');
        foreach($invocationTypes as $pluginKey => $invocationType) {
            if ($invocationType->publisherPlugin == true) {
                $available[$pluginKey] = $invocationType->publisherPlugin;
                $names[$pluginKey] = $invocationType->getName();
            }
        }
        
        $affiliateid = $this->affiliateid;
        
        if (count($available) == 1) {
            // Only one publisher invocation plugin available
            $publisherPlugin = array_keys($available);
            $codetype = $publisherPlugin[0];
            $code = $this->generateInvocationCode($invocationTag = null);
        } elseif (count($available) > 1) {
            // Multiple publisher invocation plugins available
            if (!empty($_GET['codetype'])) {
                $codetype = $_GET['codetype'];
            } else {
                $publisherPlugin = array_keys($available);
                $codetype = $publisherPlugin[0];
            }
            $code = $this->generateInvocationCode($invocationTag = null);
        
            // Show the publisher invocation selection drop down
            echo "<form name='generate' action='".$_SERVER['PHP_SELF']."' method='GET' onSubmit='return max_formValidate(this);'>\n";
            echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
            echo "<input type='hidden' name='affiliateid' value='{$affiliateid}'>";
            echo "<tr><td height='25' colspan='3'><b>". MAX_Plugin_Translation::translate('Please choose the type of invocation', 'invocationTags') ."</b></td></tr>";
            echo "<tr><td height='35'>";
            echo "<select name='codetype' onChange=\"this.form.submit()\" accesskey=".$GLOBALS['keyList']." tabindex='".($tabindex++)."'>";
        
            foreach($names as $pluginKey => $invocationTypeName) {
                echo "<option value='".$pluginKey."'".($codetype == $pluginKey ? ' selected' : '').">".$invocationTypeName."</option>";
            }
        
            echo "</select>";
            echo "&nbsp;<input type='image' src='images/".$GLOBALS['phpAds_TextDirection']."/go_blue.gif' border='0'>";
            echo "</td></tr></table>";
        
            echo phpAds_ShowBreak($print = false);
            echo "<br />";
            echo '</form>';
        } else {
            // No publisher invocation plugins available
            $code = 'Error: No publisher invocation plugins available';
        }
        if (!empty($codetype)) {
            $code = $this->generateInvocationCode($invocationTag = null);
        }
        
        echo "<table border='0' width='550' cellpadding='0' cellspacing='0'>";
        echo "<tr><td height='25'><img src='images/icon-generatecode.gif' align='absmiddle'>&nbsp;<b>".$GLOBALS['strBannercode']."</b></td>";
        
        // Show clipboard button only on IE
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 && strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') < 1) {
            echo "<td height='25' align='right'><img src='images/icon-clipboard.gif' align='absmiddle'>&nbsp;";
            echo "<a href='javascript:max_CopyClipboard(\"bannercode\");'>".$GLOBALS['strCopyToClipboard']."</a></td></tr>";
        }
        else
        echo "<td>&nbsp;</td>";
        
        echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
        
        echo "<tr><td colspan='2'><textarea name='bannercode' class='code-gray' rows='30' cols='80' style='width:800;' readonly>";
        
        echo $code;
        
        echo "</textarea></td></tr>";
        echo "</table><br />";
        
        $previewURL = 'http://' . $conf['webpath']['admin'] . "/affiliate-preview.php?affiliateid={$affiliateid}&codetype={$codetype}";
        
        echo "<strong>Preview URL:</strong> - <a href='{$previewURL}' target='_blank'>{$previewURL}</a>";
        
        phpAds_ShowBreak();
        echo "<br />";
    }
}

?>