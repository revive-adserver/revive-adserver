<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id:IndexModule.php 4204 2006-02-10 09:55:36Z roh@m3.net $
*/

require_once MAX_PATH . '/lib/max/language/Report.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

class OA_Admin_Reports_Index
{

    /**
     * @var FieldFactory
     */
    var $oFieldFactory;

    /**
     * The constructor method.
     *
     * @return OA_Admin_Reports_Index
     */
    function OA_Admin_Reports_Index()
    {
        $this->oFieldFactory = new FieldFactory();
        $this->tabindex = 1;
    }

    /**
     * A method to display all reports that the user has permissions
     * to run to the UI.
     */
    function displayReports()
    {
        $aDisplayablePlugins = $this->_findDisplayableReports();
        $aGroupedPlugins = $this->_groupReportPlugins($aDisplayablePlugins);
        if (!empty($aDisplayablePlugins)) {
            $this->_displayPluginList($aGroupedPlugins);
        }
    }

    /**
     * A method to display a report's generation screen to the UI.
     *
     * @param string $report_identifier
     */
    function displayReportSpecifics($reportIdentifier)
    {
        $aDisplayablePlugins = $this->_findDisplayableReports();
        $plugin = $aDisplayablePlugins[$reportIdentifier];
        $this->displayReportPluginInformation($plugin, $reportIdentifier);
    }

    /**
     * A private method to find all report plugins with can be executed
     * by the current user.
     *
     * @access private
     * @return array An array of all the plugins that the user has
     *               access to excute, indexed by the plugin type.
     */
    function _findDisplayableReports()
    {
        $aDisplayablePlugins = array();
        // Get all the report plugins.
        $aPlugins = &MAX_Plugin::getPlugins('reports', null, false);
        // Check the user's authorization level
        foreach ($aPlugins as $pluginType => $oPlugin) {
            if (!$oPlugin->isAllowedToDisplay()) {
                continue;
            }
            $aDisplayablePlugins[$pluginType] = $oPlugin;
        }
        return $aDisplayablePlugins;
    }

    /**
     * A private method to group an array of report plugins according
     * to their category information.
     *
     * @access private
     * @param array $aPlugins An array of plugins that the user has
     *               access to excute, indexed by the plugin type.
     * @return array An array of all the plugins that the user has
     *               access to excute, indexed by category, then plugin
     *               type.
     */
    function _groupReportPlugins($aPlugins)
    {
        $aGroupedPlugins = array();
        foreach ($aPlugins as $pluginType => $oPlugin)
        {
            $aInfo = $oPlugin->info();
            $groupName = $aInfo['plugin-category-name'];
            $aGroupedPlugins[$groupName][$pluginType] = $oPlugin;
        }
        return $aGroupedPlugins;
    }

    /**
     * A private method to display a groupd array of plugins reports
     * to the UI.
     *
     * @access private
     * @param array An array plugins that the user has access to excute,
     *              indexed by category, then plugin type.
     */
    function _displayPluginList($aGroupedPlugins)
    {
        // Print the table start
        echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        foreach ($aGroupedPlugins as $groupName => $aPluginsInGroup) {
            // Print the plugin category
            $this->_printCategoryTitle($groupName);
            // Print all the plugins in the category
            foreach ($aPluginsInGroup as $pluginType => $oPlugin) {
                $this->_printPluginSummary($oPlugin, $pluginType);
            }
            // Print a spacer row
            echo "<tr><td colspan='3'>&nbsp;</td></tr>";
        }
        // Print the table end
        echo "</table>";
    }

    /**
     * A private method to print the table row required for a report
     * category heading.
     *
     * @access private
     * @param unknown_type $pluginCategoryName
     */
    function _printCategoryTitle($groupName)
    {
        echo "<tr><td height='25' colspan='3'><b>{$groupName}</b></td></tr>
              <tr height='1'>
                <td width='30'><img src='images/break.gif' height='1' width='30'></td>
                <td width='200'><img src='images/break.gif' height='1' width='200'></td>
                <td width='100%'><img src='images/break.gif' height='1' width='100%'></td>
              </tr>";
    }

