<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
     * @var OA_Admin_Template
     */
    var $oTpl;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @param string $title
     * @param string $url
     * @param int $posts
     * @return OA_Dashboard_Widget_Feed
     */
    function OA_Dashboard_Widget_Feed($aParams, $title, $url, $posts = 6, $siteTitle = null, $siteUrl = null)
    {
        parent::OA_Dashboard_Widget($aParams);

        $this->title = $title;
        $this->url   = $url;
        $this->posts = $posts;
        $this->siteTitle = $siteTitle;
        $this->siteUrl   = $siteUrl;

        $this->oTpl = new OA_Admin_Template('dashboard/feed.html');

        $this->oTpl->setCacheId($this->title);
        $this->oTpl->setCacheLifetime(new Date_Span('0-1-0-0'));
    }

    /**
     * A method to launch and display the widget
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     */
    function display()
    {
        if (!$this->oTpl->is_cached()) {
            OA::disableErrorHandling();
            $oRss =& new XML_RSS($this->url);
            $result = $oRss->parse();
            OA::enableErrorHandling();

            // ignore bad character error which could appear if rss is using invalid characters
            if (PEAR::isError($result)) {
                if (!strstr($result->getMessage(), 'Invalid character')) {
                    PEAR::raiseError($result); // rethrow
                    $this->oTpl->caching = false;
                }
            }

            $aPost = array_slice($oRss->getItems(), 0, $this->posts);
            foreach ($aPost as $key => $aValue) {
                $aPost[$key]['origTitle'] = $aValue['title'];
                if (strlen($aValue['title']) > 38) {
                    $aPost[$key]['title'] = substr($aValue['title'], 0, 38) .'...';
                }
            }
            $this->oTpl->assign('title', $this->title);
            $this->oTpl->assign('feed', $aPost);
            $this->oTpl->assign('siteTitle', $this->siteTitle);
            $this->oTpl->assign('siteUrl', $this->siteUrl);
        }

        $this->oTpl->display();
    }
}
?>