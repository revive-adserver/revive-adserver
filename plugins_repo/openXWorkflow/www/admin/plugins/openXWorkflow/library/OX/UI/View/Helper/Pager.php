<?php

class OX_UI_View_Helper_Pager 
{
    public static function pager(Zend_Paginator $paginator, $simple = true, 
        $scrollingStyle = 'Sliding',  $pagerAction = null, $pagerController = null,
        $pagerModule = null,  $pagerUrlParams = null, $entitiesName = null)
    {
        $script =  $simple ? 'pager-controls-light.html' : 'pager-controls.html';

        $view = Zend_Registry::getInstance()->get("smartyView");
        $oPaginationHelper = $view->getHelper('PaginationControl');
        
        $aParams = array(
            'pagerAction' => $pagerAction,
            'pagerController' => $pagerController,
            'pagerModule' => $pagerModule,
            'pagerParams' => $pagerUrlParams,
            'entitiesName' => $entitiesName);
        
        return $oPaginationHelper->paginationControl($paginator, $scrollingStyle, $script, $aParams);  
    }
}
