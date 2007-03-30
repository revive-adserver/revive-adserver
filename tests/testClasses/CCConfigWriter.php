<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: TestEnv.php 5447 2007-03-28 14:33:48Z andrew.hill@openads.org $
*/

require_once('Config.php');

class CCConfigWriter
{
    function configureTest($type, $host, $port, $username, $password, $name, $tableType)
    {
        $fTestConfigSource = MAX_PATH . '/etc/test.conf.ini';
        $fTestConfigDestination = MAX_PATH . '/var/test.conf.test.ini';
        $config = new Config();
        $configContainer = &$config->parseConfig($fTestConfigSource, 'inifile');

        $sectionDatabase = &$configContainer->getItem('section', 'database');
        $sectionDatabase->setDirective('type', $type);
        $sectionDatabase->setDirective('host', $host);
        $sectionDatabase->setDirective('port', $port);
        $sectionDatabase->setDirective('username', $username);
        $sectionDatabase->setDirective('password', $password);
        $sectionDatabase->setDirective('name', $name);
        
        $sectionTable = &$configContainer->getItem('section', 'table');
        $sectionTable->setDirective('type', $tableType);
        
        $config->writeConfig($fTestConfigDestination, 'inifile');
    }
}

?>