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

require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Banners.php';

/**
 * @todo Consider renaming to Advert
 */
class MAX_Dal_Admin_Banners extends MAX_Dal_Common
{
    var $table = 'banners';

    var $orderListName = array(
        'name' => 'description',
        'id'   => 'bannerid',
    );

    /**
     * Gets a RecordSet of matching banners.
     *
     * @param string $keyword  the string to search for.
     * @param int $agencyId  restrict search to this agency ID.
     * @param bool $filterMarketBanners filter banners created by market plugin
     * @return RecordSet
     */
    function getBannerByKeyword($keyword, $agencyId = null, $filterMarketBanners = true)
    {

        $whereBanner = is_numeric($keyword) ? " OR b.bannerid=". DBC::makeLiteral($keyword) : '';
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix.'banners',true);
        $tableM = $oDbh->quoteIdentifier($prefix.'campaigns',true);
        $tableC = $oDbh->quoteIdentifier($prefix.'clients',true);

        $query = "
        SELECT
            b.bannerid as bannerid,
            b.description as description,
            b.alt as alt,
            b.campaignid as campaignid,
            b.contenttype as type,
            m.clientid as clientid
        FROM
            {$tableB} AS b,
            {$tableM} AS m,
            {$tableC} AS c
        WHERE
            (
            m.clientid=c.clientid
            AND b.campaignid=m.campaignid
            AND (b.alt LIKE " . DBC::makeLiteral('%' . $keyword . '%') . "
                OR b.description LIKE " . DBC::makeLiteral('%' . $keyword . '%') . "
                $whereBanner)
            )
        ";
        if ($filterMarketBanners) {
            //remove market banners
            $query .= " AND (b.ext_bannertype <> ". DBC::makeLiteral(DataObjects_Banners::BANNER_TYPE_MARKET) . " OR b.ext_bannertype IS NULL)"; 
        }                                                                  

        if($agencyId !== null) {
            $query .= " AND c.agencyid=".DBC::makeLiteral($agencyId);
        }

