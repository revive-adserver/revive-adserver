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
require_once 'XML/RSS.php';

/**
 * A dashboard widget to diplay an RSS feed
 *
 */
class OA_Dashboard_Widget_Feed extends OA_Dashboard_Widget
{
    var $url;
    var $title;
    var $posts;

    /**
     * The class constructor
     *
     * @param string $title
     * @param string $url
     * @param int $posts
     * @return OA_Dashboard_Widget_Feed
     */
    function OA_Dashboard_Widget_Feed($title, $url, $posts = 5)
    {
        parent::OA_Dashboard_Widget();

        $this->title = $title;
        $this->url   = $url;
        $this->posts = $posts;
    }

    /**
     * A method to launch and display the widget
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     */
    function display($aParams)
    {
        $oRss =& new XML_RSS($this->url);
        $oRss->parse();

        $oTpl = new OA_Admin_Template('dashboard-feed.html');

        $oTpl->assign('title', $this->title);
        $oTpl->assign('feed', array_slice($oRss->getItems(), 0, $this->posts));

        $oTpl->display();
    }
}

?>