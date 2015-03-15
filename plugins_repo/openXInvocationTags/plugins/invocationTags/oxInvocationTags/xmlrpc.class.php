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

/**
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 */

require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_OxInvocationTags_xmlrpc extends Plugins_InvocationTags
{

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate("XML-RPC Tag");
    }

    /**
     * Return the English name of the plugin. Used when
     * generating translation keys based on the plugin
     * name.
     *
     * @return string An English string describing the class.
     */
    function getNameEN()
    {
        return 'XML-RPC Tag';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed($extra = null)
    {
        $isAllowed = parent::isAllowed($extra);
        return $isAllowed;
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    function getOptionsList()
    {
        $options = array (
            'spacer'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'what'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'campaignid'    => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'charset'       => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'withtext'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'block'         => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'blockcampaign' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'hostlanguage'  => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'xmlrpcproto'   => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'xmlrpctimeout' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'comments'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
        );

        return $options;
    }

    /**
     * Return invocation code for this plugin (codetype)
     *
     * @return string
     */
    function generateInvocationCode()
    {
        $aComments = array(
            'Cache Buster Comment' => '',
            'Third Party Comment'  => '',
            'SSL Delivery Comment' => '',
            'SSL Backup Comment'   => '',
            'Comment'              => '',
            );
        parent::prepareCommonInvocationData($aComments);

        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;

        if (!isset($mi->clientid) || $mi->clientid == '') {
            $mi->clientid = 0;
        }
        if (empty($mi->campaignid)) {
            $mi->campaignid = 0;
        }
        if ($mi->xmlrpcproto) {
            $mi->params = parse_url(MAX_commonConstructSecureDeliveryUrl($conf['file']['xmlrpc']));
        } else {
            $mi->params = parse_url(MAX_commonConstructDeliveryUrl($conf['file']['xmlrpc']));
        }
        if (!$mi->xmlrpctimeout) {
            $mi->timeout = 15;
        } else {
            $mi->timeout = $mi->xmlrpctimeout;
        }
        switch($mi->hostlanguage) {
            case 'php':
            default:
                if (!isset($mi->what) or ($mi->what == "")) {
                    // Need to generate the waht variable here
                    if (isset($mi->zoneid) and ($mi->zoneid != "")) {
                        $mi->what = "zone:" . $mi->zoneid;
                    }elseif (isset($mi->bannerid) and ($mi->bannerid != "")) {
                        $mi->what = "bannerid:" . $mi->bannerid;
                    }
                }

                if (!isset($mi->campaignid)) {
                    $mi->campaignid = 0;
                }

                $buffer .= "<"."?php\n /* " . str_replace(array("\n", '/*', '*/'), array('', '', ''), $mi->buffer);
                if (!isset($mi->comments) || ($mi->comments == "1")) {
                    $buffer .= "\n  *";
                    $buffer .= $this->translate("
  * As the PHP script below tries to set cookies, it must be called
  * before any output is sent to the user's browser. Once the script
  * has finished running, the HTML code needed to display the ad is
  * stored in the \$adArray array (so that multiple ads can be obtained
  * by using mulitple tags). Once all ads have been obtained, and all
  * cookies set, then you can send output to the user's browser, and
  * print out the contents of \$adArray where appropriate.
  *
  * Example code for printing from \$adArray is at the end of the tag -
  * you will need to remove this before using the tag in production.
  * Remember to ensure that the PEAR::XML-RPC package is installed
  * and available to this script, and to copy over the
  * lib/xmlrpc/php/openads-xmlrpc.inc.php library file. You may need to
  * alter the 'include_path' value immediately below.
  */");
                    $buffer .= "\n\n";
                } else {
                    $buffer .= "  */\n";
                }
                $buffer .= '    //ini_set(\'include_path\', \'.:/usr/local/lib\');' . "\n";
                $buffer .= '    require \'openads-xmlrpc.inc.php\';' . "\n\n";
                $buffer .= '    if (!isset($OA_context)) $OA_context = array();' . "\n\n";
                $buffer .= '    $oaXmlRpc = new OA_XmlRpc(\'' . $mi->params['host'] . '\', \'' . $mi->params['path'] . '\'';
                if (isset($mi->params['port'])) {
                    $buffer .= ', ' . $mi->params['port'] . '';
                } else {
                    $buffer .= ($mi->xmlrpcproto) ? ', 443' : ', 80';
                }
                if ($mi->xmlrpcproto) {
                    $buffer .= ', true';
                } else {
                    $buffer .= ', false';
                }
                $buffer .= ', ' . $mi->timeout . ');' . "\n";
                if (!empty($mi->comments)) {
                    $buffer .= "\n    //view(\$what='', \$campaignid=0, \$target='', \$source='', \$withText=false, \$context=array(), \$charset='')\n";
                }
                $buffer .= "    \$adArray = \$oaXmlRpc->view('{$mi->what}', {$mi->campaignid}, '{$mi->target}', '{$mi->source}', {$mi->withtext}, \$OA_context, '{$mi->charset}');\n";

                if (isset($mi->block) && $mi->block == '1') {
                    $buffer .= '    $OA_context[] = array(\'!=\' => \'bannerid:\'.$adArray[\'bannerid\']);' . "\n";
                }
                if (isset($mi->blockcampaign) && $mi->blockcampaign == '1') {
                    $buffer .= '    $OA_context[] = array(\'!=\' => \'campaignid:\'.$adArray[\'campaignid\']);' . "\n";
                }
                $buffer .= "\n";
                $buffer .= '    echo $adArray[\'html\'];' . "\n";
                $buffer .= "?".">\n";
                break;
        }

        return $buffer;
    }

}

?>