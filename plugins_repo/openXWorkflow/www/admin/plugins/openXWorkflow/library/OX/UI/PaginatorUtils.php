<?php

/**
 * A utility class for paginators created with Factory
 */
class OX_UI_PaginatorUtils
{
    /**
     * Retrieves current page number (if any) from request. Returns null when
     * page number is not set.
     *
     * @return  int current page number or null if not set
     */
    public static function getCurrentPageNumber()
    {
        $page = Zend_Controller_Front::getInstance()->getRequest()->getParam('page'); 
        if (empty($page) || !is_numeric($page)) {
            $page = null;
        }
        
        return $page;
    }
}
