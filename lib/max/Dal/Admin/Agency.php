<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Agency extends MAX_Dal_Common
{
    var $table = 'agency';
    
	/**
     * Is a banner linked to this agency via campaign and advertiser links?
     *  
     * @param int $agencyid
     * @param int $clientid An advertiser (formerly known as client)
     * @param int $campaignid A campaign
     * @param int $bannerid A banner
     * @return bool True if all the items are linked together
     * 
     * @todo Migrate to MAX DB API
     * @todo Validate as ANSI SQL
     */
    function isAgencyLinkedToAdvertiserCampaignAndBanner($agencyid, $clientid, $campaignid, $bannerid)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query = "
            SELECT
                b.bannerid as bannerid
            FROM
                {$conf['table']['prefix']}{$conf['table']['clients']} AS c,
                {$conf['table']['prefix']}{$conf['table']['campaigns']} AS m,
                {$conf['table']['prefix']}{$conf['table']['banners']} AS b
            WHERE
                c.clientid='{$clientid}'
              AND m.campaignid='{$campaignid}'
              AND b.bannerid='{$bannerid}'
              AND b.campaignid=m.campaignid
              AND m.clientid=c.clientid
              AND c.agencyid=".$agencyid;
        $res = $this->dbh->query($query);
        if (PEAR::isError($res)) {
            MAX::raiseError($res);
            return false;
        }
        if ($this->_isResultEmpty($res)) {
            return false;
        } else {
            return true;
        } 
    }

    /**
     * Is a campaign linked to this agency via an advertiser link?
     *  
     * @param int $agencyid
     * @param int $clientid An advertiser (formerly known as client)
     * @param int $campaignid A campaign
     * @return bool True if all the items are linked together
     * 
     * @todo Migrate to MAX DB API
     * @todo Validate as ANSI SQL
     */
    function isAgencyLinkedToAdvertiserAndCampaign($agencyid, $clientid, $campaignid)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query = "
                SELECT
                    m.campaignid as campaignid
                FROM
                    {$conf['table']['prefix']}{$conf['table']['clients']} AS c,
                    {$conf['table']['prefix']}{$conf['table']['campaigns']} AS m
                WHERE
                    c.clientid='{$clientid}'
                  AND m.campaignid='{$campaignid}'
                  AND m.clientid=c.clientid
                  AND c.agencyid={$agencyid}";
        $res = $this->dbh->query($query);
        if (PEAR::isError($res)) {
            MAX::raiseError($res);
            return false;
        }
        if ($this->_isResultEmpty($res)) {
            return false;
        } else {
            return true;
        } 
    }

    /**
     * 
     * @param   DB_result    $res    A PEAR DB result.
     * @return  bool        False if the result contains any rows of data.
     * 
     * @todo Consider inverting this method; something like isResourcePopulated
     */
    function _isResultEmpty($res)
    {
        return $res->numRows() == 0;
    }
}
?>
