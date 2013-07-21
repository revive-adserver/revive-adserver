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