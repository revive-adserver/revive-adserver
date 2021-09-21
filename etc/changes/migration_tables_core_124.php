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
    public function __construct()
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


        $this->aObjectMap['banners']['campaignid'] = ['fromTable' => 'banners', 'fromField' => 'campaignid'];
        $this->aObjectMap['banners']['adserver'] = ['fromTable' => 'banners', 'fromField' => 'adserver'];
        $this->aObjectMap['banners']['session_capping'] = ['fromTable' => 'banners', 'fromField' => 'session_capping'];
        $this->aObjectMap['banners']['acl_plugins'] = ['fromTable' => 'banners', 'fromField' => 'acl_plugins'];
        $this->aObjectMap['banners']['alt_filename'] = ['fromTable' => 'banners', 'fromField' => 'alt_filename'];
        $this->aObjectMap['banners']['alt_imageurl'] = ['fromTable' => 'banners', 'fromField' => 'alt_imageurl'];
        $this->aObjectMap['banners']['alt_contenttype'] = ['fromTable' => 'banners', 'fromField' => 'alt_contenttype'];
        $this->aObjectMap['banners']['comments'] = ['fromTable' => 'banners', 'fromField' => 'comments'];
        $this->aObjectMap['banners']['updated'] = ['fromTable' => 'banners', 'fromField' => 'updated'];
    }



    public function beforeAddField__banners__campaignid()
    {
        return $this->beforeAddField('banners', 'campaignid');
    }

    public function afterAddField__banners__campaignid()
    {
        return $this->afterAddField('banners', 'campaignid') && $this->migrateCampaignId();
    }

    public function beforeAddField__banners__adserver()
    {
        return $this->beforeAddField('banners', 'adserver');
    }

    public function afterAddField__banners__adserver()
    {
        return $this->afterAddField('banners', 'adserver');
    }

    public function beforeAddField__banners__session_capping()
    {
        return $this->beforeAddField('banners', 'session_capping');
    }

    public function afterAddField__banners__session_capping()
    {
        return $this->afterAddField('banners', 'session_capping');
    }

    public function beforeAddField__banners__acl_plugins()
    {
        return $this->beforeAddField('banners', 'acl_plugins');
    }

    public function afterAddField__banners__acl_plugins()
    {
        return $this->afterAddField('banners', 'acl_plugins');
    }

    public function beforeAddField__banners__alt_filename()
    {
        return $this->beforeAddField('banners', 'alt_filename');
    }

    public function afterAddField__banners__alt_filename()
    {
        return $this->afterAddField('banners', 'alt_filename');
    }

    public function beforeAddField__banners__alt_imageurl()
    {
        return $this->beforeAddField('banners', 'alt_imageurl');
    }

    public function afterAddField__banners__alt_imageurl()
    {
        return $this->afterAddField('banners', 'alt_imageurl');
    }

    public function beforeAddField__banners__alt_contenttype()
    {
        return $this->beforeAddField('banners', 'alt_contenttype');
    }

    public function afterAddField__banners__alt_contenttype()
    {
        return $this->afterAddField('banners', 'alt_contenttype');
    }

    public function beforeAddField__banners__comments()
    {
        return $this->beforeAddField('banners', 'comments');
    }

    public function afterAddField__banners__comments()
    {
        return $this->afterAddField('banners', 'comments');
    }

    public function beforeAddField__banners__updated()
    {
        return $this->beforeAddField('banners', 'updated');
    }

    public function afterAddField__banners__updated()
    {
        return $this->afterAddField('banners', 'updated');
    }

    public function beforeAlterField__banners__target()
    {
        return $this->beforeAlterField('banners', 'target');
    }

    public function afterAlterField__banners__target()
    {
        return $this->afterAlterField('banners', 'target');
    }

    public function beforeAlterField__banners__url()
    {
        return $this->beforeAlterField('banners', 'url');
    }

    public function afterAlterField__banners__url()
    {
        return $this->afterAlterField('banners', 'url');
    }

    public function beforeRemoveField__banners__clientid()
    {
        return $this->beforeRemoveField('banners', 'clientid');
    }

    public function afterRemoveField__banners__clientid()
    {
        return $this->afterRemoveField('banners', 'clientid');
    }

    public function beforeRemoveField__banners__priority()
    {
        return $this->beforeRemoveField('banners', 'priority');
    }

    public function afterRemoveField__banners__priority()
    {
        return $this->afterRemoveField('banners', 'priority');
    }

    public function migrateCampaignId()
    {
        $table = $this->oDBH->quoteIdentifier($this->getPrefix() . 'banners', true);
        $query = "
	       UPDATE {$table}
	       set campaignid = clientid";
        $result = $this->oDBH->exec($query);
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Error migrating CampaignId during migration 124: ' . $result->getUserInfo());
        }
        return true;
    }
}
