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

require_once MAX_PATH . '/lib/OA/Dashboard/Feed.php';

/**
 * A dashboard widget to diplay an RSS feed of the OpenX Forum
 *
 */
class OA_Dashboard_Widget_ForumFeed extends OA_Dashboard_Widget_Feed
{
    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @return OA_Dashboard_Widget_BlogFeed
     */
    function OA_Dashboard_Widget_ForumFeed($aParams)
    {
        parent::OA_Dashboard_Widget_Feed(
            $aParams,
            'Last 6 forum posts',
            'http://feeds.feedburner.com/OpenadsForum?format=xml',
            6,
            'Go to OpenX forum page',
            'http://' . OX_PRODUCT_FORUMURL
        );
    }
}

?>