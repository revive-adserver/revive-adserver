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

require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';

require_once MAX_PATH . '/lib/OA/DB.php';

/**
 * A preferences management class for the Openads administration interface.
 *
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 * @TODO Class needs to be updated so that it will load the admin
 * preferences for items that are not set in the agency preferences.
 */
class MAX_Admin_Preferences
{
    var $prefSql;

    /**
     * The constructor method. Creates an array so that updates to
     * agency preferences can be (locally) stored.
     */
    function MAX_Admin_Preferences()
    {
        $this->prefSql = array();
    }

    /**
     * A method to load the preference data stored in the database
     * into a global array ($GLOBALS['_MAX']['PREF']).
     *
     * @static
     * @param integer $agencyId Optional agency ID.
     * @return array Returns an array containing the preferences loaded
     *               into the global array.
     */
    function loadPrefs($agencyId = null)
    {
        if (!isset($GLOBALS['_MAX']['PREF'])) {
            $GLOBALS['_MAX']['PREF'] = array();
        }
        $conf = $GLOBALS['_MAX']['CONF'];
        if (is_null($agencyId)) {
            if (phpAds_isUser(phpAds_Agency)) {
                $agencyId = phpAds_getUserID();
            } else {
                $agencyId = (!empty($conf['max']['defaultAgency'])) ? $conf['max']['defaultAgency'] : 0;
            }
        }
        $oDbh = &OA_DB::singleton();
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['preference']}
            WHERE
                agencyid = ". $oDbh->quote($agencyId, 'integer');

