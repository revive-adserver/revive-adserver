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

require_once MAX_PATH . '/lib/OA/Dal.php';

/**
 * The non-DB specific Common Data Access Layer (DAL) class for getting
 * and setting entities data.
 *
 * @package    MaxDal
 */
class MAX_Dal_Entities extends MAX_Dal_Common
{

    /**
     * The constructor method.
     *
     * @return MAX_Dal_Entities
     */
    function __construct()
    {
        parent::__construct();
    }

    /*========== METHODS FOR DEALING WITH ADS ===============*/

    /**
     * A method to get the details of all ads (active or not) by their
     * parent placement ID.
     *
     * @param integer $campaignId The parent campaign ID.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by ad ID, of arrays containing the ad
     *               details, for example:
     *                  array(
     *                      1 => array(
     *                          'ad_id'  => 1
     *                          'status' => 't',
     *                          'type'   => 'sql',
     *                          'weight' => 1
     *                      )
     *                      .
     *                      .
     *                      .
     *                  )
     */
    function getAdsByCampaignId($campaignId)
    {
        // Test the input values
        if (!is_numeric($campaignId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $this->oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['banners'],true);
        $query = "
            SELECT
                bannerid AS ad_id,
                status AS status,
                storagetype AS type,
                weight AS weight
            FROM
                $table
            WHERE
                campaignid = ". $this->oDbh->quote($campaignId, 'integer') ."
            ORDER BY
                ad_id";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['ad_id']] = $aRow;
        }
        return $aResult;
    }

    /**
     * A method to get the delivery limitation details of an ad, given an ad ID.
     *
     * @param integer $adId An ad ID.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by execution order, of the ad's delivery
     *               limitations. For example:
     *                  array(
     *                      0 => array(
     *                          'logical'    => 'and',
     *                          'type'       => 'Site:Channel',
     *                          'comparison' => '==',
     *                          'data'       => 12
     *                      )
     *                  )
     */
    function getDeliveryLimitationsByAdId($adId)
    {
        // Test the input values
        if (!is_numeric($adId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $this->oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['acls'],true);
        $query = "
            SELECT
                logical AS logical,
                type AS type,
                comparison AS comparison,
                data AS data,
                executionorder AS executionorder
            FROM
                $table
            WHERE
                bannerid = ". $this->oDbh->quote($adId, 'integer');
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['executionorder']] = array(
                'logical'    => $aRow['logical'],
                'type'       => $aRow['type'],
                'comparison' => $aRow['comparison'],
                'data'       => $aRow['data']
            );
        }
        return $aResult;
    }

    /**
     * A method to get the delivery limitation details of a channel, given a channel ID.
     *
     * @param integer $channelId An ad ID.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by execution order, of the channel's
     *               delivery limitations. For example:
     *                  array(
     *                      0 => array(
     *                          'logical'    => 'and',
     *                          'type'       => 'Time:Hour',
     *                          'comparison' => '==',
     *                          'data'       => 12
     *                      )
     *                  )
     */
    function getDeliveryLimitationsByChannelId($channelId)
    {
        // Test the input values
        if (!is_numeric($channelId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $this->oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['acls_channel'],true);
        $query = "
            SELECT
                logical AS logical,
                type AS type,
                comparison AS comparison,
                data AS data,
                executionorder AS executionorder
            FROM
                $table
            WHERE
                channelid = ". $this->oDbh->quote($channelId, 'integer');
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['executionorder']] = array(
                'logical'    => $aRow['logical'],
                'type'       => $aRow['type'],
                'comparison' => $aRow['comparison'],
                'data'       => $aRow['data']
            );
        }
        return $aResult;
    }

}
