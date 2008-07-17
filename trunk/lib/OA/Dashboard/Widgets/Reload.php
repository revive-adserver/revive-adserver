<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
            $url = $this->buildDashboardUrl($m2mTicket, $this->buildUrl($this->aUrl));

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

        $aErrors = array(
            -1 => 'Test'
        );

        $errorMessage = $oError->getMessage();

        if (isset($aErrors[$oError->getCode()])) {
            $errorMessage = $aErrors[$oError->getCode()];
        } elseif (empty($errorMessage)) {
            $errorMessage = 'Generic error';
        }

        $oTpl->assign('errorCode', $oError->getCode());
        $oTpl->assign('errorMessage', $errorMessage);

        $oTpl->display();
    }
}

?>