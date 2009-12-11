<?php

/**
 * 
 */
class OX_UI_View_Helper_CombinedCss
{
    public static function combinedCss($groupId, $placement = 'append')
    {
        $headLink = new Zend_View_Helper_HeadLink();
        
        if (OX_Common_Config::isCombineAssets()) {
            self::outputStylesheet($headLink, OX_UI_Minify_UrlGenerator::groupUrl($groupId), $placement);
        }
        else {
            global $MINIFY_CSS_GROUPS;
            $group = $MINIFY_CSS_GROUPS[$groupId];
            if ($placement == 'prepend') {
                $group = array_reverse($group);
            }
            foreach ($group as $entry) {
                self::outputStylesheet($headLink, Zend_Controller_Front::getInstance()->getBaseUrl() . '/' . $entry, $placement);
            }
        }
    }


    private static function outputStylesheet($headLink, $url, $placement)
    {
        if ($placement == 'prepend') {
            $headLink->prependStylesheet($url);
        }
        else {
            $headLink->appendStylesheet($url);
        }
    }
}
