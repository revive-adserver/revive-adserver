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

require_once MAX_PATH . '/lib/OA/DB.php';
require_once 'MDB2.php';


/**
 * An class for using distributed stats along with a master/slave database setup inside Openads.
 *
 * @package    OpenXDB
 * @subpackage Distributed
 */
class OA_DB_Distributed extends OA_DB
{

    /**
     * A method to return a singleton database connection resource.
     *
     * Example usage:
     * $oDbh = OA_DB_Distributed::singleton();
     *
     * Warning: In order to work correctly, the singleton method must
     * be instantiated statically and by reference, as in the above
     * example.
     *
     * @static
     * @param string $dsn Optional database DSN details - connects to the
     *                    database defined by the configuration file otherwise.
     *                    See {@link OA_DB::getDsn()} for format.
     * @return MDB2_Driver_Common An MDB2 connection resource, or PEAR_Error
     *                            on failure to connect.
     */
    static function singleton($dsn = null)
    {
        // Get the DSN, if not set
        $dsn = is_null($dsn) ? OA_DB_Distributed::getDsn() : $dsn;

        // Should the connection have options set?
        $aDriverOptions = OA_DB_Distributed::getDsnOptions();

        // Return the datbase connection
        return parent::singleton($dsn, $aDriverOptions);
    }

    /**
     * A method to return the default DSN specified by the configuration file.
     *
     * @static
     * @param array $aConf An optional array containing the database details,
     *                     specifically containing index "lb" which is
     *                     an array containing:
     *                      type     - Database type, matching PEAR::MDB2 driver name
     *                      protocol - Optional communications protocol
     *                      port     - Optional database server port
     *                      username - Optional username
     *                      password - Optional password
     *                      host     - Database server hostname
     *                      name     - Optional database name
     * @return string An string containing the DSN.
     */
    static function getDsn($aConf = null)
    {
        if (is_null($aConf)) {
            $aConf = $GLOBALS['_MAX']['CONF'];
        }
        $dbType = $aConf['lb']['type'];
    	$protocol = isset($aConf['lb']['protocol']) ? $aConf['lb']['protocol'] . '+' : '';
    	$port = !empty($aConf['lb']['port']) ? ':' . $aConf['lb']['port'] : '';
        $dsn = $dbType . '://' .
            $aConf['lb']['username'] . ':' .
            $aConf['lb']['password'] . '@' .
            $protocol .
            $aConf['lb']['host'] .
            $port . '/' .
            $aConf['lb']['name'];
        return $dsn;
    }

    /**
     * A method to return an array of driver specific options as described
     * in the OA_DB::singleton method.
     *
     * @static
     * @param array $aConf An optional array containing the database details,
     *                     specifically containing index "lb" which is
     *                     an array containing:
     *                      type     - Database type, matching PEAR::MDB2 driver name
     *                      ssl      - Optional boolean value; should MySQL connect over SSL?
     *                      ca       - Optional string; is using SSL, what is the CA filename?
     *                      capath   - Optional string; is using SSL, what is path to the the CA file?
     *                      compress - Optional boolean value; should MySQL connect using compression?
     *
     * @return array An array of driver specific options suitable for passing into
     *               the OA_DB::singleton method call.
     */
    static function getDsnOptions($aConf = null)
    {
        $aDriverOptions = array();
        if (is_null($aConf)) {
            $aConf = $GLOBALS['_MAX']['CONF'];
        }
        $dbType = $aConf['lb']['type'];
        if (strcasecmp($dbType, 'mysql') === 0) {
            if ($aConf['lb']['ssl'] && !empty($aConf['lb']['ca']) && !empty($aConf['lb']['capth'])) {
                $aDriverOptions['ssl'] = true;
                $aDriverOptions['ca'] = $aConf['lb']['ca'];
                $aDriverOptions['capath'] = $aConf['lb']['capth'];
            }
            if ($aConf['lb']['compress']) {
                $aDriverOptions['compress'] = true;
            }
        }
        return $aDriverOptions;
    }

}

?>