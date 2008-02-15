<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';

/**
 * This is the pattern from regex rule (see plugins_channel_delivery_rules table)
 * which will be replaced with domain name.
 */
define('MAX_PLUGINS_CHANNEL_DELIVERY_DOMAIN_REPLACE_NAME', 'DOMAIN_NAME');

/**
 * Plugins_ChannelDerivation is a common class for reading all the informations from channel files.
 *
 * @package    OpenXPlugin
 * @subpackage ChannelDerivation
 * @author     Radek Maciaszek <radek@m3.net>
 */
class Plugins_ChannelDerivation extends MAX_Plugin_Common
{
    var $cacheExpire;
    var $cachePath;

    function init() {
        // Plugin initialisation function

        // Read the plugin specific config file...
        $pluginConfig = MAX_Plugin::getConfig($this->module);
        $this->cacheExpire = $pluginConfig['cacheExpire'];
        $this->cachePath   = MAX_PATH . $pluginConfig['cachePath'];
    }

    /**
     * This method is looking for domain regex rule
     *
     * @abstract
     * @param string $domain
     * @return array
     */
    function getRulesByDomain($domain)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Return domain name from $referer url
     *
     * @param string $referer
     *
     * @return string
     */
    function retrieveDomainFromReferer($referer)
    {
        $parsedUrl = parse_url($referer);
        return isset($parsedUrl['host']) ? $parsedUrl['host'] : false;
    }

    /**
     * Return rule with default behaviour
     *
     * @return array
     */
    function getDefaultRule()
    {
        $defaultRule = array(
            'modifier' => '(other)/$1',
            'rule'     => '/^https?:\/\/(.*?)/i',
        );

        return $defaultRule;
    }

    /**
     * getDerivedSource() method is checking referer domain with regex rule and return as preg_replace
     *
     * @param string $referer
     *
     * @return string
     */
    function getDerivedSource($referer)
    {
        $domain = $this->retrieveDomainFromReferer($referer);
        if(!$domain) {
            return $referer;
        }
        $rules = $this->getRulesFromCacheByDomain($domain);
        if(!$rules) {
            $rules = array();
        }
        // add default rule as a last one
        $rules[] = $this->getDefaultRule();

        if($rules && is_array($rules)) {
            $derived_source = $referer;
            foreach ($rules as $rule) {
                $domain = str_replace('.', '\.', $domain);
                $rule['rule'] = str_replace(MAX_PLUGINS_CHANNEL_DELIVERY_DOMAIN_REPLACE_NAME, $domain, $rule['rule']);
                if (($derived_source = @preg_replace($rule['rule'], $rule['modifier'], $referer)) != $referer) {
                    return $derived_source;
                }
            }
        }
        return $referer;
    }

    /**
     * This method is looking for domain regex rules
     * (cache if exists else database)
     *
     * @param string $domain
     *
     * @return array
     */
    function getRulesFromCacheByDomain($domain, $doNotTestCacheValidity = false)
    {
        $options = MAX_Plugin::prepareCacheOptions($this->module, $this->package, $this->cachePath, $this->cacheExpire);

        $rules = $this->getCacheById($domain, $doNotTestCacheValidity, $options);
        if ($rules !== false) {
            return $rules;
        }
        $rules = $this->getRulesByDomain($domain);
        if (($rules === null) && (!$doNotTestCacheValidity)) {
            $rules = $this->getRulesFromCacheByDomain($domain, true);
        }
        $this->saveCache($rules, $domain, $options);

        return $rules;
    }

    /**
     * Return channelDerivation specific config file
     *
     * @param boolean $processSections      If true the configuration data is returned
     *                                      as one dimension array
     * @param boolean $commonPackageConfig  If true read the global plugin.conf.php file
     *                                      for specific package
     *
     * @return object                       Plugin object or false if any error occured
     *
     */
    function getConfig($processSections = false, $commonPackageConfig = true)
    {
        return parent::getConfig($processSections, $commonPackageConfig);
    }
}

?>