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

require_once MAX_PATH . '/tests/testClasses/TestFiles.php';
require_once 'HTML/TreeMenu.php';

/**
 * A class for managing the construction of groups of tests, and for
 * presenting them in an HTML menu.
 *
 * @package    Max
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 *
 * @todo Consider reducing repetition by extracting "add node" logic.
 */
class Menu
{
    /**
     * A method to return the HTML code needed to display a tree-based
     * menu of all the OpenX tests.
     *
     * @return string A string containing the HTML code needed to display
     *                the tests in a tree-based menu.
     */
    function buildTree()
    {
        preg_match('/^(\d+\.\d+)/', OA_VERSION, $aMatches);
        // Create the root of the test suite
        $menu     = new HTML_TreeMenu();
        $rootNode = new HTML_TreeNode(
                            array(
                                'text' => MAX_PRODUCT_NAME . ' ' . $aMatches[1] . ' Tests',
                                'icon' => "package.png"
                            )
                        );
        // Create the top-level test groups
        foreach ($GLOBALS['_MAX']['TEST']['groups'] as $type) {
            $nodeName = $type . 'RootNode';
            ${$nodeName} = new HTML_TreeNode(
                                array(
                                    'text' => ucwords($type) . ' Test Suite',
                                    'icon' => "package.png",
                                    'link' => "run.php?type=$type&level=all",
                                    'linkTarget' => "right"
                                )
                            );
            $structure = TestFiles::getAllTestFiles($type);
            foreach ($structure as $layerCode => $folders) {
                $firstNode = &${$nodeName}->addItem(
                    new HTML_TreeNode(
                        array(
                            'text' => $GLOBALS['_MAX']['TEST'][$type . '_layers'][$layerCode][0],
                            'icon' => "package.png",
                            'link' => "run.php?type=$type&level=layer&layer=$layerCode",
                            'linkTarget' => 'right'
                        )
                    )
                );
                foreach ($folders as $folder => $files) {
                    if (count($files)) {
                        $secondNode = &$firstNode->addItem(
                            new HTML_TreeNode(
                                array(
                                    'text' => $folder,
                                    'icon' => "class_folder.png",
                                    'link' => "run.php?type=$type&level=folder&layer=$layerCode&folder=$folder",
                                    'linkTarget' => 'right'
                                )
                            )
                        );
                    }
                    foreach ($files as $index => $file) {
                        $secondNode->addItem(
                            new HTML_TreeNode(
                                array(
                                    'text' => $file,
                                    'icon' => "Method.png",
                                    'link' => "run.php?type=$type&level=file&layer=$layerCode&folder=$folder&file=$file",
                                    'linkTarget' => 'right'
                                )
                            )
                        );
                    }
                }
            }
            $rootNode->addItem(${$nodeName});
        }

        /**
         * @TODO Clean up the following code to ensure that adding new
         *       PEAR PHPUnit tests to the test suite is easier!
         */
        // Create the PEAR PHPUnit tests
        $nodeName = 'PearRootNode';
        ${$nodeName} = new HTML_TreeNode(
                            array(
                                'text' => 'PEAR PHPUnit Test Suite',
                                'icon' => "package.png",
                                'link' => "",
                                'linkTarget' => "right"
                            )
                        );
        $firstNode = &${$nodeName}->addItem(
            new HTML_TreeNode(
                array(
                    'text' => 'PEAR::MDB2',
                    'icon' => "package.png",
                    'link' => "run.php?type=phpunit&dir=../lib/pear/MDB2/tests",
                    'linkTarget' => 'right'
                )
            )
        );
        $firstNode = &${$nodeName}->addItem(
            new HTML_TreeNode(
                array(
                    'text' => 'PEAR::MDB2_Schema',
                    'icon' => "package.png",
                    'link' => "run.php?type=phpunit&dir=../lib/pear/MDB2_Schema/tests",
                    'linkTarget' => 'right'
                )
            )
        );
        $rootNode->addItem(${$nodeName});

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


    /**
     * @param HTML_TreeNode $parentNode
     * @param string $title
     * @param string $target_url
     * @todo Consider moving to a subclass of HTML_TreeNode
     * @todo Consider separating "create" logic from "add" logic.
     */
    function _addLinkedPackageNode($parentNode, $title, $target_url)
    {
        assert(is_object($parentNode));

        $node_options = array(
              'icon' => 'package.png',
              'linkTarget' => 'right'
        );
        $node_options['text'] = $title;
        $node_options['link'] = $target_url;
        $node = new HTML_TreeNode($node_options);
        $parentNode->addItem($node);
    }
}

?>
