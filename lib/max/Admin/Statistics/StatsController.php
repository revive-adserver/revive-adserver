<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Dal/Admin.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/other/stats.php';
require_once MAX_PATH . '/lib/pear/Image/Graph.php';
require_once 'HTML/Template/Flexy.php';
require_once 'HTML/Template/Flexy/Element.php';

/**
 * Abstract controller class for displaying statistics screens
 *
 * Always use the factory method to instantiate fields -- it will create
 * the right subclass for you.
 *
 * @package    Max
 * @subpackage Admin_Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 * @abstract
 *
 * @see StatsControllerFactory
 */
class StatsController
{
    /**#@+
     * @var string
     */
    var $template;
    var $title;
    /**#@-*/

    /** @var object */
    var $dateSpanSelector;


    /**#@+
     * @var string
     */
    var $pageName;
    var $pageURI;
    var $pageId;
    /**#@-*/

    /**#@+
     * @var array
     */
    var $pageParams;
    var $pageSections;
    var $pagePrefs;
    var $pageContext;
    var $pageShortcuts;
    var $globalPrefs;
    /**#@-*/

    /** @var integer */
    var $tabindex;

    /**#@+
     * @var boolean
     */
    var $noStatsAvailable = false;
    var $showDaySpanSelector = false;
    var $showTotals = false;
    var $showAverage = false;
    var $skipFormatting = false;
    var $disablePager = false;
    /**#@-*/

    /**#@+
     * @var array
     */
    var $plugins;
    var $columns;
    var $columnVisible;
    var $columnLinks;
    /**#@-*/

    /**#@+
     * @var array
     */
    var $aDates;
    var $total;
    var $average;
    var $emptyRow;
    /**#@-*/

    /**#@+
     * @var string
     */
    var $averageSpan;
    var $listOrder;
    var $listOrderDirection;
    var $welcomeText;
    /**#@-*/

    /** @var string */
    var $phpAds_TextDirection;


    /**
     * PHP5-style constructor
     */
    function __construct($params)
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        foreach ($params as $k => $v) {
            $this->$k = $v;
        }

        $this->pageName = basename($_SERVER['PHP_SELF']);
        $this->pagePrefs = array();
        $this->pageParams = array();
        $this->pageShortcuts = array();
        $this->globalPrefs = array();

        $this->phpAds_TextDirection = $GLOBALS['phpAds_TextDirection'];

        $this->loadPlugins();

        $this->columns       = array();
        $this->sumColumns    = array();
        $this->emptyRow      = array();
        $this->columnLinks   = array();
        $this->columnVisible = array();
        $this->prefNames     = array();
        foreach ($this->plugins as $plugin) {
            $this->columns       += $plugin->getFields($this);
            $this->emptyRow      += $plugin->getEmptyRow();
            $this->columnLinks   += $plugin->getColumnLinks();
            $this->columnVisible += $plugin->getVisibleColumns();
            $this->prefNames     += $plugin->getPreferenceNames();
        }

        // Sort columns
        uksort($this->columns, array($this, '_columnSort'));

        $this->total = $this->emptyRow;

        if (empty($GLOBALS['tabindex'])) {
            $GLOBALS['tabindex'] = 1;
        }
        $this->tabindex =& $GLOBALS['tabindex'];

