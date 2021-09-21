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

require_once './init.php';

require_once 'HTML/TreeMenu.php';

/**
 * A class for managing the construction of groups of tests, and for
 * presenting them in an HTML menu.
 *
 * @package     Max
 * @subpackage  SimulationSuite
 */
class Menu
{
    /**
     * A method to return the HTML code needed to display a tree-based
     * menu of all the simulations.
     *
     * @return string A string containing the HTML code needed to display
     *                the tests in a tree-based menu.
     */
    public function buildTree()
    {
        $menu = new HTML_TreeMenu();
        $rootNode = new HTML_TreeNode(
            [
                                'text' => 'OpenX Developer Toolbox',
                                'icon' => '',
                                'link' => 'action.php?action=index',
                                'linkTarget' => 'right'
                            ]
        );
        $aItems[] = [
                            'title' => 'Plugins',
                            'action' => 'about&item=plugins',
                            'children' => [
                                               0 => [
                                                          'title' => 'New Plugin',
                                                          'action' => 'create_plugin',
                                                         ],
                                              ]
                        ];
        $aItems[] = [
                            'title' => 'Schemas',
                            'action' => 'about&item=schema',
                            'children' => [
                                               0 => [
                                                          'title' => 'Schema Editor',
                                                          'action' => 'schema_editor',
                                                         ],
                                               1 => [
                                                          'title' => 'Changeset Archives',
                                                          'action' => 'schema_changesets',
                                                         ],
                                              ]
                        ];
        $aItems[] = [
                            'title' => 'Core Schema Utilities',
                            'action' => 'about&item=core_utils',
                            'children' => [
                                               0 => [
                                                          'title' => 'Integrity Check',
                                                          'action' => 'schema_integ',
                                                         ],
                                               1 => [
                                                          'title' => 'Dump Data',
                                                          'action' => 'schema_datadump',
                                                         ],
                                               2 => [
                                                          'title' => 'Load Data',
                                                          'action' => 'schema_dataload',
                                                         ],
                                              ]
                        ];
        $aItems[] = [
                            'title' => 'Schema Analysis',
                            'action' => 'schema_analysis',
                        ];
        // Generate DataObjects
        $aDataObjects[] = [
                              'title' => 'OpenX Core',
                              'action' => 'generate_dataobjects',
                             ];
        $plugins = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        foreach ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] as $name => $enabled) {
            $schema = strtolower($name);
            $aDataObjects[] = [
                                  'title' => $name,
                                  'action' => "generate_dataobjects&schema={$plugins}{$name}/etc/tables_{$name}.xml&dbopath={$plugins}{$name}/etc/DataObjects",
                                 ];
        }
        $aItems[] = [
                            'title' => 'Generate DataObjects',
                            'action' => 'about&item=dataobjects',
                            'children' => $aDataObjects,

                        ];

        // Upgrade Packages
        $aPackages[] = [
                              'title' => 'New Core Upgrade Package',
                              'action' => 'upgrade_package&name=OpenXCore',
                             ];
        foreach ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] as $name => $enabled) {
            $aPackages[] = [
                                  'title' => $name,
                                  'action' => 'upgrade_package&name=' . $name,
                                 ];
        }
        $aItems[] = [
                            'title' => 'Upgrade Packages',
                            'action' => 'about&item=upgrade_packages',
                            'children' => $aPackages,

                        ];


        // Upgrade Packages Array
        $aUpgrades[] = [
                              'title' => 'OpenX Core',
                              'action' => 'upgrade_array&read=/etc/changes&write=/etc/changes/openads_upgrade_array.txt',
                             ];
        foreach ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] as $name => $enabled) {
            $aUpgrades[] = [
                                  'title' => $name,
                                  'action' => "upgrade_array&read={$plugins}{$name}/etc/changes&write={$plugins}{$name}/etc/changes/{$name}_upgrade_array.txt",
                                 ];
        }
        $aItems[] = [
                            'title' => 'Upgrade Packages Array',
                            'action' => 'about&item=upgrade_array',
                            'children' => $aUpgrades,

                        ];
        foreach ($aItems as $aItem) {
            $newNode = &$rootNode->addItem(
                new HTML_TreeNode(
                    [
                                                                    'text' => $aItem['title'],
                                                                    'icon' => 'package.png',
                                                                    'link' => 'action.php?action=' . $aItem['action'],
                                                                    'linkTarget' => 'right'
                                                                     ]
                )
            );
            if (isset($aItem['children'])) {
                foreach ($aItem['children'] as $aChild) {
                    $newNode->addItem(
                        new HTML_TreeNode(
                            [
                                                                'text' => $aChild['title'],
                                                                'icon' => 'Method.png',
                                                                'link' => 'action.php?action=' . $aChild['action'],
                                                                'linkTarget' => 'right'
                                                                 ]
                        )
                    );
                }
            }
        }

        $menu->addItem($rootNode);
        $options = ['images' => 'assets/images'];
        $tree = new HTML_TreeMenu_DHTML($menu, $options);
        $code = file_get_contents(PATH_ASSETS . '/css/menu.css');
        $code .= "\n<script>\n";
        $code .= file_get_contents(PATH_ASSETS . '/js/TreeMenu.js');
        $code .= "\n</script>";
        $code .= $tree->toHTML();
        return $code;
    }
}

echo Menu::buildTree();
