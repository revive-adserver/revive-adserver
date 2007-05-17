<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * Password recovery DAL for Openads
 *
 * @package OpenadsDal
 */

require_once MAX_PATH.'/lib/max/Dal/Common.php';

class MAX_Dal_PasswordRecovery extends MAX_Dal_Common
{
    /**
     * Return table and field names for each supported user type
     *
     * @return array with user types as keys and informations inside an array as values
     */
    function getUserTypeMappings()
    {
        return array(
            'agency' => array(
                    'table'    => $this->getFullTableName('agency'),
                    'id'       => 'agencyid',
                    'agencyid' => '0',
                    'email'    => 'email',
                    'name'     => 'name',
                    'username' => 'username',
                    'password' => 'password'
                ),
            'advertiser' => array(
                    'table'    => $this->getFullTableName('clients'),
                    'id'       => 'clientid',
                    'agencyid' => 'agencyid',
                    'email'    => 'email',
                    'name'     => 'clientname',
                    'username' => 'clientusername',
                    'password' => 'clientpassword'
                ),
            'publisher' => array(
                    'table'    => $this->getFullTableName('affiliates'),
                    'id'       => 'affiliateid',
                    'agencyid' => 'agencyid',
                    'email'    => 'email',
                    'name'     => 'name',
                    'username' => 'username',
                    'password' => 'password'
                )
            );
    }

    /**
     * Search users with a matching email address
     *
     * @param string e-mail
     * @return array matching users
     */
    function searchMatchingUsers($email)
    {
        $user_types = $this->getUserTypeMappings();

        $users = array();
        foreach ($user_types as $k => $v) {
            $query = "
                SELECT
                    '{$k}' AS usertype,
                    {$v['id']} AS id,
                    {$v['agencyid']} AS agencyid,
                    {$v['name']} AS name,
                    {$v['username']} AS username,
                    {$v['email']} AS email
                FROM
                    {$v['table']}
                WHERE
                    {$v['email']} = ". $this->oDbh->quote($email, 'text') ."
                    AND COALESCE({$v['username']}, '') <> ''
                ORDER BY
                    username
            ";

            foreach ($this->oDbh->getAll($query) as $row) {
                $users[] = $row;
            }
        }

        return $users;
    }

    /**
     * Generate and save a recovery ID for a user
     *
     * @param string user type
     * @param int user ID
     * @return array generated recovery ID
     */
    function generateRecoveryId($user_type, $user_id)
    {
        $password_recovery_table = $this->getFullTableName('password_recovery');

        $recovery_id = strtoupper(md5(uniqid('', true)));
        $recovery_id = substr(chunk_split($recovery_id, 8, '-'), -23, 22);

        $query = "DELETE FROM {$password_recovery_table} WHERE user_type = ". $this->oDbh->quote($user_type, 'text') ." AND user_id = ". $this->oDbh->quote($user_id, 'integer');
        $this->oDbh->exec($query);

        $query = "
                INSERT INTO {$password_recovery_table} (
                    user_type, user_id, recovery_id, updated
                ) VALUES (
                    ". $this->oDbh->quote($user_type, 'text') .",
                    ". $this->oDbh->quote($user_id, 'integer') .",
                    ". $this->oDbh->quote($recovery_id, 'integer') .",
                    '". OA::getNow() ."')";
        $this->oDbh->exec($query);

        return $recovery_id;
    }

    /**
     * Check if recovery ID is valid
     *
     * @param string recovery ID
     * @return bool true if recovery ID is valid
     */
    function checkRecoveryId($recovery_id)
    {
        $password_recovery_table = $this->getFullTableName('password_recovery');

        $query = "SELECT COUNT(*) AS cnt FROM {$password_recovery_table} WHERE recovery_id = ". $this->oDbh->quote($recovery_id, 'integer');
        return (bool)$this->oDbh->getOne($query);
    }

    /**
     * Save the new password in the user properties
     *
     * @param string recovery ID
     * @param string new password
     * @return bool true if the new password was correctly saved
     */
    function saveNewPassword($recovery_id, $password)
    {
        $password_recovery_table = $this->getFullTableName('password_recovery');

        $user_types = $this->getUserTypeMappings();

        $query = "SELECT user_type, user_id FROM {$password_recovery_table} WHERE recovery_id = ". $this->oDbh->quote($recovery_id, 'integer');
        $row = $this->oDbh->getRow($query);

        if ($row) {
            $u = $user_types[$row['user_type']];
            $query = "UPDATE {$u['table']} SET {$u['password']} = ". $this->oDbh->quote(md5($password), 'text') ." WHERE {$u['id']} = ". $this->oDbh->quote($row['user_id'], 'integer');
            $res = $this->oDbh->exec($query);

            $query = "DELETE FROM {$password_recovery_table} WHERE recovery_id = ". $this->oDbh->quote($recovery_id, 'integer');
            $this->oDbh->exec($query);

            return true;
        }

        return false;
    }

    /**
     * Prepend table prefix to the given table name.
     *
     * @param string $short_table_name The unqualified table name, like 'agency' or 'banners'
     * @return string A table name suitable for use in SQL "FROM" clauses
     */
    function getFullTableName($short_table_name)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $full_table_name = $conf['table']['prefix'] . $short_table_name;
        return $full_table_name;
    }
}

?>
