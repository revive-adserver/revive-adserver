<?php

/**
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 *
 */

require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

class Plugins_InvocationTags_OxInvocationTags_asyncstealth extends Plugins_InvocationTags
{
    public function getName()
    {
        return $this->translate("Async JS (Stealth Mode)");
    }

    public function getNameEN()
    {
        return 'Async JS (Stealth Mode)';
    }

    public function getOrder()
    {
        return 2;
    }

    public function isAllowed($extra = null)
    {
        return true; 
    }

    public function getOptionsList()
    {
        return [
            'block' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
        ];
    }

    public function generateInvocationCode()
    {
        $aComments = [
            'Comment' => "Stealth Mode: Bypasses AdBlock filename detection.",
        ];
        parent::prepareCommonInvocationData($aComments);

        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;

        $buffer = $mi->buffer;

        if (isset($mi->block) && $mi->block == '1') $mi->parameters['block'] = "block=1";
        if (isset($mi->blockcampaign) && $mi->blockcampaign == '1') $mi->parameters['blockcampaign'] = "blockcampaign=1";
        unset($mi->parameters['cb']); 

        $systemId = md5("{$conf['webpath']['delivery']}*{$conf['webpath']['deliverySSL']}");
        $mi->parameters['id'] = "id=" . $systemId;

        // Remap parameters to data attributes
        // We change 'data-revive-' to 'data-content-' 
        // loader.php replaces 'revive-' with 'content-' in the JS, so the JS looks for 'data-content-id'
        $prefix = 'data-content-'; 
        
        $mi->parameters = array_map(fn($v) => preg_replace('#^(.*)=(.*)$#', $prefix . '$1="$2"', $v), $mi->parameters);


        // Construct the Stealth JS URL
        $baseUrl = $conf['webpath']['delivery'];
        $baseUrl = str_replace('/delivery', '', $baseUrl); 
        
        if (substr($baseUrl, 0, 4) !== 'http' && substr($baseUrl, 0, 2) !== '//') {
             $baseUrl = '//' . $baseUrl;
        }

        $jsUrl = $baseUrl . "/assets/js/lib.js";

        $buffer .= '<ins ' . implode(' ', $mi->parameters) . '></ins>' . PHP_EOL;
        $buffer .= '<script async src="' . $jsUrl . '"></script>';

        return $buffer;
    }
}
?>