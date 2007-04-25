<?php
/**
 * Table Definition for clients (Client is often called Advertiser)
 */
require_once 'AbstractUser.php';

class DataObjects_Clients extends DataObjects_AbstractUser 
{
    var $onDeleteCascade = true;
    var $dalModelName = 'Clients';
    var $usernameField = 'clientusername';
    var $passwordField = 'clientpassword';
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'clients';                         // table name
    public $clientid;                        // int(9)  not_null primary_key auto_increment
    public $agencyid;                        // int(9)  not_null multiple_key
    public $clientname;                      // string(255)  not_null
    public $contact;                         // string(255)  
    public $email;                           // string(64)  not_null
    public $clientusername;                  // string(64)  not_null
    public $clientpassword;                  // string(64)  not_null
    public $permissions;                     // int(9)  
    public $language;                        // string(64)  
    public $report;                          // string(1)  not_null enum
    public $reportinterval;                  // int(9)  not_null
    public $reportlastdate;                  // date(10)  not_null binary
    public $reportdeactivate;                // string(1)  not_null enum
    public $comments;                        // blob(65535)  blob
    public $updated;                         // datetime(19)  not_null binary
    public $lb_reporting;                    // int(1)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Clients',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    

    /**
     * Returns phpAds_Client constant value.
     *
     * @return integer
     */
    function getUserType()
    {
        return phpAds_Client;
    }
    
    
    /**
     * Returns clientid.
     *
     * @return string
     */
    function getUserId()
    {
        return $this->clientid;
    }
}
