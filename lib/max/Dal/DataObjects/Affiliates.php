<?php
/**
 * Table Definition for affiliates (Affiliate is often called Publisher)
 */
require_once 'AbstractUser.php';

class DataObjects_Affiliates extends DataObjects_AbstractUser 
{
    var $onDeleteCascade = true;
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'affiliates';                      // table name
    public $affiliateid;                     // int(9)  not_null primary_key auto_increment
    public $agencyid;                        // int(9)  not_null multiple_key
    public $name;                            // string(255)  not_null
    public $mnemonic;                        // string(5)  not_null
    public $comments;                        // blob(65535)  blob
    public $contact;                         // string(255)  
    public $email;                           // string(64)  not_null
    public $website;                         // string(255)  
    public $username;                        // string(64)  
    public $password;                        // string(64)  
    public $permissions;                     // int(9)  
    public $language;                        // string(64)  
    public $publiczones;                     // string(1)  not_null enum
    public $last_accepted_agency_agreement;    // datetime(19)  binary
    public $updated;                         // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Affiliates',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    

    /**
     * Returns phpAds_Affiliate constant value.
     *
     * @return integer
     */
    function getUserType()
    {
        return phpAds_Affiliate;
    }
    
    
    /**
     * Returns affiliateid.
     *
     * @return string
     */
    function getUserId()
    {
        return $this->affiliateid;
    }
    
    
    /**
     * Returns 0 if the last_accepted_agency_agreement is set to not null,
     * not zero value. Otherwise, returns 1.
     *
     * @return integer
     */
    function getNeedsToAgree()
    {
        return $this->last_accepted_agency_agreement ? 0 : 1;
    }
    
    
    /**
     * Returns an array with basic data about this object for use by permission
     * module. The correctness of this function depends on whether it was initialized
     * with affiliate_extra data.
     * 
     * @return array
     */
    function getAUserData()
    {
        return User::getAAffiliateData($this);
    }
}
