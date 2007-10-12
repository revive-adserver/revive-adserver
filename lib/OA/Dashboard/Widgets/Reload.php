<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';

/**
 * A class to reload client parent frame in case user is not authenticated anymore
 *
 * @author Radek Maciaszek
 */
class OA_Dashboard_Widget_Reload extends OA_Dashboard_Widget
{
    var $url = null;

    function OA_Dashboard_Widget_Reload($aParams)
    {
        $this->widgetName = isset($aParams['widget']) ? stripslashes($aParams['widget']) : '';
        //MAX_Admin_Redirect::redirect('ssoProxy.php?url='.urlencode($url));
    }
    
    function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * A method to launch and display the widget
     *
     */
    function display()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $oTpl = new OA_Admin_Template('dashboard/reload.html');

        $oTpl->assign('url', $this->url);
        $oTpl->assign('timeoutMs', 1);
        $oTpl->display();
    }
}

?>