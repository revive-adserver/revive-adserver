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

class MAX_Dal_Admin_Acls extends MAX_Dal_Common
{
    var $table = 'acls';

	/**
     * @param $findInSet string  Data to look after (eg 13)
     * @param $type string       Data type (eg Site:Channel)
     *
     * @return RecordSet
     * @access public
     */
    function getAclsByDataValueType($findInSet, $type)
    {
        $findInSet = "FIND_IN_SET(".DBC::makeLiteral($findInSet).", data)";
        $table = $this->oDbh->quoteIdentifier($this->getTablePrefix().'acls');
    	$query = "
            SELECT
                *,
                $findInSet
            FROM
                {$table}
            WHERE
                type = ".DBC::makeLiteral($type)."
                AND $findInSet > 0
        ";

        return DBC::NewRecordSet($query);
    }


    /**
     * Returns the record set for either 'acls' or 'acls_channels' table,
     * all records and rows.
     *
     * @param string $table Either 'acls' or 'acls_channels'
     * @return RecordSet
     */
    function &getRsAcls($table, $orderBy = false)
    {
        $table = $this->oDbh->quoteIdentifier($this->getTablePrefix().$table);
        $query = "
            SELECT
                *
            FROM
                {$table}";
        if ($orderBy) {
            $query .= " ORDER BY ".$this->oDbh->quoteIdentifier($orderBy);
        }
        return DBC::NewRecordSet($query);
    }
}

?>