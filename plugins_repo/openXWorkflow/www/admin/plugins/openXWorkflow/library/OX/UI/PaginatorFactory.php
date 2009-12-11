<?php

/**
 * A factory for preconfigured Zend paginator used to create consistent pagers.
 * Uses standard 'page' parameter for page numbers
 */
class OX_UI_PaginatorFactory
{
    /**
     * Factory. Calls Zend_Paginator factory. Ad in addition setups some default 
     * parameters like page number to display, current page parameter extraction
     * from request ('page' by default)
     *
     * @param  array $data
     * @return Zend_Paginator
     */
    public static function factory($data, $itemsPerPage = 10)
    {
        $oPaginator = Zend_Paginator::factory($data);
        $oPaginator->setPageRange(5);        
        $oPaginator->setItemCountPerPage($itemsPerPage);
        
        $page = Zend_Controller_Front::getInstance()->getRequest()->getParam('page'); 
        if (empty($page) || !is_numeric($page)) {
            $page = 1;
        }
        $oPaginator->setCurrentPageNumber($page);        
        
        return $oPaginator;
    }
}
