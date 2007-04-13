<?php
/**
 * Table Definition for affiliates_extra
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Affiliates_extra extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'affiliates_extra';                // table name
    var $affiliateid;                     // int(9)  not_null primary_key
    var $address;                         // blob(65535)  blob
    var $city;                            // string(255)  
    var $postcode;                        // string(64)  
    var $country;                         // string(255)  
    var $phone;                           // string(64)  
    var $fax;                             // string(64)  
    var $account_contact;                 // string(255)  
    var $payee_name;                      // string(255)  
    var $tax_id;                          // string(64)  
    var $mode_of_payment;                 // string(64)  
    var $currency;                        // string(64)  
    var $unique_users;                    // int(11)  
    var $unique_views;                    // int(11)  
    var $page_rank;                       // int(11)  
    var $category;                        // string(255)  
    var $help_file;                       // string(255)  

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
