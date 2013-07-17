<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Dashboard/Widget.php';
require_once MAX_PATH . '/lib/OA/Central/Dashboard.php';

/**
 * A class to display the dashboard iframe content
 *
 */
class OA_Dashboard_Widget_Reload extends OA_Dashboard_Widget
{
    var $aUrl;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @return OA_Dashboard_Widget
     */
    function OA_Dashboard_Widget_Reload($aParams)
    {
        parent::OA_Dashboard_Widget($aParams);

        if (isset($aParams['url'])) {
            if ($aUrl = @parse_url(stripslashes($aParams['url']))) {
                $aUrl['protocol'] = $aUrl['scheme'];
                if (empty($aUrl['path'])) {
                    $aUrl['path'] = '/';
                }
                if (!empty($aUrl['query'])) {
                    $aUrl['path'] .= '?'.$aUrl['query'];
                }
                $this->aUrl = $aUrl;
            }
        }

        if (empty($this->aUrl)) {
            $this->aUrl = $GLOBALS['_MAX']['CONF']['oacDashboard'];
        }
    }

    /**
     * A method to launch and display the widget
     *
     */
    function display()
    {

        $oDashboard = new OA_Central_Dashboard();
        $m2mTicket = $oDashboard->getM2MTicket();
        if (PEAR::isError($m2mTicket)) {
            $this->showError($m2mTicket);
        } else {
            $url = $this->buildDashboardUrl($m2mTicket, $this->buildUrl($this->aUrl), '&');

            if (!preg_match('/[\r\n]/', $url)) {
                header("Location: {$url}");
            }
        }
    }

    /**
     * A method to display an M2M/Dashboard error
     *
     * @param PEAR_Error $oError
     */
    function showError($oError)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $oTpl = new OA_Admin_Template('dashboard/error.html');

        $errorCode = $oError->getCode();
        $nativeErrorMessage = $oError->getMessage();
        
        // Set error message
        if (isset($GLOBALS['strDashboardErrorMsg'.$errorCode])) {
            $errorMessage = $GLOBALS['strDashboardErrorMsg'.$errorCode];
        } else if (!empty($nativeErrorMessage)) {
            $errorMessage = $nativeErrorMessage;
            // Don't show this message twice on error page
            unset($nativeErrorMessage); 
        } else {
            $errorMessage = $GLOBALS['strDashboardGenericError'];
        }
        // Set error description
        if (isset($GLOBALS['strDashboardErrorDsc'.$errorCode])) {
            $errorDescription = $GLOBALS['strDashboardErrorDsc'.$errorCode];
        }

        $oTpl->assign('errorCode', $errorCode);
        $oTpl->assign('errorMessage', $errorMessage);
        $oTpl->assign('systemMessage', $nativeErrorMessage);
        $oTpl->assign('errorDescription', $errorDescription);

        $oTpl->display();
    }
}

?>