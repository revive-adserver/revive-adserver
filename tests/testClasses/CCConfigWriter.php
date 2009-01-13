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
$Id: TestEnv.php 5447 2007-03-28 14:33:48Z andrew.hill@openads.org $
*/

require_once(MAX_PATH . '/lib/pear/Config.php');

define('CONFIG_TEMPLATE', MAX_PATH . '/etc/test.conf.php');
define('CONFIG_PATH', MAX_PATH . '/var/test.conf.php');

/**
 * CCConfigWriter (short name for CruiseControlConfigWriter)
 *
 */
class CCConfigWriter
{
    function configureTest($type, $host, $port, $username, $password, $name, $tableType, $auditEnabled, $loadBalancingEnabled, $loadBalancingName)
    {
        $config = new Config();
        $configContainer = &$config->parseConfig(CONFIG_TEMPLATE, 'inifile');

        $sectionDatabase = &$configContainer->getItem('section', 'database');
        $sectionDatabase->setDirective('type', $type);
        $sectionDatabase->setDirective('host', $host);
        $sectionDatabase->setDirective('port', $port);
        $sectionDatabase->setDirective('username', $username);
        $sectionDatabase->setDirective('password', $password);
        $sectionDatabase->setDirective('name', $name);

        $sectionLoadBalancing = &$configContainer->getItem('section', 'lb');
        $sectionLoadBalancing->setDirective('enabled', $loadBalancingEnabled);
        $sectionLoadBalancing->setDirective('type', $type);
        $sectionLoadBalancing->setDirective('host', $host);
        $sectionLoadBalancing->setDirective('port', $port);
        $sectionLoadBalancing->setDirective('username', $username);
        $sectionLoadBalancing->setDirective('password', $password);
        $sectionLoadBalancing->setDirective('name', $loadBalancingName);

        $tableType = trim($tableType);
        $sectionTable = &$configContainer->getItem('section', 'table');
        $sectionTable->setDirective('type', $tableType);

        // Nightly builds can take a lot of time... use 30 minutes
        $sectionMaintenance = &$configContainer->getItem('section', 'maintenance');
        $sectionMaintenance->setDirective('timeLimitScripts', 60 * 30);

        $sectionAudit = &$configContainer->getItem('section', 'audit');
        $sectionAudit->setDirective('enabled', $auditEnabled);

        $section_oxMemcached = &$configContainer->createSection('oxMemcached');
        $section_oxMemcached->setDirective('memcachedServers', '127.0.0.1:11211');

        $config->writeConfig(CONFIG_PATH, 'inifile');
    }


    function configureTestFromArray($aConfigurationEntries, $configFilename)
    {
        $config = new Config();
        $configContainer = &$config->parseConfig(CONFIG_TEMPLATE, 'inifile');

        foreach($aConfigurationEntries as $configurationEntry) {
            $aConfigurationEntry = explode("=", $configurationEntry);
            list($configurationKey, $configurationValue) = $aConfigurationEntry;
            list($sectionName, $variableName) = explode('.', $configurationKey);
            $section = &$configContainer->getItem('section', $sectionName);
            $section->setDirective($variableName, $configurationValue);
        }

        $config->writeConfig($configFilename, 'inifile');
    }
}

?>
