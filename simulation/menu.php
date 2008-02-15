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

require_once 'init.php';

require_once 'HTML/TreeMenu.php';

require_once 'lib.inc.php';

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
     * menu of all the OpenX simulations.
     *
     * @return string A string containing the HTML code needed to display
     *                the tests in a tree-based menu.
     */
    function buildTree()
    {
        $icon_pkg = "package.png";

        // Create the root of the test suite
        $menu     = new HTML_TreeMenu();
        $rootNode = new HTML_TreeNode(
                            array(
                                'text' => 'OpenX Simulation Scenarios',
                                'icon' => $icon_pkg,
                                'link' => 'home.php',
                                'linkTarget' => 'right'
                            )
                        );
        // Create the top-level test groups

        $aTypes = array(FOLDER_SAVE=>'menu.php');
        foreach ($aTypes as $type => $link) {
            $nodeName = $type . 'RootNode';
            ${$nodeName} = new HTML_TreeNode(
                                array(
                                    'text' => ucwords($type),
                                    'icon' => $icon_pkg,
                                    'link' => $link,
                                    'linkTarget' => "left"
                                )
                            );
            $files = get_simulation_file_list($type);
            foreach ($files as $index => $file) {
                ${$nodeName}->addItem(
                    new HTML_TreeNode(
                        array(
                            'text' => $file,
                            'icon' => $icon_pkg,
                            'link' => "run.php?dir={$type}&file=$file",
                            'linkTarget' => 'right'
                            )
                    )
                );
            }
            $rootNode->addItem(${$nodeName});
        }

        $aParams = array(   'text' => 'CreateScenario',
                            'icon' => $icon_pkg,
                            'link' => "",
                            'linkTarget' => "right"
                        );

        // create the CreateScenario node
        $nodeName       = 'CreateScenarioRootNode';
        ${$nodeName}    = new HTML_TreeNode($aParams);
        $rootNode->addItem(${$nodeName});

//        $aParams['text'] = 'Configure Data Set';
//        $aParams['link'] = 'CreateScenario/setup.php';
//        ${$nodeName}->addItem(new HTML_TreeNode($aParams));
//
//        $aParams['text'] = 'Configure Request Set';
//        $aParams['link'] = 'CreateScenario/requests.php';
//        ${$nodeName}->addItem(new HTML_TreeNode($aParams));

        $aParams['text'] = 'Save Current Scenario';
        $aParams['link'] = 'CreateScenario/save.php';
        ${$nodeName}->addItem(new HTML_TreeNode($aParams));

        $aParams['text'] = 'Delete Scenario/s';
        $aParams['link'] = 'CreateScenario/delete.php';
        ${$nodeName}->addItem(new HTML_TreeNode($aParams));

        $aParams['text'] = 'Download Scenario/s';
        $aParams['link'] = 'CreateScenario/download.php';
        ${$nodeName}->addItem(new HTML_TreeNode($aParams));

        $aParams['text'] = 'Upload Scenario/s';
        $aParams['link'] = 'CreateScenario/upload.php';
        ${$nodeName}->addItem(new HTML_TreeNode($aParams));
        // Add the root node to the menu, and return the HTML code
        $menu->addItem($rootNode);

        $tree = new HTML_TreeMenu_DHTML($menu);
        $code  = file_get_contents(MAX_PATH . '/tests/testClasses/menu.css');
        $code .= "\n<script>\n";
        $code .= file_get_contents(MAX_PATH . '/tests/testClasses/TreeMenu.js');
        $code .= "\n</script>";
        $code .= $tree->toHTML();
        return $code;
    }

}

// Output the menu of tests
echo Menu::buildTree();
?>
