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

// Include required files
require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once LIB_PATH . '/Admin/Redirect.php';

/**
 * A class for displaying the list of report plugins that a user can run,
 * as well as for displaying the report generation pages for the report
 * plugins.
 *
 * @package    OpenXAdmin
 * @subpackage Reports
 */
class OA_Admin_Reports_Index
{
    /**
     * @var int|mixed
     */
    public $tabindex;
    /**
     * @var FieldFactory
     */
    public $oFieldFactory;

    /**
     * The constructor method.
     *
     * @return OA_Admin_Reports_Index
     */
    public function __construct()
    {
        $this->oFieldFactory = new FieldFactory();
        $this->tabindex = 1;
    }

    /**
     * A method to display all reports that the user has permissions
     * to run to the UI.
     */
    public function displayReports()
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
     * @param int $errorCode error code given by last report generation
     */
    public function displayReportGeneration($reportIdentifier, $errorCode = null)
    {
        $aDisplayablePlugins = $this->_findDisplayableReports();
        $oPlugin = $aDisplayablePlugins[$reportIdentifier];
        if (is_null($oPlugin)) {
            // Cannot use this plugin! display the reports instead
            $this->displayReports();
            return;
        }
        $this->_groupReportPluginGeneration($oPlugin, $reportIdentifier, $errorCode);
    }

