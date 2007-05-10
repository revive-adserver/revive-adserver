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

/**
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Misza Pawlowski <michal@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/reports/Reports.php';

class Plugins_Reports_Publisher_History extends Plugins_Reports {
    // Public info function
    function info()
    {
    	include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

        $plugininfo = array (
            'plugin-name'           => MAX_Plugin_Translation::translate('History Report', $this->module, $this->package),
            'plugin-description'    => MAX_Plugin_Translation::translate('Report of publisher distribution for an advertiser.', $this->module, $this->package),
            'plugin-category'       => 'publisher',
            'plugin-category-name'  => MAX_Plugin_Translation::translate('Publisher Reports', $this->module, $this->package),
            'plugin-author'         => 'Niels Leenheer',
            'plugin-export'         => 'csv',
            'plugin-authorize'      => phpAds_Admin+phpAds_Agency+phpAds_Affiliate,
            'plugin-import'         => $this->getDefaults()
    	);

    	$this->saveDefaults();

    	return ($plugininfo);
    }

    function getDefaults()
    {
        global $session, $strAffiliate, $strStartDate, $strEndDate, $strDelimiter;

        $default_publisher = isset($session['prefs']['GLOBALS']['report_publisher']) ? $session['prefs']['GLOBALS']['report_publisher'] : '';
        $default_delimiter  = isset($session['prefs']['GLOBALS']['report_delimiter']) ? $session['prefs']['GLOBALS']['report_delimiter'] : ',';

        $aImport = array (
            'publisher' => array (
                'title'         => MAX_Plugin_Translation::translate($strAffiliate, $this->module, $this->package),
                'type'          => 'affiliateid-dropdown',
                'default'       => $default_publisher
            ),
            'delimiter'         => array (
                'title'         => MAX_Plugin_Translation::translate($strDelimiter, $this->module, $this->package),
                'type'          => 'edit',
                'size'          => 1,
                'default'       => $default_delimiter
            )
        );

        return $aImport;
    }

    function saveDefaults()
    {
        global $session;

        if (isset($_REQUEST['publisher'])) {
            $session['prefs']['GLOBALS']['report_publisher'] = $_REQUEST['publisher'];
        }
        if (isset($_REQUEST['delimiter'])) {
            $session['prefs']['GLOBALS']['report_delimiter'] = $_REQUEST['delimiter'];
        }
        phpAds_SessionDataStore();
    }

    /*-------------------------------------------------------*/
    /* Private plugin function                               */
    /*-------------------------------------------------------*/

    function execute($affiliateid, $delimiter=",")
    {
    	global $date_format;
    	global $strAffiliate, $strTotal, $strDay, $strImpressions, $strClicks, $strCTRShort;

        $conf = & $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();

        $reportName = 'm3 History Report.csv';
        header("Content-type: application/csv\nContent-Disposition: inline; filename=\"".$reportName."\"");

        $query = "
    		SELECT
    			zoneid
    		FROM
    			".$conf['table']['prefix'].$conf['table']['zones']."
    		WHERE
    			affiliateid = ". $oDbh->quote($affiliateid, 'integer');

        $idresult = $oDbh->query($query);
        if (PEAR::isError($idresult)) {
                return $idresult;
        }

    	while ($row = $idresult->fetchRow()) {
    		$zoneids[] = "zone_id = ".$row['zoneid'];
    	}

    	$query = "
    		SELECT
    			DATE_FORMAT(day, '".$date_format."') as day,
    			SUM(impressions) AS adviews,
    			SUM(clicks) AS adclicks
    		FROM
    			".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']."
    		WHERE
    			(".implode(' OR ', $zoneids).")
    		GROUP BY
    			day
    	    ORDER BY
    	        DATE_FORMAT(day, '%Y%m%d')
    	";

        $res_banners = $oDbh->query($query);
        if (PEAR::isError($res_banners)) {
                return $res_banners;
        }

    	while ($row_banners = $res_banners->fetchRow()) {
    		$stats [$row_banners['day']]['views'] = $row_banners['adviews'];
    		$stats [$row_banners['day']]['clicks'] = $row_banners['adclicks'];
    	}

    	echo $strAffiliate.": ".strip_tags(phpAds_getAffiliateName ($affiliateid))."\n\n";
    	echo $strDay.$delimiter.$strImpressions.$delimiter.$strClicks.$delimiter.$strCTRShort."\n";

    	$totalclicks = 0;
    	$totalviews = 0;

    	if (isset($stats) && is_array($stats)) {
    		foreach (array_keys($stats) as $key) {
    			$row = array();

    //			$key = implode('/',array_reverse(split('[-]',$key)));

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
    }
}

?>