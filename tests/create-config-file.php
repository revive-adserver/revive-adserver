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

/**
 * This script takes a template configuration file from /etc/dist.conf.php,
 * loads the configuration, make changes according to the values set on
 * the command line and saves the resulting configuration to the file
 * passed to the script as the first argument.
 *
 * The configuration variables should be passed into the script in the
 * following form:
 *
 * section.variable=value
 *
 * Example:
 *
 * php create-config-file.php ../var/localhost.conf.php database.username=scott database.password=tiger
 */

if ($_SERVER['argc'] < 2) {
    echo "Usage: php create-config-file.php /path/to/config/host.conf.php [section.variable=value] ...\n";
    exit(1);
}

require_once('init.php');
require_once(MAX_PATH . '/tests/testClasses/CCConfigWriter.php');

$configFileName = $_SERVER['argv'][1];
$aValues = array_slice($_SERVER['argv'], 2);

$ccConfigWriter = new CCConfigWriter();
$ccConfigWriter->configureTestFromArray($aValues, $configFileName);

?>