    /**
     * A private method to find all report plugins with can be executed
     * by the current user.
     *
     * @access private
     * @return array An array of all the plugins that the user has
     *               access to excute, indexed by the plugin type.
     */
    public function _findDisplayableReports()
    {
        $aDisplayablePlugins = [];
        // Get all the report plugins.
        $aPlugins = OX_Component::getComponents('reports');
        // Check the user's authorization level
        foreach ($aPlugins as $pluginType => $oPlugin) {
            if (!$oPlugin->isAllowedToExecute()) {
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
    public function _groupReportPlugins($aPlugins)
    {
        $aGroupedPlugins = [];
        foreach ($aPlugins as $pluginType => $oPlugin) {
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
    public function _displayPluginList($aGroupedPlugins)
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
     * @param string $pluginCategoryName The report plugin category name.
     */
    public function _printCategoryTitle($groupName)
    {
        echo "<tr><td height='25' colspan='3'><b>{$groupName}</b></td></tr>
              <tr height='1'>
                <td width='30'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='30'></td>
                <td width='200'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='200'></td>
                <td width='100%'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
              </tr>";
    }

    /**
     * A private method to print the table row required for a
     * report plugin.
     *
     * @access private
     * @param Plugins_Reports $oPlugin A report plugin.
     * @param string $pluginType The report plugin type.
     */
    public function _printPluginSummary($oPlugin, $pluginType)
    {
        $aInfo = $oPlugin->info();
        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>
              <tr>
                <td width='30'>&nbsp;</td>
                <td width='200'><a href='report-generation.php?report=$pluginType'>{$aInfo['plugin-name']}</a></td>
                <td width='100%'>{$aInfo['plugin-description']}</td>
              </tr>";
    }

    /**
     * A private method to display the report generation screen for a
     * report plugin to the UI.
     *
     * @access private
     * @param Plugins_Reports $oPlugin The plugin to display.
     * @param string $reportIdentifier The string identifying the report.
     * @param int $errorCode error code given by last report generation
     */
    public function _groupReportPluginGeneration($oPlugin, $reportIdentifier, $errorCode = null)
    {
        $aInfo = $oPlugin->info();
        if (!empty($errorCode)) {
            $errorMessage = $oPlugin->getErrorMessage($errorCode);
        }
        // Print the report introduction
        $this->_displayReportIntroduction($aInfo['plugin-export'], $aInfo['plugin-name'], $aInfo['plugin-description'], $errorMessage);
        // Get the plugins generation parameter details
        if ($aPluginInfo = $aInfo['plugin-import']) {
            // Print the start of the report execution submission form
            $this->_displayParameterListHeader();
            foreach ($aPluginInfo as $key => $aParameters) {
                // Print the report generation parameter
                $oField = $this->oFieldFactory->newField($aParameters['type']);
                $oField->_name = $key;
                if (!is_null($aParameters['default'])) {
                    $oField->setValue($aParameters['default']);
                }
                $oField->setValueFromArray($aParameters);
                if (!is_null($aParameters['field_selection_names'])) {
                    $oField->_fieldSelectionNames = $aParameters['field_selection_names'];
                }
                if (!is_null($aParameters['size'])) {
                    $oField->_size = $aParameters['size'];
                }
                if (!is_null($aParameters['filter'])) {
                    $oField->setFilter($aParameters['filter']);
                }
                $this->_displayParameterBreak();
                echo "<tr><td width='30'>&nbsp;</td><td>{$aParameters['title']}</td><td>";
                $oField->_tabIndex = $this->tabindex;
                $oField->display();
                $this->tabindex = $oField->_tabIndex;
                echo "</td></tr>";
            }
            // Print a parameter break line
            $this->_displayParameterBreak();
            // Print the end of the report execution submission form
            $this->_displayParameterListFooter($reportIdentifier);
        }
        // Print the closing table info
        $this->_displayReportInformationFooter();
    }

    /**
     * A private method to display the introduction part of a report generation
     * page.
     *
     * @access private
     * @param string $export The export type of the report (eg. "csv").
     * @param string $name   The name of the report.
     * @param string $desc   The report's description.
     * @param string $errorMessage The error message of last report generation
     */
    public function _displayReportIntroduction($export, $name, $desc, $errorMessage)
    {
        echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        echo "<tr><td height='25' colspan='3'>";
        if ($export == 'xls') {
            echo "<img src='" . OX::assetPath() . "/images/excel.gif' align='absmiddle'>&nbsp;&nbsp;";
        }
        echo "<b>" . $name . "</b></td></tr>";
        echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
        echo "<tr><td width='30'>&nbsp;</td>";
        echo "<td height='25' colspan='2'>";
        echo nl2br($desc);
        echo "</td></tr>";
        if (!empty($errorMessage)) {
            echo "<tr><td width='30'>&nbsp;</td>";
            echo "<td height='25' colspan='2'>";
            echo "<img src='" . OX::assetPath() . "/images/error.gif' width='16' height='16'>&nbsp;";
            echo "<font color='#AA0000'><b>{$errorMessage}</b></font>";
            echo "</td></tr>";
        }
        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    }

    /**
     * A private method to close off the table started by the
     * _displayReportIntroduction() method.
     *
     * @access private
     */
    public function _displayReportInformationFooter()
    {
        echo "</table>";
    }

    /**
     * A private method to display the start of the form item required
     * for executing a report plugin.
     *
     * @access private
     */
    public function _displayParameterListHeader()
    {
        echo "
        <form action='report-generate.php' method='get'>";
    }

    /**
     * A private method to display the end of the form item required
     * for executing a report plugin.
     *
     * @param string $reportIdentifier The string identifying the report.
     */
    public function _displayParameterListFooter($reportIdentifier)
    {
        $generateTabIndex = $this->tabindex++;
        echo "
        <tr>
          <td height='25' colspan='3'>
            <br /><br />
            <input type='hidden' name='plugin' value='$reportIdentifier'>
            <input type='button' value='{$GLOBALS['strBackToTheList']}' onClick='javascript:document.location.href=\"report-index.php\"' tabindex='" . ($this->tabindex++) . "'>
            &nbsp;&nbsp;
            <input type='submit' value='{$GLOBALS['strGenerate']}' tabindex='" . ($generateTabIndex) . "'>
          </td>
        </tr>
        </form>";
    }

    /**
     * A private method to display a break line between parameters
     * in the report plugins generation page.
     *
     * @access private
     */
    public function _displayParameterBreak()
    {
        echo "
        <tr height='10'>
            <td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>
            <td><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>
        </tr>";
    }
}
