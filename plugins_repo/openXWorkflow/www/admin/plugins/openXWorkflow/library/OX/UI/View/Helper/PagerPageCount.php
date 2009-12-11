<?php

class OX_UI_View_Helper_PagerPageCount 
{
    public static function pagerPageCount(Zend_Paginator $paginator, $scrollingStyle = 'Sliding')
    {
        $ret = $paginator->getPages($scrollingStyle);
        return $ret->pageCount;  
    }
}
