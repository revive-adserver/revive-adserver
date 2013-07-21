<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';


/**
 * Dal methods for the M2M OAC API
 *
 */
class OA_Dal_Central_M2M
{
    /**
     * A method to retrieve the M2M password for an account
     *
     * @param int $accountId
     * @return mixed The password, or false if there is no password stored
     */
    function getM2MPassword($accountId)
    {
        return OA_Dal_Central_M2M::_getM2MParameter($accountId, 'm2m_password');
    }

    /**
     * A method to store the M2M password for an account
     *
     * @param int $accountId
     * @param string $m2mPassword
     * @return bool
     */
    function setM2MPassword($accountId, $m2mPassword)
    {
        return OA_Dal_Central_M2M::_setM2MParameter($accountId, 'm2m_password', $m2mPassword);
    }

    /**
     * A method to retrieve the M2M ticket for an account
     *
     * @param int $accountId
     * @return mixed The ticket, or false if there is no ticket stored
     */
    function getM2MTicket($accountId)
    {
        return OA_Dal_Central_M2M::_getM2MParameter($accountId, 'm2m_ticket');
    }

    /**
     * A method to store the M2M ticket for an account
     *
     * @param int $accountId
     * @param string $m2mTicket
     * @return bool
     */
    function setM2MTicket($accountId, $m2mTicket)
    {
        return OA_Dal_Central_M2M::_setM2MParameter($accountId, 'm2m_ticket', $m2mTicket);
    }

    /** A private method to retrieve an M2M parameter in the accounts table
     *
     * @param int $accountId
     * @param string $fieldName
     * @return bool
     */
    function _getM2MParameter($accountId, $fieldName)
    {
        $doAccounts = OA_Dal::factoryDO('accounts');

        if (!$accountId) {
            $accountId = $doAccounts->getAdminAccountId();
        }

        $doAccounts->account_id = $accountId;
        $doAccounts->find();

        if ($doAccounts->fetch() && !empty($doAccounts->$fieldName)) {
            return $doAccounts->$fieldName;
        }

        return false;
    }

    /**
     * A private method to store an M2M parameter in the accounts table
     *
     * @param int $accountId
     * @param string $fieldName
     * @param string $content
     * @return bool
     */
    function _setM2MParameter($accountId, $fieldName, $content)
    {
        $doAccounts = OA_Dal::factoryDO('accounts');

        if (!$accountId) {
            $accountId = $doAccounts->getAdminAccountId();
        }

        $doAccounts->account_id = $accountId;
        $doAccounts->$fieldName = $content;

        return (bool)$doAccounts->update();
    }
}

?>