        //$this->start();
    }

    /**
     * PHP4-style constructor
     */
    function StatsController($params)
    {
        $this->__construct($params);
    }

    /**
     * Abstract function which should contain the page data generation
     */
    function start()
    {
        MAX::raiseError('Programmer failure: "start" is an abstract method, and must be over-riden.', MAX_ERROR_NOMETHOD);
    }

    /**
     * Load plugins ensuring that the default plugin appears first
     */
    function loadPlugins()
    {
        $plugins = &MAX_Plugin::getPlugins('statsFields');
        uasort($plugins, array($this, '_pluginSort'));

        $this->plugins = $plugins;
    }

    /**
     * Callback function to sort plugins
     */
    function _pluginSort($a, $b)
    {
        $res = $a->displayOrder - $b->displayOrder;

        if (!$res) {
            // Equally weighted plugins, sort by class name
            return strcmp(get_class($a), get_class($b));
        }

        return $res;
    }


    /**
     * Callback function to sort columns
     */
    function _columnSort($a, $b)
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        $a = isset($this->prefNames[$a]) && isset($pref[$this->prefNames[$a].'_rank']) ? $pref[$this->prefNames[$a].'_rank'] : 100;
        $b = isset($this->prefNames[$b]) && isset($pref[$this->prefNames[$b].'_rank']) ? $pref[$this->prefNames[$b].'_rank'] : 100;

        return $a - $b;
    }

    /**
     * Return the visibility status of a column -- helper function for Flexy
     *
     * @param string Column name
     * @return boolean True if the column is vilible
     */
    function showColumn($column)
    {
        return isset($this->columnVisible[$column]) ? $this->columnVisible[$column] : true;
    }

    /**
     * Return an array field -- helper function for Flexy
     *
     * @param array The array
     * @param array Field name
     * @return mixed Field value
     */
    function showValue($e, $k)
    {
        return $e[$k];
    }

    /**
     * Return the link for a column -- helper function for Flexy
     *
     * @param array Entity array
     * @param array Column name
     * @return string Link associated with a column
     */
    function showColumnLink($entity, $column)
    {
        return empty($this->columnLinks[$column]) || empty($entity['linkparams']) ? '' : $this->columnLinks[$column];
    }

    /**
     * Return a translated string
     *
     * @param string Name of the translation string
     */
    function getTranslation($str)
    {
        if (preg_match('/^(str|key)/', $str) && isset($GLOBALS[$str])) {
            $str = $GLOBALS[$str];
        }

        return $str;
    }

    /**
     * Return a translated string -- helper function for Flexy
     *
     * @param string Name of the translation string
     *
     * @see getTranslation
     */
    function tr($str)
    {
        return StatsController::getTranslation($str);
    }

    /**
     * Initialize the day span selector
     *
     * You need to call this function for every page which should diplay
     * the day span selector
     */
    function initDaySpanSelector()
    {
        require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';

        $aPeriod = array();
        $aPeriod['period_preset'] = MAX_getStoredValue('period_preset', 'today');
        $aPeriod['period_start']  = MAX_getStoredValue('period_start', date('Y-m-d'));
        $aPeriod['period_end']    = MAX_getStoredValue('period_end', date('Y-m-d'));

        $this->daySpanSelector = &FieldFactory::newField('day-span');
        $this->daySpanSelector->_name = 'period';
        $this->daySpanSelector->enableAutoSubmit();
        $this->daySpanSelector->setValueFromArray($aPeriod);

        $this->aDates = array(
            'day_begin' => $this->daySpanSelector->getStartDate(),
            'day_end'   => $this->daySpanSelector->getEndDate(),
        );

        if (!is_null($this->aDates['day_begin'])) {
            $this->aDates['day_begin'] = $this->aDates['day_begin']->format('%Y-%m-%d');
            $this->aDates['day_end']   = $this->aDates['day_end']->format('%Y-%m-%d');
        } else {
            $aDates = array();
        }


        $this->globalPrefs['period_preset'] = $this->daySpanSelector->_fieldSelectionValue;
        $this->globalPrefs['period_start']  = $this->aDates['day_begin'];
        $this->globalPrefs['period_end']    = $this->aDates['day_end'];


        $this->showDaySpanSelector = true;
    }

    /**
     * Output the day-span selector -- helper function for Flexy
     *
     * This function is meant to be called within a template
     */
    function showDaySpanSelector()
    {
        $this->daySpanSelector->_tabIndex = $this->tabindex;

        echo "
        <form id='period_form' name='period_form' action='{$this->pageName}'>";

        //create tempArray and remove period_preset to prevent params duplicating in link
        $tempPageParams = $this->pageParams;
        unset($tempPageParams['period_preset']);
        unset($tempPageParams['period_start']);
        unset($tempPageParams['period_end']);

        _displayHiddenValues($tempPageParams);

        $this->daySpanSelector->display();

        $this->tabindex = $this->daySpanSelector->_tabIndex;

        echo "
        <a href='#' onclick='return periodFormSubmit()'>
        <img src='images/{$GLOBALS['phpAds_TextDirection']}/go_blue.gif' border='0' tabindex='".$this->tabindex++."' /></a>
        </form>";
    }

    /**
     * Format a row of stats according to the user preferences
     *
     * @static
     *
     * @param array Row of stats
     * @param bool  Is total
     */
    function formatStats(&$row, $is_total = false)
    {
        if (!$this->skipFormatting) {
            foreach ($this->plugins as $plugin) {
                $plugin->formatStats($row, $is_total);
            }
        }
    }

    /**
     * Format a row of stats recursively according to the user preferences
     *
     * This function is useful when formatting stats for entities which also
     * have subentities
     *
     * @static
     *
     * @param array Row of stats
     */
    function formatStatsRecursive(&$row)
    {
        $this->formatStats($row);

        if (isset($row['subentities']) && is_array($row['subentities'])) {
            foreach (array_keys($row['subentities']) as $key) {
                $this->formatStatsRecursive($row['subentities'][$key]);
            }
        }
    }

    /**
     * Generate CTR and SR ratios
     *
     * @static
     *
     * @param array Row of stats
     */
    function summarizeStats(&$row)
    {
        foreach ($this->plugins as $plugin) {
            $plugin->summarizeStats($row);
        }
    }

    /**
     * Calculate average requests, impressions, clicks and conversions
     *
     * @static
     *
     * @param array Total stats
     * @param array Number of entries
     * @return mixed Averages array or false on error
     */
    function summarizeAverage($total, $count, $min_count = 2)
    {
        if ($count < $min_count) {
            return false;
        }

        $average = array();
        foreach ($this->plugins as $plugin) {
            $average += $plugin->summarizeAverage($total, $count);
        }

        $this->summarizeStats($average);
        $this->formatStats($average, true);

        return $average;
    }

    /**
     * Calculate total requests, impressions, clicks and conversions
     *
     * @param array Rows of stats
     * @param boolean Calculate average data too
     */
    function summarizeTotals(&$rows, $average = false)
    {
        foreach ($rows as $row) {
            foreach (array_keys($this->columns) as $k) {
                $this->total[$k] += $row[$k];
            }

            // add conversion totals
            $conversion_types = array(
                MAX_CONNECTION_AD_IMPRESSION,
                MAX_CONNECTION_AD_CLICK,
                MAX_CONNECTION_AD_ARRIVAL,
                MAX_CONNECTION_MANUAL
            );
            foreach ($conversion_types as $conversion_type) {
                if (isset($row['sum_conversions_'.$conversion_type])) {
                    $this->total['sum_conversions_'.$conversion_type] += $row['sum_conversions_'.$conversion_type];
                }
            }
        }

        $this->summarizeStats($this->total);

        if ($average) {
            $this->average = $this->summarizeAverage($this->total, count($rows));
            $this->averageSpan = count($rows);
            $this->showAverage = $this->average !== false;
        }

        $this->noStatsAvailable = !$this->hasActiveStats($this->total);

        $this->formatStats($this->total, true);

        foreach (array_keys($rows) as $k) {
            $this->formatStatsRecursive($rows[$k]);
        }

        $this->showTotals = true;
    }

    /**
     * Check if the row is not empty
     *
     * @param array Rows of stats
     * @return boolean The row is not empty
     */
    function hasActiveStats($row)
    {
        foreach ($this->plugins as $plugin) {
            if ($plugin->isRowActive($row)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return the link to change sorting field and order -- helper function for Flexy
     *
     * @param string Name of the field
     * @param boolean Reverse default sorting
     * @return string The href parameter
     */
    function listOrderHref($fieldname, $reverse = false)
    {
        if ($this->listOrderField == $fieldname) {
            $orderdirection = $this->listOrderDirection == 'up' ? 'down' : 'up';
        } else {
            $orderdirection = $reverse ? 'down' : 'up';
        }

        return "{$this->pageURI}listorder={$fieldname}&orderdirection={$orderdirection}";
    }

    /**
     * Return the link to change sorting field and order using reversed
     * order by default -- helper function for Flexy
     *
     * @param string Name of the field
     * @return string The href parameter
     */
    function listOrderHrefRev($fieldname)
    {
        return $this->listOrderHref($fieldname, true);
    }

    /**
     * Return the image to show current ordering -- helper function for Flexy
     *
     * The function returns false if the data is not sorted by $fieldname
     *
     * @param string Name of the field
     * @return mixed Image src parameter
     */
    function listOrderImage($fieldname)
    {
        if ($this->listOrderField == $fieldname) {
            return "images/caret-".($this->listOrderDirection == 'up' ? 'u': 'ds').".gif";
        } else {
            return false;
        }
    }

    /**
     * Add page paramters to a page name and a terminating ? or & character
     *
     * @static
     *
     * @param string Page name
     * @param array Custom parameters
     * @param bool Strip ending ? or & characters
     * @return string URI
     */
    function uriAddParams($pageName, $params = null, $strip = false)
    {
        if (is_null($params)) {
            $params = $this->pageParams;
        }
        if (preg_match('/\?/', $pageName)) {
            $pageURI = $pageName.'&';
        } else {
            $pageURI = $pageName.'?';
        }

        foreach ($params as $k => $v) {
            if (!preg_match('/'.$k.'/', $pageName)) {
                $pageURI .= urlencode($k).'='.urlencode($v).'&';
            }
        }

        if ($strip) {
            $pageURI = substr($pageURI, 0, -1);
        }

        return $pageURI;
    }

    /**
     * Generate the current page URI with the correct page parameters
     * and store it in {@link pageURI} for use within templates
     */
    function generatePageURI()
    {
        $this->pageURI = $this->uriAddParams($this->pageName);
    }

    /**
     * Save the preferences previously assigned to {@link pagePrefs} and {@link globalPrefs}
     */
    function savePrefs()
    {
        foreach ($this->pagePrefs as $k => $v)
            $GLOBALS['session']['prefs'][$this->pageName][$k] = $v;
        foreach ($this->globalPrefs as $k => $v)
            $GLOBALS['session']['prefs']['GLOBALS'][$k] = $v;

        phpAds_sessionDataStore();
    }

    /**
     * Output context for the left navigation bar
     *
     * Note: the function uses phpAds_PageContext(), it doesn't make any output itself
     */
    function showContext($type, $current_id = 0)
    {
        $aParams = array();

        switch ($type) {

        case 'advertisers':
            if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
                if (phpAds_isUser(phpAds_Agency)) {
                    $aParams['agency_id'] = phpAds_getUserID();
                }

                $params = $this->pageParams;
                $advertisers = Admin_DA::getAdvertisers($aParams, false);
                foreach ($advertisers as $advertiser) {
                    $params['clientid'] = $advertiser['advertiser_id'];
                    phpAds_PageContext (
                        phpAds_buildName($advertiser['advertiser_id'], $advertiser['name']),
                        $this->uriAddParams($this->pageName, $params, true),
                        $current_id == $advertiser['advertiser_id']
                    );
                }
            }
            break;

        case 'campaigns':
            $aParams['advertiser_id'] = $this->pageParams['clientid'];

            $params = $this->pageParams;
            $campaigns = Admin_DA::getPlacements($aParams, false);
            foreach ($campaigns as $campaign) {
                $params['campaignid'] = $campaign['placement_id'];
                // mask campaign name if anonymous campaign
                   $campaign['name'] = MAX_getPlacementName($campaign);
                phpAds_PageContext (
                    phpAds_buildName($campaign['placement_id'], $campaign['name']),
                    $this->uriAddParams($this->pageName, $params, true),
                    $current_id == $campaign['placement_id']
                );
            }
            break;

        case 'banners':
            $aParams['placement_id'] = $this->pageParams['campaignid'];

            $params = $this->pageParams;
            $banners = Admin_DA::getAds($aParams, false);
            foreach ($banners as $banner) {
                $params['bannerid'] = $banner['ad_id'];
                // mask banner name if anonymous campaign
                $campaign = Admin_DA::getPlacement($banner['placement_id']);
                $campaignAnonymous = $campaign['anonymous'] == 't' ? true : false;
                  $banner['name'] = MAX_getAdName($banner['name'], null, null, $campaignAnonymous, $banner['ad_id']);
                phpAds_PageContext (
                    phpAds_buildName($banner['ad_id'], $banner['name']),
                    $this->uriAddParams($this->pageName, $params, true),
                    $current_id == $banner['ad_id']
                );
            }
            break;

        case 'publishers':
            if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
                if (phpAds_isUser(phpAds_Agency)) {
                    $aParams['agency_id'] = phpAds_getUserID();
                }

                $params = $this->pageParams;
                $campaigns = Admin_DA::getPublishers($aParams, false);
                foreach ($campaigns as $publisher) {
                    $params['affiliateid'] = $publisher['publisher_id'];
                    phpAds_PageContext (
                        phpAds_buildName($publisher['publisher_id'], $publisher['name']),
                        $this->uriAddParams($this->pageName, $params, true),
                        $current_id == $publisher['publisher_id']
                    );
                }
            }
            break;

        case 'publisher-campaigns':
            if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
                $aParams = array(
                    'publisher_id' => $publisherId,
                    'placement_id' => $placementId,
                    'include' => array('placement_id'),
                    'exclude' => array('zone_id')
                );
                $aPlacements = array();
                foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $this->aDates) as $v) {
                    $aPlacements[$v['placement_id']] = true;
                }
                $params = $this->pageParams;
                $campaigns = Admin_DA::getPlacements(array(), false);
                foreach ($campaigns as $campaign) {
                    if (isset($aPlacements[$campaign['placement_id']])) {
                        $params['campaignid'] = $campaign['placement_id'];
                        phpAds_PageContext (
                            phpAds_buildName($campaign['placement_id'], $campaign['name']),
                            $this->uriAddParams($this->pageName, $params, true),
                            $current_id == $campaign['placement_id']
                        );
                    }
                }
            }
            break;

        case 'zones':
            $aParams['publisher_id'] = $this->pageParams['affiliateid'];

            $params = $this->pageParams;
            $zones = Admin_DA::getZones($aParams, false);
            foreach ($zones as $zone) {
                $params['zoneid'] = $zone['zone_id'];
                phpAds_PageContext (
                    phpAds_buildName($zone['zone_id'], $zone['name']),
                    $this->uriAddParams($this->pageName, $params, true),
                    $current_id == $zone['zone_id']
                );
            }
            break;

        }
    }

    /**
     * Add breadcrumbs for an entity, automatically adding parent entities if needed
     *
     * @param string Entity type (advertiser, campaign, etc)
     * @param integer Entity ID
     * @param intever Recursion level
     */
    function addBreadcrumbs($type, $entityId, $level = 0)
    {
        switch ($type) {

        case 'advertiser':
            if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
                $advertisers = Admin_DA::getAdvertisers(array('advertiser_id' => $entityId), false);
                if (count($advertisers) == 1) {
                    $advertiser = current($advertisers);
                    $this->_addBreadcrumb(
                        phpAds_buildName($advertiser['advertiser_id'], $advertiser['name']),
                        MAX_getEntityIcon('advertiser')
                    );
                }
            }

            break;

        case 'campaign':
            $campaigns = Admin_DA::getPlacements(array('placement_id' => $entityId), false);
            if (count($campaigns) == 1) {
                $this->addBreadcrumbs('advertiser', $campaign['advertiser_id'], $level + 1);

                $campaign = current($campaigns);
                // mask campaign name if anonymous campaign
                   $campaign['name'] = MAX_getPlacementName($campaign);
                $this->_addBreadcrumb(
                    phpAds_buildName($campaign['placement_id'], $campaign['name']),
                    MAX_getEntityIcon('placement')
                );
            }

            break;

        case 'banner':
            $banners = Admin_DA::getAds(array('ad_id' => $entityId), false);
            if (count($banners) == 1) {
                $this->addBreadcrumbs('campaign', $banner['placement_id'], $level + 1);

                $banner = current($banners);
                // mask banner name if anonymous campaign
                $campaign = Admin_DA::getPlacement($banner['placement_id']);
                $campaignAnonymous = $campaign['anonymous'] == 't' ? true : false;
                   $banner['name'] = MAX_getAdName($banner['name'], null, null, $campaignAnonymous, $banner['ad_id']);
                $this->_addBreadcrumb(
                    phpAds_buildName($banner['ad_id'], $banner['name']),
                    MAX_getEntityIcon('ad')
                );
            }

            break;

        case 'publisher':
            if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
                $publishers = Admin_DA::getPublishers(array('publisher_id' => $entityId), false);
                if (count($publishers) == 1) {
                    $publisher = current($publishers);
                    $this->_addBreadcrumb(
                        phpAds_buildName($publisher['publisher_id'], $publisher['name']),
                        MAX_getEntityIcon('publisher')
                    );
                }
            }

            break;

        case 'zone':
            $zones = Admin_DA::getZones(array('zone_id' => $entityId), false);
            if (count($zones) == 1) {
                $this->addBreadcrumbs('publisher', $zone['publisher_id'], $level + 1);

                $zone = current($zones);
                $this->_addBreadcrumb(
                    phpAds_buildName($zone['zone_id'], $zone['name']),
                    MAX_getEntityIcon('zone')
                );
            }

            break;
        }
    }

    /**
     * Internal function to manually add a breadcrumb
     *
     * @param string Breadcrumb text
     * @param string Breadcrumb icon
     */
    function _addBreadcrumb($name, $icon)
    {
        $this->pageBreadcrumbs[] = array('name' => $name, 'icon' => $icon);
    }

    /**
     * Output the breadcrumbs, highlighing the last item
     */
    function showBreadcrumbs()
    {
        if (!empty($this->pageBreadcrumbs) && is_array($this->pageBreadcrumbs)) {
            foreach ($this->pageBreadcrumbs as $k => $bc) {
                if ($k == count($this->pageBreadcrumbs) - 1) {
                    $bc['name'] = '<b>'.$bc['name'].'</b>';
                }
                if ($k > 0) {
                    echo "&nbsp;<img src='images/".$GLOBALS['phpAds_TextDirection']."/caret-rs.gif'>&nbsp;";
                }
                echo '<img src="'.$bc['icon'].'" align="absmiddle" />&nbsp;'.$bc['name'];
            }

            if (count($this->pageBreadcrumbs)) {
                echo "<br /><br /><br />";
            }
        }
    }

    /**
     * Add a shortuct in the left navigation bar
     *
     * @param string Shortuct text
     * @param string Shortcut link
     * @param string Shortcut icon
     */
    function addShortcut($name, $link, $icon)
    {
        $this->pageShortcuts[] = array('name' => $name, 'link' => $link, 'icon' => $icon);
    }

    /**
     * Output the shortcuts
     *
     * Note: the function uses phpAds_PageShortcut(), it doesn't make any output itself
     */
    function showShortcuts()
    {
        foreach ($this->pageShortcuts as $shortcut) {
            phpAds_PageShortcut($shortcut['name'], $shortcut['link'], $shortcut['icon']);
        }
    }

    /**
     * Output the error string when stats are not available
     *
     * @return string Error string
     */
    function showNoStatsString()
    {
        if (!empty($this->aDates['day_begin']) && !empty($this->aDates['day_end'])) {
            $startDate = & new Date($this->aDates['day_begin']);
            $startDate = $startDate->format($GLOBALS['date_format']);
            $endDate   = & new Date($this->aDates['day_end']);
            $endDate   = $endDate->format($GLOBALS['date_format']);
            return sprintf($GLOBALS['strNoStatsForPeriod'], $startDate, $endDate);
        }

        return $GLOBALS['strNoStats'];
    }

    /**
     * Return string -- link to statics graph
     *
     * @param object
     * @param array Filter Array
     * @return string Complete link
     */
    function showGraph($this, $graphFilterArray)
    {

        global $conf, $GraphFile;

        if (!extension_loaded('gd')) {
            // GD isn't enabled in php install
            return 'noGD';
        }

        if (isset($this->history)) {

              //put sum_clicks on right axis only when there are
              $tempGraph = array_flip($graphFilterArray);

              if(isset($tempGraph['sum_clicks']) && !isset($tempGraph['sum_ctr'])) {
                        $clickArrayKey = $tempGraph['sum_clicks'];
              } else {
                    $clickArrayKey = false;
              }


             /**
             * stat display fonfiguration array to determine how the data is visually displayed on the graph
             * field line:  if set to Image_Graph_Plot_Bar, then it will display as a Bar. Otherwise it will be a line (can be dotted, dashed or solid)
             * field params: set the color of the line
             * field axis:  determine whether data is connected with left-hand axis (1) or righthand-axis (2)
             */
             $fieldStyleArray = array('sum_requests'  =>           array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#33cc00', 'transpartent'),
                                                                          'axis' => '1',
                                                                         ),
                                      'sum_views'               => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#006699', 'transparent'),
                                                                          'axis' => '1',
                                                                        ),
                                      'sum_clicks'              => array( 'line' => 'Image_Graph_Plot_Bar',
                                                                          'params' => array('#333333', 'transparent'),
                                                                          'axis' => '1',
                                                                          'background' => 'white@0.3'
                                                                        ),
                                      'sum_ctr'                 => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('cadetblue', 'transparent'),
                                                                          'axis' => '2',
                                                                          'background' => 'white@0.3'
                                                                        ),
                                      'sum_conversions'         => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#hh00hh', 'transparent'),
                                                                          'axis' => '1',
                                                                        ),
                                      'sum_conversions_pending' => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#cccccc', 'transparent'),
                                                                          'axis' => '1',
                                                                        ),
                                      'sum_sr_views'            => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#0000cc', 'transparent'),
                                                                          'axis' => '2',
                                                                          'background' => 'white@0.3'
                                                                        ),
                                      'sum_sr_clicks'           => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#cc0000', 'transparent'),
                                                                          'axis' => '2',
                                                                          'background' => 'white@0.3'
                                                                        ),
                                      'sum_revenue'             => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#120024', 'transparent'),
                                                                          'axis' => '1',
                                                                        ),
                                      'sum_cost'                => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#123456', 'transparent'),
                                                                          'axis' => '1',
                                                                        ),
                                      'sum_bv'                  => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#654321', 'transparent'),
                                                                          'axis' => '1',
                                                                       ),
                                      'sum_revcpc'              => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#666666', 'transparent'),
                                                                          'axis' => '1',
                                                                       ),
                                      'sum_costcpc'             => array( 'line' => 'Image_Graph_Line_Solid',
                                                                          'params' => array('#343434', 'transparent'),
                                                                          'axis' => '1'
                                                                       )
                                       );


      if($clickArrayKey) {
          $fieldStyleArray[$graphFilterArray[$clickArrayKey]]['axis'] = '2';
            }

            if (function_exists("imagejpeg")) {
                $imageFormat = 'jpg';
            }
            if (function_exists("imagepng")) {
                $imageFormat = 'png';
            }

            // create the graph
            $Canvas =& Image_Canvas::factory($imageFormat, array('width' => 800, 'height' => 400, 'usemap' => true));
            $Imagemap = $Canvas->getImageMap();
            $Graph =& Image_Graph::factory('graph', $Canvas);

            if (function_exists('ImageTTFBBox')) {
                // add a TrueType font
                $Font =& $Graph->addNew('ttf_font', 'arial.ttf');
                // set the font size to 11 pixels
                $Font->setSize(8);
                $Font->setColor('#444444');
                $Graph->setFont($Font);
            }

            $Plotarea =& $Graph->addNew('plotarea');

            // set gradient background
            $Fill =& Image_Graph::factory('gradient', array(IMAGE_GRAPH_GRAD_VERTICAL, 'lightgrey', 'white'));
            $Plotarea->setFillStyle($Fill);

            // set grid for graph
            $Grid =& $Plotarea->addNew('bar_grid', null, IMAGE_GRAPH_AXIS_Y);
            $Grid->setFillColor('gray@0.2');


            // creating fake object to be able to add description to second Y Axis
            $Dataset2 =& Image_Graph::factory('random', array(0, 0,100));
            $PlotA =& $Plotarea->addNew(
                                     'Image_Graph_Plot_Area',
                                     $Dataset2,
                                     IMAGE_GRAPH_AXIS_Y_SECONDARY
                                    );


            $AxisY =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y);

            $AxisY->forceMinimum(.1);

            $AxisYsecondary =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y_SECONDARY);

            $AxisY->setTitle('Value #', 'vertical');

            if($clickArrayKey) {
                $AxisYsecondary->setTitle($this->columns[$graphFilterArray[$clickArrayKey]], 'vertical2');

                if(count($tempGraph) < 3) {
                    $AxisY->setTitle($this->columns[$graphFilterArray[0]], 'vertical');
                }
            } else {
                $AxisYsecondary->setTitle('Value %', 'vertical2');
            }

             foreach($graphFilterArray as $k) {

                 $Dataset[$k] =& Image_Graph::factory('dataset');

                 foreach($this->history as $key => $record) {


                       // split the date ($key) into days and year, and place the year on the second line
                       $patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/');
                       $replace = array ('\3-\4--\1\2');
                       $key = preg_replace($patterns, $replace, $key);
                       $key = preg_split('/--/', $key);

                     if($fieldStyleArray[$k]['axis'] == 'X') {
                         $Dataset[$k]->addPoint($key[0]."\n".$key[1], $record[$k], IMAGE_GRAPH_AXIS_X);
                     } else {
                         $Dataset[$k]->addPoint($key[0]."\n".$key[1], $record[$k], IMAGE_GRAPH_AXIS_Y_SECONDARY);
                     }

                     $Dataset[$k]->setName($this->columns[$k]);

                 }

                 if($fieldStyleArray[$k]['axis'] == '1') {
                     if ($fieldStyleArray[$k]['line'] == 'Image_Graph_Plot_Bar') {
                         $Plot[$k] =& $Plotarea->addNew('bar', array(&$Dataset[$k]) );
                         $Plot[$k]->setFillColor($fieldStyleArray[$k]['background']);
                         $LineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', $fieldStyleArray[$k]['params']);
                         $Plot[$k]->setLineStyle($LineStyle);
                     } else {
                         $Plot[$k] =& $Plotarea->addNew('smooth_line', array(&$Dataset[$k]) );
                         $Plot[$k]->setFillColor($fieldStyleArray[$k]['params'][0]."@0.1");
                         $LineStyle =& Image_Graph::factory($fieldStyleArray[$k]['line'], $fieldStyleArray[$k]['params']);
                         $Plot[$k]->setLineStyle($LineStyle);
                     }
                 } else {
                     $Plot[$k] =& $Plotarea->addNew('area', array(&$Dataset[$k]), IMAGE_GRAPH_AXIS_Y_SECONDARY);
                     $Plot[$k]->setFillColor($fieldStyleArray[$k]['background']);
                     $LineStyle =& Image_Graph::factory('Image_Graph_Line_Solid', $fieldStyleArray[$k]['params']);
                     $Plot[$k]->setLineStyle($LineStyle);

                     foreach($Dataset[$k] as $id => $val) {
                         // to determine the max value of the 2nd y axis
                         if (is_numeric($val['Y']) && (!isset($maxY2val) || $val['Y'] > $maxY2val)) {
                             $maxY2val = $val['Y'];
                         }
                     }
                 }
             }

             $maxY2val = $maxY2val + 5;
             $AxisYsecondary->forceMaximum($maxY2val);

             $Legend =& $Plotarea->addNew('legend');
             $Legend->setFillColor('white@0.7');
             $Legend->setFontSize(8);
             $Legend->showShadow();

             $AxisX =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_X);
             $Graph->setPadding(10);
             $Graph->setBackground(Image_Graph::factory('gradient', array(IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED, 'white', '#eeeeee')));

             // output the Graph
             $tmpGraphFile = 'cache_' . md5( microtime() . rand(1,1000) ) . '.jpg';

             $Graph->done($param);

             return($Graph);

        }

    }

    /**
     * Return bool - checks if there are any non empty impresions in object
     *

     * @return bool
     */
    function isEmptyResultArray()
    {
        return false;
    }



    /**
     * Show the welcome text to publishers
     *
     */
    function showPublisherWelcome()
    {
        $pref = $GLOBALS['_MAX']['PREF'];

        if ($pref['publisher_welcome'] == 't') {
            // Show welcome message
            if (!empty($pref['publisher_welcome_msg'])) {
                $this->welcomeText = $pref['publisher_welcome_msg'];
            }
        }


    }

    /**
     * Show the welcome text to advertisers
     *
     */
    function showAdvertiserWelcome()
    {
        $pref = $GLOBALS['_MAX']['PREF'];

        if ($pref['client_welcome'] == 't') {
            // Show welcome message
            if (!empty($pref['client_welcome_msg'])) {
                $this->welcomeText = $pref['client_welcome_msg'];
            }
        }
    }


    /**
     * Output the controller object using a template
     */
    function output($elements = array())
    {
        global $graphFilter;

        $output = new HTML_Template_Flexy(array(
            'templateDir'       => MAX_PATH . '/lib/max/Admin/Statistics/themes',
            'compileDir'        => MAX_PATH . '/var/templates_compiled',
        ));

        // Add global variables for backwards compatibility
        if (phpAds_isUser(phpAds_Client)) {
            $GLOBALS['clientid'] = phpAds_getUserId();
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $GLOBALS['affiliateid'] = phpAds_getUserId();
        }

        // Generate URI used to add other parameters
        $this->generatePageURI();

        // Add context links, if any
        if (is_array($this->pageContext)) {
            call_user_func_array(array($this, 'showContext'), $this->pageContext);
        }

        // Add shortcuts, if any
        $this->showShortcuts();

        // Display header and section links
        phpAds_PageHeader($this->pageId);

        // Welcome text
        if (!empty($this->welcomeText))
        {
            echo "<br/>";
            echo $this->welcomeText;
            echo "<br/><br/><br/>";
        }

        $this->showBreadcrumbs();

        phpAds_ShowSections($this->pageSections, $this->pageParams, $openNewTable=false);

        $formSubmitLink = explode ("/", $_SERVER['REQUEST_URI']);
        $formSubmitLink = $formSubmitLink[ count($formSubmitLink)-1 ];

        $graphVals = $graphFilter;

        //turn off non visible fields
        $this->columnsVisibilitySet();

        //set columns showny by default
        if( !is_array($graphVals) ) {
            if(isset($this->columns['sum_views']))
              $graphVals[] = 'sum_views';
            if(isset($this->columns['sum_clicks']))
              $graphVals[] = 'sum_clicks';
        }
        $graphFilterArray = $graphVals;


        $imageFormat = null;
        if (!extension_loaded('gd')) {
        	$this->statsData['noGraph'] = true;
		}

        if(!function_exists('imagecreate')) {
            $this->statsData['noGraph']         = $GLOBALS['strGDnotEnabled'];
        } else {
            $tmpUrl = 'http://'
                      . $_SERVER['SERVER_NAME']
                      . preg_replace('/stats.php/', 'stats-showgraph.php', $_SERVER['REQUEST_URI']);

            foreach($graphFilterArray as $k => $v) {
                $tmpUrl .= '&graphFields[]=' . $v;
            }
        }

        $imgPath = 'http://' . $GLOBALS['_MAX']['CONF']['webpath']['admin'] . '/images';

        $this->statsData['imgPath']         = $imgPath;
        $this->statsData['tmpUrl']          = $tmpUrl;
        $this->statsData['queryString']     = $_SERVER['QUERY_STRING'];
        $this->statsData['formSubmitLink']  = $formSubmitLink;

        # ** flexy tags to open/close Javascript **
        $this->scriptOpen     = "\n<script type=\"text/javascript\"> <!--\n";
        $this->scriptClose    = "\n//--> </script>\n";

        // language vars for statistics display
        $this->strShowGraphOfStatistics   = $GLOBALS['strShowGraphOfStatistics'];
        $this->strExportStatisticsToExcel = $GLOBALS['strExportStatisticsToExcel'];

        // set-up flexy form for displaying graph
        $elements['graphFilter[]'] = new HTML_Template_Flexy_Element;
        $elements['graphFilter[]']->setValue($graphVals);

        if($this->isEmptyResultArray()) {

            $this->disableGraph = true;

        }

        // Display page content
        $output->compile($this->template);
        $output->outputObject($this, $elements);

        $this->savePrefs();
        phpAds_PageFooter();
    }

    /**
     * Output graph binary data
     */
    function outputGraph($elements = array())
    {
        global $graphFields;

        //remove duplicated fields
        $graphFields = array_unique($graphFields);

        $output = new HTML_Template_Flexy(array(
            'templateDir'       => MAX_PATH . '/lib/max/Admin/Statistics/themes',
            'compileDir'        => MAX_PATH . '/var/templates_compiled',
        ));

        // Add global variables for backwards compatibility
        if (phpAds_isUser(phpAds_Client)) {
            $GLOBALS['clientid'] = phpAds_getUserId();
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $GLOBALS['affiliateid'] = phpAds_getUserId();
        }

        // Generate URI used to add other parameters
        $this->generatePageURI();

        // Add context links, if any
        if (is_array($this->pageContext))
            call_user_func_array(array($this, 'showContext'), $this->pageContext);

        // Add shortcuts, if any
        $this->showShortcuts();
        $formSubmitLink = explode ("/", $_SERVER['REQUEST_URI']);
        $formSubmitLink = $formSubmitLink[ count($formSubmitLink)-1 ];
        $graphVals = $_POST['graphFilter'];

        //turn off non visible fields
        $this->columnsVisibilitySet();

        //set columns showny by default
        if( !is_array($graphVals) ) {
            if(isset($this->columns['sum_views']))
              $graphVals[] = 'sum_views';
            if(isset($this->columns['sum_clicks']))
              $graphVals[] = 'sum_clicks';
        }
        $graphFilterArray = $graphFields;

        $imgPath = 'http://' . $GLOBALS['_MAX']['CONF']['webpath']['admin'] . '/images';

        $tmpUrl = $this->showGraph($this, $graphFilterArray);
        die;
    }



    /**
     * Removed hidden columns for display
     */
    function columnsVisibilitySet()
    {
        foreach($this->columns as $k => $v) {
            $fieldName = explode('sum_', $k);
            $sum = isset($fieldName[1]) ? $fieldName[1] : '';
            $fieldName = 'gui_column_' . $sum . '_array';
            if(isset($GLOBALS['_MAX']['PREF'][$fieldName]) && is_array($GLOBALS['_MAX']['PREF'][$fieldName]) && $GLOBALS['_MAX']['PREF'][$fieldName][$GLOBALS['session']['usertype']]['show'] != 1) {
                unset($this->columns[$k]);
            }
        }
    }



    /**
     * Adds all $_GET vars into $this->pageParams
     *
     * @param array optional params array
     * @param bool clear existing pageParams
     */
    function loadParams($mergeArray = null, $clearParams = false)
    {
        //list of variables to get
        $varArray = array('period_start', 'period_end', 'listorder', 'orderdirection',
                          'day', 'period_preset', 'setPerPage');

        if ($this->pageParams['entity'] == '') {
            $varArray[] = 'entity';
        }

        if ($this->pageParams['breakdown'] == '') {
            $varArray[] = 'breakdown';
        }

        // clear existing params
        if ($clearParams) {
            unset($this->pageParams);
        }

        // add new params from $_GET/session
        foreach ($varArray as $k => $v) {
            $this->pageParams[$v] = MAX_getStoredValue($v, '');
        }

        // special protection for setPerPage value. Gives it a default value
        if (empty($this->pageParams['setPerPage'])) {
            $this->pageParams['setPerPage'] = 15;
        }

        // merge params with optional array
        if (is_array($mergeArray)) {
            $this->pageParams = array_merge($this->pageParams, $mergeArray);
        }


        //set default order direction if not exists
        if ($this->pageParams['orderdirection'] == '') {
            $this->pageParams['orderdirection'] = 'up';
        }

    }

    /**
    * Exports stats data to an array
    *
    * The array will look like:
    *
    * Array (
    *     'headers' => Array ( 0 => 'Col1', 1 => 'Col2', ... )
    *     'formats' => Array ( 0 => 'text', 1 => 'default', ... )
    *     'data'    => Array (
    *         0 => Array ( 0 => 'Entity 1', 1 => '5', ...),
    *         ...
    *     )
    * )
    *
    * @param array Stats array
    */
    function exportArray()
    {
        $headers = array();
        $formats = array();
        $data    = array();

        $tmp_formats = array();
        foreach ($this->plugins as $plugin) {
            $tmp_formats += $plugin->getFormats();
        }

        foreach ($this->columns as $ck => $cv) {
            if ($this->showColumn($ck)) {
            $headers[] = $cv;
                $formats[] = $tmp_formats[$ck];
            }
        }

        return array(
            'headers' => $headers,
            'formats' => $formats,
            'data'    => $data
        );
    }

    function removeDuplicateParams($link, $params = null)
    {
        $newParams = array();
        if (empty($link)) {
            return $newParams;
        }
        if (is_null($params)) {
            $params = $this->pageParams;
        }
        foreach ($params as $key => $value) {
            if (!empty($value)) {
                if (!strstr($link, $value) && $key != "entity" && $key != "day") {
                    $newParams[$key] = $value;
                }
            }
        }
        return $newParams;
    }

}

?>
