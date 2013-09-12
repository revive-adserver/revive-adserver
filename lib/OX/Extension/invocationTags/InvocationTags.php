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

require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OX/Translation.php';
require_once MAX_PATH . '/lib/OX/Extension/invocationTags/InvocationTagsOptions.php';


define('MAX_PLUGINS_INVOCATION_TAGS_ALLOW', 'Allow ');
define('MAX_PLUGINS_INVOCATION_TAGS_STANDARD', 0);
define('MAX_PLUGINS_INVOCATION_TAGS_CUSTOM', 1);

/**
 * Plugins_InvocationTags is an abstract class for every Invocation tag plugin.
 *
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 * @author     Radek Maciaszek <radek@m3.net>
 * @abstract
 */
class Plugins_InvocationTags extends OX_Component
{
    /**
     * With the help of this variable we could
     * pass the globals variables from
     * MAX_Admin_Invocation object in more object oriented way - as
     * object attributes
     */
    var $maxInvocation;

    /**
     * Order in which the plugins should be displayed
     *
     * @var Integer
     */
    static $order = 1;

    /**
     * If set to false, the zone invocation screen will not display the text area and the options below.
     * Instead it is up to the plugin to display HTML using the getHeaderHtml() method
     * @var bool
     */
    public $displayTextAreaAndOptions = true;

    /**
     * Return name of plugin
     *
     * @abstract
     * @return string A string describing the class.
     */
    function getName()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Return the English name of the plugin. Used when
     * generating translation keys based on the plugin
     * name.
     *
     * @abstract
     * @return string An English string describing the class.
     */
    function getNameEN()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Return list of options
     * generateOptions() use this information to generate the HTML FORM
     * containing configuration options
     *
     * @abstract
     * @see generateOptions()
     * @return array    Array of options names. Key is option name and value is option type
     *                  Option type could be:
     *                    - MAX_PLUGINS_INVOCATION_TAGS_STANDARD - option name is a method
     *                                                             from Plugins_InvocationTagsOptions classs
     *                    - MAX_PLUGINS_INVOCATION_TAGS_CUSTOM - option name is name of the method
     *                                                           from plugin class
     */
    function getOptionsList()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Check if current plugin is allowed in preferences
     *
     * @param array    Extra parameters which could be used in child classes
     *
     * @return boolean    True if allowed else false
     */
    function isAllowed($extra = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $settingString = 'isAllowed'.ucfirst($this->component);
        return isset($aConf[$this->group][$settingString]) ? $aConf[$this->group][$settingString] : false;
    }

    /**
     * Check if plugin has enough data to perform tag generation
     *
     * @return boolean
     */
    function canGenerate()
    {
        return true;
    }

    /**
     * The returned HTML will be displayed after the Invocation tags SELECT dropdown
     * and before any other invocation tag output
     *
     * @param MAX_Admin_Invocation $maxInvocation
     * @param array $extra Information about the current request
     * @return string
     */
    public function getHeaderHtml( $maxInvocation, $extra )
    {
        return '';
    }

    public function getOrder()
    {
        self::$order += 1;
        return self::$order;
    }

    /**
     * Inject invocation - required for generateInvocationCode()
     * and for custom options methods
     *
     * @see generateInvocationCode()
     */
    function setInvocation(&$invocation) {
        $this->maxInvocation = &$invocation;
    }

    /**
     * Generate the invocation string
     *
     * @return string    Generated invocation string
     */
    function generateInvocationCode()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Prepare data before generating the invocation code
     *
     * @param array $aComments Array of comments allowed keys: 'Cache Buster Comment', 'Third Party Comment',
     *                                     'SSL Delivery Comment', 'SSL Backup Comment', 'Comment'
     *
     */
    function prepareCommonInvocationData($aComments)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;

        // Check if affiliate is on the same server
        if (isset($mi->website) && $mi->website != '') {
            $mi->server_max      = parse_url('http://' . $conf['webpath']['delivery'] . '/');
            $mi->server_affilate = parse_url($mi->website);
            $mi->server_same     = (@gethostbyname($mi->server_max['host']) == @gethostbyname($mi->server_affilate['host']));
        } else {
            $mi->server_same = true;
        }

