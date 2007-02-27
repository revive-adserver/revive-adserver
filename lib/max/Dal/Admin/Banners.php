<?php
/**
 * @since Max v0.3.30 - 21-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/Common.php';

/**
 * @todo Consider renaming to Advert
 */
class MAX_Dal_Admin_Banner extends MAX_Dal_Common
{
    var $table = 'banners';
	
	var $orderListName = array(
        'name' => 'description',
        'id'   => 'bannerid',
    );
    
    function getBannerByKeyword($keyword, $agencyId = null)
    {

        $whereBanner = is_numeric($keyword) ? " OR b.bannerid=$keyword" : '';

        $query = "
        SELECT
            b.bannerid as bannerid,
            b.description as description,
            b.alt as alt,
            b.campaignid as campaignid,
            m.clientid as clientid
        FROM
            banners AS b,
            campaigns AS m,
            clients AS c
        WHERE
            (
            m.clientid=c.clientid
            AND b.campaignid=m.campaignid
            AND (b.alt LIKE " . DBC::makeLiteral('%' . $keyword . '%') . "
                OR b.description LIKE " . DBC::makeLiteral('%' . $keyword . '%') . "
                $whereBanner)
            )
        ";

        if($agencyId !== null) {
            $query .= " AND c.agencyid=".DBC::makeLiteral($agencyId);
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
    function getAllBanners($listorder, $orderdirection)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query = "SELECT bannerid AS ad_id".
        ",campaignid".
        ",alt".
        ",description".
        ",active".
        ",storagetype AS type".
        " FROM ".$conf['table']['prefix'].$conf['table']['banners'];
        $query .= $this->getSqlListOrder($listorder, $orderdirection);
        $flat_banners = $this->dbh->getAll($query);
        if (PEAR::isError($flat_banners)) {
            MAX::raiseError($flat_banners);
            return array();
        }
        $banners = $this->_rekeyBannersArray($flat_banners);
        return $banners;
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
    function getAllBannersUnderAgency($agency_id, $listorder, $orderdirection)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query = "SELECT b.bannerid AS ad_id".
            ",b.campaignid AS campaignid".
            ",b.alt AS alt".
            ",b.description AS description".
            ",b.active AS active".
            ",b.storagetype AS type".
            " FROM ".$conf['table']['prefix'].$conf['table']['banners']." AS b".
            ",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
            ",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
            " WHERE b.campaignid=m.campaignid".
            " AND m.clientid=c.clientid".
            " AND c.agencyid=".$agency_id;
        $query .= phpAds_getBannerListOrder($listorder, $orderdirection);
        $flat_banners = $this->dbh->getAll($query);
        if (PEAR::isError($flat_banners)) {
            MAX::raiseError($flat_banners);
            return array();
        }
        $banners = $this->_rekeyBannersArray($flat_banners);
        return $banners;
    }

    /**
     * @param int $advertiser_id
     * @param string $listorder One of 'bannerid', 'campaignid', 'alt',
     * 'description'...
     * @param string $orderdirection Either 'up' or 'down'.
     * @return Array of arrays representing a list of banners (keyed by id)
     *
     * @todo Verify ANSI compatible ("FROM table AS alias" probably isn't)
     * @todo Consider removing listorder and orderdirection
     */
    function getAllBannersUnderAdvertiser($advertiser_id, $listorder, $orderdirection)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query = "SELECT b.bannerid AS ad_id".
            ",b.campaignid AS campaignid".
            ",b.alt AS alt".
            ",b.description AS description".
            ",b.active AS active".
            ",b.storagetype AS type".
            " FROM ".$conf['table']['prefix'].$conf['table']['banners']." AS b".
            ",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
            " WHERE b.campaignid=m.campaignid".
            " AND m.clientid=".$advertiser_id;
        $query .= phpAds_getBannerListOrder($listorder, $orderdirection);
        $flat_banners = $this->dbh->getAll($query);
        if (PEAR::isError($flat_banners)) {
            MAX::raiseError($flat_banners);
            return array();
        }
        $banners = $this->_rekeyBannersArray($flat_banners);
        return $banners;
    }

    /**
     * @return int The number of banners in the system, active or otherwise.
     */
    function countAllBanners()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query_total_banners = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['banners'];
        $number_of_banners = $this->dbh->getOne($query_total_banners);
        return $number_of_banners;
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
        $query_active_banners = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['banners']." AS b".
            ",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
            " WHERE b.campaignid=m.campaignid".
            " AND m.active='t'".
            " AND b.active='t'";
        $number_of_active_banners = $this->dbh->getOne($query_active_banners);
        return $number_of_active_banners;
    }

    function countBannersUnderAdvertiser($advertiser_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query_total_banners = "SELECT count(*) AS count".
        " FROM ".$conf['table']['prefix'].$conf['table']['banners']." AS b".
        ",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
        " WHERE b.campaignid=m.campaignid".
        " AND m.clientid=".$advertiser_id;
        $number_of_banners = $this->dbh->getOne($query_total_banners);
        return $number_of_banners;
    }

    function countActiveBannersUnderAdvertiser($advertiser_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query_active_banners = "SELECT count(*) AS count".
        " FROM ".$conf['table']['prefix'].$conf['table']['banners']." AS b".
        ",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
        " WHERE b.campaignid=m.campaignid".
        " AND m.clientid=".$advertiser_id.
        " AND m.active='t'".
        " AND b.active='t'";
        $number_of_active_banners = $this->dbh->getOne($query_active_banners);
        return $number_of_active_banners;
    }


    /**
     * @todo Verify that SQL is ANSI-compliant
     * @todo Consider moving to Agency DAL
     */
    function countBannersUnderAgency($agency_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_total_banners = "SELECT count(*) AS count".
        " FROM ".$conf['table']['prefix'].$conf['table']['banners']." AS b".
        ",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
        ",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
        " WHERE m.clientid=c.clientid".
        " AND b.campaignid=m.campaignid".
        " AND c.agencyid=".$agency_id;
        $number_of_banners = $this->dbh->getOne($query_total_banners);
        return $number_of_banners;
    }

    /**
     * @todo Verify that SQL is ANSI-compliant
     * @todo Consider reducing duplication with countBannersUnderAgency()
     * @todo Consider moving to Agency DAL
     */
    function countActiveBannersUnderAgency($agency_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_active_banners = "SELECT count(*) AS count".
        " FROM ".$conf['table']['prefix'].$conf['table']['banners']." AS b".
        ",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
        ",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
        " WHERE m.clientid=c.clientid".
        " AND b.campaignid=m.campaignid".
        " AND c.agencyid=".$agency_id.
        " AND m.active='t'".
        " AND b.active='t'";
        $number_of_active_banners = $this->dbh->getOne($query_active_banners);
        return $number_of_active_banners;
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
}

class BannerModel extends MAX_Dal_Admin_Banner {}

?>
