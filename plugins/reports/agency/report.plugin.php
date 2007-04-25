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
 * @author     Chris Nutting <chris@m3.net>
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/reports/Reports.php';

class Plugins_Reports_Agency_Report extends Plugins_Reports {

    function info()
    {
    	include_once MAX_PATH . '/lib/max/Plugin/Translation.php';
        MAX_Plugin_Translation::init($this->module, $this->package);

    	$plugininfo = array (
            'plugin-name'           => MAX_Plugin_Translation::translate('Agency report', $this->module, $this->package),
            'plugin-description'    => MAX_Plugin_Translation::translate('This report generates an agency-wide report on' .
    		                           'all activity between the specified dates (Date range is <b>inclusive</b>)', $this->module, $this->package),
            'plugin-category'       => 'agency',
            'plugin-category-name'  => MAX_Plugin_Translation::translate('Agency Reports', $this->module, $this->package),
            'plugin-author'         => 'Chris Nutting',
            'plugin-export'         => 'csv',
            'plugin-authorize'      => phpAds_Admin+phpAds_Agency,
            'plugin-import'         => $this->getDefaults()
        );

       	$this->saveDefaults();

    	return ($plugininfo);
    }

    function getDefaults()
    {
        global $session, $strDelimiter, $strStartDate, $strEndDate;

        $default_delimiter  = isset($session['prefs']['GLOBALS']['report_delimiter']) ? $session['prefs']['GLOBALS']['report_delimiter'] : ',';
        $default_start_date  = isset($session['prefs']['GLOBALS']['report_start_date']) ? $session['prefs']['GLOBALS']['report_start_date'] : date("Y/m/d",mktime (0,0,0,date("m")-1,1,date("Y")));
        $default_end_date  = isset($session['prefs']['GLOBALS']['report_end_date']) ? $session['prefs']['GLOBALS']['report_end_date'] : date("Y/m/d", mktime(0,0,0,date("m")-1,date("t", date("m")-1),date("Y")));

        $aImport = array (
            'delimiter'        => array (
                'title'         => MAX_Plugin_Translation::translate($strDelimiter, $this->module, $this->package),
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
        $conf = & $GLOBALS['_MAX']['CONF'];
    	global $date_format;
    	global $strCampaign, $strTotal, $strDay, $strImpressions, $strClicks, $strCTRShort, $strConversions, $strCNVRShort;

    	// Format the start and end dates
        $dbStart = date("Y-m-d", strtotime($start_date));
        $dbEnd   = date("Y-m-d", strtotime($end_date));
        $start = date("Y/m/d", strtotime($start_date));
        $end   = date("Y/m/d", strtotime($end_date));

    	$clientid = phpAds_getUserID();

        $reportName = 'm3 Agency Report from ' . date('Y-M-d', strtotime($start_date)) . ' to ' . date('Y-M-d', strtotime($end_date)) . '.csv';
        header("Content-type: application/csv\nContent-Disposition: inline; filename=\"".$reportName."\"");

    	$left_query = "
    	SELECT
        a.clientname AS advertisername,
            c.campaignname AS campaignname,
            c.campaignid AS campaignid,
            p.name AS publishername,
            z.zonename AS zonename,
            z.width AS width,
            z.height AS height,
            SUM(s.impressions) AS views,
            SUM(s.clicks) AS clicks,
            SUM(s.conversions) AS conversions

    	FROM
    	    ({$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']} AS s,
            {$conf['table']['prefix']}{$conf['table']['banners']} AS b,
            {$conf['table']['prefix']}{$conf['table']['campaigns']} AS c,
            {$conf['table']['prefix']}{$conf['table']['clients']} AS a)

    	LEFT JOIN
            {$conf['table']['prefix']}{$conf['table']['zones']} AS z
          ON
            s.zone_id = z.zoneid

    	LEFT JOIN
            {$conf['table']['prefix']}{$conf['table']['affiliates']} AS p
          ON
            z.affiliateid = p.affiliateid

    	WHERE
            s.day >= '".$dbStart."'
          AND
            s.day <= '".$dbEnd."'
          AND
            b.bannerid = s.ad_id
          AND
            c.campaignid = b.campaignid
          AND
            a.clientid = c.clientid
          ";

    	$left_query .= (phpAds_isUser(phpAds_Agency)) ? " AND a.agencyid = '".$clientid."'" : '';

        $left_query .= "
    	GROUP BY
            b.campaignid,
            s.zone_id

    	ORDER BY
            advertisername,
            campaignname,
            publishername,
            zonename;
    	";

    	$res_banners = phpAds_dbQuery($left_query) or phpAds_sqlDie();

    	echo "Advertiser".$delimiter."Campaign".$delimiter."Publisher".$delimiter."Zone".$delimiter."Size".$delimiter;
    	echo "Views".$delimiter."Clicks".$delimiter,"Conversions\n\n";

    	$totals['views'] = 0;
    	$totals['clicks'] = 0;
    	$totals['conversions'] = 0;


    	while ($row_banners = phpAds_dbFetchArray($res_banners))
    	{
    	    $row_banners = str_replace($delimiter, ' ', $row_banners);

    	    ($row_banners['width'] == -1) ? $width = '*' : $width = $row_banners['width'];
    	    ($row_banners['height'] == -1) ? $height = '*' : $height = $row_banners['height'];

    	    if ($row_banners['width'] == '') $width = '?';
    	    if ($row_banners['height'] == '') $height = '?';


    	    if ($row_banners['publishername'] == '') $row_banners['publishername'] = 'Unknown';
    	    if ($row_banners['zonename'] == '') $row_banners['zonename'] = 'Unknown';


    	    echo $row_banners['advertisername'].$delimiter;
    	    echo $row_banners['campaignname'].$delimiter;
    	    echo $row_banners['publishername'].$delimiter;
    	    echo $row_banners['zonename'].$delimiter;
    	    echo $width."x".$height.$delimiter;
    	    echo $row_banners['views'].$delimiter;
    	    echo $row_banners['clicks'].$delimiter;
    	    echo $row_banners['conversions'].$delimiter;

    	    echo "\n";
            $totals['views'] += $row_banners['views'];
            $totals['clicks'] += $row_banners['clicks'];
            $totals['conversions'] += $row_banners['conversions'];
    	}

    	echo "\nTotals".$delimiter.$delimiter.$delimiter.$delimiter.$delimiter.$totals['views'].$delimiter.$totals['clicks'].$delimiter.$totals['conversions']."\n";
    }
}

?>
