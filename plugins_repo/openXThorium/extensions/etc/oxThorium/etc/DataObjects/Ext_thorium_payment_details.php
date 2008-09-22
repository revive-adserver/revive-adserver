<?php
/**
 * Table Definition for ext_thorium_payment_details
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_thorium_payment_details extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_thorium_payment_details';     // table name
    public $agencyid;                        // MEDIUMINT(9) => openads_mediumint => 129 
    public $company;                         // VARCHAR(255) => openads_varchar => 130 
    public $country;                         // VARCHAR(16) => openads_varchar => 130 
    public $registered_for_tax;              // ENUM('t','f') => openads_enum => 2 
    public $first_name;                      // VARCHAR(64) => openads_varchar => 130 
    public $last_name;                       // VARCHAR(64) => openads_varchar => 130 
    public $phone;                           // VARCHAR(16) => openads_varchar => 130 
    public $email;                           // VARCHAR(64) => openads_varchar => 130 
    public $address_1;                       // TEXT() => openads_text => 34 
    public $address_2;                       // TEXT() => openads_text => 34 
    public $address_3;                       // TEXT() => openads_text => 34 
    public $city;                            // VARCHAR(255) => openads_varchar => 2 
    public $state;                           // VARCHAR(255) => openads_varchar => 2 
    public $zip_code;                        // VARCHAR(64) => openads_varchar => 2 
    public $payee_name;                      // VARCHAR(255) => openads_varchar => 130 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ext_thorium_payment_details',$k,$v); }

    var $defaultValues = array(
                'company' => '',
                'country' => '',
                'registered_for_tax' => 'f',
                'first_name' => '',
                'last_name' => '',
                'phone' => '',
                'email' => '',
                'payee_name' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>