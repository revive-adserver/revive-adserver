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

require_once MAX_PATH . '/lib/OA/Upgrade/Migration.php';

// following does not seem to be required?
//require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';
//require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';
//require_once MAX_PATH . '/lib/wact/db/db.inc.php';

class Migration_124 extends Migration
{
    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__banners__campaignid';
		$this->aTaskList_constructive[] = 'afterAddField__banners__campaignid';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__adserver';
		$this->aTaskList_constructive[] = 'afterAddField__banners__adserver';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__session_capping';
		$this->aTaskList_constructive[] = 'afterAddField__banners__session_capping';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__acl_plugins';
		$this->aTaskList_constructive[] = 'afterAddField__banners__acl_plugins';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__alt_filename';
		$this->aTaskList_constructive[] = 'afterAddField__banners__alt_filename';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__alt_imageurl';
		$this->aTaskList_constructive[] = 'afterAddField__banners__alt_imageurl';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__alt_contenttype';
		$this->aTaskList_constructive[] = 'afterAddField__banners__alt_contenttype';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__comments';
		$this->aTaskList_constructive[] = 'afterAddField__banners__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__updated';
		$this->aTaskList_constructive[] = 'afterAddField__banners__updated';
		$this->aTaskList_constructive[] = 'beforeAlterField__banners__target';
		$this->aTaskList_constructive[] = 'afterAlterField__banners__target';
		$this->aTaskList_constructive[] = 'beforeAlterField__banners__url';
		$this->aTaskList_constructive[] = 'afterAlterField__banners__url';
		$this->aTaskList_destructive[] = 'beforeRemoveField__banners__clientid';
		$this->aTaskList_destructive[] = 'afterRemoveField__banners__clientid';
		$this->aTaskList_destructive[] = 'beforeRemoveField__banners__priority';
		$this->aTaskList_destructive[] = 'afterRemoveField__banners__priority';


		$this->aObjectMap['banners']['campaignid'] = array('fromTable'=>'banners', 'fromField'=>'campaignid');
		$this->aObjectMap['banners']['adserver'] = array('fromTable'=>'banners', 'fromField'=>'adserver');
		$this->aObjectMap['banners']['session_capping'] = array('fromTable'=>'banners', 'fromField'=>'session_capping');
		$this->aObjectMap['banners']['acl_plugins'] = array('fromTable'=>'banners', 'fromField'=>'acl_plugins');
		$this->aObjectMap['banners']['alt_filename'] = array('fromTable'=>'banners', 'fromField'=>'alt_filename');
		$this->aObjectMap['banners']['alt_imageurl'] = array('fromTable'=>'banners', 'fromField'=>'alt_imageurl');
		$this->aObjectMap['banners']['alt_contenttype'] = array('fromTable'=>'banners', 'fromField'=>'alt_contenttype');
		$this->aObjectMap['banners']['comments'] = array('fromTable'=>'banners', 'fromField'=>'comments');
		$this->aObjectMap['banners']['updated'] = array('fromTable'=>'banners', 'fromField'=>'updated');
    }



	function beforeAddField__banners__campaignid()
	{
		return $this->beforeAddField('banners', 'campaignid');
	}

	function afterAddField__banners__campaignid()
	{
		return $this->afterAddField('banners', 'campaignid') && $this->migrateCampaignId();
	}

	function beforeAddField__banners__adserver()
	{
		return $this->beforeAddField('banners', 'adserver');
	}

	function afterAddField__banners__adserver()
	{
		return $this->afterAddField('banners', 'adserver');
	}

	function beforeAddField__banners__session_capping()
	{
		return $this->beforeAddField('banners', 'session_capping');
	}

	function afterAddField__banners__session_capping()
	{
		return $this->afterAddField('banners', 'session_capping');
	}

	function beforeAddField__banners__acl_plugins()
	{
		return $this->beforeAddField('banners', 'acl_plugins');
	}

	function afterAddField__banners__acl_plugins()
	{
		return $this->afterAddField('banners', 'acl_plugins');
	}

	function beforeAddField__banners__alt_filename()
	{
		return $this->beforeAddField('banners', 'alt_filename');
	}

	function afterAddField__banners__alt_filename()
	{
		return $this->afterAddField('banners', 'alt_filename');
	}

	function beforeAddField__banners__alt_imageurl()
	{
		return $this->beforeAddField('banners', 'alt_imageurl');
	}

	function afterAddField__banners__alt_imageurl()
	{
		return $this->afterAddField('banners', 'alt_imageurl');
	}

	function beforeAddField__banners__alt_contenttype()
	{
		return $this->beforeAddField('banners', 'alt_contenttype');
	}

	function afterAddField__banners__alt_contenttype()
	{
		return $this->afterAddField('banners', 'alt_contenttype');
	}

	function beforeAddField__banners__comments()
	{
		return $this->beforeAddField('banners', 'comments');
	}

	function afterAddField__banners__comments()
	{
		return $this->afterAddField('banners', 'comments');
	}

	function beforeAddField__banners__updated()
	{
		return $this->beforeAddField('banners', 'updated');
	}

	function afterAddField__banners__updated()
	{
		return $this->afterAddField('banners', 'updated');
	}

	function beforeAlterField__banners__target()
	{
		return $this->beforeAlterField('banners', 'target');
	}

	function afterAlterField__banners__target()
	{
		return $this->afterAlterField('banners', 'target');
	}

	function beforeAlterField__banners__url()
	{
		return $this->beforeAlterField('banners', 'url');
	}

	function afterAlterField__banners__url()
	{
		return $this->afterAlterField('banners', 'url');
	}

	function beforeRemoveField__banners__clientid()
	{
		return $this->beforeRemoveField('banners', 'clientid');
	}

	function afterRemoveField__banners__clientid()
	{
		return $this->afterRemoveField('banners', 'clientid');
	}

	function beforeRemoveField__banners__priority()
	{
		return $this->beforeRemoveField('banners', 'priority');
	}

	function afterRemoveField__banners__priority()
	{
		return $this->afterRemoveField('banners', 'priority');
	}

	function migrateCampaignId()
	{
	    $table = $this->oDBH->quoteIdentifier($this->getPrefix().'banners',true);
	    $query = "
	       UPDATE {$table}
	       set campaignid = clientid";
	    $result = $this->oDBH->exec($query);
	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse('Error migrating CampaignId during migration 124: '.$result->getUserInfo());
	    }
	    return true;
	}
}

?>