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

require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/other/stats.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/lib/OA/Permission.php';

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Daily.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/Flexy.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/History.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display statistics.
 *
 * @package    OpenXAdmin
 * @subpackage Statistics
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
     * An array of columns to display, sum into totals,
     * or calculate as averages.
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
     * A boolean to determine if the {@link $this->aTotal}
     * array should be used in the Flexy template to show
     * total values.
     *
     * @var boolean
     */
    var $showTotals = false;

    /**
     * A boolean to note if there are no statistics available
     * to display.
     *
     * @var boolean
     */
    var $noStatsAvailable = false;

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
     * A local instance of the Admin_UI_DaySpanField object,
     * if required.
     *
     * @var Admin_UI_DaySpanField
     */
    var $oDaySpanSelector;

    /**
     * An array of the start and end date values used when
     * the day span selector element is in use.
     *
     * @var array
     */
    var $aDates;

    /**
     * Is the OA_Admin_Statistics_History helper class required
     * by the class to assist in preparing the data to display?
     *
     * @var boolean
     */
    var $useHistoryClass = false;

    /**
     * An local instance of the OA_Admin_Statistics_History
     * ibject, if required.
     *
     * @var OA_Admin_Statistics_History
     */
    var $oHistory;

    /**
     * Is the OA_Admin_Statistics_Daily helper class required
     * by the class to assist in preparing the data to display?
     *
     * @var boolean
     */
    var $useDailyClass = false;

    /**
     * An local instance of the OA_Admin_Statistics_Daily
     * ibject, if required.
     *
     * @var OA_Admin_Statistics_Daily
     */
    var $oDaily;

    /**
     * The current page URI.
     *
     * @var string
     */
    var $pageURI;

    /**
     * A path for static assets (images, CSS, JavaScripts).
     *
     * @var string
     */
    var $assetPath = ".";

    /**
     * An array for storing information about the statistics to display
     * for use in the Flexy template.
     *
     * @var array
     */
    var $aStatsData;

    /**
     * A variable naming the output type.
     * One of "deliveryHistory", or "deliveryEntity"
     *
     * @var string
     */
    var $outputType;

    /**
     * A variable for holding the current statistics page's "entity"
     * value.
     *
     * @var string
     */
    var $entity;

    /**
     * A variable for holding the current statistics page's "breakdown"
     * value.
     *
     * @var string
     */
    var $breakdown;

    /**
     * A variable for storing the page "display breakdown" values, either
     * from the breakdown selection element, or "hour" when it's a daily
     * statistics page.
     *
     * @var string
     */
    var $statsBreakdown;

    /**
     * A variable for holding the current statistics page's "breakdown"
     * value that should be used for any links that need to be
     * generated to the daily breakdown page in the left-most column
     * of the tabular data. Default is "daily".
     *
     * @var string
     */
    var $dayLinkBreakdown = 'daily';

    /**
     * A variable to decide if stats returned need to be formatted or not
     *
     * @var boolean
     */
    var $skipFormatting = false;

    /**
     * A variable to decide if the big red TZ inaccuracy warning box should be displayed
     *
     * @var bool
     */
    var $displayInaccurateStatsWarning = false;

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
        // Set the parameters
        if (is_array($aParams)) {
            foreach ($aParams as $k => $v) {
                $this->$k = $v;
            }
        }
        $this->coreParams = self::getCoreParams();

        // Ensure that the entity/breakdown values are set
        if (empty($this->entity)) {
            $this->entity = 'entity';
        }
        if (empty($this->breakdown)) {
            $this->breakdown = 'breakdown';
        }

        // Prepare some basic preferences for the class
        $this->pageName = basename($_SERVER['SCRIPT_NAME']);

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

        // Initialise the OA_Admin_Statistics_Daily class, if required
        if ($this->useDailyClass) {
            $this->oDaily = new OA_Admin_Statistics_Daily();
            $this->oDaily->parseDay($this->aDates);
            $this->aPageContext = array('days', $this->aDates['day_begin']);
            $this->statsBreakdown = 'hour';
        }

        // Initialise the OA_Admin_Statistics_History class, if required
        if ($this->useHistoryClass) {
            $this->oHistory = new OA_Admin_Statistics_History();
        }
    }

    /**
     * Returns the $aParams to include Market entities in the DAL returned values.
     * @return array to be merged with $aParams
     */
    static function getCoreParams()
    {
        $coreParams = array();
        return $coreParams;
    }

    function prepare(&$aParams)
    {
        $aParams = $this->coreParams + $aParams;
    }

    /********** METHODS THAT CHILDREN CLASS MUST OVERRRIDE **********/

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
     * An abstract, private method which must be overridden in the child class,
     * to load the required statistics fields plugins during instantiation.
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
     * An abstract, private method which must be overridden in the child class,
     * to test if the appropriate data array is empty, or not.
     *
     * @abstract
     * @access private
     * @return boolean True on empty, false if at least one row of data.
     */
    function _isEmptyResultArray()
    {
        $message = 'Error: Abstract method ' . __FUNCTION__ . ' must be implemented.';
        MAX::raiseError($message, MAX_ERROR_NOMETHOD);
    }

    /**
     * An abstract, private method which must be overridden in the child class,
     * to produce a graph of the data.
     *
     * @abstract
     * @param array $aGraphFilterArray Filter array ...?
     * @return string Complete link ...?
     */
    function showGraph($aGraphFilterArray)
    {
        $message = 'Error: Abstract method ' . __FUNCTION__ . ' must be implemented.';
        MAX::raiseError($message, MAX_ERROR_NOMETHOD);
    }

    /**
     * Create the error string to display when delivery statistics are not available.
     *
     * @return string The error string to display.
     */
    function showNoStatsString()
    {
        $message = 'Error: Abstract method ' . __FUNCTION__ . ' must be implemented.';
        MAX::raiseError($message, MAX_ERROR_NOMETHOD);
    }

    /********** METHODS THAT CHILDREN CLASS WILL INHERIT AND CAN USE **********/

    /**
     * A method that can be inherited and used by children classes to output the
     * required statistics to the screen, using the set Flexy template.
     *
     * @param boolean $graphMode     Should the data be shown as a graph, rather than
     *                               as tabular data via the Flexy template?
     */
    function output($graphMode = false)
    {
        // Check if stats are accourate (when upgraded from a non-TZ enabled version)
        $this->_checkStatsAccuracy();
        
        $this->_showShortcuts();
        
        if ($this->outputType == 'deliveryEntity') {

            // Display the entity delivery stats
            $this->template = 'breakdown_by_entity.html';
            $this->flattenEntities();
            $this->_output();

        } else if ($this->outputType == 'deliveryHistory') {

            $aDisplayData =& $this->aStatsData;
            if ($this->outputType == 'deliveryHistory') {
                $weekTemplate = 'breakdown_by_week.html';
                $dateTemplate = 'breakdown_by_date.html';
            }

            // Add the day as a breadcrumb trail if looking at a day breakdown
            if (preg_match('/daily$/', $this->breakdown)) {
                $oDate = new Date($this->aDates['day_begin']);
                $this->_addBreadcrumb($oDate->format($GLOBALS['date_format']), OX::assetPath() . '/images/icon-date.gif', 'day');
            }

            // Display the delivery history or targeting history stats
            if ($this->statsBreakdown == 'week') {
                $this->template = $weekTemplate;
                if (count($aDisplayData)) {
                    // Fix htmlclass to match the weekly template
                    $aRows = array('date');
                    foreach (array_keys($this->aColumns) as $v) {
                        if ($this->showColumn($v)) {
                            $aRows[] = $v;
                        }
                    }
                    $aRows = array_reverse($aRows);
                    foreach (array_keys($aDisplayData) as $k) {
                        $htmlclass = $aDisplayData[$k]['htmlclass'];
                        $aTmpHtmlclass  = array();
                        foreach ($aRows as $r => $v) {
                            $aTmpHtmlclass[$v] = ($r ? 'nb' : '') . $htmlclass;
                        }
                        $aDisplayData[$k]['htmlclass'] = $aTmpHtmlclass;
                    }
                }
            } else {
                $this->template = $dateTemplate;
            }

            // Set the appopriate icon for the breakdown type
            if ($this->statsBreakdown == 'hour') {
                $this->statsIcon = 'images/icon-time.gif';
            } else {
                $this->statsIcon = 'images/icon-date.gif';
            }

            $aElements = array();
            if (!$graphMode) {
                $aElements['statsBreakdown'] = new HTML_Template_Flexy_Element;
                $aElements['statsBreakdown']->setOptions(
                    array(
                        'day'   => $GLOBALS['strBreakdownByDay'],
                        'week'  => $GLOBALS['strBreakdownByWeek'],
                        'month' => $GLOBALS['strBreakdownByMonth'],
                        'dow'   => $GLOBALS['strBreakdownByDow'],
                        'hour'  => $GLOBALS['strBreakdownByHour']
                    )
                );
                $aElements['statsBreakdown']->setValue($this->statsBreakdown);
                $aElements['statsBreakdown']->setAttributes(array('onchange' => 'this.form.submit()'));
                $this->_output($aElements);
            } else {
                 $this->_outputGraph($aElements);
            }
        }
    }

    /**
     * A private method to do part of the work of the
     * {@link OA_Admin_Statistics_Common::output()} method.
     *
     * @access private
     * @param array $aElements An optional array of output elements to display.
     */
    function _output($aElements = array())
    {
        global $graphFilter;

        // Prepare the Flexy output object
        $oOutput = new HTML_Template_Flexy(array(
            'templateDir'       => $this->templateDir,
            'compileDir'        => MAX_PATH . '/var/templates_compiled',
        ));

        // Add global variables for backwards compatibility
        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $GLOBALS['clientid'] = OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $GLOBALS['affiliateid'] = OA_Permission::getEntityId();
        }

        // Add the current page's entity/breakdown values to the page
        // parameters before generating this page's URI
        $this->aPageParams['entity']    = $this->entity;
        $this->aPageParams['breakdown'] = $this->breakdown;

        // Generate URI used to add other parameters
        $this->_generatePageURI();
        $this->assetPath = OX::assetPath();

        phpAds_PageHeader($this->pageId, $this->getHeaderModel());

        // Welcome text
        if (!empty($this->welcomeText))
        {
            echo "<br/>";
            echo $this->welcomeText;
            echo "<br/><br/><br/>";
        }

        // Show the page sections
        phpAds_ShowSections($this->aPageSections, $this->aPageParams, $openNewTable=false);

        $graphVals = $graphFilter;

        // Set columns shown by default
        if (!is_array($graphVals)) {
            if (isset($this->aColumns['sum_views'])) {
                $graphVals[] = 'sum_views';
            }
            if (isset($this->aColumns['sum_clicks'])) {
                $graphVals[] = 'sum_clicks';
            }
        }

        // Prepare the data required for displaying graphs
        $graphFilterArray = $graphVals;
        $imageFormat = null;
        if (!extension_loaded('gd')) {
            $this->aGraphData['noGraph'] = true;
	    } else {
            $imgPath = rtrim(MAX::constructURL(MAX_URL_IMAGE), '/');
            if (!function_exists('imagecreate')) {
                $this->aGraphData['noGraph'] = $GLOBALS['strGDnotEnabled'];
            } else {
                $tmpUrl = MAX::constructURL(MAX_URL_ADMIN) . 'stats-showgraph.php?' . $_SERVER['QUERY_STRING'];
                if(is_array($graphFilterArray)) {
	                foreach ($graphFilterArray as $k => $v) {
	                    $tmpUrl .= '&graphFields[]=' . $v;
	                }
                }
            }
            $formSubmitLink = explode ("/", $_SERVER['REQUEST_URI']);
            $formSubmitLink = $formSubmitLink[ count($formSubmitLink) - 1 ];
            $this->aGraphData['imgPath']         = $imgPath;
            $this->aGraphData['tmpUrl']          = $tmpUrl;
            $this->aGraphData['queryString']     = $_SERVER['QUERY_STRING'];
            $this->aGraphData['formSubmitLink']  = $formSubmitLink;
	    }

        // Set the Flexy tags to open/close Javascript
        $this->scriptOpen     = "\n<script type=\"text/javascript\"> <!--\n";
        $this->scriptClose    = "\n//--> </script>\n";

        // Set whether to automatically display the Graph div, will return true if user has just changed the 'graphFields' value
        $this->autoShowGraph  = strpos($_SERVER['QUERY_STRING'], 'graphFields');

        // Set the language vars for statistics display
        $this->strShowGraphOfStatistics   = $GLOBALS['strShowGraphOfStatistics'];
        $this->strExportStatisticsToExcel = $GLOBALS['strExportStatisticsToExcel'];

        // Set-up Flexy form for displaying graph
        $aElements['graphFilter[]'] = new HTML_Template_Flexy_Element;
        $aElements['graphFilter[]']->setValue($graphVals);
        if ($this->_isEmptyResultArray()) {
            $this->disableGraph = true;
        }

        // Display page content
        $oOutput->compile($this->template);
        $oOutput->outputObject($this, $aElements);

        $this->_savePrefs();

        phpAds_PageFooter();
    }

    /**
     * A private method to do part of the work of the
     * {@link OA_Admin_Statistics_Common::output()} method.
     *
     * @access private
     * @param array $aElements An optional array of output elements to display.
     */
    function _outputGraph($aElements = array())
    {
        global $graphFields;

        // Remove duplicated fields
        $graphFields = array_unique($graphFields);

        // Add global variables for backwards compatibility
        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $GLOBALS['clientid'] = OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $GLOBALS['affiliateid'] = OA_Permission::getEntityId();
        }

        // Generate URI used to add other parameters
        $this->_generatePageURI();
        $this->assetPath = OX::assetPath();

        // Add context links, if any
        if (is_array($this->aPageContext))
            call_user_func_array(array($this, '_showContext'), $this->aPageContext);

        // Add shortcuts, if any
        $this->_showShortcuts();
        $formSubmitLink = explode ("/", $_SERVER['REQUEST_URI']);
        $formSubmitLink = $formSubmitLink[ count($formSubmitLink)-1 ];
        $graphVals = $_POST['graphFilter'];

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
        $tmpUrl = $this->showGraph($graphFilterArray);

        // Stop!
        die;
    }

    /**
     * A method that can be used in both the Flexy template and the
     * output() method to determine if a column should be visible,
     * or not.
     *
     * @param string $column The column name.
     * @return boolean True if the column is visible, false otherwise.
     */
    function showColumn($column)
    {
        return isset($this->aColumnVisible[$column]) ? $this->aColumnVisible[$column] : true;
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
     * A private method that can be inherited and used by children classes
     * to obtain the correct ID of various entities.
     *
     * @access private
     * @param string   $type    One of "advertiser", "publisher", "placement",
     *                          "ad", "zone".
     * @param ingeger  $default Optional default value.
     * @return integer The appropriate ID field.
     */
    function _getId($type, $default = null)
    {
        if ($type == 'advertiser') {
            if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
                return OA_Permission::getEntityId();
            } else {
                if (is_null($default)) {
                    return (int) MAX_getValue('clientid', '');
                } else {
                    return (int) MAX_getValue('clientid', $default);
                }
            }
        } else if ($type == 'publisher') {
            if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
                return OA_Permission::getEntityId();
            } else {
                if (is_null($default)) {
                    return (int) MAX_getValue('affiliateid', '');
                } else {
                    return (int) MAX_getValue('affiliateid', $default);
                }
            }
        } else if ($type == 'placement') {
            if (is_null($default)) {
                return (int) MAX_getValue('campaignid', '');
            } else {
                return (int) MAX_getValue('campaignid', $default);
            }
        } else if ($type == 'ad') {
            if (is_null($default)) {
                return (int) MAX_getValue('bannerid', '');
            } else {
                return (int) MAX_getValue('bannerid', $default);
            }
        } else if ($type == 'zone') {
            if (is_null($default)) {
                return (int) MAX_getValue('zoneid', '');
            } else {
                return (int) MAX_getValue('zoneid', $default);
            }
        }
    }

    /**
     * A private method that can be inherited and used by children classes
     * to check if the user has the required access level to view the
     * statistics page. If not, the method will display the error message
     * to the user, and terminate execution of the program.
     *
     * @access private
     * @param array $aParams An array, indexed by types, of the entity IDs
     *                       the statistics page is using, that the user
     *                       must have access to. For example:
     *                          array(
     *                              'advertiser' => 5,
     *                              'placement'  => 12
     *                          )
     */
    function _checkAccess($aParams)
    {
        $access = false;
        if (count($aParams) == 1) {
            if (array_key_exists('advertiser', $aParams)) {
                $access = MAX_checkAdvertiser($aParams['advertiser'], $aParams + $this->coreParams);
            } else if (array_key_exists('publisher', $aParams)) {
                $access = MAX_checkPublisher($aParams['publisher']);
            }
        } else if (count($aParams) == 2) {
            if (array_key_exists('advertiser', $aParams) && array_key_exists('placement', $aParams)) {
                $access = MAX_checkPlacement($aParams['advertiser'], $aParams['placement'], $aParams + $this->coreParams);
            } else if (array_key_exists('publisher', $aParams) && array_key_exists('zone', $aParams)) {
                $access = MAX_checkZone($aParams['publisher'], $aParams['zone']);
            }
        } else if (count($aParams) == 3) {
            if (array_key_exists('advertiser', $aParams) && array_key_exists('placement', $aParams) && array_key_exists('ad', $aParams)) {
                $access = MAX_checkAd($aParams['advertiser'], $aParams['placement'], $aParams['ad']);
            }
        }
        if (!$access) {
            // Before blatting out an error, has the access failure come about from
            // a manually generated account switch process?
            if (OA_Permission::isManualAccountSwitch()) {
                // Yup! Re-direct to the main stats page
                OX_Admin_Redirect::redirect('stats.php', true);
            }
            // Not a manual account switch, just deny access for now...
            if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                phpAds_PageHeader('2');
            }
            if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) || OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
                phpAds_PageHeader('1');
            }
            phpAds_Die($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }
    }

    /**
     * A private method that can be inherited and used by children classes to
     * add page paramters to a page name and a terminating ? or & character.
     *
     * @access private
     * @param string  $pageName Optional The page name to use. If not used,
     *                          returns an empty URI.
     * @param array   $aParams  An optional array of page parameters to use
     *                          instead of {@link $this->aPageParams}.
     * @param boolean $strip    Strip ending ? or & characters.
     * @return string The URI of the page with the page parameters appended.
     */
    function _addPageParamsToURI($pageName = null, $aParams = null, $strip = false)
    {
        if (is_null($pageName)) {
            return '';
        }
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
     * add a navigation shortcut.
     *
     * @param string $name Shortuct text
     * @param string $link Shortcut link
     * @param string $iconClass Shortcut icon class
     */
    function _addShortcut($name, $link, $iconClass)
    {
        $this->aPageShortcuts[] = array('name' => $name, 'link' => $link, 'iconClass' => $iconClass);
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
            if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                $advertisers = Admin_DA::getAdvertisers(array('advertiser_id' => $entityId), false);
                if (count($advertisers) == 1) {
                    $advertiser = current($advertisers);
                    $this->_addBreadcrumb(
                        MAX_buildName($advertiser['advertiser_id'], $advertiser['name']),
                        MAX_getEntityIcon('advertiser'),
                        $type
                    );
                }
            }
            break;

        case 'campaign':
            $campaigns = Admin_DA::getPlacements(array('placement_id' => $entityId), false);
            if (count($campaigns) == 1) {
                $campaign = current($campaigns);
                $this->_addBreadcrumbs('advertiser', $campaign['advertiser_id'], $level + 1);

                // mask campaign name if anonymous campaign
                   $campaign['name'] = MAX_getPlacementName($campaign);
                $this->_addBreadcrumb(
                    MAX_buildName($campaign['placement_id'], $campaign['name']),
                    MAX_getEntityIcon('placement'),
                    $type
                );
            }
            break;

        case 'banner':
            $banners = Admin_DA::getAds(array('ad_id' => $entityId), false);
            if (count($banners) == 1) {
                $banner = current($banners);
                $this->_addBreadcrumbs('campaign', $banner['placement_id'], $level + 1);

                // mask banner name if anonymous campaign
                $campaign = Admin_DA::getPlacement($banner['placement_id']);
                $campaignAnonymous = $campaign['anonymous'] == 't' ? true : false;
                   $banner['name'] = MAX_getAdName($banner['name'], null, null, $campaignAnonymous, $banner['ad_id']);
                $this->_addBreadcrumb(
                    MAX_buildName($banner['ad_id'], $banner['name']),
                    MAX_getEntityIcon('ad'),
                    $type
                );
            }
            break;

        case 'publisher':
            if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                $publishers = Admin_DA::getPublishers(array('publisher_id' => $entityId), false);
                if (count($publishers) == 1) {
                    $publisher = current($publishers);
                    $this->_addBreadcrumb(
                        MAX_buildName($publisher['publisher_id'], $publisher['name']),
                        MAX_getEntityIcon('publisher'),
                        'website'
                    );
                }
            }
            break;

        case 'zone':
            $zones = Admin_DA::getZones(array('zone_id' => $entityId), false);
            if (count($zones) == 1) {
                $zone = current($zones);
                $this->_addBreadcrumbs('publisher', $zone['publisher_id'], $level + 1);
                $this->_addBreadcrumb(
                    MAX_buildName($zone['zone_id'], $zone['name']),
                    MAX_getEntityIcon('zone'),
                    $type
                );
            }
            break;
        }
    }

    /**
     * A private method that can be inherited and used by children classes to
     * add a breadcrumb to the trail.
     *
     * @param string Breadcrumb text
     * @param string Breadcrumb icon
     * @param string Breadcrumb entity type
     */
    function _addBreadcrumb($name, $icon, $type = '')
    {
        $this->aPageBreadcrumbs[] = array('name' => $name, 'icon' => $icon, 'type' => $type);
    }

    function getHeaderModel()
    {
        $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();

        $oMenu = OA_Admin_Menu::singleton();
        $oMenu->_setLinkParams($this->aPageParams);
        $oCurrentSection = $oMenu->get($this->pageId);

        $oHeader = new OA_Admin_UI_Model_PageHeaderModel($oCurrentSection->getName());
        $oHeader->setIconClass('iconTargetingChannelsLarge');

        foreach ($this->aPageBreadcrumbs as $v) {
            $headerMeta = $builder->getEntityHeaderMeta($v['type']);
            $oSegment = new OA_Admin_UI_Model_EntityBreadcrumbSegment();
            $oSegment->setEntityName($v['name']);
            $oSegment->setEntityLabel($headerMeta['label']);
            $oSegment->setCssClass($headerMeta['class']);

            $oHeader->addSegment($oSegment);
        }

        return $oHeader;
    }

    /**
     * A private method that can be inherited and used by children classes to
     * output the context in the left navigation bar.
     *
     * {@uses phpAds_PageContext()}
     */
    function _showContext($type, $current_id = 0)
    {
        if ($this->useDailyClass && $type == 'days') {
            // Use the helper class contect method instead
            $aArray = array(
                'period_start' => MAX_getStoredValue('period_start', date('Y-m-d')),
                'period_end'   => MAX_getStoredValue('period_end', date('Y-m-d'))
            );
            $aDates = array_reverse($this->oHistory->getDatesArray($aArray, 'day', $this->oStartDate));
            $this->oDaily->showContext($aDates, $current_id, $this);
        } else {
            $aParams = array();
            switch ($type) {
                case 'advertisers':
                    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                            $aParams['agency_id'] = OA_Permission::getEntityId();
                        }
                        $params = $this->aPageParams;
                        $advertisers = Admin_DA::getAdvertisers($aParams, false);
                        foreach ($advertisers as $advertiser) {
                            $params['clientid'] = $advertiser['advertiser_id'];
                            phpAds_PageContext(
                                MAX_buildName($advertiser['advertiser_id'], $advertiser['name']),
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
                        phpAds_PageContext(
                            MAX_buildName($campaign['placement_id'], $campaign['name']),
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
                        phpAds_PageContext(
                            MAX_buildName($banner['ad_id'], $banner['name']),
                            $this->_addPageParamsToURI($this->pageName, $params, true),
                            $current_id == $banner['ad_id']
                        );
                    }
                    break;

                case 'publishers':
                    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                            $aParams['agency_id'] = OA_Permission::getEntityId();
                        }
                        $params = $this->aPageParams;
                        $campaigns = Admin_DA::getPublishers($aParams, false);
                        foreach ($campaigns as $publisher) {
                            $params['affiliateid'] = $publisher['publisher_id'];
                            phpAds_PageContext(
                                MAX_buildName($publisher['publisher_id'], $publisher['name']),
                                $this->_addPageParamsToURI($this->pageName, $params, true),
                                $current_id == $publisher['publisher_id']
                            );
                        }
                    }
                    break;

                case 'publisher-campaigns':
                    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
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
                                phpAds_PageContext(
                                    MAX_buildName($campaign['placement_id'], $campaign['name']),
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
                        phpAds_PageContext(
                            MAX_buildName($zone['zone_id'], $zone['name']),
                            $this->_addPageParamsToURI($this->pageName, $params, true),
                            $current_id == $zone['zone_id']
                        );
                    }
                    break;
            }
        }
    }

    /**
     * A private method that can be inherited and used by children classes to
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

        // Clear existing params, if required
        if ($clearParams) {
            unset($this->aPageParams);
        }

        // Add new params from $_GET/session
        foreach ($aVarArray as $k => $v) {
            $this->aPageParams[$v] = htmlspecialchars(MAX_getStoredValue($v, ''));
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
     * A private method that can be inherited and used by children classes to
     * load the statistics breakdown parameter.
     */
    function _loadStatsBreakdownParam()
    {
        $this->aPageParams['period_preset'] = MAX_getStoredValue('period_preset', 'today');
    }

    /**
     * A private method that can be inherited and used by children classes to
     * load the period preset parameter.
     */
    function _loadPeriodPresetParam()
    {
        $this->aPageParams['statsBreakdown'] = htmlspecialchars(MAX_getStoredValue('statsBreakdown', 'day'));
        $this->statsBreakdown = $this->aPageParams['statsBreakdown'];
    }

    /**
     * A private method that can be inherited and used by children classes to
     * return a sub-array of {@link $this->aPageParams}, where any duplicate
     * parameters already in a given URI (excluding "entity" and "day" parameters)
     * have been removed, so that parameters can be added to the URI with
     * confidence that duplicates will not be added.
     *
     * @access private
     * @param string $link The URI to be used. If null, the {@link $this->aPageParams}
     *                     array will be returned unmodified.
     * @return array An array of the de-duplicated parameters.
     */
    function _removeDuplicateParams($link)
    {
        if (empty($link)) {
            return $this->aPageParams;
        }
        $aNewParams = array();
        foreach ($this->aPageParams as $key => $value) {
            if (!empty($value)) {
                if (!strstr($link, $value) && $key != "entity" && $key != "day") {
                    $aNewParams[$key] = $value;
                }
            }
        }
        return $aNewParams;
    }

    /**
     * A private method that can be inherited and used by children classes to
     * calculate the total sum of all data rows, and store it in the
     * {@link $this->aTotal} array, as well as formatting all the rows and the
     * total array.
     *
     * Also sets {@link $this->showTotals} to true, if required.
     *
     * Also sets {@link $this->noStatsAvailable}, as required.
     *
     * @access private
     * @param array $aRows An array of rows of statistics to summarise & format.
     */
    function _summariseTotalsAndFormat(&$aRows)
    {
        $this->_summariseTotals($aRows);
        $this->noStatsAvailable = !$this->_hasActiveStats($this->aTotal);
        if (!$this->skipFormatting) {
            // Format all stats rows
            $this->_formatStats($aRows);
            // Format single total row
            $this->_formatStatsRowRecursive($this->aTotal, true);
        }
    }

    /**
     * A private method that can be inherited and used by children classes to
     * calculate the total sum of all data rows, and store it in the
     * {@link $this->aTotal} array.
     *
     * Also sets {@link $this->showTotals} to true, if required.
     *
     * @access private
     * @param array $aRows An array of rows of statistics to summarise.
     */
    function _summariseTotals(&$aRows)
    {
        $showTotals = false;
        reset($aRows);
        while (list(, $aRow) = each($aRows)) {
            reset($aRow);
            while (list($key, $value) = each($aRow)) {
                // Ensure that we only try to sum for those columns
                // that are set in the initial empty row
                if (isset($this->aColumns[$key])) {
                    if (is_bool($value)) {
                        if ($value) {
                            $this->aTotal[$key] = $value;
                        }
                    } else {
                        $this->aTotal[$key] += $value;
                    }
                    $showTotals = true;
                }
            }
        }
        $this->showTotals = $showTotals;
    }

    /**
     * A private method that can be inherited and used by children classes to
     * calculate the average of data rows.
     *
     * @static
     * @access private
     * @param array $aRows An array of rows of statistics to calcuate the average for.
     * @return array An array of averages.
     */
    function _summarizeAverages($aRows)
    {
        $aAverages = array();
        // How many rows of data are there?
        $rows = count($aRows);
        if ($rows == 1) {
            // Nothing to do, whoopie!
            reset($aRows);
            $key = key($aRows);
            $aAverages = $aRows[$key];
        } else {
            // Boo, have to do real work
            $aAverages = $this->aEmptyRow;
            reset($aRows);
            while (list(, $aRow) = each($aRows)) {
                reset($aRow);
                while (list($key, $value) = each($aRow)) {
                    // Ensure that we only try to create averages for those
                    // columns that are set in the empty row
                    if (isset($this->aColumns[$key])) {
                        if (is_bool($value)) {
                            if ($value) {
                                $aAverages[$key] = $value;
                            }
                        } else {
                            $aAverages[$key] += $value;
                        }
                    }
                }
            }
            foreach (array_keys($aAverages) as $key) {
                if (!is_bool($aAverages[$key])) {
                    $aAverages[$key] /= $rows;
                }
            }
        }
        // Format the averages and return
        $this->_formatStatsRowRecursive($aAverages, true);
        return $aAverages;
    }

    /**
     * A private method that can be inherited and used by children classes to
     * format an array of statistics rows.
     *
     * @access private
     * @param array   $aRows   An array of statistics rows.
     * @param boolean $isTotal Is the row a "total" row? When true, ensures that
     *                         all "id" formatted columns (from the
     *                         {@link $this->_aFields} array) are set to "-".
     */
    function _formatStats(&$aRows, $isTotal = false)
    {
        if (isset($aRows) && is_array($aRows)) {
            foreach (array_keys($aRows) as $key) {
                $this->_formatStatsRowRecursive($aRows[$key], $isTotal);
            }
        }
    }

    /**
     * A private method that can be inherited and used by children classes to
     * recursively format a row of statistics.
     *
     * @access private
     * @param array   $aRow    An array, containing a row of statistics,
     *                         with possible "subentities" rows.
     * @param boolean $isTotal Is the row a "total" row? When true, ensures that
     *                         all "id" formatted columns (from the
     *                         {@link $this->_aFields} array) are set to "-".
     */
    function _formatStatsRowRecursive(&$aRow, $isTotal = false)
    {
        if (isset($aRow['subentities']) && is_array($aRow['subentities'])) {
            foreach (array_keys($aRow['subentities']) as $key) {
                $this->_formatStatsRowRecursive($aRow['subentities'][$key], $isTotal);
            }
        }
        if (is_array($aRow)) {
            $this->_formatStatsRow($aRow, $isTotal);
        }
    }

    /**
     * A private method that can be inherited and used by children classes to
     * format a row of statistics.
     *
     * @access private
     * @param array   $aRow    An array, containing a row of statistics.
     * @param boolean $isTotal Is the row a "total" row? When true, ensures that
     *                         all "id" formatted columns (from the
     *                         {@link $this->_aFields} array) are set to "-".
     */
    function _formatStatsRow(&$aRow, $isTotal = false)
    {
        foreach ($this->aPlugins as $oPlugin) {
            $oPlugin->_formatStats($aRow, $isTotal);
        }
    }

    /********** PRIVATE METHODS USED BY THIS CLASS ONLY **********/

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

        $this->oDaySpanSelector =& FieldFactory::newField('day-span');
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
            $this->aDates = array();
        }

        $this->aGlobalPrefs['period_preset'] = $this->oDaySpanSelector->_fieldSelectionValue;
        $this->aGlobalPrefs['period_start']  = $this->aDates['day_begin'];
        $this->aGlobalPrefs['period_end']    = $this->aDates['day_end'];
    }

    /**
     * A private method to generate the current page URI with the correct
     * page parameters and store it in {@link $this->pageURI} for use
     * within templates.
     *
     * @access private
     */
    function _generatePageURI()
    {
        $this->pageURI = $this->_addPageParamsToURI($this->pageName);
    }

    /**
     * A private method to output the shortcuts.
     *
     * @access private
     * {@uses addPageShortcut()}
     */
    function _showShortcuts()
    {
        foreach ($this->aPageShortcuts as $shortcut) {
            addPageShortcut($shortcut['name'], $shortcut['link'], $shortcut['iconClass']);
        }
    }

    /**
     * A private method to save the preferences previously assigned to the
     * {@link $this->aPagePrefs} and {@link $this->aGlobalPrefs} arrays to
     * the user's session data store.
     *
     * @access private
     */
    function _savePrefs()
    {
        foreach ($this->aPagePrefs as $k => $v) {
            $GLOBALS['session']['prefs'][$this->pageName][$k] = $v;
        }
        foreach ($this->aGlobalPrefs as $k => $v) {
            $GLOBALS['session']['prefs']['GLOBALS'][$k] = $v;
        }
        phpAds_sessionDataStore();
    }

    /**
     * A private method to determine if there are "active" statistics
     * (ie. non-zero) in a given set of data rows.
     *
     * @access private
     * @param array $aRow An array containing a rows of statistics.
     * @return boolean True if the row is active, false otherwise.
     */
    function _hasActiveStats($aRow)
    {
        foreach ($this->aPlugins as $oPlugin) {
            if ($oPlugin->isRowActive($aRow)) {
                return true;
            }
        }
        return false;
    }

    /**
     * A private method to check if the returned stats may be inaccurate
     * becuase of an upgrade from a non TZ-enabled version
     *
     */
    function _checkStatsAccuracy()
    {
        $utcUpdate = OA_Dal_ApplicationVariables::get('utc_update');
        if (!empty($utcUpdate)) {
            $oUpdate = new Date($utcUpdate);
            $oUpdate->setTZbyID('UTC');
            // Add 12 hours
            $oUpdate->addSeconds(3600 * 12);
            if (!empty($this->aDates['day_begin']) && !empty($this->aDates['day_end'])) {
                $startDate = new Date($this->aDates['day_begin']);
                $endDate   = new Date($this->aDates['day_end']);

                if ($oUpdate->after($endDate) || $oUpdate->after($startDate)) {
                    $this->displayInaccurateStatsWarning = true;
                }
            } else {
                // All statistics
                $this->displayInaccurateStatsWarning = true;
            }
        }
    }

    function showInaccurateStatsWarning()
    {
        echo $GLOBALS['strWarningInaccurateStats'].
            ' <a href="http://www.openx.org/en/docs/2.8/adminguide/Upgrade+Time+Zones" target="_blank">'.
            $GLOBALS['strWarningInaccurateReadMore']
            .'</a>';
    }

}

?>
