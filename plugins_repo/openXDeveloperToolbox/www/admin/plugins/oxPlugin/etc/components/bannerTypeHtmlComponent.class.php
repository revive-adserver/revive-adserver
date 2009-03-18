<?php

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';
require_once LIB_PATH . '/Extension/bannerTypeText/bannerTypeText.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

class Plugins_BannerTypeHTML_{GROUP}_{GROUP}Component extends Plugins_BannerTypeText
{
    /**
     * Return type of plugin
     *
     * @return string A string describing the type of plugin.
     */
    function getOptionDescription()
    {
        return $this->translate("My HTML Banner");
    }

    function buildForm(&$form, &$row)
    {
        parent::buildForm($form, $row);
    }

}