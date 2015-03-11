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

class Migration_547 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__accounts__m2m_password';
		$this->aTaskList_constructive[] = 'afterAddField__accounts__m2m_password';
		$this->aTaskList_constructive[] = 'beforeAddField__accounts__m2m_ticket';
		$this->aTaskList_constructive[] = 'afterAddField__accounts__m2m_ticket';


		$this->aObjectMap['accounts']['m2m_password'] = array('fromTable'=>'accounts', 'fromField'=>'m2m_password');
		$this->aObjectMap['accounts']['m2m_ticket'] = array('fromTable'=>'accounts', 'fromField'=>'m2m_ticket');
    }



	function beforeAddField__accounts__m2m_password()
	{
		return $this->beforeAddField('accounts', 'm2m_password');
	}

	function afterAddField__accounts__m2m_password()
	{
		return $this->afterAddField('accounts', 'm2m_password');
	}

	function beforeAddField__accounts__m2m_ticket()
	{
		return $this->beforeAddField('accounts', 'm2m_ticket');
	}

	function afterAddField__accounts__m2m_ticket()
	{
		return $this->afterAddField('accounts', 'm2m_ticket');
	}

}

?>
