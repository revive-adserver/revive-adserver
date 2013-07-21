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

class MAX_Dal_Admin_Channel extends MAX_Dal_Common
{
    var $table = 'channel';

    var $orderListName = array(
        'name' => 'name',
        'id'   => 'channelid'
    );

	function getChannelsAndAffiliates()
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableCh = $oDbh->quoteIdentifier($prefix.'channel',true);
        $tableAf = $oDbh->quoteIdentifier($prefix.'affiliates',true);
        $query = "
            SELECT
                ch.channelid,
                ch.affiliateid,
                ch.name,
                af.name AS affiliatename
            FROM
                {$tableCh} AS ch,
                {$tableAf} AS af
            WHERE
                af.affiliateid=ch.affiliateid
            ORDER BY ch.channelid
    ";

        return DBC::NewRecordSet($query);
    }

}

?>