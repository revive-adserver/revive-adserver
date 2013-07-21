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

require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Trackers.php';

class MAX_Dal_Admin_Variables extends MAX_Dal_Common
{
    var $table = 'variables';

    function getTrackerVariables($zoneid, $affiliateid, $selectForAffiliate)
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableZ = $oDbh->quoteIdentifier($prefix.'zones',true);
        $tableAza = $oDbh->quoteIdentifier($prefix.'ad_zone_assoc',true);
        $tableB = $oDbh->quoteIdentifier($prefix.'banners',true);
        $tableCt = $oDbh->quoteIdentifier($prefix.'campaigns_trackers',true);
        $tableT = $oDbh->quoteIdentifier($prefix.'trackers',true);
        $tableV = $oDbh->quoteIdentifier($prefix.'variables',true);
        $tableVp = $oDbh->quoteIdentifier($prefix.'variable_publisher',true);


        $whereZoneAffiliate = empty($zoneid) ?
            "z.affiliateid = ".DBC::makeLiteral($affiliateid) :
            "z.zoneid = ".DBC::makeLiteral($zoneid);

        $query = "
            SELECT DISTINCT
                v.variableid AS variable_id,
                v.name AS variable_name,
                v.description AS variable_description,
                t.trackerid AS tracker_id,
                t.trackername AS tracker_name,
                t.description AS tracker_description
            FROM
                {$tableAza} aza JOIN
                {$tableZ} z ON (aza.zone_id = z.zoneid) JOIN
                {$tableB} b ON (aza.ad_id = b.bannerid) JOIN
                {$tableCt} ct USING (campaignid) JOIN
                {$tableT} t USING (trackerid) JOIN
                {$tableV} v USING (trackerid) LEFT JOIN
                {$tableVp} vp ON (vp.variable_id = v.variableid AND vp.publisher_id = z.affiliateid)
            WHERE
                {$whereZoneAffiliate} AND
                v.datatype = 'numeric'
            ";

        if($selectForAffiliate) {
            $query .= " AND (v.hidden = 'f' OR vp.visible = 1)";
        }

        return DBC::NewRecordSet($query);
    }

    /**
     * Update the variablecode for all variables linked to the given trackerId.
     *
     * @param int $trackerId the trackerId to update variables for.
     * @param string $variableMethod see DataObjects_Trackers.
     * @return boolean true on successful update, false otherwise.
     */
    public function updateVariableCode($trackerId, $variableMethod = null)
    {
        // Get all variables for this tracker.
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid = $trackerId;
        $doVariables->find();
        while ($doVariables->fetch()) {
            $doVariables->setCode($variableMethod);
            if (!$doVariables->update()) {
                return false;
            }
        }
        return true;
    }

}

?>