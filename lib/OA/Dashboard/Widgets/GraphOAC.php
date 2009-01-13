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

require_once MAX_PATH . '/lib/OA/Dashboard/Graph.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/Factory.php';
require_once MAX_PATH . '/lib/OA/Central/Dashboard.php';

/**
 * A dashboard widget to diplay the community statistics graph.
 *
 */
class OA_Dashboard_Widget_GraphOAC extends OA_Dashboard_Widget_Graph
{
    function OA_Dashboard_Widget_GraphOAC($aParams)
    {
        parent::OA_Dashboard_Widget_Graph($aParams);

        $this->oTpl->setCacheLifetime(new Date_Span('0-8-0-0'));

        if (!$this->oTpl->is_cached()) {
            $oDashboard = new OA_Central_Dashboard();

            if ($aData = $oDashboard->getCommunityStats()) {
                $this->setData($aData);
            }
        }
    }
}

?>