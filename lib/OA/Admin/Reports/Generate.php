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
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/OA/Admin/ExcelWriter.php';

require_once LIB_PATH . '/Admin/Redirect.php';

/**
 * A class for generating reports via the report plugins.
 *
 * @package    OpenXAdmin
 * @subpackage Reports
 */
class OA_Admin_Reports_Generate
{
    /**
     * The main method to generate a report from a report plugin.
     *
     * @param string $reportIdentifier The string identifying the report.
     */
    public function generate($reportIdentifier)
    {
        if (!(isset($reportIdentifier) && $reportIdentifier != '')) {
            // No report identified! Return to the main report page
            OX_Admin_Redirect::redirect('report-index.php');
        }
        $oReportPlugin = $this->_newPluginByName($reportIdentifier);
        if (!$oReportPlugin) {
            // No report plugin created! Return to the main report page
            OX_Admin_Redirect::redirect('report-index.php');
        }
        $this->_runReport($oReportPlugin);
    }

    /**
     * A private method to return the appropriate report plugin, based
     * on the identifying string.
     *
     * @access private
     * @param string $reportIdentifier The string identifying the report.
     * @return Plugins_Reports The report plugin.
     */
    public function _newPluginByName($reportIdentifier)
    {
        $pluginKey = explode(':', $reportIdentifier);
        return OX_Component::factoryByComponentIdentifier($reportIdentifier);
    }

    /**
     * A private method to generate a report plugin.
     *
     * @access private
     * @param Plugins_Reports $oPlugin The report plugin.
     *
     * @TODO Extend to allow use of other report writers, if required.
     */
    public function _runReport($oPlugin)
    {
        if (!$oPlugin->isAllowedToExecute()) {
            // User cannot execute this report
            OX_Admin_Redirect::redirect('report-index.php');
        }
        $aInfo = $oPlugin->info();
        // Get the variables for running the report plugin
        $aVariables = $this->_getVariablesForReport($aInfo['plugin-import']);
        // Set the Excel Report writer
        $oWriter = new OA_Admin_ExcelWriter();
        $oPlugin->useReportWriter($oWriter);
        // Generate the report by calling the report plugin's
        // execute method with the required variables
        $result = $oPlugin->execute(...$aVariables);
        if (!empty($result)) {
            OX_Admin_Redirect::redirect('report-generation.php?report=' . $oPlugin->getComponentIdentifier() . '&error=' . $result);
        }
    }

    /**
     * A private method to obtain the variables required for generating
     * the report from the $_GET array.
     *
     * @access private
     * @param array $aImport An array of the required variables for
     *                       the report.
     * @return array An array of the required variables.
     */
    public function _getVariablesForReport($aImport)
    {
        $aVariables = [];
        foreach (array_keys($aImport) as $key) {
            $oField = FieldFactory::newField($aImport[$key]['type']);
            $oField->_name = $key;
            $oField->setValueFromArray($_GET);
            $aVariables[] = $oField->_value;
        }
        return $aVariables;
    }
}
