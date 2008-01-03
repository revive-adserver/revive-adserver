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

require_once MAX_PATH . '/lib/OA/Dashboard/Feed.php';

/**
 * A dashboard widget to diplay an RSS feed of the Openads Blog
 *
 */
class OA_Dashboard_Widget_BlogFeed extends OA_Dashboard_Widget_Feed
{
    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @return OA_Dashboard_Widget_BlogFeed
     */
    function OA_Dashboard_Widget_BlogFeed($aParams)
    {
        parent::OA_Dashboard_Widget_Feed(
            $aParams,
            'Last 5 blog posts',
            'http://feeds.feedburner.com/OpenadsBlog?format=xml',
            7,
            'Go to Openads news page',
            'http://blog.openads.org'
        );
    }
}

?>