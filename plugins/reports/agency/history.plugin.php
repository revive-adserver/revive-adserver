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
$Id$
*/

/**
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Misza Pawlowski <michal@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/reports/Reports.php';

class Plugins_Reports_Agency_History extends Plugins_Reports {

    // Public info function
    function info()
    {
    	include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

    	$plugininfo = array (
            'plugin-name'           => MAX_Plugin_Translation::translate('Overall History Report', $this->module, $this->package),
            'plugin-description'    => MAX_Plugin_Translation::translate('Overall advertising history, broken down by day.', $this->module, $this->package),
            'plugin-category'       => 'agency',
            'plugin-category-name'  => MAX_Plugin_Translation::translate('Agency Reports', $this->module, $this->package),
            'plugin-author'         => 'Niels Leenheer',
            'plugin-export'         => 'csv',
            'plugin-authorize'      => phpAds_Admin+phpAds_Agency,
            'plugin-import'         => $this->getDefaults()
    	);

    	$this->saveDefaults();

    	return ($plugininfo);
    }

    function getDefaults()
    {
        global $session, $strDelimiter;

        $default_delimiter  = isset($session['prefs']['GLOBALS']['report_delimiter']) ? $session['prefs']['GLOBALS']['report_delimiter'] : ',';

        $aImport = array (
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

        if (isset($_REQUEST['delimiter'])) {
            $session['prefs']['GLOBALS']['report_delimiter'] = $_REQUEST['delimiter'];
        }
        phpAds_SessionDataStore();
    }

    /*-------------------------------------------------------*/
    /* Private plugin function                               */
    /*-------------------------------------------------------*/

    function execute($delimiter=",")
    {
        $conf = & $GLOBALS['_MAX']['CONF'];
    	global $date_format;
    	global $strGlobalHistory, $strTotal, $strDay, $strImpressions, $strClicks, $strCTRShort;

        $reportName = 'm3 Overall History Report.csv';
        header("Content-type: application/csv\nContent-Disposition: inline; filename=\"".$reportName."\"");

    	if(phpAds_isUser(phpAds_Admin))
    	{
    		$res_query = "
    			SELECT
    				DATE_FORMAT(day, '".$date_format."') as day,
    				SUM(impressions) AS adviews,
    				SUM(clicks) AS adclicks
    			FROM
    				".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']."
    			GROUP BY
    				day
                ORDER BY
    	           DATE_FORMAT(day, '%Y%m%d')
    		";

    	}
    	else
    	{
    		$res_query = "SELECT
    						DATE_FORMAT(s.day, '".$date_format."') as day,
    						SUM(s.impressions) AS adviews,
    						SUM(s.clicks) AS adclicks
    					FROM
    						".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." 	as s,
    						".$conf['table']['prefix'].$conf['table']['banners']." 	as b,
    						".$conf['table']['prefix'].$conf['table']['campaigns']." as m,
    						".$conf['table']['prefix'].$conf['table']['clients']." 	as c
    					WHERE
    						s.ad_id 		= b.bannerid AND
    						b.campaignid 	= m.campaignid AND
    						m.clientid 		= c.clientid AND
    						c.agencyid 		= " . phpAds_getUserID() ."
    					GROUP BY
    						day
                        ORDER BY
                            DATE_FORMAT(day, '%Y%m%d')
    		";
    	}


    	$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();

    	while ($row_banners = phpAds_dbFetchArray($res_banners))
    	{
    		$stats [$row_banners['day']]['views'] = $row_banners['adviews'];
    		$stats [$row_banners['day']]['clicks'] = $row_banners['adclicks'];
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
    }

}

?>
