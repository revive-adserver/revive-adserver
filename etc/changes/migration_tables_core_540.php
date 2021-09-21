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
require_once(MAX_PATH . '/lib/OA/Dll.php');

class Migration_540 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__banners__an_banner_id';
        $this->aTaskList_constructive[] = 'afterAddField__banners__an_banner_id';
        $this->aTaskList_constructive[] = 'beforeAddField__banners__as_banner_id';
        $this->aTaskList_constructive[] = 'afterAddField__banners__as_banner_id';
        $this->aTaskList_constructive[] = 'beforeAddField__banners__status';
        $this->aTaskList_constructive[] = 'afterAddField__banners__status';
        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__an_campaign_id';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__an_campaign_id';
        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__as_campaign_id';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__as_campaign_id';
        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__status';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__status';
        $this->aTaskList_constructive[] = 'beforeAddField__campaigns__an_status';
        $this->aTaskList_constructive[] = 'afterAddField__campaigns__an_status';
        $this->aTaskList_constructive[] = 'beforeAddField__clients__an_adnetwork_id';
        $this->aTaskList_constructive[] = 'afterAddField__clients__an_adnetwork_id';
        $this->aTaskList_constructive[] = 'beforeAddField__clients__as_advertiser_id';
        $this->aTaskList_constructive[] = 'afterAddField__clients__as_advertiser_id';
        $this->aTaskList_constructive[] = 'beforeAddField__zones__as_zone_id';
        $this->aTaskList_constructive[] = 'afterAddField__zones__as_zone_id';
        $this->aTaskList_destructive[] = 'beforeRemoveField__banners__active';
        $this->aTaskList_destructive[] = 'afterRemoveField__banners__active';
        $this->aTaskList_destructive[] = 'beforeRemoveField__banners__oac_banner_id';
        $this->aTaskList_destructive[] = 'afterRemoveField__banners__oac_banner_id';
        $this->aTaskList_destructive[] = 'beforeRemoveField__campaigns__active';
        $this->aTaskList_destructive[] = 'afterRemoveField__campaigns__active';
        $this->aTaskList_destructive[] = 'beforeRemoveField__campaigns__oac_campaign_id';
        $this->aTaskList_destructive[] = 'afterRemoveField__campaigns__oac_campaign_id';
        $this->aTaskList_destructive[] = 'beforeRemoveField__clients__oac_adnetwork_id';
        $this->aTaskList_destructive[] = 'afterRemoveField__clients__oac_adnetwork_id';


        $this->aObjectMap['banners']['an_banner_id'] = ['fromTable' => 'banners', 'fromField' => 'oac_banner_id'];
        $this->aObjectMap['banners']['as_banner_id'] = ['fromTable' => 'banners', 'fromField' => 'as_banner_id'];
        $this->aObjectMap['banners']['status'] = ['fromTable' => 'banners', 'fromField' => 'status'];
        $this->aObjectMap['campaigns']['an_campaign_id'] = ['fromTable' => 'campaigns', 'fromField' => 'oac_campaign_id'];
        $this->aObjectMap['campaigns']['as_campaign_id'] = ['fromTable' => 'campaigns', 'fromField' => 'as_campaign_id'];
        $this->aObjectMap['campaigns']['status'] = ['fromTable' => 'campaigns', 'fromField' => 'status'];
        $this->aObjectMap['campaigns']['an_status'] = ['fromTable' => 'campaigns', 'fromField' => 'an_status'];
        $this->aObjectMap['clients']['an_adnetwork_id'] = ['fromTable' => 'clients', 'fromField' => 'oac_adnetwork_id'];
        $this->aObjectMap['clients']['as_advertiser_id'] = ['fromTable' => 'clients', 'fromField' => 'as_advertiser_id'];
        $this->aObjectMap['zones']['as_zone_id'] = ['fromTable' => 'zones', 'fromField' => 'as_zone_id'];
    }



    public function beforeAddField__banners__an_banner_id()
    {
        return $this->beforeAddField('banners', 'an_banner_id');
    }

    public function afterAddField__banners__an_banner_id()
    {
        return $this->afterAddField('banners', 'an_banner_id');
    }

    public function beforeAddField__banners__as_banner_id()
    {
        return $this->beforeAddField('banners', 'as_banner_id');
    }

    public function afterAddField__banners__as_banner_id()
    {
        return $this->afterAddField('banners', 'as_banner_id');
    }

    public function beforeAddField__banners__status()
    {
        return $this->beforeAddField('banners', 'status');
    }

    public function afterAddField__banners__status()
    {
        return $this->migrateBannerStatus() && $this->afterAddField('banners', 'status');
    }

    public function beforeAddField__campaigns__an_campaign_id()
    {
        return $this->beforeAddField('campaigns', 'an_campaign_id');
    }

    public function afterAddField__campaigns__an_campaign_id()
    {
        return $this->afterAddField('campaigns', 'an_campaign_id');
    }

    public function beforeAddField__campaigns__as_campaign_id()
    {
        return $this->beforeAddField('campaigns', 'as_campaign_id');
    }

    public function afterAddField__campaigns__as_campaign_id()
    {
        return $this->afterAddField('campaigns', 'as_campaign_id');
    }

    public function beforeAddField__campaigns__status()
    {
        return $this->beforeAddField('campaigns', 'status');
    }

    public function afterAddField__campaigns__status()
    {
        return $this->migrateCampaignStatus() && $this->afterAddField('campaigns', 'status');
    }

    public function beforeAddField__campaigns__an_status()
    {
        return $this->beforeAddField('campaigns', 'an_status');
    }

    public function afterAddField__campaigns__an_status()
    {
        return $this->afterAddField('campaigns', 'an_status');
    }

    public function beforeAddField__clients__an_adnetwork_id()
    {
        return $this->beforeAddField('clients', 'an_adnetwork_id');
    }

    public function afterAddField__clients__an_adnetwork_id()
    {
        return $this->afterAddField('clients', 'an_adnetwork_id');
    }

    public function beforeAddField__clients__as_advertiser_id()
    {
        return $this->beforeAddField('clients', 'as_advertiser_id');
    }

    public function afterAddField__clients__as_advertiser_id()
    {
        return $this->afterAddField('clients', 'as_advertiser_id');
    }

    public function beforeAddField__zones__as_zone_id()
    {
        return $this->beforeAddField('zones', 'as_zone_id');
    }

    public function afterAddField__zones__as_zone_id()
    {
        return $this->afterAddField('zones', 'as_zone_id');
    }

    public function beforeRemoveField__banners__active()
    {
        return $this->beforeRemoveField('banners', 'active');
    }

    public function afterRemoveField__banners__active()
    {
        return $this->afterRemoveField('banners', 'active');
    }

    public function beforeRemoveField__banners__oac_banner_id()
    {
        return $this->beforeRemoveField('banners', 'oac_banner_id');
    }

    public function afterRemoveField__banners__oac_banner_id()
    {
        return $this->afterRemoveField('banners', 'oac_banner_id');
    }

    public function beforeRemoveField__campaigns__active()
    {
        return $this->beforeRemoveField('campaigns', 'active');
    }

    public function afterRemoveField__campaigns__active()
    {
        return $this->afterRemoveField('campaigns', 'active');
    }

    public function beforeRemoveField__campaigns__oac_campaign_id()
    {
        return $this->beforeRemoveField('campaigns', 'oac_campaign_id');
    }

    public function afterRemoveField__campaigns__oac_campaign_id()
    {
        return $this->afterRemoveField('campaigns', 'oac_campaign_id');
    }

    public function beforeRemoveField__clients__oac_adnetwork_id()
    {
        return $this->beforeRemoveField('clients', 'oac_adnetwork_id');
    }

    public function afterRemoveField__clients__oac_adnetwork_id()
    {
        return $this->afterRemoveField('clients', 'oac_adnetwork_id');
    }

    public function migrateBannerStatus()
    {
        $this->_log("Migrating statuses for: banners");

        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $tblBanners = $this->oDBH->quoteIdentifier($prefix . 'banners', true);

        $query = "
            SELECT
	           bannerid,
	           active
            FROM
                {$tblBanners}
            ORDER BY
                bannerid
            ";
        $aBanners = $this->oDBH->getAssoc($query);

        if (PEAR::isError($aBanners)) {
            return $this->_logErrorAndReturnFalse("Cannot retrieve banners");
        }

        foreach ($aBanners as $bannerId => $active) {
            $status = $active == 't' ? OA_ENTITY_STATUS_RUNNING : OA_ENTITY_STATUS_PAUSED;

            $result = $this->oDBH->exec("
                UPDATE
                    {$tblBanners}
                SET
                    status = " . $this->oDBH->quote($status, 'integer') . "
                WHERE
                    bannerid = " . $this->oDBH->quote($bannerId, 'integer') . "
            ");

            if (PEAR::isError($result)) {
                return $this->_logErrorAndReturnFalse("Cannot execute banners query");
            }
        }

        return true;
    }

    public function migrateCampaignStatus()
    {
        $this->_log("Migrating statuses for: campaigns");

        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $tblCampaigns = $this->oDBH->quoteIdentifier($prefix . 'campaigns', true);

        $query = "
	       SELECT
	           campaignid,
	           active,
	           activate,
	           expire,
	           views,
	           clicks,
	           conversions
	       FROM
	           {$tblCampaigns}
	       ORDER BY
	           campaignid
           ";
        $aCampaigns = $this->oDBH->getAssoc($query);

        if (PEAR::isError($aCampaigns)) {
            return $this->_logErrorAndReturnFalse("Cannot retrieve campaign list");
        }

        foreach ($aCampaigns as $campaignId => $row) {
            if ($row['active'] == 't') {
                $status = OA_ENTITY_STATUS_RUNNING;
            } elseif ($row['expire'] && $row['expire'] !== '0000-00-00' && strtotime($row['expire']) < time()) {
                $status = OA_ENTITY_STATUS_EXPIRED;
            } elseif ($row['activate'] && $row['activate'] !== '0000-00-00' && strtotime($row['activate']) >= time()) {
                $status = OA_ENTITY_STATUS_AWAITING;
            } elseif ($row['views'] >= 0 || $row['clicks'] >= 0 || $row['conversions'] >= 0) {
                $status = OA_ENTITY_STATUS_EXPIRED;
            } else {
                $status = OA_ENTITY_STATUS_PAUSED;
            }

            $result = $this->oDBH->exec("
                UPDATE
                    {$tblCampaigns}
                SET
                    status = " . $this->oDBH->quote($status, 'integer') . "
                WHERE
                    campaignid = " . $this->oDBH->quote($campaignId, 'integer') . "
            ");

            if (PEAR::isError($result)) {
                return $this->_logErrorAndReturnFalse("Cannot execute campaign query");
            }
        }

        return true;
    }
}
