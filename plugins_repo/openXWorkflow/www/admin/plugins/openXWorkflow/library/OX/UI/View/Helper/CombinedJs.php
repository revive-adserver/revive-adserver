<?php

/**
 * 
 */
class OX_UI_View_Helper_CombinedJs
{
    public static function combinedJs($groupId, $placement = 'append')
    {
        $headScript = new Zend_View_Helper_HeadScript();
        
        if (OX_Common_Config::isCombineAssets()) {
            $headScript->headScript(Zend_View_Helper_HeadScript::FILE, OX_UI_Minify_UrlGenerator::groupUrl($groupId), $placement);
        }
        else {
            global $MINIFY_JS_GROUPS;
            $group = $MINIFY_JS_GROUPS[$groupId];
            if ($placement == 'prepend') {
                $group = array_reverse($group);
            }
            foreach ($group as $entry) {
                $headScript->headScript(Zend_View_Helper_HeadScript::FILE, Zend_Controller_Front::getInstance()->getBaseUrl() . '/' . $entry, $placement);
            }
        }
    }
}
