<?php
/**
 * A helper for pager links. By default takes page name and uses current
 * request parameters and generates link to current module/controller action
 *
 */
class OX_UI_View_Helper_PagerUrl 
{
    /*
     * Creates an url for pager links. By default takes page name and uses current
     * request parameters and generates link to current module/controller action
     *
     * @param int $pageNum page number
     * @param string $pagerUrl custom pager url to be used
     * @param array $pagerUrlParams custom pager params
     * @return string
     */
    public static function pagerUrl($pageNum, $pagerAction = null, $pagerController = null,
        $pagerModule = null,  $pagerUrlParams = null)
    {
        $oRequest = Zend_Controller_Front::getInstance()->getRequest();
        $view = Zend_Registry::getInstance()->get("smartyView");
        
        $aUrlParams = array('page' => $pageNum);
        if (is_array($pagerUrlParams) && !empty($pagerUrlParams)) {
            $aUrlParams = array_merge($aUrlParams, $pagerUrlParams);
        }
        
        //generate url for current page if action not overriden        
        if (empty($pagerAction)) {
            $aUrlParams = array_merge(OX_UI_Controller_Request_RequestUtils::getNonFrameworkParams($oRequest), $aUrlParams);
            $oUrlHelper = $view->getHelper('Url');
            $url = $oUrlHelper->url($aUrlParams);
        }
        else {
            $oActionUrlHelper = $view->getHelper('ActionUrl');
            $url = $oActionUrlHelper->actionUrl($pagerAction, $pagerController, $pagerModule, $aUrlParams);
        }
        
        return $url;
    }
}
