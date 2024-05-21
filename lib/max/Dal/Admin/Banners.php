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
    public $table = 'banners';

    public $orderListName = [
        'name' => 'description',
        'id' => 'bannerid',
        'updated' => 'updated',
    ];

    /**
     * Gets a RecordSet of matching banners.
     *
     * @param string $keyword  the string to search for.
     * @param int $agencyId  restrict search to this agency ID.
     * @param bool $filterMarketBanners filter banners created by market plugin
     * @return RecordSet
     */
    public function getBannerByKeyword($keyword, $agencyId = null)
    {
        $oDbh = OA_DB::singleton();
        $oDbh->loadModule('Datatype');

        $whereBannerId = is_numeric($keyword) ? " OR b.bannerid=" . DBC::makeLiteral($keyword) : '';

        $prefix = $this->getTablePrefix();
        $tableB = $oDbh->quoteIdentifier($prefix . 'banners', true);
        $tableM = $oDbh->quoteIdentifier($prefix . 'campaigns', true);
        $tableC = $oDbh->quoteIdentifier($prefix . 'clients', true);

        $query = "
        SELECT
            b.bannerid as bannerid,
            b.description as description,
            b.alt as alt,
            b.campaignid as campaignid,
            b.contenttype as type,
            m.clientid as clientid
        FROM
            {$tableB} AS b INNER JOIN
            {$tableM} AS m ON (b.campaignid = m.campaignid) INNER JOIN
            {$tableC} AS c ON (m.clientid = c.clientid)
        WHERE
            (
                {$oDbh->datatype->matchPattern(['', '%', $keyword, '%'], 'ILIKE', 'b.alt')} OR
                {$oDbh->datatype->matchPattern(['', '%', $keyword, '%'], 'ILIKE', 'b.description')}
                {$whereBannerId}
            )
        ";

        if ($agencyId !== null) {
            $query .= " AND c.agencyid=" . DBC::makeLiteral($agencyId);
        }

        return DBC::NewRecordSet($query);
    }

    /**
     * @param string $listorder One of 'bannerid', 'campaignid', 'alt',
     * 'description'...
     * @param string $orderdirection Either 'up' or 'down'.
     * @return Array of arrays representing a list of banners (keyed by id)
     *
     * @todo Verify ANSI compatible
     * @todo Consider removing listorder and orderdirection
     */
    public function getAllBanners($listorder, $orderdirection)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix . 'banners', true);
        $query = "SELECT bannerid AS ad_id" .
        ",campaignid" .
        ",alt" .
        ",description" .
        ",status" .
        ",storagetype AS type" .
        " FROM " . $tableB;
        $query .= $this->getSqlListOrder($listorder, $orderdirection);
        return $this->oDbh->queryAll($query, null, MDB2_FETCHMODE_DEFAULT, true);
    }

    /**
     * @param int $agency_id
     * @param string $listorder One of 'bannerid', 'campaignid', 'alt',
     * 'description'...
     * @param string $orderdirection Either 'up' or 'down'.
     * @return Array of arrays representing a list of banners (keyed by id)
     *
     * @todo Verify ANSI compatible ("FROM table AS alias" probably isn't)
     * @todo Consider removing listorder and orderdirection
     */
    public function getAllBannersUnderAgency($agency_id, $listorder, $orderdirection)
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix . 'banners', true);
        $tableM = $oDbh->quoteIdentifier($prefix . 'campaigns', true);
        $tableC = $oDbh->quoteIdentifier($prefix . 'clients', true);

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
                AND c.agencyid = " . DBC::makeLiteral($agency_id) .
            $this->getSqlListOrder($listorder, $orderdirection)
        ;

        $rsBanners = DBC::NewRecordSet($query);
        $aBanners = $rsBanners->getAll(['ad_id', 'campaignid', 'alt', 'description', 'active', 'type']);
        $aBanners = $this->_rekeyBannersArray($aBanners);
        return $aBanners;
    }


    /**
     * @param int $campaignid
     * @param string $listorder One of 'bannerid', 'campaignid', 'alt',
     * 'description'...
     * @param string $orderdirection Either 'up' or 'down'.
     * @return Array of arrays representing a list of banners (keyed by id)
     */
    public function getAllBannersUnderCampaign($campaignid, $listorder, $orderdirection)
    {
        if (!isset($campaignid)) {
            return [];
        }
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $campaignid;
        $doBanners->addListOrderBy($listorder, $orderdirection);
        $doBanners->find();

        $aBanners = [];
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
    public function countActiveBanners()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix . 'banners', true);
        $tableM = $oDbh->quoteIdentifier($prefix . 'campaigns', true);

        $query_active_banners = "SELECT count(*) AS count" .
            " FROM " . $tableB . " AS b" .
            "," . $tableM . " AS m" .
            " WHERE b.campaignid=m.campaignid" .
            " AND m.status=" . OA_ENTITY_STATUS_RUNNING .
            " AND b.status=" . OA_ENTITY_STATUS_RUNNING;
        return $this->oDbh->queryOne($query_active_banners);
    }

    public function countActiveBannersUnderAdvertiser($advertiser_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix . 'banners', true);
        $tableM = $oDbh->quoteIdentifier($prefix . 'campaigns', true);
        $query_active_banners = "SELECT count(*) AS count" .
        " FROM " . $tableB . " AS b" .
        "," . $tableM . " AS m" .
        " WHERE b.campaignid=m.campaignid" .
        " AND m.clientid=" . DBC::makeLiteral($advertiser_id) .
        " AND m.status=" . OA_ENTITY_STATUS_RUNNING .
        " AND b.status=" . OA_ENTITY_STATUS_RUNNING;
        $number_of_active_banners = $this->oDbh->getOne($query_active_banners);
        return $number_of_active_banners;
    }


    /**
     * @todo Verify that SQL is ANSI-compliant
     * @todo Consider reducing duplication with countBannersUnderAgency()
     * @todo Consider moving to Agency DAL
     */
    public function countActiveBannersUnderAgency($agency_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix . 'banners', true);
        $tableCa = $oDbh->quoteIdentifier($prefix . 'campaigns', true);
        $tableCl = $oDbh->quoteIdentifier($prefix . 'clients', true);

        $query_active_banners = "SELECT count(*) AS count" .
        " FROM " . $tableB . " AS b" .
        "," . $tableCa . " AS m" .
        "," . $tableCl . " AS c" .
        " WHERE m.clientid=c.clientid" .
        " AND b.campaignid=m.campaignid" .
        " AND c.agencyid=" . DBC::makeLiteral($agency_id) .
        " AND m.status=" . OA_ENTITY_STATUS_RUNNING .
        " AND b.status=" . OA_ENTITY_STATUS_RUNNING;
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
    public function _rekeyBannersArray($flat_banners)
    {
        $banners = [];
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
    public function moveBannerToCampaign($bannerId, $campaignId)
    {
        $Record = DBC::NewRecord();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($this->getTablePrefix() . 'banners', true);
        return $Record->update(
            $tableB,
            [],
            "bannerid=" . DBC::makeLiteral($bannerId),
            ['campaignid' => DBC::makeLiteral($campaignId)]
        );
    }

    /**
     * Join all banners, campaigns and clients and return it as RecordSet
     *
     * @return RecordSet
     */
    public function getBannersCampaignsClients()
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix . 'banners', true);
        $tableC = $oDbh->quoteIdentifier($prefix . 'campaigns', true);
        $tableCl = $oDbh->quoteIdentifier($prefix . 'clients', true);

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

        return DBC::NewRecordSet($query);
    }
}
