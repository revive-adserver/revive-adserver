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

require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

/**
 * MAX_Admin_Invocation_Publisher class is a class for placingInvocationForm(s)
 * and generating invocation codes for publishers
 *
 */
class MAX_Admin_Invocation_Publisher extends MAX_Admin_Invocation
{
    /**
     * Set default values for options used by this invocation type
     *
     * @var array Array of $key => $defaultValue
     */
    public $defaultOptionValues = ['comments' => 0];

    /**
     * Place invocation form - generate form with group of options for every plugin,
     * look into max/docs/developer/plugins.zuml for more details
     *
     * @param array $extra
     * @param boolean $zone_invocation
     *
     * @return string  Generated invocation form
     */
    public function placeInvocationForm($extra = '', $zone_invocation = false, $aParams = null)
    {
        global $tabindex;

        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];

        $globalVariables = [
            'affiliateid', 'codetype', 'size', 'text', 'dest',
        ];

        $buffer = '';

        $this->zone_invocation = $zone_invocation;

        foreach ($globalVariables as $makeMeGlobal) {
            global $$makeMeGlobal;
            // also make this variable a class attribute
            // so plugins could have an access to these values and modify them
            $this->$makeMeGlobal = &$$makeMeGlobal;
        }

        $invocationTypes = OX_Component::getComponents('invocationTags');
        foreach ($invocationTypes as $pluginKey => $invocationType) {
            if ($invocationType instanceof \RV\Extension\InvocationTags\WebsiteInvocationInterface) {
                $available[$pluginKey] = $invocationType->publisherPlugin;
                $names[$pluginKey] = $invocationType->getName();
                if (!empty($invocationType->isWebsiteDefault())) {
                    $defaultPublisherPlugin = $pluginKey;
                }
            }
        }

        $affiliateid = $this->affiliateid;

        if (count($available) == 1) {
            // Only one publisher invocation plugin available
            $codetype = $defaultPublisherPlugin;
        } elseif (count($available) > 1) {
            // Multiple publisher invocation plugins available
            if (!isset($codetype)) {
                $codetype = $defaultPublisherPlugin;
            }

            echo "<form name='generate' method='POST' onSubmit='return max_formValidate(this);'>\n";

            // Show the publisher invocation selection drop down
            echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
            echo "<input type='hidden' name='affiliateid' value='{$affiliateid}'>";
            echo "<tr><td height='25' colspan='3'><b>" . $GLOBALS['strChooseTypeOfInvocation'] . "</b></td></tr>";
            echo "<tr><td height='35'>";
            echo "<select name='codetype' onChange=\"this.form.submit()\" accesskey=" . $GLOBALS['keyList'] . " tabindex='" . ($tabindex++) . "'>";

            foreach ($names as $pluginKey => $invocationTypeName) {
                echo "<option value='" . $pluginKey . "'" . ($codetype == $pluginKey ? ' selected' : '') . ">" . $invocationTypeName . "</option>";
            }

            echo "</select>";
            echo "&nbsp;<input type='image' src='" . OX::assetPath() . "/images/" . $GLOBALS['phpAds_TextDirection'] . "/go_blue.gif' border='0'>";
            echo "</td></tr></table>";

            echo "</form>";

            echo phpAds_ShowBreak($print = false);
            echo "<br />";
        } else {
            // No publisher invocation plugins available
            $code = 'Error: No publisher invocation plugins available';
            return;
        }
        if (!empty($codetype)) {
            $invocationTag = OX_Component::factoryByComponentIdentifier($codetype);
            if ($invocationTag === false) {
                OA::debug('Error while factory invocationTag plugin');
                exit();
            }
            $code = $this->generateInvocationCode($invocationTag);
        }

        $previewURL = MAX::constructURL(MAX_URL_ADMIN, 'affiliate-preview.php');

        echo "<form name='generate' action='" . $previewURL . "' method='get' target='_blank'>\n";
        echo "<input type='hidden' name='codetype' value='" . htmlspecialchars($codetype, ENT_QUOTES) . "' />";

        // Show parameters for the publisher invocation list
        echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        echo "<tr><td height='25' colspan='3'><img src='" . OX::assetPath() . "/images/icon-overview.gif' align='absmiddle'>&nbsp;<b>" . $GLOBALS['strParameters'] . "</b></td></tr>";
        echo "<tr height='1'><td width='30'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='30'></td>";
        echo "<td width='200'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='200'></td>";
        echo "<td width='100%'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";

        echo $invocationTag->generateOptions($this);

        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
        //echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
        echo "</table>";
        // Pass in current values

        echo "<input type='hidden' name='affiliateid' value='{$affiliateid}' />";

        echo "<input type='submit' value='" . $GLOBALS['strGenerate'] . "' name='submitbutton' tabindex='" . ($tabindex++) . "'>";
        echo "</form>";
    }

    /**
     * Override the default options since PublisherInvocation options require different defaults
     *
     * @return array An array of options to show for all invocation plugins of this type
     */
    public function getDefaultOptionsList()
    {
        return [
            'comments' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'https' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
        ];
    }
}
