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

class OA_Admin_Config
{
    var $config;
    
     /**
     * The constructor method. Stores the current parse result of the
     * configuration .ini file so that it can be (locally) modified.
     */
    function OA_Admin_Config($isNewConfig = false)
    {
        if($isNewConfig) {
            $this->conf = array();
        } else {
            $this->conf = $GLOBALS['_MAX']['CONF'];
        }
    }
    
    /**
     * A method to test if the Openads configuration .ini file is writable by
     * the web server process.
     *
     * @static
     * @param string $configFile  Path to the config file
     * @param boolean $checkDir
     * @return boolean True if file is writable else method is checking
     *                 if directory is writable (if $checkDir is true)
     *                 else return false
     */
    function isConfigWritable($configFile = null, $checkDir = true)
    {
        if (!$configFile) {
            $conf = $GLOBALS['_MAX']['CONF'];
            $url = @parse_url('http://' . $conf['webpath']['delivery']);
            $configFile = MAX_PATH . '/var/' . $url['host'] . '.conf.php';
        }
        if (file_exists($configFile)) {
            return is_writable($configFile);
        } elseif ($checkDir) {
            // Openads has not been installed yet (or plugin config file doesn't exists)
            // so need to test if the web
            // server can write to the config file directory
            $configDir = substr($configFile, 0, strrpos($configFile, '/'));
            return is_writable($configDir);
        } else {
            return false;
        }
    }
    
}

?>