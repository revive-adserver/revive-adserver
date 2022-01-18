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

require_once RV_PATH . '/lib/RV.php';

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
    public $maxInvocation;

    /**
     * Order in which the plugins should be displayed
     *
     * @var Integer
     */
    public static $order = 1;

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
    public function getName()
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
    public function getNameEN()
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
    public function getOptionsList()
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
    public function isAllowed($extra = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $settingString = 'isAllowed' . ucfirst($this->component);
        return isset($aConf[$this->group][$settingString]) ? $aConf[$this->group][$settingString] : false;
    }

    /**
     * Check if plugin has enough data to perform tag generation
     *
     * @return boolean
     */
    public function canGenerate()
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
    public function getHeaderHtml($maxInvocation, $extra)
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
    public function setInvocation(&$invocation)
    {
        $this->maxInvocation = &$invocation;
    }

    /**
     * Generate the invocation string
     *
     * @return string    Generated invocation string
     */
    public function generateInvocationCode()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Prepare data before generating the invocation code
     *
     * @param array $aComments Array of comments allowed keys: 'Cache Buster Comment', 'Third Party Comment',
     *                         'Comment'
     *
     */
    public function prepareCommonInvocationData($aComments)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;

        $mi->macros = [
            'cachebuster' => 'INSERT_RANDOM_NUMBER_HERE',
            'clickurl' => 'INSERT_ENCODED_CLICKURL_HERE',
        ];
        $mi->parameters = [];
        $imgParams = [];

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
            $mi->parameters['clientid'] = $this->options['clientid'] = $imgParams['clientid'] = "clientid=" . $mi->clientid;
        }
        if (isset($mi->zoneid) && $mi->zoneid != '') {
            $mi->parameters['zoneid'] = $this->options['zoneid'] = $imgParams['zoneid'] = "zoneid=" . urlencode($mi->zoneid);
        }
        if (isset($mi->campaignid) && strlen($mi->campaignid) && $mi->campaignid != '0') {
            $mi->parameters['campaignid'] = $this->options['campaignid'] = $imgParams['campaignid'] = "campaignid=" . $mi->campaignid;
        }
        if (isset($mi->bannerid) && $mi->bannerid != '') {
            $mi->parameters['bannerid'] = $this->options['bannerid'] = $imgParams['bannerid'] = "bannerid=" . urlencode($mi->bannerid);
        }
        if (isset($mi->what) && $mi->what != '') {
            $mi->parameters['what'] = $this->options['what'] = $imgParams['what'] = "what=" . str_replace(",+", ",_", $mi->what);
        }
        if (isset($mi->source) && $mi->source != '') {
            $mi->parameters['source'] = $this->options['source'] = $imgParams['source'] = "source=" . urlencode($mi->source);
        }
        if (isset($mi->target) && $mi->target != '') {
            $mi->parameters['target'] = $this->options['target'] = $imgParams['target'] = "target=" . urlencode($mi->target);
        }
        if (isset($mi->charset) && $mi->charset != '') {
            $mi->parameters['charset'] = $this->options['charset'] = $imgParams['charset'] = "charset=" . urlencode($mi->charset);
        }
        if (!empty($mi->cachebuster)) {
            $mi->parameters['cb'] = $this->options['cb'] = $imgParams['cb'] = "cb=" . $mi->macros['cachebuster'];
        }

        // Set $mi->buffer to the initial comment
        $name = PRODUCT_NAME;
        if (!empty($GLOBALS['_MAX']['CONF']['ui']['applicationName'])) {
            $name = $GLOBALS['_MAX']['CONF']['ui']['applicationName'];
        }

        $buffer = sprintf(
            "<!-- %s %s - Generated with %s v%s -->\n",
            $name,
            $this->getName(),
            PRODUCT_NAME,
            VERSION
        );

        if (!empty($mi->comments)) {
            $comment = '';
            if (!empty($mi->cachebuster)) {
                if (isset($aComments['Cache Buster Comment'])) {
                    $cbComment = $aComments['Cache Buster Comment'];
                } else {
                    $cbComment = $GLOBALS['strCacheBusterComment'];
                }
                $comment .= str_replace('{random}', $mi->macros['cachebuster'], $cbComment);
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
        $hrefParams = [];
        $uniqueid = 'a' . substr(md5(uniqid('', 1)), 0, 7);

        if ((isset($mi->bannerid)) && ($mi->bannerid != '')) {
            $hrefParams[] = "bannerid=" . $mi->bannerid;
            $hrefParams[] = "zoneid=" . $mi->zoneid;
        } else {
            $hrefParams[] = "n=" . $uniqueid;
            $imgParams[] = "n=" . $uniqueid;
        }
        if (!empty($mi->cachebuster) || !isset($mi->cachebuster)) {
            $hrefParams[] = "cb=" . $mi->macros['cachebuster'];
        }
        $backup = "<a href='" . MAX_commonConstructDeliveryUrl($conf['file']['click'], $mi->https) . "?" . implode("&amp;", $hrefParams) . "'";

        if (isset($mi->target) && $mi->target != '') {
            $backup .= " target='" . $mi->target . "'";
        } else {
            $backup .= " target='_blank'";
        }
        $backup .= "><img src='" . MAX_commonConstructDeliveryUrl($conf['file']['view'], $mi->https);
        // Remove any paramaters that should not be passed into the IMG call
        unset($imgParams['target']);

        if (sizeof($imgParams) > 0) {
            $backup .= "?" . implode("&amp;", $imgParams);
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
    public function generateOptions(&$maxInvocation)
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
        foreach ($show as $optionToShow => $methodType) {
            if ($methodType == MAX_PLUGINS_INVOCATION_TAGS_STANDARD) {
                if (!method_exists($invocationOptions, $optionToShow)) {
                    MAX::raiseError("Method '$optionToShow' doesn't exists");
                } else {
                    $htmlOptions .= $invocationOptions->$optionToShow();
                }
            } else {
                if (!method_exists($this, $optionToShow)) {
                    MAX::raiseError("Method '$optionToShow' doesn't exists");
                } else {
                    $htmlOptions .= $this->$optionToShow();
                }
            }
        }

        return $htmlOptions;
    }
}
