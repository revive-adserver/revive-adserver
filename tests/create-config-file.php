<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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