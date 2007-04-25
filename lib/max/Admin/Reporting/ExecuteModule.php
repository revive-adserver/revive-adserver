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

// Include required files
//require_once MAX_PATH . '/lib/max/Plugin.php';
//require_once MAX_PATH . '/lib/max/language/Report.php';
//require_once MAX_PATH . '/www/admin/config.php';
//require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
//require_once(MAX_PATH . '/lib/max/DaySpan.php');

require_once(MAX_PATH . '/lib/max/Admin/Reporting/ReportScope.php');
require_once(MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php');
require_once(MAX_PATH . '/plugins/reportWriter/output/NullReportWriter.plugin.php');
require_once('Date.php');

class ReportExecuteModule
{
    /* @var Date */
    var $now;

    function main($plugin_identifier)
    {
        if (!(isset($plugin_identifier) && $plugin_identifier != '')) {
            return;
        }

        $pluginReport = $this->_newPluginByName($plugin_identifier);

        if (!$pluginReport) {
            return;
        }

        $this->runReport($pluginReport);
    }

    function _newPluginByName($plugin_identifier)
    {
        $pluginKey = explode(':', $plugin_identifier);
        $plugin = MAX_Plugin::factory('reports', $pluginKey[0], $pluginKey[1]);
        return $plugin;
    }

    function &_newDefaultReportWriter()
    {
        $config = MAX_Plugin::getConfig('reports', null, null, true);
        $default_writer_name = $config['writers']['default'];
        $writer_plugin =& MAX_Plugin::factory('reportWriter', 'output',  $default_writer_name);
        if (!$writer_plugin) {
            $writer_plugin = new Plugins_ReportWriter_Output_NullReportWriter();
        }

        return $writer_plugin;
    }

    function runReport($plugin)
    {
        $plugininfo = $plugin->info();
        $this->_haltIfReportCannotRun($plugininfo);
        $plugin_variables = $this->_getVariablesForReport($plugininfo, $_GET);
        $writer =& $this->_newDefaultReportWriter();
        $plugin->useReportWriter($writer);
        $this->_executeReportWithVariables($plugin, $plugin_variables);
    }

    function _haltIfReportCannotRun($plugininfo)
    {
        // Check security
        phpAds_checkAccess($plugininfo["plugin-authorize"]);
    }

    /**
     * Actually transfer control to the plugin's execute() method
     *
     * Each item in the plugin's 'import' declaration is passed as an argument.
     */
    function _executeReportWithVariables($pluginReport, $plugin_variables)
    {
        $callback = array(&$pluginReport, 'execute');
        call_user_func_array($callback, $plugin_variables);
    }

    function _getVariablesForReport($plugininfo, $values)
    {
        $plugin_import    = $plugininfo["plugin-import"];
        $plugin_variables = array();

        foreach (array_keys($plugin_import) as $key) {
            $field_type = $plugin_import[$key]['type'];
            $field =& FieldFactory::newField($field_type);
            $field->_name = $key;
            $field->setValueFromArray($values);
            $plugin_variables[] = $field->_value;
        }
        return $plugin_variables;
    }

    function _scopeFromQueryArray($values, $base_key)
    {
        $scope = new ReportScope;
        $scope->useValuesFromQueryArray($values, $base_key);
        return $scope;
    }

}

?>
