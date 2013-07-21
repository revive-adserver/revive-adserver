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
