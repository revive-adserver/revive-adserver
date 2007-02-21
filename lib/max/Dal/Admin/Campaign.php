<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/max/Dal/db/db.inc.php';

class MAX_Dal_Admin_Campaign extends MAX_Dal_Common
{
    /**
     * Gets campaign Id and name and client Id by keyword and agency Id
     * matched by keyword and either client name or client id.
     *
     * @param $keyword  string  Keyword to look for
     * @param $agencyId int  Agency Id
     *
     * @return RecordSet
     * @access public
     */
    function getCampaignAndClientByKeyword($keyword, $agencyId = null)
    {
        $whereCampaign = is_numeric($keyword) ? " OR m.campaignid=$keyword" : '';

        $query = "
        SELECT
            m.campaignid AS campaignid,
            m.campaignname AS campaignname,
            m.clientid AS clientid
        FROM
            campaigns AS m,
            clients AS c
        WHERE
            (
            m.clientid=c.clientid
            AND (m.campaignname LIKE ".DBC::makeLiteral('%'.$keyword.'%')."
                $whereCampaign)
            )
        ";

        if($agencyId !== null) {
            $query .= " AND c.agencyid=".DBC::makeLiteral($agencyId);
        }

        return DBC::NewRecordSet($query);
    }

    /**
     * @todo Consider removing order options (or making them optional)
     */
    function getAllCampaigns($listorder, $orderdirection)
    {
        // Adapt old order options to new ones.
        if ($listorder == 'campaignname') {
            $listorder = 'name';
        } else {
            $listorder = 'id';
        }

        if ($orderdirection == 'asc') {
            $orderdirection = 'up';
        } else {
            $orderdirection = 'down';
        }

        $conf = $GLOBALS['_MAX']['CONF'];

        $query =
            "SELECT campaignid,clientid,campaignname,active".
            " FROM ".$conf['table']['prefix'].$conf['table']['campaigns'];
        $query .= phpAds_getCampaignListOrder ($listorder, $orderdirection);

        $flat_campaign_data = $this->dbh->getAll($query);

        $keyed_campaigns = $this->_rekeyCampaignsArray($flat_campaign_data);
        return $keyed_campaigns;
    }

    /**
     * @param int $agency_id
     * @return array    An array of arrays, representing a list of campaigns.
     *
     * @todo Consider removing order options (or making them optional)
     */
    function getAllCampaignsUnderAgency($agency_id, $listorder, $orderdirection)
    {
        // Adapt old order options to new ones.
        if ($listorder == 'campaignname') {
            $listorder = 'name';
        } else {
            $listorder = 'id';
        }

        if ($orderdirection == 'asc') {
            $orderdirection = 'up';
        } else {
            $orderdirection = 'down';
        }

        $conf = $GLOBALS['_MAX']['CONF'];

        $query =
        "SELECT m.campaignid as campaignid".
        ",m.clientid as clientid".
        ",m.campaignname as campaignname".
        ",m.active as active".
        " FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
        ",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
        " WHERE c.clientid=m.clientid".
        " AND c.agencyid=?";
        $query_params = array($agency_id);
        $query .= phpAds_getCampaignListOrder ($listorder, $orderdirection);

        $flat_campaign_data = $this->dbh->getAll($query, $query_params);

        $keyed_campaigns = $this->_rekeyCampaignsArray($flat_campaign_data);
        return $keyed_campaigns;
    }

    /**
     * @param int $advertiser_id
     * @return array    An array of arrays, representing a list of displayable
     *                  campaigns.
     *
     * @todo Consider removing order options (or making them optional)
     */
    function getAllCampaignsUnderAdvertiser($advertiser_id, $listorder, $orderdirection)
    {
        // Adapt old order options to new ones.
        if ($listorder == 'campaignname') {
            $listorder = 'name';
        } else {
            $listorder = 'id';
        }

        if ($orderdirection == 'asc') {
            $orderdirection = 'up';
        } else {
            $orderdirection = 'down';
        }

        $conf = $GLOBALS['_MAX']['CONF'];

        $query =
        "SELECT campaignid,campaignname,active".
        " FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
        " WHERE clientid=?";
        $query_params = array($advertiser_id);
        $query .= phpAds_getCampaignListOrder ($listorder, $orderdirection);

        $flat_campaign_data = $this->dbh->getAll($query, $query_params);

        $keyed_campaigns = $this->_rekeyCampaignsArray($flat_campaign_data);
        return $keyed_campaigns;
    }

    function countAllCampaigns()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query_campaigns = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['campaigns'];
        $number_of_campaigns =  $this->dbh->getOne($query_campaigns);
        return $number_of_campaigns;
    }

    function countActiveCampaigns()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_active_campaigns = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." WHERE active='t'";
        $number_of_active_campaigns = $this->dbh->getOne($query_active_campaigns);

        return $number_of_active_campaigns;
    }

    function countCampaignsUnderAdvertiser($advertiser_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_campaigns = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
            " WHERE clientid=".$advertiser_id;
        $number_of_campaigns = $this->dbh->getOne($query_campaigns);
        return $number_of_campaigns;
    }

    function countActiveCampaignsUnderAdvertiser($advertiser_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_active_campaigns = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
            " WHERE active='t'".
            " AND clientid=".$advertiser_id;
        $number_of_active_campaigns =  $this->dbh->getOne($query_active_campaigns);
        return $number_of_active_campaigns;
    }

    /**
     * @todo Verify that SQL is ANSI-compliant
     * @todo Consider moving to Agency DAL
     */
    function countCampaignsUnderAgency($agency_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_campaigns = "SELECT count(*) AS count".
        " FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
        ",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
        " WHERE m.clientid=c.clientid".
        " AND c.agencyid=".$agency_id;
        $number_of_campaigns =  $this->dbh->getOne($query_campaigns);
        return $number_of_campaigns;
    }

    /**
     * @todo Verify that SQL is ANSI-compliant
     * @todo Consider reducing duplication with countCampaignsUnderAgency()
     * @todo Consider moving to Agency DAL
     */
    function countActiveCampaignsUnderAgency($agency_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_active_campaigns = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
            ",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
            " WHERE m.clientid=c.clientid".
            " AND c.agencyid=".$agency_id.
            " AND m.active='t'";
        $number_of_active_campaigns =  $this->dbh->getOne($query_active_campaigns);
        return $number_of_active_campaigns;
    }

    /**
     * Converts a database result into an array keyed by campaign ID.
     * @param array $flat_campaign_data An flat array of campaign field arrays
     * @return array An array of arrays, representing a list of campaigns.
     */
    function _rekeyCampaignsArray($flat_campaign_data)
    {
        $campaigns = array();
        foreach ($flat_campaign_data as $row_campaign) {
            $campaigns[$row_campaign['campaignid']] = $row_campaign;
            $campaigns[$row_campaign['campaignid']]['expand'] = false;
            unset($campaigns[$row_campaign['campaignid']]['campaignid']);
        }
        return $campaigns;
    }
}

class CampaignModel extends MAX_Dal_Admin_Campaign
{
}

?>