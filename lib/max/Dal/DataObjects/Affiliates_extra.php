<?php
/**
 * Table Definition for affiliates_extra
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Affiliates_extra extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'affiliates_extra';                // table name
    public $affiliateid;                     // int(9)  not_null primary_key
    public $address;                         // blob(65535)  blob
    public $city;                            // string(255)  
    public $postcode;                        // string(64)  
    public $country;                         // string(255)  
    public $phone;                           // string(64)  
    public $fax;                             // string(64)  
    public $account_contact;                 // string(255)  
    public $payee_name;                      // string(255)  
    public $tax_id;                          // string(64)  
    public $mode_of_payment;                 // string(64)  
    public $currency;                        // string(64)  
    public $unique_users;                    // int(11)  
    public $unique_views;                    // int(11)  
    public $page_rank;                       // int(11)  
    public $category;                        // string(255)  
    public $help_file;                       // string(255)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Affiliates_extra',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    
    /**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    function sequenceKey() {
        return array(false, false, false);
    }
}
