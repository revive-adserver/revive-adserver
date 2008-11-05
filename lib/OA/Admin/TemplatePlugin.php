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

define('SMARTY_DIR', MAX_PATH . '/lib/smarty/');

require_once MAX_PATH . '/lib/smarty/Smarty.class.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A UI templating class.
 *
 * @package    OpenadsAdmin
 * @author     Monique Szpak <monique.szpak@openads.org>
 */
class OA_Plugin_Template
    extends OA_Admin_Template
{
    /**
     * @var string
     */
    var $templateName;

    /**
     * @var string
     */
    var $cacheId;

    /**
     * @var int
     */
    var $_tabIndex = 0;

    function OA_Plugin_Template($templateName, $pluginName)
    {
        $this->init($templateName, $pluginName);
    }


    function init($templateName, $pluginName)
    {
        parent::init($templateName);
        $this->template_dir = 'templates';
    }
}

?>