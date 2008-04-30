<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * Table Definition for banners
 */
require_once 'DB_DataObjectCommon.php';
include_once MAX_PATH . '/www/admin/lib-banner.inc.php';
include_once MAX_PATH . '/www/admin/lib-storage.inc.php';

class DataObjects_Banners extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'banners';                         // table name
    var $bannerid;                        // int(9)  not_null primary_key auto_increment
    var $campaignid;                      // int(9)  not_null multiple_key
    var $contenttype;                     // string(12)  not_null enum
    var $pluginversion;                   // int(9)  not_null
    var $storagetype;                     // string(21)  not_null enum
    var $filename;                        // string(765)  not_null
    var $imageurl;                        // string(765)  not_null
    var $htmltemplate;                    // blob(65535)  not_null blob
    var $htmlcache;                       // blob(65535)  not_null blob
    var $width;                           // int(6)  not_null
    var $height;                          // int(6)  not_null
    var $weight;                          // int(4)  not_null
    var $seq;                             // int(4)  not_null
    var $target;                          // string(48)  not_null
    var $url;                             // blob(65535)  not_null blob
    var $alt;                             // string(765)  not_null
    var $statustext;                      // string(765)  not_null
    var $bannertext;                      // blob(65535)  not_null blob
    var $description;                     // string(765)  not_null
    var $autohtml;                        // string(3)  not_null enum
    var $adserver;                        // string(150)  not_null
    var $block;                           // int(11)  not_null
    var $capping;                         // int(11)  not_null
    var $session_capping;                 // int(11)  not_null
    var $compiledlimitation;              // blob(65535)  not_null blob
    var $acl_plugins;                     // blob(65535)  blob
    var $append;                          // blob(65535)  not_null blob
    var $appendtype;                      // int(4)  not_null
    var $bannertype;                      // int(4)  not_null
    var $alt_filename;                    // string(765)  not_null
    var $alt_imageurl;                    // string(765)  not_null
    var $alt_contenttype;                 // string(12)  not_null enum
    var $comments;                        // blob(65535)  blob
    var $updated;                         // datetime(19)  not_null binary
    var $acls_updated;                    // datetime(19)  not_null binary
    var $keyword;                         // string(765)  not_null
    var $transparent;                     // int(1)  not_null
    var $parameters;                      // blob(65535)  blob
    var $an_banner_id;                    // int(11)
    var $as_banner_id;                    // int(11)
    var $status;                          // int(11)  not_null
    var $ad_direct_status;                // int(4)  not_null
    var $ad_direct_rejection_reason_id;    // int(4)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Banners',$k,$v); }

    var $defaultValues = array(
                'campaignid' => 0,
                'contenttype' => 'gif',
                'pluginversion' => 0,
                'storagetype' => 'sql',
                'width' => 0,
                'height' => 0,
                'weight' => 1,
                'seq' => 0,
                'autohtml' => 't',
                'block' => 0,
                'capping' => 0,
                'session_capping' => 0,
                'appendtype' => 0,
                'bannertype' => 0,
                'alt_contenttype' => 'gif',
                'acls_updated' => '%NO_DATE_TIME%',
                'transparent' => 0,
                'status' => 0,
                'ad_direct_status' => 0,
                'ad_direct_rejection_reason_id' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function delete($useWhere = false, $cascade = true, $parentid = null)
    {
    	$doBanner = clone($this);
    	$doBanner->find();
    	while ($doBanner->fetch()) {
    		phpAds_ImageDelete ($this->type, $this->filename);
    	}
    	return parent::delete($useWhere, $cascade, $parentid);
    }

    /**
     * Duplicates the banner.
     * @param string $new_campaignId only when the banner is
     *        duplicated as consequence of a campaign duplication
     * @return int  the new bannerid
     *
     */
    function duplicate($new_campaignId = null)
    {
        // unset the bannerId
        $old_adId = $this->bannerid;
        unset($this->bannerid);

        $this->description = 'Copy of ' . $this->description;
        if ($new_campaignId != null) {
        	$this->campaignid = $new_campaignId;
        }

        // Set the filename
        // We want to rename column 'storagetype' to 'type' so...
        if ($this->storagetype == 'web' || $this->storagetype == 'sql') {
            $this->filename = $this->_imageDuplicate($this->storagetype, $this->filename);
        } elseif ($this->type == 'web' || $this->type == 'sql') {
            $this->filename = $this->_imageDuplicate($this->type, $this->filename);
        }

        // Insert the new banner and get the ID
        $new_adId = $this->insert();

        // Copy ACLs and capping
        MAX_AclCopy(basename($_SERVER['PHP_SELF']), $old_adId, $new_adId);

        // Duplicate and ad-zone associations
        MAX_duplicateAdZones($old_adId, $new_adId);

        // Return the new bannerId
        return $new_adId;
    }

    function insert()
    {
        $this->_rebuildCache();
        $id = parent::insert();
        if ($id) {
            // add default zone
            $aVariables = array('ad_id' => $id, 'zone_id' => 0);
            Admin_DA::addAdZone($aVariables);
            MAX_addDefaultPlacementZones($id, $this->campaignid);
        }
        return $id;
    }

    function _rebuildCache()
    {
        if (!is_null($this->htmltemplate)) {
            $this->htmlcache = phpAds_getBannerCache($this->toArray());
        }
    }


    /**
     * Automatically refreshes HTML cache in addition to normal
     * update() call.
     *
     * @see DB_DataObject::update()
     * @param object $dataObject
     * @return boolean
     * @access public
     */
    function update($dataObject = false)
    {
        $this->_rebuildCache();
        return parent::update($dataObject);
    }

    /**
     * Wrapper for phpAds_ImageDuplicate
     *
     * @access private
     */
    function _imageDuplicate($storagetype, $filename)
    {
        return phpAds_ImageDuplicate($storagetype, $filename);
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->bannerid;
    }

    function _getContext()
    {
        return 'Banner';
    }

    /**
     * A method to return an array of account IDs of the account(s) that
     * should "own" any audit trail entries for this entity type; these
     * are NOT related to the account ID of the currently active account
     * (which is performing some kind of action on the entity), but is
     * instead related to the type of entity, and where in the account
     * heirrachy the entity is located.
     *
     * @return array An array containing up to three indexes:
     *                  - "OA_ACCOUNT_ADMIN" or "OA_ACCOUNT_MANAGER":
     *                      Contains the account ID of the manager account
     *                      that needs to be able to see the audit trail
     *                      entry, or, the admin account, if the entity
     *                      is a special case where only the admin account
     *                      should see the entry.
     *                  - "OA_ACCOUNT_ADVERTISER":
     *                      Contains the account ID of the advertiser account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     *                  - "OA_ACCOUNT_TRAFFICKER":
     *                      Contains the account ID of the trafficker account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     */
    function getOwningAccountIds()
    {
        // Banners don't have an account_id, get it from the parent
        // campaign (stored in the "campaigns" table) using the
        // "campaignid" key
        return parent::getOwningAccountIds('campaigns', 'campaignid');
    }

    /**
     * build a campaign specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']   = $this->description;
        switch ($actionid)
        {
            case OA_AUDIT_ACTION_UPDATE:
                        $aAuditFields['campaignid']    = $this->campaignid;
                        break;
        }
    }

}

?>
