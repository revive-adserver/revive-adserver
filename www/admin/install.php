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
global $installing;
$installing = true;
define('phpAds_installing', true);


//error_reporting(E_ERROR);
require_once '../../init.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Install/InstallController.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/Controller/Request.php';
require_once MAX_PATH.'/lib/OX/Admin/UI/WizardSteps.php';

/* Report all errors directly to the screen for simple diagnostics in the dev environment */
//error_reporting(E_ALL | E_STRICT);
//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);

$oInstaller = new Installer();
$oInstaller->startMVC();

class Installer
{
    public function startMVC()
    {
        $oRequest = new OX_Admin_UI_Controller_Request();
        
        //setup controller
        $oController = $this->createController();
        ob_start();
        $oController->process($oRequest); 
        $actionContent = ob_get_contents();
        ob_end_clean();
        
        //create view
        if ($oController->hasViewScript()) {
            $view = $this->createView($oController->getAction());
            //pass model variables to view
            $oController->assignModelToView($view);
        }
        
        
        
        //LAYOUT
        // setup dummy installer section display
        $oMenu = OA_Admin_Menu::singleton();
        $oMenu->add(new OA_Admin_Menu_Section('install',  '', ''));
        
        if ($oController->hasLayout()) {
            //layout
            $oPageHeader = $oController->getModelProperty('pageHeader');
            phpAds_PageHeader('install', $oPageHeader, $imgPath, false, true, false);
        }                                
        if ($view) {
            $view->display();
        }
        echo $actionContent;
        if ($oController->hasLayout()) {
            phpAds_PageFooter($imgPath);
            // Do not remove. This is a marker that AJAX response parsers look for to
            // determine whether the response did not redirect to the installer.
            echo "<!-- install -->";
        }
    }
    
    
    protected function createView($actionName)
    {
        $view = new OA_Admin_Template($actionName.'-step.html');
        $installTemplatesPath = MAX_PATH . '/www/admin/templates/install/';
        $view->template_dir = $installTemplatesPath;
        $view->assign("oxInstallerTemplateDir", $installTemplatesPath);
        $view->register_function('ox_wizard_steps', array(new OX_UI_WizardSteps(),  'wizardSteps'));
        
        return $view;
    }
    
    
    /**
     * Creates a controller to handle that request
     *
     * @return OX_Admin_UI_Controller_BaseController
     */
    protected function createController()
    {
        $oController = new OX_Admin_UI_Install_InstallController();

        return $oController;
    }
}

?>
