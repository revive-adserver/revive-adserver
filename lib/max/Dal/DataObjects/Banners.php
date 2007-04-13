<?php
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

    public $__table = 'banners';                         // table name
    public $bannerid;                        // int(9)  not_null primary_key auto_increment
    public $campaignid;                      // int(9)  not_null multiple_key
    public $active;                          // string(1)  not_null enum
    public $contenttype;                     // string(4)  not_null enum
    public $pluginversion;                   // int(9)  not_null
    public $storagetype;                     // string(7)  not_null enum
    public $filename;                        // string(255)  not_null
    public $imageurl;                        // string(255)  not_null
    public $htmltemplate;                    // blob(65535)  not_null blob
    public $htmlcache;                       // blob(65535)  not_null blob
    public $width;                           // int(6)  not_null
    public $height;                          // int(6)  not_null
    public $weight;                          // int(4)  not_null
    public $seq;                             // int(4)  not_null
    public $target;                          // string(16)  not_null
    public $url;                             // blob(65535)  not_null blob
    public $alt;                             // string(255)  not_null
    public $status;                          // string(255)  not_null
    public $bannertext;                      // blob(65535)  not_null blob
    public $description;                     // string(255)  not_null
    public $autohtml;                        // string(1)  not_null enum
    public $adserver;                        // string(50)  not_null
    public $block;                           // int(11)  not_null
    public $capping;                         // int(11)  not_null
    public $session_capping;                 // int(11)  not_null
    public $compiledlimitation;              // blob(65535)  not_null blob
    public $acl_plugins;                     // blob(65535)  blob
    public $append;                          // blob(65535)  not_null blob
    public $appendtype;                      // int(4)  not_null
    public $bannertype;                      // int(4)  not_null
    public $alt_filename;                    // string(255)  not_null
    public $alt_imageurl;                    // string(255)  not_null
    public $alt_contenttype;                 // string(4)  not_null enum
    public $comments;                        // blob(65535)  blob
    public $updated;                         // datetime(19)  not_null binary
    public $acls_updated;                    // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Banners',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function delete($useWhere = false, $cascade = true)
    {
    	$doBanner = clone($this);
    	$doBanner->find();
    	while ($doBanner->fetch()) {
    		phpAds_ImageDelete ($this->type, $this->filename);
    	}
    	return parent::delete($useWhere, $cascade);
    }
    
    /**
     * Duplicates the banner.
     * 
     * @return int  the new bannerid
     *
     */
    function duplicate()
    {
        // unset the bannerId
        $old_adId = $this->bannerid;
        unset($this->bannerid);
        
        $this->description = 'Copy of ' . $this->description;
        
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
    	$this->htmlcache = phpAds_getBannerCache($this->toArray());
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
}
