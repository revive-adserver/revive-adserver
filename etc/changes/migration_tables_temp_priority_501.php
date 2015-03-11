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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_501 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__tmp_ad_zone_impression__to_be_delivered';
		$this->aTaskList_constructive[] = 'afterAddField__tmp_ad_zone_impression__to_be_delivered';


		$this->aObjectMap['tmp_ad_zone_impression']['to_be_delivered'] = array('fromTable'=>'tmp_ad_zone_impression', 'fromField'=>'to_be_delivered');
    }



	function beforeAddField__tmp_ad_zone_impression__to_be_delivered()
	{
		return $this->beforeAddField('tmp_ad_zone_impression', 'to_be_delivered');
	}

	function afterAddField__tmp_ad_zone_impression__to_be_delivered()
	{
		return $this->afterAddField('tmp_ad_zone_impression', 'to_be_delivered');
	}

}

?>