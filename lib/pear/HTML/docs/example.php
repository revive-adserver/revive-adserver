<?php
// +-----------------------------------------------------------------------+
// | Copyright (c) 2002-2005, Richard Heyes, Harald Radi                   |
// | All rights reserved.                                                  |
// |                                                                       |
// | Redistribution and use in source and binary forms, with or without    |
// | modification, are permitted provided that the following conditions    |
// | are met:                                                              |
// |                                                                       |
// | o Redistributions of source code must retain the above copyright      |
// |   notice, this list of conditions and the following disclaimer.       |
// | o Redistributions in binary form must reproduce the above copyright   |
// |   notice, this list of conditions and the following disclaimer in the |
// |   documentation and/or other materials provided with the distribution.|
// | o The names of the authors may not be used to endorse or promote      |
// |   products derived from this software without specific prior written  |
// |   permission.                                                         |
// |                                                                       |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
// |                                                                       |
// +-----------------------------------------------------------------------+
// | Author: Richard Heyes <http://www.phpguru.org/>                       |
// |         Harald Radi <harald.radi@nme.at>                              |
// +-----------------------------------------------------------------------+

    //error_reporting(E_ALL | E_STRICT);
    //require_once('HTML/TreeMenu.php');
    require_once('../TreeMenu.php');

    $icon         = 'folder.gif';
    $expandedIcon = 'folder-expanded.gif';

    $menu  = new HTML_TreeMenu();

    $node1   = new HTML_TreeNode(array('text' => "First level", 'link' => "test.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true), array('onclick' => "alert('foo'); return false", 'onexpand' => "alert('Expanded')"));
    $node1_1 = &$node1->addItem(new HTML_TreeNode(array('text' => "Second level", 'link' => "test.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
    $node1_1_1 = &$node1_1->addItem(new HTML_TreeNode(array('text' => "Third level", 'link' => "test.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
    $node1_1_1_1 = &$node1_1_1->addItem(new HTML_TreeNode(array('text' => "Fourth level", 'link' => "test.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
    $node1_1_1_1->addItem(new HTML_TreeNode(array('text' => "Fifth level", 'link' => "test.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'cssClass' => 'treeMenuBold')));

    $node1->addItem(new HTML_TreeNode(array('text' => "Second level, item 2", 'link' => "test.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
    $node1->addItem(new HTML_TreeNode(array('text' => "Second level, item 3", 'link' => "test.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon)));

    $menu->addItem($node1);
    $menu->addItem($node1);

    // Create the presentation class
    $treeMenu = new HTML_TreeMenu_DHTML($menu, array('images' => '../images', 'defaultClass' => 'treeMenuDefault'));
    $listBox  = new HTML_TreeMenu_Listbox($menu, array('linkTarget' => '_self'));
    //$treeMenuStatic = new HTML_TreeMenu_staticHTML($menu, array('images' => '../images', 'defaultClass' => 'treeMenuDefault', 'noTopLevelImages' => true));
?>
<html>
<head>
    <style type="text/css">
        body {
            font-family: Georgia;
            font-size: 11pt;
        }

        .treeMenuDefault {
            font-style: italic;
        }

        .treeMenuBold {
            font-style: italic;
            font-weight: bold;
        }
    </style>
    <script src="../TreeMenu.js" language="JavaScript" type="text/javascript"></script>
</head>
<body>

<script language="JavaScript" type="text/javascript">
<!--
    a = new Date();
    a = a.getTime();
//-->
</script>

<?$treeMenu->printMenu()?><br /><br />
<?$listBox->printMenu()?>

<script language="JavaScript" type="text/javascript">
<!--
    b = new Date();
    b = b.getTime();

    document.write("Time to render tree: " + ((b - a) / 1000) + "s");
//-->
</script>


</body>
</html>
