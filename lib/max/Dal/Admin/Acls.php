<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
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
        $prefix = $this->getTablePrefix();
    	$query = "
            SELECT
                *,
                $findInSet
            FROM 
                {$prefix}acls
            WHERE
                type = ".DBC::makeLiteral($type)."
                AND $findInSet > 0
        ";
        
        return DBC::NewRecordSet($query);
    }
}

?>