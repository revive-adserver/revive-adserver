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
