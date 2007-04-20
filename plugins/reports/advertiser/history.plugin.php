<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
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
$Id$
*/

/**
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Misza Pawlowski <michal@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/reports/Reports.php';

class Plugins_Reports_Advertiser_History extends Plugins_Reports {

    // Public info function
    function info()
    {
        include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

        $plugininfo = array (
            'plugin-name'           => MAX_Plugin_Translation::translate('History Report', $this->module, $this->package),
            'plugin-description'    => MAX_Plugin_Translation::translate('A daily breakdown of all activity for a specific advertiser', $this->module, $this->package),
            'plugin-category'       => 'advertiser',
            'plugin-category-name'  => MAX_Plugin_Translation::translate('Advertiser Reports', $this->module, $this->package),
            'plugin-author'         => 'Niels Leenheer',
            'plugin-export'         => 'csv',
            'plugin-authorize'      => phpAds_Admin+phpAds_Agency+phpAds_Client,
            'plugin-import'         => $this->getDefaults()
        );

        $this->saveDefaults();

        return ($plugininfo);
    }

    function getDefaults()
    {
        global $session, $strClient, $strDelimiter;

        $default_advertiser = isset($session['prefs']['GLOBALS']['report_advertiser']) ? $session['prefs']['GLOBALS']['report_advertiser'] : '';
        $default_delimiter = isset($session['prefs']['GLOBALS']['report_delimiter']) ? $session['prefs']['GLOBALS']['report_delimiter'] : ',';

        $aImport = array (
            'advertiser' => array (
                'title'         => MAX_Plugin_Translation::translate($strClient, $this->module, $this->package),
                'type'          => 'clientid-dropdown',
                'default'       => $default_advertiser
            ),
            'delimiter'        => array (
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

        if (isset($_REQUEST['advertiser'])) {
            $session['prefs']['GLOBALS']['report_advertiser'] = $_REQUEST['advertiser'];
        }
        if (isset($_REQUEST['delimiter'])) {
            $session['prefs']['GLOBALS']['report_delimiter'] = $_REQUEST['delimiter'];
        }
        phpAds_SessionDataStore();
    }

    /*-------------------------------------------------------*/
    /* Private plugin function                               */
    /*-------------------------------------------------------*/

    function execute($clientid, $delimiter=",")
    {
        $conf = & $GLOBALS['_MAX']['CONF'];

    	global $date_format;
    	global $strClient, $strTotal, $strDay, $strImpressions, $strClicks, $strCTRShort, $strConversions, $strCNVRShort;

       	$reportName = 'm3 History Report.csv';
        header("Content-type: application/csv\nContent-Disposition: inline; filename=\"".$reportName."\"");

    	$res_query = "  SELECT
    						s.ad_id AS bannerid,
    						DATE_FORMAT(s.day, '".$date_format."') as day,
    						SUM(s.impressions) AS adviews,
    						SUM(s.clicks) AS adclicks,
    						SUM(s.conversions) AS adconversions
    					FROM
    						".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." as s,
    						".$conf['table']['prefix'].$conf['table']['banners']." as b,
    						".$conf['table']['prefix'].$conf['table']['campaigns']." as c
    					WHERE
    						s.ad_id=b.bannerid
    						AND b.campaignid=c.campaignid
    						AND c.clientid = '".$clientid."'
    					GROUP BY
    						day
                        ORDER BY
                            DATE_FORMAT(day, '%Y%m%d')
    				";

    	$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();

    	while ($row_banners = phpAds_dbFetchArray($res_banners))
    	{
    		$stats[$row_banners['day']]['views'] 		= $row_banners['adviews'];
    		$stats[$row_banners['day']]['clicks'] 		= $row_banners['adclicks'];
    		$stats[$row_banners['day']]['conversions'] 	= $row_banners['adconversions'];
    	}

    	echo $strClient.": ".strip_tags(phpAds_getClientName($clientid,true))."\n\n";
    	echo $strDay.$delimiter.$strImpressions.$delimiter.$strClicks.$delimiter.$strCTRShort.$delimiter.$strConversions.$delimiter.$strCNVRShort."\n";

    	$totalclicks      = 0;
    	$totalviews       = 0;
    	$totalconversions = 0;

    	if (isset($stats) && is_array($stats))
    	{
    		foreach (array_keys($stats) as $key)
    		{
    			echo $key.
    				 $delimiter.
    				 $stats[$key]['views'].
    				 $delimiter.
    				 $stats[$key]['clicks'].
    				 $delimiter.
    				 str_replace(',','.',phpAds_buildCTR($stats[$key]['views'], $stats[$key]['clicks'])).
    				 $delimiter.
    				 $stats[$key]['conversions'].
    				 $delimiter.
    				 str_replace(',','.',phpAds_buildCTR($stats[$key]['clicks'], $stats[$key]['conversions'])).
    				 "\n";

    			$totalclicks 		+= $stats[$key]['clicks'];
    			$totalviews			+= $stats[$key]['views'];
    			$totalconversions 	+= $stats[$key]['conversions'];
    		}
    	}

    	echo "\n";
    	echo $strTotal.
    		 $delimiter.
    		 $totalviews.
    		 $delimiter.
    		 $totalclicks.
    		 $delimiter.
    		 str_replace(',','.',phpAds_buildCTR ($totalviews, $totalclicks)).
    		 $delimiter.
    		 $totalconversions.
    		 $delimiter.
    		 str_replace(',','.',phpAds_buildCTR ($totalclicks, $totalconversions)).
    		 "\n";
    }
}

?>