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

    var $__table = 'clients';                         // table name
    var $clientid;                        // int(9)  not_null primary_key auto_increment
    var $agencyid;                        // int(9)  not_null multiple_key
    var $clientname;                      // string(255)  not_null
    var $contact;                         // string(255)  
    var $email;                           // string(64)  not_null
    var $clientusername;                  // string(64)  not_null
    var $clientpassword;                  // string(64)  not_null
    var $permissions;                     // int(9)  
    var $language;                        // string(64)  
    var $report;                          // string(1)  not_null enum
    var $reportinterval;                  // int(9)  not_null
    var $reportlastdate;                  // date(10)  not_null binary
    var $reportdeactivate;                // string(1)  not_null enum
    var $comments;                        // blob(65535)  blob
    var $updated;                         // datetime(19)  not_null binary

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
