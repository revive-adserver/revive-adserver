<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
require_once MAX_PATH.'/lib/OA/Admin/UI/component/Page.php';


/**
 * Base page object for plugins. Provides plugin related helper methods.
 *
 */
class OA_Admin_UI_PluginPage
    extends OA_Admin_UI_Page
{
    protected $pluginId;

    public function __construct($id, $pluginId)
    {
        parent::__construct($id);
        $this->pluginId = $pluginId;
    }


    /**
     * Creates a EventContext for this particular page. Included the name of the
     * plugin this page was created for.
     * @return OA_Admin_Plugins_EventContext
     */
    protected function createPageContext()
    {
       $context = parent::createPageContext();
       $context->pluginId = $this->getPluginId();

       return $context;
    }


    /**
     * Returns page's plugin id
     *
     * @return string plugin id
     */
    public function getPluginId()
    {
        return $this->pluginId;
    }
}

?>
