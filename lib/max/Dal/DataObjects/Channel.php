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

    public $__table = 'channel';                         // table name
    public $channelid;                       // int(9)  not_null primary_key auto_increment
    public $agencyid;                        // int(9)  not_null
    public $affiliateid;                     // int(9)  not_null
    public $name;                            // string(255)  
    public $description;                     // string(255)  
    public $compiledlimitation;              // blob(65535)  not_null blob
    public $acl_plugins;                     // blob(65535)  blob
    public $active;                          // int(1)  
    public $comments;                        // blob(65535)  blob
    public $updated;                         // datetime(19)  not_null binary
    public $acls_updated;                    // datetime(19)  not_null binary

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
