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

if (!defined('SMARTY_DIR')) {
    define('SMARTY_DIR', MAX_PATH . '/lib/smarty/');
}

require_once MAX_PATH . '/lib/smarty/Smarty.class.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A UI templating class.
 *
 * @package    OpenadsAdmin
 */
class OA_Plugin_Template extends OA_Admin_Template
{
    /**
     * @var string
     */
    public $templateName;

    /**
     * @var string
     */
    public $cacheId;

    /**
     * @var int
     */
    public $_tabIndex = 0;

    /**
     * @var string
     */
    private $adminGroupName;

    public function __construct($templateName, $adminGroupName)
    {
        $this->adminGroupName = $adminGroupName;

        parent::__construct($templateName);
    }


    public function init($templateName)
    {
        parent::init($templateName);

        //since previous version was using relative path and $adminGroupName was
        //ignored (and thus could be incorect and cannot be relied on), for backward compatibility check if absolute path is correct
        //if not use relative one
        $pluginBaseDir = $this->get_template_vars('pluginBaseDir'); //with trailing /
        $pluginTemplateDir = $this->get_template_vars('pluginTemplateDir'); //with trailing /

        $absoluteTemplateDir = $pluginBaseDir . $this->adminGroupName . $pluginTemplateDir;

        $this->template_dir = is_dir($absoluteTemplateDir)
            ? $absoluteTemplateDir : $pluginTemplateDir;
    }
}
