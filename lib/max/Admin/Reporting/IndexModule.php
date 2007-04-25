<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
$Id:IndexModule.php 4204 2006-02-10 09:55:36Z roh@m3.net $
*/

require_once MAX_PATH . '/lib/max/language/Report.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';

class ReportIndexModule
{
    /* @var FieldFactory */
    var $field_factory;

    function ReportIndexModule()
    {
        $this->field_factory = new FieldFactory();
        $this->tabindex = 1;
    }

    /**
     * @todo Stop the redundant info reading/writing back to the object
     */
    function _findDisplayableReports()
    {
        $all_plugins = &MAX_Plugin::getPlugins('reports', null, false);
        // authorization
        foreach ($all_plugins as $pluginType => $plugin) {
            if (!$plugin->isAllowedToDisplay()) {
                continue;
            }
            $info = $plugin->info();
            $category = $info['plugin-category-name'];

            $plugin->info = $info;
            $groupedPlugins[$category][$pluginType] = $plugin;
            $displayable_plugins[$pluginType] = $plugin;
        }
        return $displayable_plugins;
    }

    function _categoriseReportPlugins($flat_plugins, $required_category_names = null)
    {
        if (count($required_category_names) > 0) {
            $only_specific_categories = true;
        } else {
        	$only_specific_categories = false;
        }
        $categories = array();
        foreach ($flat_plugins as $identifier => $plugin)
        {
            $category_id = $plugin->info['plugin-category'];
            $category_name = $plugin->info['plugin-category-name'];
            if ($only_specific_categories && !in_array($category_id, $required_category_names)) {
                continue;
            }
            $categories[$category_name][$identifier] = $plugin;
        }
        return $categories;
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
     * @todo Form a template method with this and displayAllAvailableReports()
     */
    function displayCommonReports()
    {
        $common_categories = $this->getCommonReportCategories();
        $displayable_plugins = $this->_findDisplayableReports();
        $groupedPlugins = $this->_categoriseReportPlugins($displayable_plugins, $common_categories);

        $this->displayPluginList($groupedPlugins);

        if (phpAds_isUser(phpAds_Agency)) {
            if ($GLOBALS['_MAX']['PREF']['more_reports'] == 't') {
                echo '<a href="report-index-all.php">More reports...</a>';
            }
        } else {
            echo '<a href="report-index-all.php">More reports...</a>';        
        }
        
    }

    function displayAllAvailableReports()
    {
        $displayable_plugins = $this->_findDisplayableReports();
        $groupedPlugins = $this->_categoriseReportPlugins($displayable_plugins);

        if (!empty($displayable_plugins)) {
            $this->displayPluginList($groupedPlugins);
        }

        if (phpAds_isUser(phpAds_Agency)) {
            if ($GLOBALS['_MAX']['PREF']['more_reports'] == 't') {
                echo '<a href="report-index.php">Less reports...</a>';
            }
        } else {
            echo '<a href="report-index.php">Less reports...</a>';
        }
    }

    /**
     * @param string $report_identifier
     */
    function displayReportSpecifics($report_identifier)
    {
        $displayable_plugins = $this->_findDisplayableReports();
        $plugin = $displayable_plugins[$report_identifier];
        $this->displayReportPluginInformation($plugin, $report_identifier);
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
                $field =& $this->field_factory->newField($field_type);
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

    /**
     * Displays an HTML list of reports available to the logged-in user.
     *
     * Reports show as a title with a description,
     * and are grouped into categories.
     */
    function displayPluginList($groupedPlugins)
    {
        echo "
            <table border='0' width='100%' cellpadding='0' cellspacing='0'>
                ";
        foreach ($groupedPlugins as $pluginCategoryName => $pluginsInGroup) {
            $this->_printCategoryTitle($pluginCategoryName);

            foreach ($pluginsInGroup as $key => $plugin) {
                $this->_printPluginSummary($plugin, $key);
            }
            echo "
        <tr><td colspan='3'>&nbsp;</td></tr>";
        }
        echo "</table>";
    }

    function _printCategoryTitle($pluginCategoryName)
    {
        echo "
            <tr>
                <td height='25' colspan='3'><b>{$pluginCategoryName}</b></td>
            </tr>
            <tr height='1'>
                <td width='30'><img src='images/break.gif' height='1' width='30'></td>
                <td width='200'><img src='images/break.gif' height='1' width='200'></td>
                <td width='100%'><img src='images/break.gif' height='1' width='100%'></td>
            </tr>
            ";
    }

    function _printPluginSummary($plugin, $key)
    {
        echo "
            <tr><td height='10' colspan='3'>&nbsp;</td></tr>
            <tr>
                <td width='30'>&nbsp;</td>
                <td width='200'><a href='report-specifics.php?selection=$key'>{$plugin->info['plugin-name']}</a></td>
                <td width='100%'>{$plugin->info['plugin-description']}</td>
            </tr>";
    }
}

?>
