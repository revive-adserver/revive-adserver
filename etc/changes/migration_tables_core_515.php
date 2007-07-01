<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once MAX_PATH . '/etc/changes/ConfigMigration.php';

class Migration_515 extends Migration
{

    function Migration_515()
    {
		$this->aTaskList_constructive[] = 'beforeAlterField__preference__gui_invocation_3rdparty_default';
		$this->aTaskList_constructive[] = 'afterAlterField__preference__gui_invocation_3rdparty_default';


    }

	function beforeAlterField__preference__gui_invocation_3rdparty_default()
	{
		return $this->beforeAlterField('preference', 'gui_invocation_3rdparty_default');
	}

	function afterAlterField__preference__gui_invocation_3rdparty_default()
	{
		return $this->migrateConfig() && $this->afterAlterField('preference', 'gui_invocation_3rdparty_default');
	}
	
	function migrateConfig()
	{
		$configMigration = new ConfigMigration();
        return $configMigration->mergeGeotargetingPLuginsConfig();
	}

}

?>