        $mi->macros = array(
            'cachebuster' => 'INSERT_RANDOM_NUMBER_HERE',
            'clickurl'    => 'INSERT_ENCODED_CLICKURL_HERE',
        );
        if (!empty($mi->thirdpartytrack) && ($mi->thirdpartytrack != 'generic')) {
            if ($thirdpartyserver = OX_Component::factoryByComponentIdentifier($mi->thirdpartytrack)) {
                $thirdpartyname = $thirdpartyserver->getName();
                if (!empty($thirdpartyserver->clickurlMacro)) {
                    $mi->macros['clickurl'] = $thirdpartyserver->clickurlMacro;
                }
                if (!empty($thirdpartyserver->cachebusterMacro)) {
                    $mi->macros['cachebuster'] = $thirdpartyserver->cachebusterMacro;
                }
            }
        }
        $mi->parameters = array();
        $imgParams      = array();

        // Setup option defaults
        $pluginOptions = new Plugins_InvocationTagsOptions();
        foreach ($pluginOptions->defaultValues as $key => $value) {
            if (!is_array($value) && (!isset($mi->$key) || is_null($mi->$key))) {
                $mi->$key = $mi->parameters[$key] = $value;
            }
        }

        // UniqueID is only necessary for a couple of plugins, so it is not "common"
        //$mi->uniqueid = 'a'.substr(md5(uniqid('', 1)), 0, 7);

        if (!isset($mi->withtext)) {
            $mi->withtext = 0;
        }

        // Set parameters
        if (isset($mi->clientid) && strlen($mi->clientid) && $mi->clientid != '0') {
            $mi->parameters['clientid'] = $this->options['clientid'] = $imgParams['clientid'] = "clientid=".$mi->clientid;
        }
        if (isset($mi->zoneid) && $mi->zoneid != '') {
            $mi->parameters['zoneid'] = $this->options['zoneid'] = $imgParams['zoneid'] = "zoneid=".urlencode($mi->zoneid);
        }
        if (isset($mi->campaignid) && strlen($mi->campaignid) && $mi->campaignid != '0') {
            $mi->parameters['campaignid'] = $this->options['campaignid'] = $imgParams['campaignid'] = "campaignid=".$mi->campaignid;
        }
        if (isset($mi->bannerid) && $mi->bannerid != '') {
            $mi->parameters['bannerid'] = $this->options['bannerid'] = $imgParams['bannerid'] = "bannerid=".urlencode($mi->bannerid);
        }
        if (isset($mi->what) && $mi->what != '') {
            $mi->parameters['what'] = $this->options['what'] = $imgParams['what'] = "what=".str_replace (",+", ",_", $mi->what);
        }
        if (isset($mi->source) && $mi->source != '') {
            $mi->parameters['source'] = $this->options['source'] = $imgParams['source'] = "source=".urlencode($mi->source);
        }
        if (isset($mi->target) && $mi->target != '') {
            $mi->parameters['target'] = $this->options['target'] = $imgParams['target'] = "target=".urlencode($mi->target);
        }
        if (isset($mi->charset) && $mi->charset != '') {
            $mi->parameters['charset'] = $this->options['charset'] = $imgParams['charset'] = "charset=".urlencode($mi->charset);
        }
        if (!empty($mi->cachebuster)) {
            $mi->parameters['cb'] = $this->options['cb'] = $imgParams['cb'] = "cb=" . $mi->macros['cachebuster'];
        }
        if (!empty($mi->thirdpartytrack)) {
           $mi->parameters['ct0'] = $this->options['ct0'] = $imgParams['ct0'] = "ct0=" . $mi->macros['clickurl'];
        }

        // Set $mi->buffer to the initial comment
        $name = (!empty($GLOBALS['_MAX']['PREF']['name'])) ? $GLOBALS['_MAX']['PREF']['name'] : MAX_PRODUCT_NAME;
        $buffer = '<!--/* '. $name .' '. $this->getName() . ' v' . OA_VERSION;
        if (!empty($thirdpartyname)) {
            $buffer .= " (".$thirdpartyname.")";
        }
        $buffer .= " */-->\n\n";