        $rc = $oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() == 1) {
            $row = $rc->fetchRow();
            foreach ($row as $key => $value) {
                $GLOBALS['_MAX']['PREF'][$key] = $value;
            }

            if (phpAds_isUser(phpAds_Client)) {
                MAX_Admin_Preferences::loadEntityPrefs('advertiser');
            } elseif (phpAds_isUser(phpAds_Affiliate)) {
                MAX_Admin_Preferences::loadEntityPrefs('publisher');
            }

            return $GLOBALS['_MAX']['PREF'];
        }
        return array();
    }

    /**
     * A method to load entity preference data stored in the database
     * as key/value pairs and merge it into a global array
     * ($GLOBALS['_MAX']['PREF'])
     *
     * @static
     * @param string Entity type (currently supported: advertiser, publisher)
     * @param int The entity unique id, defaults to current user id
     */
    function loadEntityPrefs($entityType, $entityId = '')
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (empty($entityId)) {
            $entityId = phpAds_getUserId();
        }

        switch ($entityType) {

        case 'advertiser':
            $table_name   = "{$conf['table']['prefix']}{$conf['table']['preference_advertiser']}";
            $table_column = 'advertiser_id';
            break;

        case 'publisher':
            $table_name   = "{$conf['table']['prefix']}{$conf['table']['preference_publisher']}";
            $table_column = 'publisher_id';
            break;

        default:
            MAX::raiseError("The MAX_Admin_Preferences module discovered an entity type that it didn't know how to handle.", MAX_ERROR_INVALIDARGS);
        }

        $oDbh = &OA_DB::singleton();
        $query = "
            SELECT
                preference,
                value
            FROM
                {$table_name}
            WHERE
                {$table_column} = ". $oDbh->quote($entityId, 'integer');

        $rc = $oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }

        while ($row = $rc->fetchRow()) {
            if (array_key_exists($row['preference'], $GLOBALS['_MAX']['PREF'])) {
                $GLOBALS['_MAX']['PREF'][$row['preference']] = $row['value'];
            }
        }
    }

    /**
     * A method to write entity preference data  in the database
     * as key/value pairs
     *
     * @static
     * @param string Entity type (currently supported: advertiser, publisher)
     * @param int The entity unique id, defaults to current user id
     * @return boolean True when the preferences were correctly saved, false otherwise.
     */
    function writeEntityPrefs($entityType, $entityId = '')
    {
        if (!is_null($this->prefSql)) {
            $conf = $GLOBALS['_MAX']['CONF'];
            $oDbh = &OA_DB::singleton();

            if (empty($entityId)) {
                $entityId = phpAds_getUserId();
            }

            switch ($entityType) {

            case 'advertiser':
                $table_name   = "{$conf['table']['prefix']}{$conf['table']['preference_advertiser']}";
                $table_column = 'advertiser_id';
                break;

            case 'publisher':
                $table_name   = "{$conf['table']['prefix']}{$conf['table']['preference_publisher']}";
                $table_column = 'publisher_id';
                break;

            default:
                MAX::raiseError("The MAX_Admin_Preferences module discovered an entity type that it didn't know how to handle.", MAX_ERROR_INVALIDARGS);
            }

            $query = "
                INSERT INTO {$table_name} (
                    {$table_column}, preference, value
                ) VALUES (
                    ?, ? ,?
                )
                ";
            $aTypes = array('integer', 'text', 'text');
            $st     = $oDbh->prepare($query, $aTypes);
            foreach ($this->prefSql as $key => $value) {

                // Don't use a PEAR_Error handler
                PEAR::pushErrorHandling(null);
                // Try to INSERT first
                $rows = $oDbh->execute(array($entityId, $key, $value));
                // Restore the PEAR_Error handler
                PEAR::popErrorHandling();
                if (PEAR::isError($rows)) {
                    // Can't INSERT, try UPDATE instead
                    $query = "
                        UPDATE
                            {$table_name}
                        SET
                            value = '$value'
                        WHERE
                            {$table_column} = ?
                        AND
                            preference = ?";
                    $aTypes = array('integer', 'text');
                    $st     = $oDbh->prepare($query, $aTypes);
                    $rows   = $oDbh->execute(array($entityId, $key));
                    if (PEAR::isError($rows)) {
                        return MAX::raiseError($rows, MAX_ERROR_DBFAILURE);
                    }
                }
            }
            unset($this->prefSql);
        }

        return true;
    }

    /**
     * A method for defining required changes to the agency preferences.
     *
     *
     * @param string $pref The preference value to change.
     * @param string $value The new value for the preference.
     */
    function setPrefChange($pref, $value)
    {
        if (phpAds_isUser(phpAds_Agency)) {
            $agencyid = phpAds_getUserID();
        } else {
            $agencyid = 0;
        }
        $this->prefSql[$pref] = $value;
    }

    /**
     * A method for writing out any required changes to an agency's preferences.
     *
     * @return boolean True when the preferences were correctly saved,
     *                 false otherwise.
     */
    function writePrefChange()
    {
        if (!is_null($this->prefSql)) {
            $conf = $GLOBALS['_MAX']['CONF'];
            $oDbh = &OA_DB::singleton();

            if (phpAds_isUser(phpAds_Client)) {
                return MAX_Admin_Preferences::writeEntityPrefs('advertiser');
            } elseif (phpAds_isUser(phpAds_Affiliate)) {
                return MAX_Admin_Preferences::writeEntityPrefs('publisher');
            } else {
                $agencyId   = phpAds_isUser(phpAds_Agency) ? phpAds_getUserID() : 0;
            }

            // Try to INSERT first
            $query = "
                INSERT INTO
                    {$conf['table']['prefix']}{$conf['table']['preference']}
                    (
                    agencyid,
                ";
            foreach ($this->prefSql as $key => $value) {
                $query .= "$key, ";
            }
            $query = preg_replace('/, $/', '', $query);
            $query .= "
                    )
                VALUES
                    (
                    ". $oDbh->quote($agencyId, 'integer') .",
                ";
            foreach ($this->prefSql as $value) {
                $query .= $oDbh->quote($value) .", ";
            }
            $query = preg_replace('/, $/', '', $query);
            $query .= '
                    )
                ';
            // Don't use a PEAR_Error handler
            PEAR::pushErrorHandling(null);
            $rows = $oDbh->exec($query);
            // Restore the PEAR_Error handler
            PEAR::popErrorHandling();
            if (PEAR::isError($rows)) {
                // Can't INSERT, try UPDATE instead
                foreach ($this->prefSql as $key => $value) {
                    $sql[] = "$key = ". $oDbh->quote($value);
                }
                $query = "
                    UPDATE
                        {$conf['table']['prefix']}{$conf['table']['preference']}
                    SET
                        " . join(', ', $sql) . "
                    WHERE
                        agencyid = ". $oDbh->quote($agencyId, 'integer');

                $rows = $oDbh->exec($query);
                if (PEAR::isError($rows)) {
                    return MAX::raiseError($rows, MAX_ERROR_DBFAILURE);
                }
            }
            unset($this->prefSql);
        }
        return true;
    }

    /**
     * A method for unserializing and expanding column preferences.
     *
     * Column preferences are currently stored as a serialized array, which
     * looks like this:
     *
     *  Array
     *  (
     *      [1] => Array
     *          (
     *              [show]  => (bool)   Show the column to the user
     *              [label] => (string) Custom label for the column
     *              [rank]  => (int)    Value used to sort the columns
     *          )
     *      [2] => Array
     *          (
     *              ...
     *          )
     *      [4] => Array
     *          (
     *              ...
     *          )
     *      [8] => Array
     *          (
     *              ...
     *          )
     *  )
     *
     * The array keys are the usertype constants (phpAds_Admin, phpAds_Client,
     * etc.).
     *
     * @return boolean True when the preferences were correctly saved,
     *                 false otherwise.
     */
    function expandColumnPrefs()
    {
        $max_rank     = 0;
        $missing_cols = array();
        foreach ($GLOBALS['_MAX']['PREF'] as $k => $v) {
            if (preg_match('/^gui_column_/', $k)) {
                if (is_string($v) && $tmp = @unserialize($v)) {
                    $GLOBALS['_MAX']['PREF'][$k.'_array'] = $tmp;
                    $GLOBALS['_MAX']['PREF'][$k] = 0;
                    foreach ($tmp as $perm => $custom) {
                        $GLOBALS['_MAX']['PREF'][$k] |= $custom['show'] ? $perm : 0;
                        if (phpAds_isUser($perm)) {
                            $GLOBALS['_MAX']['PREF'][$k.'_label'] = $custom['label'];
                            $GLOBALS['_MAX']['PREF'][$k.'_rank']  = $custom['rank'];
                            $max_rank = max($max_rank, $custom['rank']);
                        }
                    }
                } else {
                    $missing_cols[] = $k;
                }
            }
        }

        // Adjust missing column preferences
        foreach ($missing_cols as $k) {
            $GLOBALS['_MAX']['PREF'][$k]          = 15; // Any user
            $GLOBALS['_MAX']['PREF'][$k.'_rank']  = ++$max_rank;
        }

        return $GLOBALS['_MAX']['PREF'];
    }

}



?>
