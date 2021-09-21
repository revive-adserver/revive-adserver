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

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_601 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__viewwindow';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__viewwindow';
        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__clickwindow';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__clickwindow';
        $this->aTaskList_destructive[] = 'beforeRemoveField__campaigns_trackers__viewwindow';
        $this->aTaskList_destructive[] = 'afterRemoveField__campaigns_trackers__viewwindow';
        $this->aTaskList_destructive[] = 'beforeRemoveField__campaigns_trackers__clickwindow';
        $this->aTaskList_destructive[] = 'afterRemoveField__campaigns_trackers__clickwindow';


        $this->aObjectMap['campaigns']['viewwindow'] = ['fromTable' => 'campaigns', 'fromField' => 'viewwindow'];
        $this->aObjectMap['campaigns']['clickwindow'] = ['fromTable' => 'campaigns', 'fromField' => 'clickwindow'];
    }



    public function beforeAddField__campaigns__viewwindow()
    {
        return $this->beforeAddField('campaigns', 'viewwindow');
    }

    public function afterAddField__campaigns__viewwindow()
    {
        return $this->afterAddField('campaigns', 'viewwindow');
    }

    public function beforeAddField__campaigns__clickwindow()
    {
        return $this->beforeAddField('campaigns', 'clickwindow');
    }

    public function afterAddField__campaigns__clickwindow()
    {
        return $this->afterAddField('campaigns', 'clickwindow');
    }

    /**
     * Migrate the largest clickwindow value for any linked tracker-campaign
     * into the campaigns table before dropping the field
     *
     * @return boolean True on sucess, false otherwise
     */
    public function beforeRemoveField__campaigns_trackers__viewwindow()
    {
        $aConf = $GLOBALS['_MAX']['CONF']['table'];
        $prefix = $aConf['prefix'];
        $tblCampaigns = $this->_getTableName('campaigns');
        $tblCampaignsTrackers = $this->_getTableName('campaigns_trackers');

        $query = "
            SELECT
                campaignid AS campaign_id,
                MAX(viewwindow) AS max_viewwindow,
                MAX(clickwindow) AS max_clickwindow
            FROM
                " . $this->oDBH->quoteIdentifier($tblCampaignsTrackers) . " AS ct
            GROUP BY
                campaign_id
        ";

        $rs = $this->oDBH->query($query);

        //check for error
        if (PEAR::isError($rs)) {
            $this->logError($rs->getUserInfo());
            return false;
        }

        while ($aCampaignTrackers = $rs->fetchRow(MDB2_FETCHMODE_ASSOC)) {
            $updateQuery = "
                UPDATE
                    " . $this->oDBH->quoteIdentifier($tblCampaigns) . "
                SET
                    viewwindow = '{$aCampaignTrackers['max_viewwindow']}',
                    clickwindow = '{$aCampaignTrackers['max_clickwindow']}'
                WHERE
                    campaignid = '{$aCampaignTrackers['campaign_id']}'
            ";

            $this->oDBH->query($updateQuery);
        }

        return $this->beforeRemoveField('campaigns_trackers', 'viewwindow');
    }

    public function afterRemoveField__campaigns_trackers__viewwindow()
    {
        return $this->afterRemoveField('campaigns_trackers', 'viewwindow');
    }

    /**
     * Migrate the largest clickwindow value for any linked tracker-campaign
     * into the campaigns table before dropping the field
     *
     * @return boolean True on sucess, false otherwise
     */
    public function beforeRemoveField__campaigns_trackers__clickwindow()
    {
        return $this->beforeRemoveField('campaigns_trackers', 'clickwindow');
    }

    public function afterRemoveField__campaigns_trackers__clickwindow()
    {
        return $this->afterRemoveField('campaigns_trackers', 'clickwindow');
    }

    /**
     * Get the name of a table
     *
     * @param unknown_type $table
     */
    public function _getTableName($table)
    {
        $aConf = $GLOBALS['_MAX']['CONF']['table'];
        return $aConf['prefix'] . ($aConf[$table] ? $aConf[$table] : $table);
    }
}
