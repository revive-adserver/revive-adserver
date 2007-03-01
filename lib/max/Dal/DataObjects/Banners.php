<?php
/**
 * Table Definition for banners
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Banners extends DB_DataObjectCommon 
{
    var $onDeleteCascade = true;
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'banners';                         // table name
    var $bannerid;                        // int(9)  not_null primary_key auto_increment
    var $campaignid;                      // int(9)  not_null multiple_key
    var $active;                          // string(1)  not_null enum
    var $contenttype;                     // string(4)  not_null enum
    var $pluginversion;                   // int(9)  not_null
    var $storagetype;                     // string(7)  not_null enum
    var $filename;                        // string(255)  not_null
    var $imageurl;                        // string(255)  not_null
    var $htmltemplate;                    // blob(65535)  not_null blob
    var $htmlcache;                       // blob(65535)  not_null blob
    var $width;                           // int(6)  not_null
    var $height;                          // int(6)  not_null
    var $weight;                          // int(4)  not_null
    var $seq;                             // int(4)  not_null
    var $target;                          // string(16)  not_null
    var $url;                             // blob(65535)  not_null blob
    var $alt;                             // string(255)  not_null
    var $status;                          // string(255)  not_null
    var $bannertext;                      // blob(65535)  not_null blob
    var $description;                     // string(255)  not_null
    var $autohtml;                        // string(1)  not_null enum
    var $adserver;                        // string(50)  not_null
    var $block;                           // int(11)  not_null
    var $capping;                         // int(11)  not_null
    var $session_capping;                 // int(11)  not_null
    var $compiledlimitation;              // blob(65535)  not_null blob
    var $acl_plugins;                     // blob(65535)  blob
    var $append;                          // blob(65535)  not_null blob
    var $appendtype;                      // int(4)  not_null
    var $bannertype;                      // int(4)  not_null
    var $alt_filename;                    // string(255)  not_null
    var $alt_imageurl;                    // string(255)  not_null
    var $alt_contenttype;                 // string(4)  not_null enum
    var $comments;                        // blob(65535)  blob
    var $updated;                         // datetime(19)  not_null binary
    var $acls_updated;                    // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

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
    
    function insert()
    {
        $id = parent::insert();
        if ($id) {
            // add default zone
            $aVariables = array('ad_id' => $id, 'zone_id' => 0);
            Admin_DA::addAdZone($aVariables);
            MAX_addDefaultPlacementZones($id, $this->campaignid);
        }
        return $id;
    }
}
