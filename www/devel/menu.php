<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once './init.php';

require_once 'HTML/TreeMenu.php';

/**
 * A class for managing the construction of groups of tests, and for
 * presenting them in an HTML menu.
 *
 * @package     Max
 * @subpackage  SimulationSuite
 * @author      Monique Szpak <monique@m3.net>
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
    function buildTree()
    {
        $menu     = new HTML_TreeMenu();
        $rootNode = new HTML_TreeNode(
                            array(
                                'text' => 'OpenX Developer Toolbox',
                                'icon' => '',
                                'link' => 'action.php?action=index',
                                'linkTarget' => 'right'
                            )
                        );
        $aItems[] = array(
                            'title' => 'Plugins',
                            'action'=>'about&item=plugins',
                            'children'=> array(
                                               0 => array(
                                                          'title'=>'New Plugin',
                                                          'action'=>'create_plugin',
                                                         ),
                                              )
                        );
        $aItems[] = array(
                            'title' => 'Schemas',
                            'action'=>'about&item=schema',
                            'children'=> array(
                                               0 => array(
                                                          'title'=>'Schema Editor',
                                                          'action'=>'schema_editor',
                                                         ),
                                               1 => array(
                                                          'title'=>'Changeset Archives',
                                                          'action'=>'schema_changesets',
                                                         ),
                                              )
                        );
        $aItems[] = array(
                            'title' => 'Core Schema Utilities',
                            'action'=>'about&item=core_utils',
                            'children'=> array(
                                               0 => array(
                                                          'title'=>'Integrity Check',
                                                          'action'=>'schema_integ',
                                                         ),
                                               1 => array(
                                                          'title'=>'Dump Data',
                                                          'action'=>'schema_datadump',
                                                         ),
                                               2 => array(
                                                          'title'=>'Load Data',
                                                          'action'=>'schema_dataload',
                                                         ),
                                              )
                        );
        $aItems[] = array(
                            'title' => 'Schema Analysis',
                            'action'=>'schema_analysis',
                        );
        // Generate DataObjects
        $aDataObjects[] =  array(
                              'title'=>'OpenX Core',
                              'action'=>'generate_dataobjects',
                             );
        $plugins = $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
        foreach ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] AS $name => $enabled)
        {
            $schema = strtolower($name);
            $aDataObjects[] =  array(
                                  'title'=>$name,
                                  'action'=>"generate_dataobjects&schema={$plugins}{$name}/etc/tables_{$schema}.xml&dbopath={$plugins}{$name}/etc/DataObjects",
                                 );
        }
        $aItems[] = array(
                            'title' => 'Generate DataObjects',
                            'action'=>'about&item=dataobjects',
                            'children'=> $aDataObjects,

                        );

        // Upgrade Packages
        $aPackages[] =  array(
                              'title'=>'New Core Upgrade Package',
                              'action'=>'upgrade_package&name=OpenXCore',
                             );
        foreach ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] AS $name => $enabled)
        {
            $aPackages[] =  array(
                                  'title'=>$name,
                                  'action'=>'upgrade_package&name='.$name,
                                 );
        }
        $aItems[] = array(
                            'title' => 'Upgrade Packages',
                            'action'=>'about&item=upgrade_packages',
                            'children'=> $aPackages,

                        );


        // Upgrade Packages Array
        $aUpgrades[] =  array(
                              'title'=>'OpenX Core',
                              'action'=>'upgrade_array&read=/etc/changes&write=/etc/changes/openads_upgrade_array.txt',
                             );
        foreach ($GLOBALS['_MAX']['CONF']['pluginGroupComponents'] AS $name => $enabled)
        {
            $aUpgrades[] =  array(
                                  'title'=>$name,
                                  'action'=>"upgrade_array&read={$plugins}{$name}/etc/changes&write={$plugins}{$name}/etc/changes/{$name}_upgrade_array.txt",
                                 );
        }
        $aItems[] = array(
                            'title' => 'Upgrade Packages Array',
                            'action'=>'about&item=upgrade_array',
                            'children'=> $aUpgrades,

                        );
        foreach ($aItems as $aItem)
        {
            $newNode = &$rootNode->addItem(
                                            new HTML_TreeNode(
                                                                array(
                                                                    'text' => $aItem['title'],
                                                                    'icon' => 'package.png',
                                                                    'link' => 'action.php?action='.$aItem['action'],
                                                                    'linkTarget' => 'right'
                                                                     )
                                                             )
                                           );
            if (isset($aItem['children']))
            {
                foreach ($aItem['children'] AS $aChild)
                {
                    $newNode->addItem(
                                        new HTML_TreeNode(
                                                            array(
                                                                'text' => $aChild['title'],
                                                                'icon' => 'Method.png',
                                                                'link' => 'action.php?action='.$aChild['action'],
                                                                'linkTarget' => 'right'
                                                                 )
                                                         )
                                     );
                }
            }
        }

        $menu->addItem($rootNode);
        $options = array('images'=>'assets/images');
        $tree = new HTML_TreeMenu_DHTML($menu, $options);
        $code  = file_get_contents(PATH_ASSETS . '/css/menu.css');
        $code .= "\n<script>\n";
        $code .= file_get_contents(PATH_ASSETS . '/js/TreeMenu.js');
        $code .= "\n</script>";
        $code .= $tree->toHTML();
        return $code;
    }

}

echo Menu::buildTree();
?>
