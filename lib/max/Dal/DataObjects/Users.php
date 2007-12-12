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
     * Handle all necessary operations when new user is created
     *
     * @see DB_DataObject::insert()
     */
    function insert()
    {
        $userId = parent::insert();

        if (!empty($userId)) {
            require_once MAX_PATH . '/lib/OA/Permission/Gacl.php';

            // Create GACL ARO
            $oGacl = OA_Permission_Gacl::factory();
            if (!$oGacl->add_object('USERS', $this->contact_name, $userId, 0, 0, 'ARO')) {
                OA::debug('Error creating the gacl users ARO entry', PEAR_LOG_ERROR);
            }
        }

        return $userId;
    }

    /**
     * Handle all necessary operations when a user is updated
     *
     * @see DB_DataObject::update()
     */
    function update($dataObject = false)
    {
        $ret = parent::update($dataObject);
        if (!$ret) {
            return $ret;
        }

        $oGacl = OA_Permission_Gacl::factory();
        $acoId = $oGacl->get_object_id('USERS', $this->user_id, 'ARO');
        if ($acoId) {
            $oGacl->edit_object($acoId, 'ACCOUNTS', $this->contact_name, 0, 0, 0, 'ARO');
        }

        return $ret;
    }

    /**
     * Handle all necessary operations when a user is deleted
     *
     * @see DB_DataObject::delete()
     */
    function delete($useWhere = false, $cascade = true, $parentid = null)
    {
        $ret = parent::delete($useWhere, $cascade, $parentid);

        if ($ret) {
            $oGacl = OA_Permission_Gacl::factory();
            $acoId = $oGacl->get_object_id('USERS', $this->user_id, 'ARO');
            if ($acoId) {
                $oGacl->del_object($acoId, 'ARO', true);
            }
        }

        return $ret;
    }

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