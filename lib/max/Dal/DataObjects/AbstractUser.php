<?php
/**
 * Table Definition for agency
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_AbstractUser extends DB_DataObjectCommon 
{
    var $usernameField = 'username';
    
    function userExists($username)
    {
        $this->whereAddLower($this->usernameField, $username);
        return $this->count();
    }
    
    /**
     * Returns array of unique users
     *
     * @return array
     * @access public
     */
    function getUniqueUsers()
    {
        return $this->getUniqueValuesFromColumn($this->usernameField);
    }
}
