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
    // Public info function
    function info()
    {
        include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

        $plugininfo = array (
            'plugin-name'             => MAX_Plugin_Translation::translate('Agency Breakdown', $this->module, $this->package),
            'plugin-description'      => MAX_Plugin_Translation::translate('Lists Adviews/AdClicks/AdSales totals for a given month',
                                          $this->module, $this->package),
            'plugin-category'         => 'admin',
            'plugin-category-name'    => MAX_Plugin_Translation::translate('Admin Reports', $this->module, $this->package),
            'plugin-author'           => 'Chris Nutting',
            'plugin-export'           => 'csv',
            'plugin-authorize'        => phpAds_Admin,
            'plugin-import'           => $this->getDefaults()
        );

        $this->saveDefaults();

        return ($plugininfo);
    }

    function getDefaults()
    {
        global $session, $strStartDate, $strEndDate, $strDelimiter;

        $default_delimiter = isset($session['prefs']['GLOBALS']['report_delimiter']) ? $session['prefs']['GLOBALS']['report_delimiter'] : ',';
        $default_start_date  = isset($session['prefs']['GLOBALS']['report_start_date']) ? $session['prefs']['GLOBALS']['report_start_date'] : date("Y/m/d", mktime(0,0,0,date("m")-1,1,date("Y")));
        $default_end_date  = isset($session['prefs']['GLOBALS']['report_end_date']) ? $session['prefs']['GLOBALS']['report_end_date'] : date("Y/m/d", (mktime(0,0,0,date("m"),1,date("Y")))-(24*60*60));

        $aImport = array (
            'delimiter'     => array (
                'title'            => MAX_Plugin_Translation::translate($strDelimiter, $this->module, $this->package),
                'type'          => 'edit',
                'size'          => 1,
                'default'       => $default_delimiter
            ),
            'start_date'    => array (
                'title'         => MAX_Plugin_Translation::translate($strStartDate, $this->module, $this->package),
                'type'          => 'edit',
                'size'          => 10,
                'default'       => $default_start_date
            ),
            'end_date'        => array (
                'title'         => MAX_Plugin_Translation::translate($strEndDate, $this->module, $this->package),
                'type'          => 'edit',
                'size'          => 10,
                'default'       => $default_end_date
            )
        );

        return $aImport;
    }

    function saveDefaults()
    {
        global $session;

        if (isset($_REQUEST['delimiter'])) {
            $session['prefs']['GLOBALS']['report_delimiter'] = $_REQUEST['delimiter'];
        }
        if (isset($_REQUEST['start_date'])) {
            $session['prefs']['GLOBALS']['report_start_date'] = $_REQUEST['start_date'];
        }
        if (isset($_REQUEST['end_date'])) {
            $session['prefs']['GLOBALS']['report_end_date'] = $_REQUEST['end_date'];
        }
        phpAds_SessionDataStore();
    }

    /*********************************************************/
    /* Private plugin function                               */
    /*********************************************************/

    function execute($delimiter=",", $start_date, $end_date)
    {
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

    	/*
    	while ($row_banners = phpAds_dbFetchArray($res_banners))
    	{
    		$stats [$row_banners['day']]['views'] = $row_banners['adviews'];
    		$stats [$row_banners['day']]['clicks'] = $row_banners['adclicks'];
    		$stats [$row_banners['day']]['sales'] = $row_banners['TotalConversions'];
    	}

    	echo $strGlobalHistory."\n\n";

    	echo $strDay.$delimiter.$strImpressions.$delimiter.$strClicks.$delimiter.$strCTRShort."\n";

    	$totalclicks = 0;
    	$totalviews = 0;

    	if (isset($stats) && is_array($stats))
    	{
    		foreach (array_keys($stats) as $key)
    		{
    			$row = array();

    			//$key = implode('/',array_reverse(split('[-]',$key)));

    			$row[] = $key;
    			$row[] = $stats[$key]['views'];
    			$row[] = $stats[$key]['clicks'];
    			$row[] = phpAds_buildCTR ($stats[$key]['views'], $stats[$key]['clicks']);

    			echo implode ($delimiter, $row)."\n";

    			$totalclicks += $stats[$key]['clicks'];
    			$totalviews += $stats[$key]['views'];
    		}
    	}

    	echo "\n";
    	echo $strTotal.$delimiter.$totalviews.$delimiter.$totalclicks.$delimiter.phpAds_buildCTR ($totalviews, $totalclicks)."\n";
    	*/
    }
}

?>