        return DBC::NewRecordSet($query);
    }

    /**
     * @param string $listorder One of 'bannerid', 'campaignid', 'alt',
     * 'description'...
     * @param string $orderdirection Either 'up' or 'down'.
     * @param bool $filterMarketBanners filter banners created by market plugin
     * @return Array of arrays representing a list of banners (keyed by id)
     *
     * @todo Verify ANSI compatible
     * @todo Consider removing listorder and orderdirection
     */
    function getAllBanners($listorder, $orderdirection, $filterMarketBanners = true)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix.'banners',true);
        $query = "SELECT bannerid AS ad_id".
        ",campaignid".
        ",alt".
        ",description".
        ",status".
        ",storagetype AS type".
        " FROM ".$tableB;
        if ($filterMarketBanners) {
            //remove market banners
            $query .= " WHERE (ext_bannertype <> ". DBC::makeLiteral(DataObjects_Banners::BANNER_TYPE_MARKET)." OR ext_bannertype IS NULL)"; 
        }
        
        $query .= $this->getSqlListOrder($listorder, $orderdirection);
        return $this->oDbh->queryAll($query, null, MDB2_FETCHMODE_DEFAULT, true);
    }

    /**
     * @param int $agency_id
     * @param string $listorder One of 'bannerid', 'campaignid', 'alt',
     * 'description'...
     * @param string $orderdirection Either 'up' or 'down'.
     * @param bool $filterMarketBanners filter banners created by market plugin
     * @return Array of arrays representing a list of banners (keyed by id)
     *
     * @todo Verify ANSI compatible ("FROM table AS alias" probably isn't)
     * @todo Consider removing listorder and orderdirection
     */
    function getAllBannersUnderAgency($agency_id, $listorder, $orderdirection, $filterMarketBanners = true)
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix.'banners',true);
        $tableM = $oDbh->quoteIdentifier($prefix.'campaigns',true);
        $tableC = $oDbh->quoteIdentifier($prefix.'clients',true);

        $query = "
            SELECT
                b.bannerid AS ad_id,
                b.campaignid AS campaignid,
                b.alt AS alt,
                b.description AS description,
                b.status AS active,
                b.storagetype AS type
            FROM
                {$tableB} AS b,
                {$tableM} AS m,
                {$tableC} AS c
            WHERE
                b.campaignid = m.campaignid
                AND m.clientid = c.clientid
                AND c.agencyid = ". DBC::makeLiteral($agency_id) ." 
                ". ( ($filterMarketBanners) ? 
                    ("AND (b.ext_bannertype <> ". DBC::makeLiteral(DataObjects_Banners::BANNER_TYPE_MARKET) . " OR b.ext_bannertype IS NULL)") : "") .
            $this->getSqlListOrder($listorder, $orderdirection)
        ;

        $rsBanners = DBC::NewRecordSet($query);
        $aBanners = $rsBanners->getAll(array('ad_id', 'campaignid', 'alt', 'description', 'active', 'type'));
        $aBanners = $this->_rekeyBannersArray($aBanners);
        return $aBanners;
    }
    
    
    /**
     * @param int $campaignid
     * @param string $listorder One of 'bannerid', 'campaignid', 'alt',
     * 'description'...
     * @param string $orderdirection Either 'up' or 'down'.
     * @param bool $filterMarketBanners filter banners created by market plugin
     * @return Array of arrays representing a list of banners (keyed by id)
     */
    function getAllBannersUnderCampaign($campaignid, $listorder, $orderdirection, $filterMarketBanners = true)
    {
        if (!isset($campaignid)) {
            return array();
        }
        $doBanners = OA_Dal::factoryDO('banners');
        if ($filterMarketBanners) {
            $doBanners->whereAdd("(ext_bannertype <> ". DBC::makeLiteral(DataObjects_Banners::BANNER_TYPE_MARKET) . " OR ext_bannertype IS NULL)");
        }
        $doBanners->campaignid = $campaignid;
        $doBanners->addListOrderBy($listorder, $orderdirection);
        $doBanners->find();

        $aBanners = array();
        while ($doBanners->fetch() && $row_banners = $doBanners->toArray()) {
            $row_banners['ad_id'] = $row_banners['bannerid'];
            $row_banners['type'] = $row_banners['storagetype'];
            $aBanners[$row_banners['bannerid']] = $row_banners;
        }
        
        return $aBanners;
    }

    /**
     * @return int The number of active banners
     *
     * @todo Verify SQL is ANSI-compliant
     * @todo Consider reducing duplication with countAllBanner
     */
    function countActiveBanners()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix.'banners',true);
        $tableM = $oDbh->quoteIdentifier($prefix.'campaigns',true);

        $query_active_banners = "SELECT count(*) AS count".
            " FROM ".$tableB." AS b".
            ",".$tableM." AS m".
            " WHERE b.campaignid=m.campaignid".
            " AND m.status=".OA_ENTITY_STATUS_RUNNING.
            " AND b.status=".OA_ENTITY_STATUS_RUNNING;
        return $this->oDbh->queryOne($query_active_banners);
    }

    function countActiveBannersUnderAdvertiser($advertiser_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix.'banners',true);
        $tableM = $oDbh->quoteIdentifier($prefix.'campaigns',true);
        $query_active_banners = "SELECT count(*) AS count".
        " FROM ".$tableB." AS b".
        ",".$tableM." AS m".
        " WHERE b.campaignid=m.campaignid".
        " AND m.clientid=". DBC::makeLiteral($advertiser_id) .
        " AND m.status=".OA_ENTITY_STATUS_RUNNING.
        " AND b.status=".OA_ENTITY_STATUS_RUNNING;
        $number_of_active_banners = $this->oDbh->getOne($query_active_banners);
        return $number_of_active_banners;
    }


    /**
     * @todo Verify that SQL is ANSI-compliant
     * @todo Consider reducing duplication with countBannersUnderAgency()
     * @todo Consider moving to Agency DAL
     */
    function countActiveBannersUnderAgency($agency_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB   = $oDbh->quoteIdentifier($prefix.'banners',true);
        $tableCa  = $oDbh->quoteIdentifier($prefix.'campaigns',true);
        $tableCl  = $oDbh->quoteIdentifier($prefix.'clients',true);

        $query_active_banners = "SELECT count(*) AS count".
        " FROM ".$tableB." AS b".
        ",".$tableCa." AS m".
        ",".$tableCl." AS c".
        " WHERE m.clientid=c.clientid".
        " AND b.campaignid=m.campaignid".
        " AND c.agencyid=". DBC::makeLiteral($agency_id) .
        " AND m.status=".OA_ENTITY_STATUS_RUNNING.
        " AND b.status=".OA_ENTITY_STATUS_RUNNING;
        return $this->oDbh->queryOne($query_active_banners);
    }

    /**
     * @param array $flat_banners An unkeyed array of field-keyed arrays
     * @return array An array of arrays
     *               representing  a list of banners keyed by id
     *
     * @todo Identify common factors between this and a very similar method,
     * <code>MAX_Dal_Admin_Advertiser:: _rekeyClientsArray</code>
     */
    function _rekeyBannersArray($flat_banners)
    {
        $banners = array();
        foreach ($flat_banners as $row_banners) {
            $banners[$row_banners['ad_id']] = $row_banners;
            unset($row_banners['ad_id']);
        }
        return $banners;
    }

    /**
     * Move banner to different campaign
     *
     * @param int $bannerId
     * @param int $campaignId
     * @return bool  True on success
     */
    function moveBannerToCampaign($bannerId, $campaignId)
    {
        $Record = DBC::NewRecord();
        $oDbh = OA_DB::singleton();
        $tableB  = $oDbh->quoteIdentifier($this->getTablePrefix().'banners',true);
        return $Record->update($tableB,
            array(),
            "bannerid=". DBC::makeLiteral($bannerId),
            array('campaignid' => DBC::makeLiteral($campaignId)));
    }

    /**
     * Join all banners, campaigns and clients and return it as RecordSet
     * @param bool $filterMarketBanners filter banners created by market plugin
     *
     * @return RecordSet
     */
    function getBannersCampaignsClients($filterMarketBanners = true)
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB  = $oDbh->quoteIdentifier($prefix.'banners',true);
        $tableC  = $oDbh->quoteIdentifier($prefix.'campaigns',true);
        $tableCl = $oDbh->quoteIdentifier($prefix.'clients',true);

        $query = "
            SELECT
                b.bannerid,
                b.campaignid,
                b.description,
                c.clientid,
                c.campaignname,
                cl.clientname
            FROM
                {$tableB} AS b,
                {$tableC} AS c,
                {$tableCl} AS cl
            WHERE
                c.campaignid=b.campaignid
                AND cl.clientid=c.clientid
        ";
        if ($filterMarketBanners) {
            $query .= " AND (b.ext_bannertype <> ". DBC::makeLiteral(DataObjects_Banners::BANNER_TYPE_MARKET) . " OR b.ext_bannertype IS NULL)";
        }

        return DBC::NewRecordSet($query);
    }

}

?>
