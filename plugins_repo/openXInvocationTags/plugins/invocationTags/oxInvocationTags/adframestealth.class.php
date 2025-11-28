<?php

/**
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 *
 */

require_once LIB_PATH . '/Extension/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

class Plugins_InvocationTags_OxInvocationTags_adframestealth extends Plugins_InvocationTags
{
    public function getName()
    {
        return $this->translate("iFrame (Stealth Mode)");
    }

    public function getNameEN()
    {
        return 'iFrame (Stealth Mode)';
    }

    public function getOrder()
    {
        return 4;
    }

    public function isAllowed($extra = null)
    {
        if ((is_array($extra) && $extra['delivery'] == phpAds_ZoneText)) {
            return false;
        }
        return true; 
    }

    public function getOptionsList()
    {
        return [
            'spacer' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'refresh' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'size' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'transparent' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'responsive' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
        ];
    }

    public function generateInvocationCode()
    {
        $aComments = ['Comment' => "Stealth Mode: Loads content via 'widget.html'."];
        parent::prepareCommonInvocationData($aComments); 

        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;
        $buffer = $mi->buffer;
        
        $uniqueid = 'widget-' . substr(md5(uniqid('', 1)), 0, 7);

        if (isset($mi->refresh) && $mi->refresh != '') {
            $mi->parameters['refresh'] = "refresh=" . $mi->refresh;
        }
        
        $responsiveEnabled = isset($mi->responsive) && ($mi->responsive === '1' || $mi->responsive === 1);
        
        unset($mi->parameters['responsive']);
        if ($responsiveEnabled) {
            $mi->parameters['responsive'] = "responsive=1";
        }
        if (isset($mi->parameters['responsive']) && $mi->parameters['responsive'] === 'responsive=1') {
            $responsiveEnabled = true;
        }

        if (empty($mi->frame_width)) $mi->frame_width = $mi->width;
        if (empty($mi->frame_height)) $mi->frame_height = $mi->height;

        // Build base URL for stealth paths
        $baseUrl = $conf['webpath']['delivery'];
        $baseUrl = str_replace('/delivery', '', $baseUrl);
        if (substr($baseUrl, 0, 4) !== 'http' && substr($baseUrl, 0, 2) !== '//') {
            $baseUrl = '//' . $baseUrl;
        }
        
        // Construct stealth frame URL
        $frameUrl = $baseUrl . "/assets/frames/widget.html";

        // Generate stealth backup image with stealth URLs
        // Override the backup image from parent class to use stealth URLs
        $hrefParams = [];
        $backupUniqueid = 'a' . substr(md5(uniqid('', 1)), 0, 7);

        if ((isset($mi->bannerid)) && ($mi->bannerid != '')) {
            $hrefParams[] = "bannerid=" . $mi->bannerid;
            $hrefParams[] = "zoneid=" . $mi->zoneid;
            $imgParams = ["zoneid=" . $mi->zoneid];
        } else {
            $hrefParams[] = "n=" . $backupUniqueid;
            $imgParams = ["n=" . $backupUniqueid];
        }
        if (!empty($mi->cachebuster) || !isset($mi->cachebuster)) {
            $hrefParams[] = "cb=" . $mi->macros['cachebuster'];
        }

        // Use stealth URLs: /assets/go for clicks, /assets/view.gif for views
        $clickUrl = $baseUrl . "/assets/go?" . implode("&amp;", $hrefParams);
        $viewUrl = $baseUrl . "/assets/view.gif";
        if ($imgParams !== []) {
            $viewUrl .= "?" . implode("&amp;", $imgParams);
        }

        $backupImage = "<a href='" . $clickUrl . "'";
        if (isset($mi->target) && $mi->target != '') {
            $backupImage .= " target='" . $mi->target . "'";
        } else {
            $backupImage .= " target='_blank'";
        }
        $backupImage .= "><img src='" . $viewUrl . "' border='0' alt='' /></a>";

        if ($responsiveEnabled) {
            // wrap iframe in responsive container
            $originalWidth = isset($mi->frame_width) && $mi->frame_width != '' && $mi->frame_width != '-1' ? $mi->frame_width : (isset($mi->width) && $mi->width != '' && $mi->width != '-1' ? $mi->width : '100%');
            $originalHeight = isset($mi->frame_height) && $mi->frame_height != '' && $mi->frame_height != '-1' ? $mi->frame_height : (isset($mi->height) && $mi->height != '' && $mi->height != '-1' ? $mi->height : 'auto');
            $buffer .= "<div class='responsive-content-wrapper' style='width:100%;max-width:" . $originalWidth . "px;height:" . ($originalHeight == 'auto' ? 'auto' : $originalHeight . 'px') . ";margin:0 auto;position:relative;overflow:hidden;'>";
        }
        
        $buffer .= "<iframe id='{$uniqueid}' name='{$uniqueid}' src='" . $frameUrl;
        if (count($mi->parameters) > 0) {
            $buffer .= "?" . implode("&amp;", $mi->parameters);
        }
        $buffer .= "' frameborder='0' scrolling='no'";
        if ($responsiveEnabled) {
            // set iframe to 100% width and height
            $buffer .= " style='width:100%;max-width:100%;height:100%;'";
        } else {
            // use fixed dimensions
            if (isset($mi->frame_width) && $mi->frame_width != '' && $mi->frame_width != '-1') {
                $buffer .= " width='" . $mi->frame_width . "'";
            }
            if (isset($mi->frame_height) && $mi->frame_height != '' && $mi->frame_height != '-1') {
                $buffer .= " height='" . $mi->frame_height . "'";
            }
        }
        if (isset($mi->transparent) && $mi->transparent == '1') {
            $buffer .= " allowtransparency='true'";
        }
        $buffer .= " allow='autoplay'>";
        $buffer .= $backupImage; 
        $buffer .= "</iframe>";
        
        if ($responsiveEnabled) {
            $buffer .= "</div>";
        }
        $buffer .= "\n";

        return $buffer;
    }
}
?>