<?php
/**
 * Table Definition for users
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Users extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    
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
    
    /**
     * Check whether user is linked only to one account
     *
     * @return boolean  True if linked only to one account, else false
     */
    function countLinkedAccounts()
    {
        $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_assoc->user_id = $this->user_id;
        return $doAccount_user_assoc->count();
    }
    
    /**
     * Returns user ID for specific username
     *
     * @param string $userName  Username
     * @return integer  User ID or false if user do not exists
     */
    function getUserIdByUserName($userName)
    {
        $this->username = $userName;
        if ($this->find()) {
            $this->fetch();
            return $this->user_id;
        }
        return false;
    }
    
    /**
     * Fetch user by it's username
     *
     * @param string $userName
     * @return boolean True on success else false
     */
    function fetchUserByUserName($userName)
    {
        $this->username = $userName;
        if (!$this->find()) {
            return false;
        }
        return $this->fetch();
    }

}

?>