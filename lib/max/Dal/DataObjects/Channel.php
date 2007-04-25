<?php
/**
 * Table Definition for channel
 */

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once 'DB_DataObjectCommon.php';

class DataObjects_Channel extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'channel';                         // table name
    var $channelid;                       // int(9)  not_null primary_key auto_increment
    var $agencyid;                        // int(9)  not_null
    var $affiliateid;                     // int(9)  not_null
    var $name;                            // string(255)  
    var $description;                     // string(255)  
    var $compiledlimitation;              // blob(65535)  not_null blob
    var $acl_plugins;                     // blob(65535)  blob
    var $active;                          // int(1)  
    var $comments;                        // blob(65535)  blob
    var $updated;                         // datetime(19)  not_null binary
    var $acls_updated;                    // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Channel',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function delete($useWhere = false, $cascade = true)
    {
    	// find acls which uses this channels
    	$dalAcls = OA_Dal::factoryDAL('acls');
    	$rsChannel = $dalAcls->getAclsByDataValueType($this->channelid, 'Site:Channel');
    	$rsChannel->reset();
    	while ($rsChannel->next()) {
    		$channelIds = explode(',', $rsChannel->get('data'));
    		$channelIds = array_diff($channelIds, array($this->channelid));

    		$doAcl = DB_DataObject::factory('acls');
    		$doAcl->init();
    		$doAcl->bannerid = $rsChannel->get('bannerid');
    		$doAcl->executionorder = $rsChannel->get('executionorder');
    		if (!empty($channelIds)) {
	    		$doAcl->data = implode(',', $channelIds);
	    		$doAcl->update();
    		} else {
    			$doAcl->delete();
    		}
    	}

    	return parent::delete($useWhere, $cascade);
    }
}
