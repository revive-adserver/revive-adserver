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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/Common.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display entity delivery statistics.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Delivery_CommonEntity extends OA_Admin_Statistics_Delivery_Common
{

    /** @var boolean */
    var $showHideInactive = false;
    /** @var int */
    var $startLevel;
    /** @var boolean */
    var $hideInactive;
    /** @var int */
    var $hiddenEntities = 0;
    /** @var array */
    var $showHideLevels;

    /** @var array */
    var $data;
    /** @var array */
    var $childrendata;

    /** @var array */
    var $entityLinks = array(
            'a' => 'stats.php?entity=advertiser&breakdown=history',
            'c' => 'stats.php?entity=campaign&breakdown=history',
            'b' => 'stats.php?entity=banner&breakdown=history',
            'p' => 'stats.php?entity=affiliate&breakdown=history',
            'z' => 'stats.php?entity=zone&breakdown=history'
        );

    /**
     * The array of "entity" style delivery statistics data to
     * display in the Flexy template.
     *
     * @var array
     */
    var $aEntitiesData;

    /**
     * PHP5-style constructor
     */
    function __construct($params)
    {
        // Set the output type "entity" style delivery statistcs
        $this->outputType = 'deliveryEntity';

        // Get list order and direction
        $this->listOrderField     = MAX_getStoredValue('listorder', 'name');
        $this->listOrderDirection = MAX_getStoredValue('orderdirection', 'up');

        parent::__construct($params);

        // Store the preferences
        $this->aPagePrefs['listorder']      = $this->listOrderField;
        $this->aPagePrefs['orderdirection'] = $this->listOrderDirection;

        // load the Banners DO class (to be used in entityLink)
        $do = DB_DataObject::factory('Banners');
    }

    /**
     * PHP4-style constructor
     */
    function OA_Admin_Statistics_Delivery_CommonEntity($params)
    {
        $this->__construct($params);
    }

    /**
     * The final "child" implementation of the parental abstract method,
     * to test if the appropriate data array is empty, or not.
     *
     * @see OA_Admin_Statistics_Common::_isEmptyResultArray()
     *
     * @access private
     * @return boolean True on empty, false if at least one row of data.
     */
    function _isEmptyResultArray()
    {
        if (!is_array($this->aEntitiesData)) {
            return true;
        }
        foreach($this->aEntitiesData as $aRecord) {
            if (
                $aRecord['sum_requests'] != '-' ||
                $aRecord['sum_views']    != '-' ||
                $aRecord['sum_clicks']   != '-'
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Recursively convert the tree-style entities array to a flat array
     * suitable for displaying it in a template
     */
    function flattenEntities()
    {
        $i = 0;
        $this->aEntitiesData = $this->_flattenEntities($this->aEntitiesData, $i);
        if (count($this->aEntitiesData)) {
            $this->aEntitiesData[count($this->aEntitiesData) - 1]['htmlclass'] .= ' last';
            $this->aEntitiesData[count($this->aEntitiesData) - 1]['nameclass'] .= ' last';
            foreach (array_keys($this->aEntitiesData) as $k) {
                if ($k && $this->aEntitiesData[$k]['level'] != 0) {
                    $this->aEntitiesData[$k-1]['nameclass'] = 'nb'.$this->aEntitiesData[$k-1]['nameclass'];
                }
            }
        }
    }

    /**
     * Internal function to convert a tree-style entities array to a flat array
     *
     * @param array Entities array
     * @param int Entities array
     * @param array Reference to the parent entity
     *
     * @return array Flat entities array
     */
    function _flattenEntities($aEntitiesData, &$cycle_var, $parent = null)
    {
        $ret = array();

        foreach ($aEntitiesData as $e) {
            if (is_null($parent)) {
                $e['level'] = 0;
                $e['padding'] = 0;

                $e['htmlclass'] = ($cycle_var++ % 2 == 0) ? 'dark' : 'light';
            } else {
                $e['level'] = $parent['level'] + 1;

                $e['htmlclass'] = $parent['htmlclass'];
                $e['padding'] = $parent['padding'] + 16;
            }

            $e['nameclass'] = $e['htmlclass'];

            $sub = null;
            if (isset($e['subentities'])) {
                if (count($e['subentities'])) {
                    $sub = $this->_flattenEntities($e['subentities'], $cycle_var, $e);
                }

                unset($e['subentities']);
            }

            $ret[] = $e;

            if (is_array($sub))
                $ret = array_merge($ret, $sub);
        }

        return $ret;
    }

    /**
     * Return the appriopriate link for an entity -- helper function for Flexy
     */
    function entityLink($key, $type = null)
    {
        return empty($this->entityLinks[$key])
            || $type == DataObjects_Banners::BANNER_TYPE_MARKET
            || $type == MAX_ZoneMarketMigrated
                ?  false
                : $this->entityLinks[$key];
    }

    /**
     * Internal function to aggregate the stats data
     *
     * @param array Entities array
     * @param array Stats row
     * @param string Key name
     */
    function _prepareDataAdd(&$entity, $row, $key)
    {
        if (!isset($entity[$row[$key]])) {
            $entity[$row[$key]][$key] = $row[$key];
            foreach (array_keys($this->aColumns) as $s) {
                $entity[$row[$key]][$s] = 0;
            }
        }

        // Use $row keys instead of $this->column to preserve non visible data
        foreach (array_keys($row) as $s) {
            if (isset($row[$s])) {
                if (!isset($entity[$row[$key]][$s])) {
                    $entity[$row[$key]][$s] = $row[$s];
                }
                if (substr($s, -3) != '_id') {
                    $entity[$row[$key]][$s] += $row[$s];
                }
            }
        }
    }

    /**
     * Fetch and aggregate stats using the specified parameters
     *
     * @param array Query parameters
     */
    function prepareData($aParams)
    {
        if (is_null($this->data))
        {
            $oNow = new Date();
            $aParams['tz'] = $oNow->tz->getID();

            // Get plugin aParams
            $pluginParams = array();
            foreach ($this->aPlugins as $oPlugin) {
                $oPlugin->addQueryParams($pluginParams);
            }

            $aRows = Admin_DA::fromCache('getEntitiesStats', $aParams + $this->aDates + $pluginParams);

            // Merge plugin additional data
            foreach ($this->aPlugins as $oPlugin) {
                $oPlugin->mergeData($aRows, $this->aEmptyRow, 'getEntitiesStats', $aParams + $this->aDates);
            }

            $this->data = array(
                'advertiser_id' => array(),
                'placement_id'  => array(),
                'ad_id'         => array(),
                'publisher_id'  => array(),
                'zone_id'       => array()
            );

            if (!count($aRows)) {
                $this->noStatsAvailable = true;
                return;
            }

            $aggregates = array('ad_id', 'zone_id');
            if (isset($aParams['exclude'])) {
                $aggregates = array_diff($aggregates, $aParams['exclude']);
            }
            if (isset($aParams['include'])) {
                $aggregates = array_merge($aggregates, $aParams['include']);
            }

            $this->childrendata = array();
            if (array_search('ad_id', $aggregates) !== false) {
                $this->childrendata['ad_id'] = Admin_DA::fromCache('getAds', $aParams);
                // Plugins can set their own ads in the array
                foreach ($this->aPlugins as $oPlugin) {
                    $oPlugin->mergeAds($this->childrendata['ad_id']);
                }
            }
            if (array_search('placement_id', $aggregates) !== false) {
                $this->childrendata['placement_id'] = Admin_DA::fromCache('getPlacementsChildren', $aParams);

                if (isset($this->childrendata['ad_id'])) {
                    foreach ($this->childrendata['ad_id'] as $key => $item) {
                        $this->childrendata['placement_id'][$item['placement_id']]['children'][$key] =& $this->childrendata['ad_id'][$key];
                        $this->childrendata['ad_id'][$key]['advertiser_id'] = $this->childrendata['placement_id'][$item['placement_id']]['advertiser_id'];
                    }
                }
            }
            if (array_search('advertiser_id', $aggregates) !== false) {
                $this->childrendata['advertiser_id'] = Admin_DA::fromCache('getAdvertisersChildren', $aParams);

                if (isset($this->childrendata['placement_id'])) {
                    foreach ($this->childrendata['placement_id'] as $key => $item) {
                        $this->childrendata['advertiser_id'][$item['advertiser_id']]['children'][$key] =& $this->childrendata['placement_id'][$key];
                    }
                }
            }
            if (array_search('zone_id', $aggregates) !== false) {
                $this->childrendata['zone_id'] = Admin_DA::fromCache('getZones', $aParams);
                // Plugins can set their own zones in the array
                foreach ($this->aPlugins as $oPlugin) {
                    $oPlugin->mergeZones($this->childrendata['zone_id']);
                }
            }
            if (array_search('publisher_id', $aggregates) !== false) {
                $this->childrendata['publisher_id'] = Admin_DA::fromCache('getPublishersChildren', $aParams);

                if (isset($this->childrendata['zone_id'])) {
                    foreach ($this->childrendata['zone_id'] as $key => $item) {
                        $this->childrendata['publisher_id'][$item['publisher_id']]['children'][$key] =& $this->childrendata['zone_id'][$key];
                    }
                }
            }

            foreach ($aRows as $row) {
                foreach ($aggregates as $agg) {
                    $this->_prepareDataAdd($this->data[$agg], $row, $agg);
                }
            }
        }
    }

    /**
     * Merge aggregate stats with entity properties (name, children, etc)
     *
     * @param array Query parameters
     * @param string Key name
     * @return array Full entity stats with entity data
     */
    function mergeData($aParams, $key)
    {
        $aEntitiesData = array();

        if (isset($this->childrendata[$key])) {
            if ($key == 'placement_id' && !empty($aParams['advertiser_id'])) {
                if (isset($this->childrendata['advertiser_id'][$aParams['advertiser_id']]['children'])) {
                    $aEntitiesData = $this->childrendata['advertiser_id'][$aParams['advertiser_id']]['children'];
                }
            } elseif ($key == 'ad_id' && !empty($aParams['placement_id'])) {
                if (isset($this->childrendata['placement_id'][$aParams['placement_id']]['children'])) {
                    $aEntitiesData = $this->childrendata['placement_id'][$aParams['placement_id']]['children'];
                }
            } elseif ($key == 'zone_id' && !empty($aParams['publisher_id'])) {
                if (isset($this->childrendata['publisher_id'][$aParams['publisher_id']]['children'])) {
                    $aEntitiesData = $this->childrendata['publisher_id'][$aParams['publisher_id']]['children'];
                }
            } else {
                $aEntitiesData = $this->childrendata[$key];
            }
            foreach (array_keys($aEntitiesData) as $entityId) {
                if (isset($this->data[$key][$entityId])) {
                    $aEntitiesData[$entityId] += $this->data[$key][$entityId];
                } else {
                    foreach (array_keys($this->aColumns) as $s) {
                        $aEntitiesData[$entityId][$s] = 0;
                    }
                }
            }
        }

        return $aEntitiesData;
    }

    /**
     * Get advertiser stats
     *
     * @param array Query parameters
     * @param int Tree level
     * @param string Expand GET parameter, used only when called from other get methods
     * @return Entities array
     */
    function getAdvertisers($aParams, $level, $expand = '')
    {
        $aParams['include'] = array('advertiser_id', 'placement_id');
        $aParams['exclude'] = array('zone_id');
        $this->prepareData($aParams);
        $period_preset = MAX_getStoredValue('period_preset', 'today');
        $aAdvertisers = $this->mergeData($aParams, 'advertiser_id');
        MAX_sortArray(
            $aAdvertisers,
            ($this->listOrderField == 'id' ? 'advertiser_id' : $this->listOrderField),
            $this->listOrderDirection == 'up'
        );

        $aEntitiesData = array();
        foreach ($aAdvertisers as $advertiserId => $advertiser) {
            $advertiser['active'] = $this->_hasActiveStats($advertiser);

            $this->_summarizeStats($advertiser);

            if ($this->startLevel > $level || !$this->hideInactive || $advertiser['active']) {
                $advertiser['prefix'] = 'a';
                $advertiser['id'] = $advertiserId;
                $advertiser['linkparams'] = "clientid={$advertiserId}&";
                if (is_array($aParams) && count($aParams) > 0) {
                    foreach ($aParams as $key => $value) {
                        if ($key != "include" && $key != "exclude") {
                            $advertiser['linkparams'] .= $key . "=" . $value . "&";
                        }
                    }
                } else {
                    $advertiser['linkparams'] .= "&";
                }
                $advertiser['linkparams'] .= "period_preset={$period_preset}&period_start=" . MAX_getStoredValue('period_start', date('Y-m-d'))
                                          . "&period_end=" . MAX_getStoredValue('period_end', date('Y-m-d'));

                $advertiser['conversionslink'] = "stats.php?entity=conversions&clientid={$advertiserId}";
                $advertiser['expanded'] = MAX_isExpanded($advertiserId, $expand, $this->aNodes, $advertiser['prefix']);
                $advertiser['icon'] = MAX_getEntityIcon('advertiser', $advertiser['active'], $advertiser['type']);

                if ($advertiser['expanded'] || $this->startLevel > $level) {
                    $aParams2 = $aParams + array('advertiser_id' => $advertiserId);
                    $advertiser['subentities'] = $this->getCampaigns($aParams2, $level + 1, $expand);
                }

                $aEntitiesData[] = $advertiser;
            } elseif ($this->startLevel == $level) {
                $this->hiddenEntities++;
            }
        }

        return $aEntitiesData;
    }

    /**
     * Get campaign stats
     *
     * @param array Query parameters
     * @param int Tree level
     * @param string Expand GET parameter, used only when called from other get methods
     * @return Entities array
     */
    function getCampaigns($aParams, $level, $expand = '')
    {
        $aParams['include'] = array('placement_id', 'advertiser_id');
        $aParams['exclude'] = array('zone_id');
        $this->prepareData($aParams);
        $period_preset = MAX_getStoredValue('period_preset', 'today');

        $aPlacements = $this->mergeData($aParams, 'placement_id');
        MAX_sortArray(
            $aPlacements,
            ($this->listOrderField == 'id' ? 'placement_id' : $this->listOrderField),
            $this->listOrderDirection == 'up'
        );

        $aEntitiesData = array();
        foreach ($aPlacements as $campaignId => $campaign) {
            $campaign['active'] = $this->_hasActiveStats($campaign);

            if ($this->startLevel > $level || !$this->hideInactive || $campaign['active']) {

                $this->_summarizeStats($campaign);
                // mask anonymous campaigns if advertiser
                if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
                    // a) mask campaign name
                    $campaign['name'] = MAX_getPlacementName($campaign);
                    // b) mask ad names
                    if ($campaign['anonymous'] == 't') {
                        if(isset($campaign['children'])) {
		                    foreach ($campaign['children'] as $ad_id => $ad) {
		                        $campaign['children'][$ad_id]['name'] = MAX_getAdName($ad['name'], null, null, $campaign['anonymous'], $ad_id);
		                    }
                        }
                    }
                }

                $campaign['prefix'] = 'c';
                $campaign['id'] = $campaignId;
                $campaign['linkparams'] = "clientid={$campaign['advertiser_id']}&campaignid={$campaignId}&";
                if (is_array($aParams) && count($aParams) > 0) {
                    foreach ($aParams as $key => $value) {
                        if ($key != "include" && $key != "exclude") {
                            $campaign['linkparams'] .= $key . "=" . $value . "&";
                        }
                    }
                } else {
                    $campaign['linkparams'] .= "&";
                }
                $campaign['linkparams'] .= "period_preset={$period_preset}&period_start=" . MAX_getStoredValue('period_start', date('Y-m-d'))
                                          . "&period_end=" . MAX_getStoredValue('period_end', date('Y-m-d'));
                $campaign['expanded'] = MAX_isExpanded($campaignId, $expand, $this->aNodes, $campaign['prefix']);
                $campaign['icon'] = MAX_getEntityIcon('placement', $campaign['active'], $campaign['type']);

                $htmlToAppend = '';
                if($campaign['mtype'] == DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CAMPAIGN_OPTIN) {
                    $htmlToAppend = $this->getHtmlHelpLink('help-market-optin-campaign');
                } else if($campaign['mtype'] == DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_ZONE_OPTIN) {
                    $htmlToAppend = $this->getHtmlHelpLink('help-market-optin-zone');
                }
                $campaign['html-append'] = $htmlToAppend;


                // mask anonymous campaigns
                // a) mask campaign name
                $campaign['name'] = MAX_getPlacementName($campaign);
                if($campaign['mtype'] == DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CAMPAIGN_OPTIN) {
                    $campaign['name'] = $GLOBALS['strMarketCampaignOptin'];
                } else if($campaign['mtype'] == DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_ZONE_OPTIN) {
                    $campaign['name'] = $GLOBALS['strMarketZoneOptin'];
                }

                // b) mask ad names
                if(isset($campaign['children'])) {
	                foreach ($campaign['children'] as $ad_id => $ad) {
	                    $campaign['children'][$ad_id]['name'] = MAX_getAdName($ad['name'], null, null, $campaign['anonymous'], $ad_id);
	                }
                }
                if ($campaign['expanded'] || $this->startLevel > $level) {
                    $aParams2 = $aParams + array('placement_id' => $campaignId);
                    $campaign['subentities'] = $this->getBanners($aParams2, $level + 1, $expand);
                }

                $aEntitiesData[] = $campaign;
            } elseif ($this->startLevel == $level) {
                $this->hiddenEntities++;
            }
        }

        return $aEntitiesData;
    }

    /**
     * Returns the HTML used to display the help icon triggering the tooltip
     * @param $id ID of the html div to show on hover
     * @return string
     */
    private function getHtmlHelpLink($id)
    {
        return '<span class="link" help="'. $id .'"><span class="icon icon-info"></span></span>';
    }

    /**
     * Get banner stats
     *
     * @param array Query parameters
     * @param int Tree level
     * @param string Expand GET parameter, used only when called from other get methods
     * @return Entities array
     */
    function getBanners($aParams, $level, $expand = '')
    {
        global $phpAds_IAB;
        require_once MAX_PATH . '/www/admin/lib-size.inc.php';

        $aParams['include'] = array('placement_id'); // Needed to fetch the advertiser_id
        $aParams['exclude'] = array('zone_id');
        $this->prepareData($aParams);
        $period_preset = MAX_getStoredValue('period_preset', 'today');

        $aAds = $this->mergeData($aParams, 'ad_id');
        MAX_sortArray(
            $aAds,
            ($this->listOrderField == 'id' ? 'ad_id' : $this->listOrderField),
            $this->listOrderDirection == 'up'
        );

        $aEntitiesData = array();
        foreach ($aAds as $bannerId => $banner) {
            $banner['active'] = $this->_hasActiveStats($banner);

            if ($this->startLevel > $level || !$this->hideInactive || $banner['active']) {

                $this->_summarizeStats($banner);
                // mask banner name if anonymous campaign
                $campaign = Admin_DA::getPlacement($banner['placement_id']);
                $campaignAnonymous = $campaign['anonymous'] == 't' ? true : false;

                if($banner['type'] == DataObjects_Banners::BANNER_TYPE_MARKET) {
                    $marketBannerNameAndAdvertiserId = $this->getMarketBannerName($banner['name']);
                    $banner['name'] = $marketBannerNameAndAdvertiserId['name'];
                    $banner['marketAdvertiserId'] = $marketBannerNameAndAdvertiserId['marketAdvertiserId'];

                }
                $banner['name'] = MAX_getAdName($banner['name'], null, null, $campaignAnonymous, $bannerId);

                $banner['prefix'] = 'b';
                $banner['id'] = $bannerId;
                $banner['linkparams'] = "clientid={$banner['advertiser_id']}&campaignid={$banner['placement_id']}&bannerid={$bannerId}&";
                if (is_array($aParams) && count($aParams) > 0) {
                    foreach ($aParams as $key => $value) {
                        if ($key != "include" && $key != "exclude") {
                            $banner['linkparams'] .= $key . "=" . $value . "&";
                        }
                    }
                } else {
                    $banner['linkparams'] .= "&";
                }
                $banner['linkparams'] .= "period_preset={$period_preset}&period_start=" . MAX_getStoredValue('period_start', date('Y-m-d'))
                                          . "&period_end=" . MAX_getStoredValue('period_end', date('Y-m-d'));
                $banner['expanded'] = false;
                $banner['icon'] = MAX_getEntityIcon('ad', $banner['active'], $banner['type'], $banner['marketAdvertiserId']);

                $aEntitiesData[] = $banner;
            } elseif ($this->startLevel == $level) {
                $this->hiddenEntities++;
            }
        }

        return $aEntitiesData;
    }

    function getMarketBannerName($bannerName)
    {
        $marketAdvertiserId = false;
        // Market ads are written in the array as "campaignid-$NAME" which is a unique ID
        // across this manager
        $startRealBannerName = 1 + strpos($bannerName, '_');
        if($startRealBannerName !== false) {
            $bannerName = substr($bannerName, $startRealBannerName);
            // the banner $NAME can be
            // - "$ADVERTISERID_$ADWIDTH x $ADHEIGHT"
            // - or "$AD_WIDTH x $AD_HEIGHT"
            $startBannerDimension = strpos($bannerName, '_');

            $marketAdvertiserName = false;
            if($startBannerDimension === false) {
                $bannerDimensions = $bannerName;
            } else {
                $bannerDimensions = substr($bannerName, $startBannerDimension + 1);
                $marketAdvertiserId = substr($bannerName, 0, $startBannerDimension);

                if(!empty($marketAdvertiserId)) {
                    $marketAdvertiserName = $this->getMarketAdvertiserNameFromId($marketAdvertiserId);
                }
                if($marketAdvertiserName) {
                    $bannerName = $marketAdvertiserName . ' - ' .$bannerDimensions;
                }
            }
            if($marketAdvertiserName === false)
            {
                $bannerDimensions = explode('x', $bannerDimensions);
                $width = trim($bannerDimensions[0]);
                $height = trim($bannerDimensions[1]);
                $bannerName = phpAds_getBannerSize($width, $height);
                $bannerName = $bannerName;
            }
        }
        return array(
            'name' => $bannerName,
            'marketAdvertiserId' => $marketAdvertiserId
        );
    }
    /**
     * Loads the list of market advertisers once, and returns the name for the given market advertiser ID
     * @param $marketAdvertiserId
     * @return string or false
     */
    protected function getMarketAdvertiserNameFromId($marketAdvertiserId)
    {
        static $advertiserList = null;
        if(is_null($advertiserList)) {
            $oDbh = OA_DB::singleton();
            $query = 'SELECT market_advertiser_id, name
            			FROM '.$GLOBALS['_MAX']['CONF']['table']['prefix'].'ext_market_advertiser
            			';
            $rows = $oDbh->queryAll($query);
            foreach($rows as $row) {
                $advertiserList[$row['market_advertiser_id']] = utf8_encode($row['name']);
            }
        }
        if(isset($advertiserList[$marketAdvertiserId])) {
            return $advertiserList[$marketAdvertiserId];
        }
        return false;
    }

    /**
     * Get publisher stats
     *
     * @param array Query parameters
     * @param int Tree level
     * @param string Expand GET parameter, used only when called from other get methods
     * @return Entities array
     */
    function getPublishers($aParams, $level, $expand = '')
    {
        $aParams['include'] = array('publisher_id');
        $aParams['exclude'] = array('ad_id');
        $this->prepareData($aParams);
        $period_preset = MAX_getStoredValue('period_preset', 'today');

        $aPublishers = $this->mergeData($aParams, 'publisher_id');
        MAX_sortArray(
            $aPublishers,
            ($this->listOrderField == 'id' ? 'publisher_id' : $this->listOrderField),
            $this->listOrderDirection == 'up'
        );

        $aEntitiesData = array();
        foreach ($aPublishers as $publisherId => $publisher) {
            $publisher['active'] = $this->_hasActiveStats($publisher);

            $this->_summarizeStats($publisher);

            if ($this->startLevel > $level || !$this->hideInactive || $publisher['active']) {
                $publisher['prefix'] = 'p';
                $publisher['id'] = $publisherId;
                $publisher['linkparams'] = "affiliateid={$publisherId}&";
                if (is_array($aParams) && count($aParams) > 0) {
                    foreach ($aParams as $key => $value) {
                        if ($key != "include" && $key != "exclude") {
                            $publisher['linkparams'] .= $key . "=" . $value . "&";
                        }
                    }
                } else {
                    $publisher['linkparams'] .= "&";
                }
                $publisher['linkparams'] .= "period_preset={$period_preset}&period_start=" . MAX_getStoredValue('period_start', date('Y-m-d'))
                                          . "&period_end=" . MAX_getStoredValue('period_end', date('Y-m-d'));
                $publisher['expanded'] = MAX_isExpanded($publisherId, $expand, $this->aNodes, $publisher['prefix']);
                $publisher['icon'] = MAX_getEntityIcon('publisher', $publisher['active']);

                if ($publisher['expanded'] || $this->startLevel > $level) {
                    $aParams2 = $aParams + array('publisher_id' => $publisherId);
                    $publisher['subentities'] = $this->getZones($aParams2, $level + 1, $expand);
                }

                $aEntitiesData[] = $publisher;
            } elseif ($this->startLevel == $level) {
                $this->hiddenEntities++;
            }
        }

        return $aEntitiesData;
    }

    /**
     * Get zone stats
     *
     * @param array Query parameters
     * @param int Tree level
     * @param string Expand GET parameter, used only when called from other get methods
     * @return Entities array
     */
    function getZones($aParams, $level, $expand)
    {
        $aParams['exclude'] = array('ad_id');
        $aParams['include'] = array('publisher_id');
        $this->prepareData($aParams);
        $period_preset = MAX_getStoredValue('period_preset', 'today');

        $aZones = $this->mergeData($aParams, 'zone_id');
        MAX_sortArray(
            $aZones,
            ($this->listOrderField == 'id' ? 'zone_id' : $this->listOrderField),
            $this->listOrderDirection == 'up'
        );

        $aEntitiesData = array();
        foreach ($aZones as $zoneId => $zone) {
            $zone['active'] = $this->_hasActiveStats($zone);

            if ($this->startLevel > $level || !$this->hideInactive || $zone['active']) {

                $this->_summarizeStats($zone);

                $zone['prefix'] = 'z';
                $zone['id'] = $zoneId;
                $zone['linkparams'] = "affiliateid={$zone['publisher_id']}&zoneid={$zoneId}&";
                if (is_array($aParams) && count($aParams) > 0) {
                    foreach ($aParams as $key => $value) {
                        if ($key != "include" && $key != "exclude") {
                            $zone['linkparams'] .= $key . "=" . $value . "&";
                        }
                    }
                } else {
                    $zone['linkparams'] .= "&";
                }
                $zone['linkparams'] .= "period_preset={$period_preset}&period_start=" . MAX_getStoredValue('period_start', date('Y-m-d'))
                                          . "&period_end=" . MAX_getStoredValue('period_end', date('Y-m-d'));
                $zone['expanded'] = MAX_isExpanded($zoneId, $expand, $this->aNodes, $zone['prefix']);;
                $zone['icon'] = MAX_getEntityIcon('zone', $zone['active'], $zone['type']);

                if($zone['type'] == MAX_ZoneMarketMigrated) {
                    $zone['html-append'] = $this->getHtmlHelpLink('help-market-zone-migrated-from-pre-283');
                    $zone['name'] = $GLOBALS['strMarketZoneBeforeOpenX2.8.4'];
                }

                $aEntitiesData[] = $zone;
            } elseif ($this->startLevel == $level) {
                $this->hiddenEntities++;
            }
        }

        return $aEntitiesData;
    }

    /**
     * Exports stats data to an array
     *
     * The array will look like:
     *
     * Array (
     *     'headers' => Array ( 0 => 'Col1', 1 => 'Col2', ... )
     *     'formats' => Array ( 0 => 'text', 1 => 'default', ... )
     *     'data'    => Array (
     *         0 => Array ( 0 => 'Entity 1', 1 => '5', ...),
     *         ...
     *     )
     * )
     *
     * @param array Stats array
     */
    function exportArray()
    {
        $parent = parent::exportArray();

        $headers = array_merge(array($GLOBALS['strName']), $parent['headers']);
        $formats = array_merge(array('text'), $parent['formats']);
        $data    = array();

        foreach ($this->aEntitiesData as $e) {
            $row = array();
            $row[] = $e['name'];
            foreach (array_keys($this->aColumns) as $ck) {
                if ($this->showColumn($ck)) {
                    $row[] = $e[$ck];
                }
            }

            $data[] = $row;
        }

        return array(
            'headers' => $headers,
            'formats' => $formats,
            'data'    => $data
        );
    }
}

?>
