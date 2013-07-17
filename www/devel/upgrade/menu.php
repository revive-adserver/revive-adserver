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

require_once 'init.php';

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
        $icon_pkg = "package.png";

        // Create the root of the test suite
        $menu     = new HTML_TreeMenu();
        $rootNode = new HTML_TreeNode(
                            array(
                                'text' => 'Upgrade Package Utilities',
                                'icon' => $icon_pkg,
                                'link' => 'home.php',
                                'linkTarget' => 'right'
                            )
                        );
        // Create the top-level test groups
        $list = get_package_array();

        $aTypes = array('milestone'=>'menu.php',
                        'incremental'=>'menu.php',
                        'changeset'=>'menu.php',
                        );
        foreach ($aTypes as $type => $link)
        {
            $nodeName = $type . 'RootNode';
            ${$nodeName} = new HTML_TreeNode(
                                array(
                                    'text' => ucwords(ucfirst($type)),
                                    'icon' => $icon_pkg,
                                    'link' => $link,
                                    'linkTarget' => "left"
                                )
                            );
            if ($type == 'changeset')
            {
                ${$nodeName}->addItem(
                                    new HTML_TreeNode(
                                                        array(
                                                            'text' => 'next',
                                                            'icon' => $icon_pkg,
                                                            'link' => "action.php?type={$type}&file=new",
                                                            'linkTarget' => 'right'
                                                             )
                                                     )
                );
                ${$nodeName}->addItem(
                                    new HTML_TreeNode(
                                                        array(
                                                            'text' => 'register',
                                                            'icon' => $icon_pkg,
                                                            'link' => "action.php?type={$type}&file=reg",
                                                            'linkTarget' => 'right'
                                                             )
                                                     )
                );
            }
            foreach ($list[$type] as $index => $file)
            {
                ${$nodeName}->addItem(
                                    new HTML_TreeNode(
                                                        array(
                                                            'text' => $file,
                                                            'icon' => $icon_pkg,
                                                            'link' => "action.php?type={$type}&file={$file}",
                                                            'linkTarget' => 'right'
                                                             )
                                                     )
                );
            }
            $rootNode->addItem(${$nodeName});
        }

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
