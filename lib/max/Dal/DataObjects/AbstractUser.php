<?php

require_once 'DB_DataObjectCommon.php';
require_once MAX_PATH . '/lib/max/Permission/User.php';


/**
 * The base data object for all objects representing different Openads users.
 */
class DataObjects_AbstractUser extends DB_DataObjectCommon 
{
    var $usernameField = 'username';
    var $passwordField = 'password';
    
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
    
    
    /**
     * Returns a username for this user independently of what is the column
     * name where username is kept. Created because clients table store
     * username in 'clientusername' column while other tables store them in
     * 'username' column.
     *
     * @return string
     */
    function getSUsername()
    {
        $sFieldName = $this->usernameField;
        return $this->$sFieldName;
    }
    
    
    /**
     * Sets the username independent of what is the column name where the
     * username is stored.
     *
     * @param string $sUsername
     * @see #getSUsername()
     */
    function setSUsername($sUsername)
    {
        $sFieldName = $this->usernameField;
        $this->$sFieldName = $sUsername;
    }
    
    
    /**
     * Sets the password independent of what is the column name where the
     * password is stored.
     *
     * @param string $md5digest
     */
    function setPassword($md5digest)
    {
        $sFieldName = $this->passwordField;
        $this->$sFieldName = $md5digest;
    }
    
    
    /**
     * Returns one of the constants representing type of the user, eg.
     * phpAdsAgency, phpAdsAdmin...
     *
     * The method must be overriden by subclasses! By default returns null.
     * Note that such a method should not be really necessary if we could use
     * objects everywhere in the application instead of arrays.
     * 
     * @return string
     */
    function getUserType()
    {
        return null;
    }
    
    
    /**
     * Returns a proper user id for a given user type. For example, it'll be
     * $agencyid for Agency, clientid for Client...
     * 
     * The method must be overriden by subclasses! By default returns null.
     *
     * @return string
     */
    function getUserId()
    {
        return null;
    }
    
    
    /**
     * Returns an array with basic data about this object for use by permission
     * module.
     * 
     * @return array
     */
    function getAUserData()
    {
        return User::getAUserData($this);
    }
}
