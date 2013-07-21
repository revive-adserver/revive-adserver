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

require_once '../../../../init.php';
require_once '../../config.php';

require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/component/Form.php';
require_once LIB_PATH . '/Plugin/Component.php';

$oTrans = new OX_Translation($GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] . '/oxPlugin/_lang/');

require_once('lib/oxPlugin.inc.php')

?>