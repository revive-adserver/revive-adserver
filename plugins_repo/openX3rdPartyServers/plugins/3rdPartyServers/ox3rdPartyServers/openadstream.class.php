<?php

/**
 * @package    OpenXPlugin
 * @subpackage 3rdPartyServers
 * @author     Pedro Faustino <pedro.faustino@247realmedia.com>
 *
 */

require_once LIB_PATH . '/Extension/3rdPartyServers/3rdPartyServers.php';

/**
 *
 * 3rdPartyServer plugin. Allow for generating different banner html cache
 *
 * @static
 */
class Plugins_3rdPartyServers_ox3rdPartyServers_openadstream extends Plugins_3rdPartyServers
{
    var $hasOutputMacros = true;
    var $clickurlMacro = '%%C%%?';
    var $cachebusterMacro = '%%RAND%%';

    /**
     * Return the name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('Rich Media - Open AdStream');
    }

    /**
     * Return plugin cache
     *
     * @return string
     */
    function getBannerCache($buffer, &$noScript)
    {
        $search  = array("/\[INSERT_RANDOM_NUMBER_HERE\]/i", "/\[INSERT_CLICK_URL_HERE\]/i");
        $replace = array("{random}", "{clickurl}");

        $buffer = preg_replace ($search, $replace, $buffer);
        $noScript[0] = preg_replace($search[0], $replace[0], $noScript[0]);

        return $buffer;
    }

}

?>
