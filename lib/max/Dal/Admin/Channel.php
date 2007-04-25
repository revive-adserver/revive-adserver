<?php
/**
 * @since Openads v2.3.30-alpah - 20-Nov-2006
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

        $query = "
            SELECT
                ch.channelid,
                ch.affiliateid,
                ch.name,
                af.name AS affiliatename
            FROM
                {$prefix}channel AS ch,
                {$prefix}affiliates AS af
            WHERE
                af.affiliateid=ch.affiliateid
            ORDER BY ch.channelid
    ";
        
        return DBC::NewRecordSet($query);
    }
    
}

?>