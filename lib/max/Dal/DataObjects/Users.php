<?php
/**
 * Table Definition for users
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Users extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'users';                           // table name
    var $user_id;                         // int(9)  not_null primary_key auto_increment
    var $contact_name;                    // string(255)  not_null
    var $email_address;                   // string(64)  not_null
    var $username;                        // string(64)  multiple_key
    var $password;                        // string(64)  
    var $default_account_id;              // int(9)  
    var $comments;                        // blob(65535)  blob
    var $active;                          // int(1)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Users',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Checks is a username already exists in the database
     *
     * @param string $username
     * @return boolean
     */
    function userExists($username)
    {
        $this->whereAddLower('username', $username);
        return (bool)$this->count();
    }

    /**
     * Returns array of unique users
     *
     * @return array
     * @access public
     */
    function getUniqueUsers()
    {
        return $this->getUniqueValuesFromColumn('username');
    }

}

?>