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
class Plugins_InvocationTags_OxInvocationTags_async extends Plugins_InvocationTags implements \RV\Extension\InvocationTags\WebsiteInvocationInterface
{
    /**
     * Set default values for options used by this plugin
     *
     * @var array Array of $key => $defaultValue
     */
    private $defaultOptionValues = [
        'block' => 0,
        'blockcampaign' => 0,
        'target' => '',
        'source' => '',
    ];

    /**
     * Return name of plugin
     *
     * @return string
     */
    public function getName()
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
    public function getNameEN()
    {
        return 'Asynchronous JS Tag';
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    public function isAllowed($extra = null)
    {
        $isAllowed = parent::isAllowed($extra);
        return $isAllowed;
    }

    public function getOrder()
    {
        parent::getOrder();
        return 0;
    }

    /**
     * Return list of options
     *
     * @return array    Group of options
     */
    public function getOptionsList()
    {
        if (is_array($this->defaultOptions)) {
            unset($this->defaultOptions['cacheBuster']);
            unset($this->defaultOptions['comments']);
            unset($this->defaultOptions['https']);
        }
        $options = [
            'block' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'blockcampaign' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
        ];

        return $options;
    }

    /**
     * Return invocation code for this plugin (codetype)
     *
     * @return string
     */
    public function generateInvocationCode()
    {
        $aComments = [
            'Comment' => "",
        ];
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
        $mi->parameters['id'] = 'id=' . md5("{$conf['webpath']['delivery']}*{$conf['webpath']['deliverySSL']}");

        // Remap as tag attributes with data-revive prefix
        $mi->parameters = array_map(function ($v) use ($conf) {
            return preg_replace('#^(.*)=(.*)$#', 'data-' . $conf['var']['product'] . '-$1="$2"', $v);
        }, $mi->parameters);

        $buffer .= '<ins ' . join(' ', $mi->parameters) . '></ins>' . PHP_EOL;
        if ($conf['webpath']['delivery'] === $conf['webpath']['deliverySSL']) {
            // Yes, we can use the short version!
            $buffer .= '<script async src="' . MAX_commonConstructPartialDeliveryUrl($conf['file']['asyncjs']) . '"></script>';
        } else {
            // Bummer, we need the longer variant
            $url = [
                MAX_commonConstructDeliveryUrl($conf['file']['asyncjs']),
                MAX_commonConstructSecureDeliveryUrl($conf['file']['asyncjs']),
            ];
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

    public function setInvocation(&$invocation)
    {
        $this->maxInvocation = &$invocation;
        $this->maxInvocation->canDetectCharset = true;
    }

    public function generateWebsiteInvocationCode(): string
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['CONF'];

        $mi = &$this->maxInvocation;

        // Get the affiliate information
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if ($doAffiliates->get($mi->affiliateid)) {
            $affiliate = $doAffiliates->toArray();
        }
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = $mi->affiliateid;
        $doZones->find();
        while ($doZones->fetch() && $row = $doZones->toArray()) {
            // Email/Newsletter and DHTML and Video zones are not included in SPC
            if ($row['delivery'] != MAX_ZoneEmail
                && $row['delivery'] != phpAds_ZoneInterstitial
                && $row['delivery'] != OX_ZoneVideoInstream
                && $row['delivery'] != OX_ZoneVideoOverlay) {
                $aZones[] = $row;
            }
        }

        if (empty($aZones)) {
            return 'No Zones Available!';
        }


        $channel = (!empty($mi->source)) ? $mi->source : $affiliate['mnemonic'] . "/test/preview";

        $script = "<?xml version='1.0' encoding='UTF-8' ?><!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>
    <title>Tags for [id{$affiliate['affiliateid']}] " . htmlspecialchars($affiliate['name']) . "</title>
        <link rel='stylesheet' type='text/css' href='" . OX::assetPath() . "/css/preview.css' />
        <script type='text/javascript' src='" . OX::assetPath() . "/js/jquery-1.2.3.js'></script>

        <script type='text/javascript'>
        <!--

            function selectElement() {
                if (window.getSelection) {
                    var r = document.createRange();
                    r.selectNodeContents($(this)[0]);
                    var s = window.getSelection();
                    if (s.rangeCount) {
                        s.collapseToStart();
                        s.removeAllRanges();
                    }
                    s.addRange(r);
                } else if (document.body.createTextRange) {
                    var r = document.body.createTextRange();
                    r.moveToElementText($(this)[0]);
                    r.select();
                }
            }

            $(document).ready(function() {
                $('pre').bind('mousedown', selectElement);
                $('pre').bind('click', selectElement);
                $('pre').bind('mousemove', selectElement);

                $('#closeWindow').click(function() {
                    window.close();
                });
            });

        //-->
        </script>
    </head>

    <body class='invocationCodes'>
        <div class='header'>
            <h1>" . PRODUCT_NAME . "</h1>
        </div>
        ";

        $script .= "
        <div class='settings'>
            <h2>Tags <small>for <span class='inlinePublisher'>[id{$affiliate['affiliateid']}] " . htmlspecialchars($affiliate['name']) . "</span></small></h2>
            <p>
                This page contains all the information you need to show banners on your website.
                Please follow the instructions carefully and ensure that you copied the scripts <strong>exactly</strong> as shown below.
            </p>

            <h3>The following settings were used to generate this page:</h3>
            <table class='horizontalSummary' summary=''>
        ";

        reset($this->defaultOptionValues);
        foreach ($this->defaultOptionValues as $feature => $default) {
            switch ($feature) {
                case 'block':
                    $optionName = $GLOBALS['strInvocationDontShowAgain'];
                    $optionValue = intval($mi->$feature) ? $GLOBALS['strYes'] : $GLOBALS['strNo'];
                    break;
                case 'blockcampaign':
                    $optionName = $GLOBALS['strInvocationDontShowAgainCampaign'];
                    $optionValue = intval($mi->$feature) ? $GLOBALS['strYes'] : $GLOBALS['strNo'];
                    break;
                case 'target':
                    $optionName = $GLOBALS['strInvocationTarget'];
                    switch ($mi->$feature) {
                        case '_blank':  $optionValue = 'New window'; break;
                        case '_top':    $optionValue = 'Same window'; break;
                        default:        $optionValue = $GLOBALS['strDefault']; break;
                    }
                    break;
                case 'source':
                    $optionName = $GLOBALS['strInvocationSource'];
                    $optionValue = $mi->$feature != '' ? htmlspecialchars(stripslashes($mi->$feature)) : '-';
                    break;
                default:
                    $optionName = $feature;
                    $optionValue = htmlspecialchars(stripslashes($mi->$feature));
                    break;
            }

            $script .= "
                <tr>
                    <th>{$optionName}</th>
                    <td>{$optionValue}</td>
                </tr>
            ";
        }

        $script .= "
            </table>
        </div>
        ";

        $i = 1;
        foreach ($aZones as $zone) {
            $codeblock = $this->getZoneCode($zone, $affiliate);

            $inlineZoneClass = $zone['delivery'] == phpAds_ZoneText ? 'textZone' : '';

            $script .= "
        <div class='step'>
            <h2>
                <div class='number'><span>{$i}</span></div>
                Ad script <small>for <span class='inlineZone {$inlineZoneClass}'>[id{$zone['zoneid']}] " . htmlspecialchars($zone['zonename']) . "</span></small>
            </h2>
            <p>
                Copy the following script and place it in the site where you want the ad to display:
            </p>

            <pre>" . htmlspecialchars($codeblock) . "</pre>
                ";

            if ($zone['delivery'] == phpAds_ZoneBanner) {
                $script .= "
            <p>
                Example" . ($zone['width'] == -1 || $zone['height'] == -1 ? ' (actual size may vary)' : '') . ":
            </p>
            ";
                $width = $zone['width'] > -1 ? $zone['width'] : 150;
                $widthLabel = $zone['width'] > -1 ? $zone['width'] : '*';

                $height = $zone['height'] > -1 ? $zone['height'] : 150;
                $heightLabel = $zone['height'] > -1 ? $zone['height'] : '*';

                $customClass = [];

                if ($zone['width'] == -1 && $zone['height'] == -1) {
                    $customClass[] = 'customBoth';
                } elseif ($zone['height'] == -1) {
                    $customClass[] = 'customHeight';
                } elseif ($zone['width'] == -1) {
                    $customClass[] = 'customWidth';
                }

                // Labels are roughly 80 x 30 pixels...
                // width < 80 || height < 30 => No room for even a single label, drop the OpenX logo and show the size outside
                // width < 160 && height < 60   => No room for both labels... drop the OpenX logo
                if (($zone['width'] > -1 && $zone['width'] < 80) || ($zone['height'] > -1 && $zone['height'] < 30)) {
                    $customClass[] = 'labelsMicro';
                } elseif ($zone['width'] > -1 && $zone['width'] < 160 && $zone['height'] > -1 && $zone['height'] < 60) {
                    $customClass[] = 'labelsMini';
                }

                $script .= "
            <div class='sizePreview " . (count($customClass) ? ' ' . implode(' ', $customClass) : '') . "' style='width: {$width}px; height: {$height}px;'>
                <img src='" . OX::assetPath() . "/images/logo-adserver-small.png' alt='' />
                <span>{$widthLabel} x {$heightLabel}</span>
            </div>
                ";
            }

            $script .= "
        </div>
            ";

            $i++;
        }

        $script .= "
        <div class='step'>
            <h2>
                <div class='number'><span>{$i}</span></div>
                Done
            </h2>
            <p>
                Banners should now appear on your website
            </p>

            <button id='closeWindow'><img src='" . OX::assetPath() . "/images/cross.png' alt='' />Close this window</button>
        </div>
    </body>
</html>
        ";

        return $script;
    }

    public function isWebsiteDefault(): bool
    {
        return true;
    }

    private function getZoneCode($zone, $affiliate, $zoneAlias = null): string
    {
        $mi = &$this->maxInvocation;
        $conf = $GLOBALS['_MAX']['CONF'];

        $zone['n'] = $affiliate['mnemonic'] . substr(md5(uniqid('', 1)), 0, 7);

        $mi->zoneid = $zone['zoneid'];

        return $this->generateInvocationCode();
    }
}
