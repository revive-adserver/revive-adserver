<?php

/**
 * A helper that outputs the base for application-relative URLs.
 */
class OX_UI_View_Helper_UrlBase
{
    private $view;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }

    public static function urlBase($absolute = false)
    {
        $front = Zend_Controller_Front::getInstance();
        return ($absolute ? OX_UI_View_Helper_ActionUrl::getAbsoluteUrlPrefix() : '') . 
            $front->getBaseUrl();
    }
}
