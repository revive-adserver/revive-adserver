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

require_once MAX_PATH . '/lib/OA.php';
require_once LIB_PATH . '/Extension/bannerTypeHtml/bannerTypeHtml.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 * @abstract
 */
class Plugins_BannerTypeHTML_oxHtml_genericHtml extends Plugins_BannerTypeHTML
{
    /**
     * Return type of plugin
     *
     * @return string A string describing the type of plugin.
     */
    function getOptionDescription()
    {
        return $this->translate("Generic HTML Banner");
    }

    function buildForm(&$form, &$row)
    {
        parent::buildForm($form, $row);
    }

}

?>
