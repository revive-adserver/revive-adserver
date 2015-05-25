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
 *
 */

require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * Invocation tag plugin.
 *
 */
class Plugins_InvocationTags_OxInvocationTags_async extends Plugins_InvocationTags
{

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate("Asynchronous JS Tag");
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
        return 'Asynchronous JS Tag';
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

    function getOrder()
    {
        parent::getOrder();
        return 0;
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    function getOptionsList()
    {
        if (is_array($this->defaultOptions)) {
            if (in_array('cacheBuster', $this->defaultOptions)) {
                unset($this->defaultOptions['cacheBuster']);
            }
            if (in_array('comments', $this->defaultOptions)) {
                unset($this->defaultOptions['comments']);
            }
        }
        $options = array (
            'spacer'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'what'          => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'block'         => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'blockcampaign' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
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
            'SSL Backup Comment' => "",
            'SSL Delivery Comment' => "",
            'Comment'              => "",
        );
        parent::prepareCommonInvocationData($aComments);

        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;

        $buffer = $mi->buffer;

        if (isset($mi->block) && $mi->block == '1') {
            $mi->parameters['block'] = "block=1";
        }
        if (isset($mi->blockcampaign) && $mi->blockcampaign == '1') {
            $mi->parameters['blockcampaign'] = "blockcampaign=1";
        }

        // The cachebuster for async tags isn't needed
        unset($mi->parameters['cb']);

        // Add ID
        $mi->parameters['id'] = 'id='.md5("{$conf['webpath']['delivery']}*{$conf['webpath']['deliverySSL']}");

        // Remap as tag attributes with data-revive prefix
        $mi->parameters = array_map(function ($v) use ($conf) {
            return preg_replace('#^(.*)=(.*)$#', 'data-'.$conf['var']['product'].'-$1="$2"', $v);
        }, $mi->parameters);

        $buffer .= '<ins '.join(' ', $mi->parameters).'></ins>'.PHP_EOL;
        if ($conf['webpath']['delivery'] == $conf['webpath']['deliverySSL']) {
            // Yes, we can use the short version!
            $buffer .= '<script async src="'.MAX_commonConstructPartialDeliveryUrl($conf['file']['asyncjs']).'"></script>';
        } else {
            // Bummer, we need the longer variant
            $url = array(
                MAX_commonConstructDeliveryUrl($conf['file']['asyncjs']),
                MAX_commonConstructSecureDeliveryUrl($conf['file']['asyncjs']),
            );
            $buffer .= <<<EOF
<script>
(function () {
  var d = document, s = d.createElement('script'), p = d.location.protocol,
      i = d.getElementsByTagName('ins'), j = i[i.length-1];
  try {
    s.src = p === 'http:' ? '{$url[0]}' :
      '{$url[1]}';
    s.async = true; j.appendChild(s);
  } catch (e) {}
})();
</script>
EOF;
        }

        return $buffer;
    }

    function setInvocation(&$invocation) {
        $this->maxInvocation = &$invocation;
        $this->maxInvocation->canDetectCharset = true;
    }

}

?>
