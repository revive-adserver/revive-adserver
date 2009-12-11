<?php
/**
 * Sets P3P compact policy header to make IE accept third party cookies
 */
class OX_UI_Controller_Plugin_P3PPolicySetter 
    extends Zend_Controller_Plugin_Abstract
{
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $oResponse = $this->getResponse(); 
        $oResponse->setHeader("P3P", "CP=\"IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT\"");
    }
}