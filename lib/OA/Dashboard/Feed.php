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
    function __construct($aParams, $title, $url, $posts = 6, $siteTitle = null, $siteUrl = null)
    {
        parent::__construct($aParams);

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
            $oRss = new XML_RSS($this->url);
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