    /**
     * A private method to print the table row required for a
     * report plugin.
     *
     * @access private
     * @param object $oPlugin A report plugin.
     * @param string $pluginType The report plugin type.
     */
    function _printPluginSummary($oPlugin, $pluginType)
    {
        $aInfo = $oPlugin->info();
        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>
              <tr>
                <td width='30'>&nbsp;</td>
                <td width='200'><a href='report-specifics.php?selection=$pluginType'>{$aInfo['plugin-name']}</a></td>
                <td width='100%'>{$aInfo['plugin-description']}</td>
              </tr>";
    }














    /**
     *
     * @return array of strings
     */
    function getCommonReportCategories()
    {
        $config = MAX_Plugin::getConfig('reports', null, null, true);
        $categories = $config['commonReportCategories'];
        return $categories;
    }

    /**
     * Displays full information about a report plugin.
     *
     * Includes title, description, and all parameters required to
     * execute it.
     *
     */
    function displayReportPluginInformation($plugin, $selection)
    {
        $this->_displayReportIntroduction($plugin->info);

        if ($pluginInfo = $plugin->info['plugin-import'])
        {
            $this->_displayParameterListHeader();

            foreach ($pluginInfo as $key=>$fieldParameters)
            {
                $field_type = $fieldParameters['type'];
                $field =& $this->oFieldFactory->newField($field_type);
                $field->_name = $key;
                if (!is_null($fieldParameters['default'])) {
                    $field->setValue($fieldParameters['default']);
                }
                $field->setValueFromArray($fieldParameters);
                if (!is_null($fieldParameters['field_selection_names'])) {
                    $field->_fieldSelectionNames = $fieldParameters['field_selection_names'];
                }
                if (!is_null($fieldParameters['size'])) {
                    $field->_size = $fieldParameters['size'];
                }
                if (!is_null($fieldParameters['filter'])) {
                    $field->setFilter($fieldParameters['filter']);
                }
                $this->_displayParameterBreak();
                echo "
                <tr>
                    <td width='30'>&nbsp;</td>
                    <td>{$fieldParameters['title']}</td>
                    <td>";
                $field->_tabIndex = $this->tabindex;
                $field->display();
                $this->tabindex = $field->_tabIndex;
                echo "
                    </td>
                </tr>";
            }
            $this->_displayParameterBreak();
            $this->_displayParameterListFooter($selection, $fields);
        }
        $this->_displayReportInformationFooter();
    }

    function _displayParameterBreak()
    {
        echo "
        <tr height='10'>
            <td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>
            <td><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
        </tr>";
    }
    function _displayParameterListHeader()
    {
        echo "
        <form action='report-execute.php' method='get'>";
    }

    function _displayParameterListFooter($selection, $fields)
    {
        echo "
        <tr>
            <td height='25' colspan='3'>
                <br><br>
                <input type='hidden' name='plugin' value='$selection'>
                <input type='submit' value='{$GLOBALS['strGenerate']}' tabindex='".($this->tabindex++)."'>
                &nbsp;
                <input type='button' value='{$GLOBALS['strBackToTheList']}' onClick='javascript:document.location.href=\"report-index.php\"' tabindex='".($this->tabindex++)."'>
            </td>
        </tr>
        </form>";
    }

    function _displayReportIntroduction($info)
    {
        echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        echo "<tr><td height='25' colspan='3'>";

        if ($info['plugin-export'] == 'csv')
            echo "<img src='images/excel.gif' align='absmiddle'>&nbsp;";

        echo "<b>".$info['plugin-name']."</b></td></tr>";
        echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
        echo "<tr><td width='30'>&nbsp;</td>";
        echo "<td height='25' colspan='2'>";
        echo nl2br($info['plugin-description']);
        echo "</td></tr>";
        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    }

    function _displayReportInformationFooter()
    {
        echo "</table>";
    }
}

?>
