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

require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/other/stats.php';
require_once MAX_PATH . '/lib/max/Plugin.php';

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Flexy.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display statistics.
 *
 * @package    OpenadsAdmin
 * @subpackage Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Statistics_Common extends OA_Admin_Statistics_Flexy
{

    /**
     * The name of the page displaying the statistics (eg. "stats.php").
     *
     * @var string
     */
    var $pageName;

    /**
     * The ID "number" of the page (eg. "2.1.2").
     *
     * @var string
     */
    var $pageId;

    /**
     * An arry of page ID "numbers" (eg. "2.1.1, 2.1.2, 2.1.3"), including
     * the page itself {@see $this->pageId} that should be on the navigation
     * tabs at the top of the page.
     *
     * @var Array
     */
    var $aPageSections;

    /**
     * The template file to use for displaying the statistics.
     *
     * @var string
     */
    var $template;

    /**
     * The template directory that $this->template can be found in.
     *
     * @var string
     */
    var $templateDir;

    /**
     * An array for storing the user's global preferences.
     *
     * @var array
     */
    var $aGlobalPrefs;

    /**
     * An array for storing the user's page preferences.
     *
     * @var array
     */
    var $aPagePrefs;

    /**
     * An array of the $_GET page parameters.
     *
     * @var array
     */
    var $aPageParams;

    /**
     * An array of page breadcrumbs to display.
     *
     * @var array
     */
    var $aPageBreadcrumbs;

    /**
     * An array of page shortcuts to display.
     *
     * @var array
     */
    var $aPageShortcuts;

    /**
     * An array of columns to display.
     *
     * @var array
     */
    var $aColumns;

    /**
     * An array of the visible columns.
     *
     * @var array
     */
    var $aColumnVisible;

    /**
     * An array of columns links.
     *
     * @var array
     */
    var $aColumnLinks;

    /**
     * An array columns with no content, to match the
     * columns in {@link $this->aColumns}.
     *
     * @var array
     */
    var $aEmptyRow;

    /**
     * An array to hold the sum of columns of data.
     *
     * @var array
     */
    var $aTotal;

    /**
     * An array of the appropriate display plugins.
     *
     * @var array
     */
    var $aPlugins;

    /**
     * Will the day span selector element be shown on the page,
     * and therefore does it require initialisation?
     *
     * @var boolean
     */
    var $showDaySpanSelector = false;

    /**
     * A local instance of the Admin_UI_DaySpanField object.
     *
     * @var Admin_UI_DaySpanField
     */
    var $oDaySpanSelector;

    /**
     * The current page URI.
     *
     * @var string
     */
    var $pageURI;

    /**
     * The starting day of the page's report span.
     *
     * @var PEAR::Date
     */
    var $oStartDate;

    /**
     * The number of days that the page's report spans.
     *
     * @var integer
     */
    var $spanDays;

    /**
     * The number of weeks that the page's report spans.
     *
     * @var integer
     */
    var $spanWeeks;

    /**
     * The number of months that the page's report spans.
     *
     * @var integer
     */
    var $spanMonths;

    /**
     * A PHP5-style constructor that can be used to perform common
     * class instantiation by children classes.
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function __construct($aParams)
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        // Set the parameters
        foreach ($aParams as $k => $v) {
            $this->$k = $v;
        }

        // Prepare some basic preferences for the class
        $this->pageName       = basename($_SERVER['PHP_SELF']);

        $this->aGlobalPrefs     = array();
        $this->aPagePrefs       = array();
        $this->aPageParams      = array();
        $this->aPageBreadcrumbs = array();
        $this->aPageShortcuts   = array();
        $this->aColumns         = array();
        $this->aColumnLinks     = array();
        $this->aColumnVisible   = array();
        $this->aEmptyRow        = array();

        $this->phpAds_TextDirection = $GLOBALS['phpAds_TextDirection'];

        // Load the required display plugins
        $this->_loadPlugins();

        // Set the various columns from the display plugins
        foreach ($this->aPlugins as $oPlugin) {
            $this->aColumns       += $oPlugin->getFields($this);
            $this->aColumnLinks   += $oPlugin->getColumnLinks();
            $this->aColumnVisible += $oPlugin->getVisibleColumns();
            $this->aEmptyRow      += $oPlugin->getEmptyRow();
        }

        // Set the column totals to the empty row value
        $this->aTotal = $this->aEmptyRow;

        // Set the tab index.
        if (empty($GLOBALS['tabindex'])) {
            $GLOBALS['tabindex'] = 1;
        }
        $this->tabindex =& $GLOBALS['tabindex'];

        // Initialise the day span selector element, if required
        if ($this->showDaySpanSelector) {
            $this->_initDaySpanSelector();
        }
    }

    /**
     * PHP4-style constructor
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function OA_Admin_Statistics_Common($aParams)
    {
        $this->__construct($aParams);
    }

    /**
     * An abstract method which must be overridden in the child class, to set up
     * the child class with the necessary page data so that the class is ready to
     * have either the output() or outputGraph() method called to display the
     * statistics data.
     *
     * @abstract
     */
    function start()
    {
        $message = 'Error: Abstract method ' . __FUNCTION__ . ' must be implemented.';
        MAX::raiseError($message, MAX_ERROR_NOMETHOD);
    }

    /**
     * A method that can be inherited and used by children classes to output the
     * required statistics to the screen, using the set Flexy template.
     */
    function output($elements = array())
    {
        global $graphFilter;

        // Prepare the Flexy output object
        $oOutput = new HTML_Template_Flexy(array(
            'templateDir'       => $this->templateDir,
            'compileDir'        => MAX_PATH . '/var/templates_compiled',
        ));

        // Add global variables for backwards compatibility
        if (phpAds_isUser(phpAds_Client)) {
            $GLOBALS['clientid'] = phpAds_getUserId();
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $GLOBALS['affiliateid'] = phpAds_getUserId();
        }

        // Generate URI used to add other parameters
        $this->_generatePageURI();

        // Add context links, if any
        if (is_array($this->pageContext)) {
            call_user_func_array(array($this, '_showContext'), $this->pageContext);
        }

        // Add shortcuts, if any
        $this->_showShortcuts();

        // Display header and section links
        phpAds_PageHeader($this->pageId);

        // Welcome text
        if (!empty($this->welcomeText))
        {
            echo "<br/>";
            echo $this->welcomeText;
            echo "<br/><br/><br/>";
        }

        $this->_showBreadcrumbs();

        phpAds_ShowSections($this->aPageSections, $this->aPageParams, $openNewTable=false);

        $formSubmitLink = explode ("/", $_SERVER['REQUEST_URI']);
        $formSubmitLink = $formSubmitLink[ count($formSubmitLink) - 1 ];

        $graphVals = $graphFilter;

        // Turn off non visible fields
        $this->_columnsVisibilitySet();

        // Set columns shown by default
        if (!is_array($graphVals)) {
            if (isset($this->aColumns['sum_views'])) {
                $graphVals[] = 'sum_views';
            }
            if (isset($this->aColumns['sum_clicks'])) {
                $graphVals[] = 'sum_clicks';
            }
        }
        $graphFilterArray = $graphVals;

        $imageFormat = null;
        if (!extension_loaded('gd')) {
        	$this->statsData['noGraph'] = true;
		}

        if (!function_exists('imagecreate')) {
            $this->statsData['noGraph'] = $GLOBALS['strGDnotEnabled'];
        } else {
            $tmpUrl = 'http://'
                      . $_SERVER['SERVER_NAME']
                      . preg_replace('/stats.php/', 'stats-showgraph.php', $_SERVER['REQUEST_URI']);
            foreach ($graphFilterArray as $k => $v) {
                $tmpUrl .= '&graphFields[]=' . $v;
            }
        }

        $imgPath = 'http://' . $GLOBALS['_MAX']['CONF']['webpath']['admin'] . '/images';

        $this->statsData['imgPath']         = $imgPath;
        $this->statsData['tmpUrl']          = $tmpUrl;
        $this->statsData['queryString']     = $_SERVER['QUERY_STRING'];
        $this->statsData['formSubmitLink']  = $formSubmitLink;

        // Set the Flexy tags to open/close Javascript
        $this->scriptOpen     = "\n<script type=\"text/javascript\"> <!--\n";
        $this->scriptClose    = "\n//--> </script>\n";

        // Set the language vars for statistics display
        $this->strShowGraphOfStatistics   = $GLOBALS['strShowGraphOfStatistics'];
        $this->strExportStatisticsToExcel = $GLOBALS['strExportStatisticsToExcel'];

        // Set-up Flexy form for displaying graph
        $elements['graphFilter[]'] = new HTML_Template_Flexy_Element;
        $elements['graphFilter[]']->setValue($graphVals);
        if ($this->isEmptyResultArray()) {
            $this->disableGraph = true;
        }

        // Display page content
        $oOutput->compile($this->template);
        $oOutput->outputObject($this, $elements);

        $this->savePrefs();

        phpAds_PageFooter();
    }


    /**
     * A method that can be inherited and used by children classes to output the
     * required statistics to the screen in graph format.
     */
    function outputGraph($elements = array())
    {
        global $graphFields;

        // Remove duplicated fields
        $graphFields = array_unique($graphFields);

        // Add global variables for backwards compatibility
        if (phpAds_isUser(phpAds_Client)) {
            $GLOBALS['clientid'] = phpAds_getUserId();
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $GLOBALS['affiliateid'] = phpAds_getUserId();
        }

        // Generate URI used to add other parameters
        $this->_generatePageURI();

        // Add context links, if any
        if (is_array($this->pageContext))
            call_user_func_array(array($this, '_showContext'), $this->pageContext);

        // Add shortcuts, if any
        $this->_showShortcuts();
        $formSubmitLink = explode ("/", $_SERVER['REQUEST_URI']);
        $formSubmitLink = $formSubmitLink[ count($formSubmitLink)-1 ];
        $graphVals = $_POST['graphFilter'];

        // Turn off non visible fields
        $this->_columnsVisibilitySet();

        // Set columns showny by default
        if (!is_array($graphVals) ) {
            if (isset($this->aColumns['sum_views'])) {
              $graphVals[] = 'sum_views';
            }
            if (isset($this->aColumns['sum_clicks'])) {
              $graphVals[] = 'sum_clicks';
            }
        }
        $graphFilterArray = $graphFields;

        $imgPath = 'http://' . $GLOBALS['_MAX']['CONF']['webpath']['admin'] . '/images';
        $tmpUrl = $this->showGraph($this, $graphFilterArray);

        // Stop!
        die;
    }

    /**
     * A private method to initialise the day span selector element.
     *
     * @access pivate
     */
    function _initDaySpanSelector()
    {
        require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';

        $aPeriod = array();
        $aPeriod['period_preset'] = MAX_getStoredValue('period_preset', 'today');
        $aPeriod['period_start']  = MAX_getStoredValue('period_start',  date('Y-m-d'));
        $aPeriod['period_end']    = MAX_getStoredValue('period_end',    date('Y-m-d'));

        $this->oDaySpanSelector = &FieldFactory::newField('day-span');
        $this->oDaySpanSelector->_name = 'period';
        $this->oDaySpanSelector->enableAutoSubmit();
        $this->oDaySpanSelector->setValueFromArray($aPeriod);

        $this->aDates = array(
            'day_begin' => $this->oDaySpanSelector->getStartDate(),
            'day_end'   => $this->oDaySpanSelector->getEndDate(),
        );

        if (!is_null($this->aDates['day_begin'])) {
            $this->aDates['day_begin'] = $this->aDates['day_begin']->format('%Y-%m-%d');
            $this->aDates['day_end']   = $this->aDates['day_end']->format('%Y-%m-%d');
        } else {
            $aDates = array();
        }

        $this->aGlobalPrefs['period_preset'] = $this->oDaySpanSelector->_fieldSelectionValue;
        $this->aGlobalPrefs['period_start']  = $this->aDates['day_begin'];
        $this->aGlobalPrefs['period_end']    = $this->aDates['day_end'];
    }

    /**
     * A method that can be inherited and used by children classes to get the
     * required date span of a statistics page.
     *
     * @param array  $aParams      An array of query parameters for
     *                             {@link Admin_DA::fromCache()}.
     * @param string $type         The name of the method to pass to the
     *                             {@link Admin_DA::fromCache()} method.
     *                             Default is the name required for delivery
     *                             statistics.
     * @param string $pluginMethod The name of the method to call on the
     *                             display plugins to determine if there
     *                             are any custom parameters to pass to the
     *                             {@link Admin_DA::fromCache()} method.
     *                             Default is the name of the method for
     *                             delivery statistics.
     */
    function getSpan($aParams, $type = 'getHistorySpan', $pluginMethod = 'getHistorySpanParams')
    {
        $oStartDate = new Date(date('Y-m-d'));
        // Check span using all plugins
        foreach ($this->aPlugins as $oPlugin) {
            $aPluginParams = call_user_func(array($oPlugin, $pluginMethod));
            $aSpan = Admin_DA::fromCache($type, $aParams + $aPluginParams);
            if (!empty($aSpan['start_date'])) {
                $oDate = new Date($aSpan['start_date']);
                if ($oDate->before($oStartDate)) {
                    $oStartDate = new Date($oDate);
                }
            }
        }
        $oNow  = new Date();
        $oSpan = new Date_Span($oStartDate, new Date(date('Y-m-d')));
        $this->oStartDate = $oStartDate;
        $this->spanDays   = (int)ceil($oSpan->toDays());
        $this->spanWeeks  = (int)ceil($this->spanDays / 7) + ($this->spanDays % 7 ? 1 : 0);
        $this->spanMonths = (($oNow->getYear() - $oStartDate->getYear()) * 12) + ($oNow->getMonth() - $oStartDate->getMonth()) + 1;
    }

    /**
     * An abstract, private method which must be overridden in the child class,
     * to load the required plugins during instantiation.
     *
     * @abstract
     * @access private
     */
    function _loadPlugins()
    {
        $message = 'Error: Abstract method ' . __FUNCTION__ . ' must be implemented.';
        MAX::raiseError($message, MAX_ERROR_NOMETHOD);
    }

    /**
     * A private callback method that can be inherited and used by children
     * classes to sort an array of plugins.
     *
     * @access private
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
     * A private method that can be inherited and used by children classes to
     * remove any hidden columns from the list to be displayed.
     *
     * @access private
     */
    function _columnsVisibilitySet()
    {
        foreach ($this->aColumns as $k => $v) {
            $fieldName = explode('sum_', $k);
            $sum = isset($fieldName[1]) ? $fieldName[1] : '';
            $fieldName = 'gui_column_' . $sum . '_array';
            if (isset($GLOBALS['_MAX']['PREF'][$fieldName]) && is_array($GLOBALS['_MAX']['PREF'][$fieldName]) && $GLOBALS['_MAX']['PREF'][$fieldName][$GLOBALS['session']['usertype']]['show'] != 1) {
                unset($this->aColumns[$k]);
            }
        }
    }

    /**
     * A private method that can be inherited and used by children classes to
     * generate the current page URI with the correct page parameters and store
     * it in {@link $this->pageURI} for use within templates.
     *
     * @access pricate
     */
    function _generatePageURI()
    {
        $this->pageURI = $this->_addPageParamsToURI($this->pageName);
    }

    /**
     * A private method that can be inherited and used by children classes to
     * add page paramters to a page name and a terminating ? or & character.
     *
     * @access private
     * @param string  $pageName The page name to use.
     * @param array   $aParams  An optional array of page parameters to use
     *                          instead of {@link $this->aPageParams}.
     * @param boolean $strip    Strip ending ? or & characters.
     * @return string The URI of the page with the page parameters appended.
     */
    function _addPageParamsToURI($pageName, $aParams = null, $strip = false)
    {
        if (is_null($aParams)) {
            $aParams = $this->aPageParams;
        }
        if (preg_match('/\?/', $pageName)) {
            $pageURI = $pageName.'&';
        } else {
            $pageURI = $pageName.'?';
        }
        foreach ($aParams as $k => $v) {
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
     * A private method that can be inherited and used by children classes to
     * add a shortcut to the left navigation bar.
     *
     * @param string $name Shortuct text
     * @param string $link Shortcut link
     * @param string $icon Shortcut icon
     */
    function _addShortcut($name, $link, $icon)
    {
        $this->pageShortcuts[] = array('name' => $name, 'link' => $link, 'icon' => $icon);
    }

    /**
     * A private method that can be inherited and used by children classes to
     * output the shortcuts in the left navigation bar.
     *
     * @access private
     * {@uses phpAds_PageShortcut()}
     */
    function _showShortcuts()
    {
        foreach ($this->aPageShortcuts as $shortcut) {
            phpAds_PageShortcut($shortcut['name'], $shortcut['link'], $shortcut['icon']);
        }
    }

    /**
     * A private method that can be inherited and used by children classes to
     * add the breadcrumbs for the current entity item, automatically adding
     * parent entities breadcrumbs if needed.
     *
     * @param string  $type     Entity type (advertiser, campaign, etc)
     * @param integer $entityId Entity ID
     * @param intever $level    Recursion level
     */
    function _addBreadcrumbs($type, $entityId, $level = 0)
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
                $this->_addBreadcrumbs('advertiser', $campaign['advertiser_id'], $level + 1);

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
                $this->_addBreadcrumbs('campaign', $banner['placement_id'], $level + 1);

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
                $this->_addBreadcrumbs('publisher', $zone['publisher_id'], $level + 1);

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
        $this->aPageBreadcrumbs[] = array('name' => $name, 'icon' => $icon);
    }

    /**
     * A private method that can be inherited and used by children classes to
     * output the breadcrumb trail, highlighing the last item.
     */
    function _showBreadcrumbs()
    {
        if (!empty($this->aPageBreadcrumbs) && is_array($this->aPageBreadcrumbs)) {
            foreach ($this->aPageBreadcrumbs as $k => $bc) {
                if ($k == count($this->aPageBreadcrumbs) - 1) {
                    $bc['name'] = '<b>'.$bc['name'].'</b>';
                }
                if ($k > 0) {
                    echo "&nbsp;<img src='images/".$GLOBALS['phpAds_TextDirection']."/caret-rs.gif'>&nbsp;";
                }
                echo '<img src="'.$bc['icon'].'" align="absmiddle" />&nbsp;'.$bc['name'];
            }
            if (count($this->aPageBreadcrumbs)) {
                echo "<br /><br /><br />";
            }
        }
    }

    /**
     * A private method that can be inherited and used by children classes to
     * output the context in the left navigation bar.
     *
     * {@uses phpAds_PageContext()}
     */
    function _showContext($type, $current_id = 0)
    {
        $aParams = array();

        switch ($type) {

        case 'advertisers':
            if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
                if (phpAds_isUser(phpAds_Agency)) {
                    $aParams['agency_id'] = phpAds_getUserID();
                }

                $params = $this->aPageParams;
                $advertisers = Admin_DA::getAdvertisers($aParams, false);
                foreach ($advertisers as $advertiser) {
                    $params['clientid'] = $advertiser['advertiser_id'];
                    phpAds_PageContext (
                        phpAds_buildName($advertiser['advertiser_id'], $advertiser['name']),
                        $this->_addPageParamsToURI($this->pageName, $params, true),
                        $current_id == $advertiser['advertiser_id']
                    );
                }
            }
            break;

        case 'campaigns':
            $aParams['advertiser_id'] = $this->aPageParams['clientid'];

            $params = $this->aPageParams;
            $campaigns = Admin_DA::getPlacements($aParams, false);
            foreach ($campaigns as $campaign) {
                $params['campaignid'] = $campaign['placement_id'];
                // mask campaign name if anonymous campaign
                   $campaign['name'] = MAX_getPlacementName($campaign);
                phpAds_PageContext (
                    phpAds_buildName($campaign['placement_id'], $campaign['name']),
                    $this->_addPageParamsToURI($this->pageName, $params, true),
                    $current_id == $campaign['placement_id']
                );
            }
            break;

        case 'banners':
            $aParams['placement_id'] = $this->aPageParams['campaignid'];

            $params = $this->aPageParams;
            $banners = Admin_DA::getAds($aParams, false);
            foreach ($banners as $banner) {
                $params['bannerid'] = $banner['ad_id'];
                // mask banner name if anonymous campaign
                $campaign = Admin_DA::getPlacement($banner['placement_id']);
                $campaignAnonymous = $campaign['anonymous'] == 't' ? true : false;
                  $banner['name'] = MAX_getAdName($banner['name'], null, null, $campaignAnonymous, $banner['ad_id']);
                phpAds_PageContext (
                    phpAds_buildName($banner['ad_id'], $banner['name']),
                    $this->_addPageParamsToURI($this->pageName, $params, true),
                    $current_id == $banner['ad_id']
                );
            }
            break;

        case 'publishers':
            if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
                if (phpAds_isUser(phpAds_Agency)) {
                    $aParams['agency_id'] = phpAds_getUserID();
                }

                $params = $this->aPageParams;
                $campaigns = Admin_DA::getPublishers($aParams, false);
                foreach ($campaigns as $publisher) {
                    $params['affiliateid'] = $publisher['publisher_id'];
                    phpAds_PageContext (
                        phpAds_buildName($publisher['publisher_id'], $publisher['name']),
                        $this->_addPageParamsToURI($this->pageName, $params, true),
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
                $params = $this->aPageParams;
                $campaigns = Admin_DA::getPlacements(array(), false);
                foreach ($campaigns as $campaign) {
                    if (isset($aPlacements[$campaign['placement_id']])) {
                        $params['campaignid'] = $campaign['placement_id'];
                        phpAds_PageContext (
                            phpAds_buildName($campaign['placement_id'], $campaign['name']),
                            $this->_addPageParamsToURI($this->pageName, $params, true),
                            $current_id == $campaign['placement_id']
                        );
                    }
                }
            }
            break;

        case 'zones':
            $aParams['publisher_id'] = $this->aPageParams['affiliateid'];

            $params = $this->aPageParams;
            $zones = Admin_DA::getZones($aParams, false);
            foreach ($zones as $zone) {
                $params['zoneid'] = $zone['zone_id'];
                phpAds_PageContext (
                    phpAds_buildName($zone['zone_id'], $zone['name']),
                    $this->_addPageParamsToURI($this->pageName, $params, true),
                    $current_id == $zone['zone_id']
                );
            }
            break;

        }
    }

    /**
     * A private method that can be inherited and used by childred classes to
     * load all $_GET variables into the $this->aPageParams array.
     *
     * @access private
     * @param array $aMergeArray   An optional array of parameters to merge into
     *                             the $this->aPageParams array.
     * @param boolean $clearParams Should the previous existing $this->aPageParams
     *                             be cleared before loading?
     */
    function _loadParams($aMergeArray = null, $clearParams = false)
    {
        // List of variables to get
        $aVarArray = array(
            'period_start',
            'period_end',
            'listorder',
            'orderdirection',
            'day',
            'period_preset',
            'setPerPage'
        );

        if ($this->aPageParams['entity'] == '') {
            $aVarArray[] = 'entity';
        }

        if ($this->aPageParams['breakdown'] == '') {
            $aVarArray[] = 'breakdown';
        }

        // Clear existing params, if required
        if ($clearParams) {
            unset($this->aPageParams);
        }

        // Add new params from $_GET/session
        foreach ($aVarArray as $k => $v) {
            $this->aPageParams[$v] = MAX_getStoredValue($v, '');
        }

        // Ensure the setPerPage value is set
        if (empty($this->aPageParams['setPerPage'])) {
            $this->aPageParams['setPerPage'] = 15;
        }

        // Merge params with optional array, if required
        if (is_array($aMergeArray)) {
            $this->aPageParams = array_merge($this->aPageParams, $aMergeArray);
        }

        // Ensure the orderdirection value is set
        if ($this->aPageParams['orderdirection'] == '') {
            $this->aPageParams['orderdirection'] = 'up';
        }

    }

    /**
     * A method that can be inherited and used by children classes to save the
     * preferences previously assigned to {@link aPagePrefs} and {@link aGlobalPrefs}
     * arrays to the user's session data store.
     */
    function savePrefs()
    {
        foreach ($this->aPagePrefs as $k => $v) {
            $GLOBALS['session']['prefs'][$this->pageName][$k] = $v;
        }
        foreach ($this->aGlobalPrefs as $k => $v) {
            $GLOBALS['session']['prefs']['GLOBALS'][$k] = $v;
        }
        phpAds_sessionDataStore();
    }

}

?>