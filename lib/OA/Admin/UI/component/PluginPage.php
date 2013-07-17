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
