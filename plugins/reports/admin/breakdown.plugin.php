<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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
$Id$
*/

require_once MAX_PATH . '/plugins/reports/Reports.php';

/**
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Chris Nutting <chris@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */

class Plugins_Reports_Admin_Breakdown extends Plugins_Reports
{

    /**
     * The local implementation of the initInfo() method to set all of the
     * required values for this report.
     */
    function initInfo()
    {
        $this->_name         = MAX_Plugin_Translation::translate('Agency Breakdown', $this->module, $this->package);
        $this->_description  = MAX_Plugin_Translation::translate('Lists Adviews/AdClicks/AdSales totals for a given month.', $this->module, $this->package);
        $this->_category     = 'admin';
        $this->_categoryName = MAX_Plugin_Translation::translate('Admin Reports', $this->module, $this->package);
        $this->_author       = 'Chris Nutting';
        $this->_export       = 'xls';
        $this->_authorize    = phpAds_Admin;

        $this->_import = $this->getDefaults();
        $this->saveDefaults();
    }

    /**
     * The local implementation of the getDefaults() method to prepare the
     * required information for laying out the plugin's report generation
     * screen/the variables required for generating the report.
     */
    function getDefaults()
    {
        global $strStartDate, $strEndDate, $strDelimiter;
        // Obtain the user's session-based default values for the report
        global $session;
        $default_period_preset = isset($session['prefs']['GLOBALS']['report_period_preset']) ? $session['prefs']['GLOBALS']['report_period_preset'] : 'last_month';
        // Prepare the array for displaying the generation page
        $aImport = array (
            'period' => array(
                'title'   => MAX_Plugin_Translation::translate('Period', $this->module, $this->package),
                'type'    => 'date-month',
                'default' => $default_period_preset
            ),
        );
        return $aImport;
    }

    /**
     * The local implementation of the saveDefaults() method to save the
     * values used for the report by the user to the user's session
     * preferences, so that they can be re-used in other reports.
     */
    function saveDefaults()
    {
        global $session;
        if (isset($_REQUEST['period_preset'])) {
            $session['prefs']['GLOBALS']['report_period_preset']    = $_REQUEST['period_preset'];
        }
        phpAds_SessionDataStore();
    }

    function execute($oDaySpan)
    {
        // Prepare the range information for the report
        $this->_prepareReportRange($oDaySpan);
        // Prepare the report name
        $reportFileName = $this->_getReportFileName();
        // Prepare the output writer for generation
        $this->_oReportWriter->openWithFilename($reportFileName);
        // Add the worksheets to the report, as required

        // Close the report writer and send the report to the user
        $this->_oReportWriter->closeAndSend();









    	global $date_format;
    	global $strGlobalHistory, $strTotal, $strDay, $strImpressions, $strClicks, $strCTRShort;

        $oDbh = &OA_DB::singleton();
        $conf = $GLOBALS['_MAX']['CONF'];

    	$start_date_save   = $start_date;
    	$end_date_save     = $end_date;
    	$start_date    = str_replace('/', '', $start_date);
    	$end_date      = str_replace('/', '', $end_date);

    	$reportName = 'm3 Agency Breakdown from ' . date('Y-M-d', strtotime($start_date)) . ' to ' . date('Y-M-d', strtotime($end_date)) . '.csv';
        header("Content-type: application/csv\nContent-Disposition: inline; filename=\"".$reportName."\"");

    	if(phpAds_isUser(phpAds_Admin))
    	{
    		$res_query = "
                SELECT
                    g.agencyid AS AgencyId,
                    g.name AS AgencyName,
                    SUM(s.impressions) AS TotalViews,
                    SUM(s.clicks) AS TotalClicks,
                    SUM(s.conversions) AS TotalConversions
                FROM
                    {$conf['table']['prefix']}{$conf['table']['agency']} AS g,
                    {$conf['table']['prefix']}{$conf['table']['clients']} AS c,
                    {$conf['table']['prefix']}{$conf['table']['campaigns']} AS m,
                    {$conf['table']['prefix']}{$conf['table']['banners']} AS b,
                    {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']} AS s
                WHERE
                    g.agencyid=c.agencyid
                  AND
                    c.clientid=m.clientid
                  AND
                    m.campaignid=b.campaignid
                  AND
                    b.bannerid=s.ad_id
                  AND
                    s.day >= ". $oDbh->quote($start_date, 'date') ."
                  AND
                    s.day <= ". $oDbh->quote($end_date, 'date') ."
                GROUP BY AgencyId, AgencyName
    		";

    	}

    	$res_banners = $oDbh->query($res_query);
        if (PEAR::isError($res_banners)) {
            return $res_banners;
        }

    	echo "Agency Breakdown - ".$start_date_save." - ".$end_date_save."\n";
    	echo "AgencyID".$delimiter."Agency Name".$delimiter."Total Views".$delimiter."Total Clicks".$delimiter."Total Sales"."\n";

    	while ($row_banners = $res_banners->fetchRow()) {
    	    echo $row_banners['AgencyId'].$delimiter.$row_banners['AgencyName'].$delimiter.$row_banners['TotalViews'].$delimiter.$row_banners['TotalClicks'].$delimiter.$row_banners['TotalConversions']."\n";
    	}
    }
}

?>
