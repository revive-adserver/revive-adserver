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
require_once MAX_PATH . '/lib/OA/Admin/ExcelWriter.php';
require_once LIB_PATH . '/Extension/reports/ReportsScope.php';
require_once MAX_PATH . '/lib/OA/Admin/Menu.php';

/**
 * A class for generating reports via exporting statistics screens data.
 *
 * @package    OpenXAdmin
 * @subpackage Reports
 */
class OA_Admin_Reports_Export extends Plugins_ReportsScope
{
    /**
     * The stats controller with stats ready to export.
     *
     * @var OA_Admin_Statistics_Common
     */
    public $oStatsController;

    /**
     * The constructor method. Stores the stats controller with the
     * already prepared stats for display, and sets up the XLS writer.
     *
     * @param OA_Admin_Statistics_Common $oStatsController
     * @return OA_Admin_Reports_Export
     */
    public function __construct($oStatsController)
    {
        $this->oStatsController = $oStatsController;
        // Set the Excel Report writer
        $oWriter = new OA_Admin_ExcelWriter();
        $this->useReportWriter($oWriter);
    }

    /**
     * The method to generate a plugin-style report XLS from an already
     * prepared statistics page OA_Admin_Statistics_Common object.
     */
    public function export()
    {
        // Prepare the report name
        // Get system navigation
        $oMenu = OA_Admin_Menu::singleton();
        // Get section by pageId
        $oCurrentSection = $oMenu->get($this->oStatsController->pageId);
        if ($oCurrentSection == null) {
            phpAds_Die($GLOBALS['strErrorOccurred'], 'Menu system error: <strong>' . OA_Permission::getAccountType(true) . '::' . htmlspecialchars($this->oStatsController->pageId) . '</strong> not found for the current user');
        }
        // Get name
        $reportName = $oCurrentSection->getName();

        $this->_name = $reportName;
        // Prepare the output writer for generation
        $reportFileName = 'Exported Statistics - ' . $reportName;
        if (!empty($this->oStatsController->aDates['day_begin'])) {
            $oStartDate = new Date($this->oStatsController->aDates['day_begin']);
            $reportFileName .= ' from ' . $oStartDate->format($GLOBALS['date_format']);
        }
        if (!empty($this->oStatsController->aDates['day_end'])) {
            $oEndDate = new Date($this->oStatsController->aDates['day_end']);
            $reportFileName .= ' to ' . $oEndDate->format($GLOBALS['date_format']);
        }
        $reportFileName .= '.xls';
        $this->_oReportWriter->openWithFilename($reportFileName);
        // Get the header and data arrays from the same statistics controllers
        // that prepare stats for the user interface stats pages
        list($aHeaders, $aData) = $this->getHeadersAndDataFromStatsController(null, $this->oStatsController);
        // Add the worksheet
        $name = ucfirst($this->oStatsController->entity) . ' ' . ucfirst($this->oStatsController->breakdown);
        $this->createSubReport($reportName, $aHeaders, $aData);
        // Close the report writer and send the report to the user
        $this->_oReportWriter->closeAndSend();
    }

    /**
     * The local implementation of the _getReportParametersForDisplay() method
     * to return a string to display the date range of the report.
     *
     * @access private
     * @return array The array of index/value sub-headings.
     */
    public function _getReportParametersForDisplay()
    {
        global $strClient, $strCampaign, $strBanner, $strAffiliate, $strZone;
        $aParams = [];
        // Deal with the possible entity types
        foreach ($this->oStatsController->aPageParams as $key => $value) {
            unset($string);
            unset($name);
            if ($key == 'client' || $key == 'clientid') {
                $string = $strClient;
                $doClients = OA_Dal::factoryDO('clients');
                $doClients->clientid = $value;
                $doClients->find();
                if ($doClients->fetch()) {
                    $aAdvertiser = $doClients->toArray();
                    $name = $aAdvertiser['clientname'];
                }
            } elseif ($key == 'campaignid') {
                $string = $strCampaign;
                $doCampaigns = OA_Dal::factoryDO('campaigns');
                $doCampaigns->campaignid = $value;
                $doCampaigns->find();
                if ($doCampaigns->fetch()) {
                    $aCampaign = $doCampaigns->toArray();
                    $name = $aCampaign['campaignname'];
                }
            } elseif ($key == 'bannerid') {
                $string = $strBanner;
                $doBanners = OA_Dal::factoryDO('banners');
                $doBanners->bannerid = $value;
                $doBanners->find();
                if ($doBanners->fetch()) {
                    $aBanner = $doBanners->toArray();
                    $name = $aBanner['description'];
                }
            } elseif ($key == 'affiliateid') {
                $string = $strAffiliate;
                $doAffiliates = OA_Dal::factoryDO('affiliates');
                $doAffiliates->affiliateid = $value;
                $doAffiliates->find();
                if ($doAffiliates->fetch()) {
                    $aPublisher = $doAffiliates->toArray();
                    $name = $aPublisher['name'];
                }
            } elseif ($key == 'zoneid') {
                $string = $strZone;
                $doZones = OA_Dal::factoryDO('zones');
                $doZones->zoneid = $value;
                $doZones->find();
                if ($doZones->fetch()) {
                    $aZone = $doZones->toArray();
                    $name = $aZone['zonename'];
                }
            }
            if (!is_null($string) && !is_null($name)) {
                $aParams[$string] = '[id' . $value . '] ' . $name;
            }
        }
        // Add the start and end dates
        if (!empty($this->oStatsController->aDates['day_begin'])) {
            $aParams['Start Date'] = $this->oStatsController->aDates['day_begin'];
        }
        if (!empty($this->oStatsController->aDates['day_end'])) {
            $aParams['End Date'] = $this->oStatsController->aDates['day_end'];
        }
        return $aParams;
    }
}