        if (!empty($mi->comments)) {
            $oTrans = new OX_Translation();
            $comment = '';
            if ((!empty($mi->cachebuster)) && ($mi->thirdpartytrack == 'generic' || $mi->thirdpartytrack === 0)) {
                if (isset($aComments['Cache Buster Comment'])) {
                    $cbComment = $aComments['Cache Buster Comment'];
                } else {
                    $cbComment = $GLOBALS['strCacheBusterComment'];
                }
                $comment .= str_replace('{random}', $mi->macros['cachebuster'], $cbComment);
            }
            if (isset($mi->thirdpartytrack) && ($mi->thirdpartytrack == 'generic' || $mi->thirdpartytrack === 0)) {
                if (isset($aComments['Third Party Comment'])) {
                    $clickurlComment = $aComments['Third Party Comment'];
                } else {
                    $clickurlComment = $GLOBALS['strThirdPartyComment'];
                }
                $clickurlComment = $aComments['Third Party Comment'];
                $comment .= str_replace('{clickurl}', $mi->macros['clickurl'], $clickurlComment);
            }
            //SSL Delivery Comment
            if (isset($aComments['SSL Delivery Comment'])) {
                $comment .= $aComments['SSL Delivery Comment'];
            } else {
                $comment .= $oTrans->translate('SSLDeliveryComment', array($conf['webpath']['delivery'], $conf['webpath']['deliverySSL']));
            }
            if (isset($aComments['SSL Backup Comment'])) {
                $comment .= $aComments['SSL Backup Comment'];
            } else {
                $comment .= $oTrans->translate('SSLBackupComment', array($conf['webpath']['delivery'], $conf['webpath']['deliverySSL']));
            }
            if (isset($aComments['Comment'])) {
                $comment .= $aComments['Comment'];
            }

            if ($comment != '') {
                $buffer .= "<!--/*" . $comment . "\n  */-->\n\n";
            }
        }
        $mi->buffer = $buffer;

        // Set $mi->backupImage to the HTML for the backup image (same as used by adview)
        $hrefParams = array();
        $uniqueid = 'a'.substr(md5(uniqid('', 1)), 0, 7);

        if ((isset($mi->bannerid)) && ($mi->bannerid != '')) {
            $hrefParams[] = "bannerid=".$mi->bannerid;
            $hrefParams[] = "zoneid=".$mi->zoneid;
        } else {
            $hrefParams[] = "n=".$uniqueid;
            $imgParams[] = "n=".$uniqueid;
        }
        if (!empty($mi->cachebuster) || !isset($mi->cachebuster)) {
            $hrefParams[] = "cb=" . $mi->macros['cachebuster'];
        }
        // Make sure that ct0= is the last element in the array
        unset($imgParams['ct0']);
        if (!empty($mi->thirdpartytrack)) {
           $imgParams[] = "ct0=" . $mi->macros['clickurl'];
        }
        $backup = "<a href='".MAX_commonConstructDeliveryUrl($conf['file']['click'])."?".implode("&amp;", $hrefParams)."'";

        if (isset($mi->target) && $mi->target != '') {
            $backup .= " target='".$mi->target."'";
        } else {
            $backup .= " target='_blank'";
        }
        $backup .= "><img src='".MAX_commonConstructDeliveryUrl($conf['file']['view']);
        // Remove any paramaters that should not be passed into the IMG call
        unset($imgParams['target']);

        if (sizeof($imgParams) > 0) {
            $backup .= "?".implode ("&amp;", $imgParams);
        }
        $backup .= "' border='0' alt='' /></a>";
        $mi->backupImage = $backup;

        // Make sure that the parameters being added are accepted by this plugin, else remove them
        foreach ($mi->parameters as $key => $value) {
            if (!in_array($key, array_keys($this->options))) {
                unset($mi->parameters[$key]);
            }
        }
    }

    /**
     * Generate all the options for plugin settings and return as HTML
     *
     * @param object $maxInvocation    MAX_Admin_Invocation object
     *
     * @return string
     */
    function generateOptions(&$maxInvocation)
    {
        $this->setInvocation($maxInvocation);

        // Here I would like to set commonOptions on the invocationTag option prior to calling getOptionList
        // This means that within the invocationTag option I can remove common options where necessary
        $this->defaultOptions = $maxInvocation->getDefaultOptionsList();
        $show = $this->getOptionsList($maxInvocation);
        $show += $this->defaultOptions;

        $invocationOptions = new Plugins_InvocationTagsOptions();
        $invocationOptions->setInvocation($maxInvocation);

        $htmlOptions = '';
        foreach($show as $optionToShow => $methodType) {
            if($methodType == MAX_PLUGINS_INVOCATION_TAGS_STANDARD) {
                if(!method_exists($invocationOptions, $optionToShow)) {
                    MAX::raiseError("Method '$optionToShow' doesn't exists");
                } else {
                    $htmlOptions .= $invocationOptions->$optionToShow();
                }
            } else {
                if(!method_exists($this, $optionToShow)) {
                    MAX::raiseError("Method '$optionToShow' doesn't exists");
                } else {
                    $htmlOptions .= $this->$optionToShow();
                }
            }
        }

        return $htmlOptions;
    }

}
