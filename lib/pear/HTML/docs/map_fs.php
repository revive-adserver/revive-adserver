<?php
/**
Map a filesystem with HTML TreeMenu
@author Tomas V.V.Cox <cox@idecnet.com>
*/
require_once '../HTML_TreeMenu/TreeMenu.php';
$map_dir = '.';
$menu  = new HTML_TreeMenu('menuLayer', 'images', '_self');
$menu->addItem(recurseDir($map_dir));

function &recurseDir($path) {
    if (!$dir = opendir($path)) {
        return false;
    }
    $files = array();
    $node = new HTML_TreeNode(basename($path), basename($path), 'folder.gif');
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            if (@is_dir("$path/$file")) {
                $addnode = &recurseDir("$path/$file");
            } else {
                $addnode = new HTML_TreeNode($file, $file, 'document2.png');
            }
            $node->addItem($addnode);
        }
    }
    closedir($dir);
    return $node;
}
?>
<html>
<head>
    <script src="./css/sniffer.js" language="JavaScript" type="text/javascript"></script>
    <script src="./css/TreeMenu.js" language="JavaScript" type="text/javascript"></script>
</head>
<body>

<div id="menuLayer"></div>
<?$menu->printMenu()?>

</body>
</html>