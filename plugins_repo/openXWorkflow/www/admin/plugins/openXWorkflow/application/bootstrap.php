<?php

/* Report all errors directly to the screen for simple diagnostics in the dev environment */
//error_reporting(E_ALL | E_STRICT);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
ob_start();

/* Set time zone */
date_default_timezone_set("UTC");

/** Application-wide configuration */
require_once dirname(__FILE__) . '/config.php';

/**
 * Add the Zend Framework library to the include path so that we can access the ZF classes.
 * Additionally, to be able to use Zend Studio's "Organize Includes" function, which inserts
 * the includes relative to the project root, we add project root path as well.
 */
set_include_path(MAIN_PATH . PATH_SEPARATOR . APP_LIB_PATH . PATH_SEPARATOR . get_include_path());
/** Add Zend autoload */
require_once (APP_LIB_PATH . '/OX/Common/zend-init.php');

OX_Common_Config::initLocale(); // set locale based on config.php

/** Lists of minified CSS/JavaScripts */
require_once APP_PATH . '/minify-init.php';


/* Get the singleton instance of the front controller */
$frontController = Zend_Controller_Front::getInstance();

/* Point the front controller to action controller directory */
$frontController->addModuleDirectory(MODULES_PATH);

/* Register front controller plugins */
/**
 * Configure plugin session 
 */
$frontController->registerPlugin(new OX_UI_Controller_Plugin_SessionCookiePathSetter());
$frontController->registerPlugin(new OX_OXP_UI_Controller_Plugin_OxpSessionConfigure('ox_wk_session_id'));
$frontController->registerPlugin(new OX_UI_Controller_Plugin_P3PPolicySetter());
$executionTimer = new OX_UI_Controller_Plugin_ExecutionTimer();
$frontController->registerPlugin($executionTimer);


/* Register OX controller plugins */
OX_UI_Controller_Default::registerPlugin(OX_Workflow_UI_Controller_Plugin_PluginMenuSectionResolver::getInstance());

/* A Smarty view that saves compiled templates to cache */

$view = new OX_UI_View_SmartyView(array ('compileDir' => MAX_PATH . '/var/templates_compiled'));
$view->addHelperPath(APP_LIB_PATH . "/OX/UI/View/Helper", "OX_UI_View_Helper");
$view->addScriptPath(APP_LIB_PATH . "/OX/UI/View/scripts");
$view->addHelperPath(APP_LIB_PATH . "/OX/OXP/UI/View/Helper", "OX_OXP_UI_View_Helper");
$view->addHelperPath(APP_LIB_PATH . "/OX/Workflow/UI/View/Helper", "OX_Workflow_UI_View_Helper");

$view->doctype('XHTML1_TRANSITIONAL');

/**
 * A workaround for SmartyCompiler -- the registry is the only way to pass the
 * custom Smarty view to it, so that it can load view helpers from the paths we
 * added above.
 */
$registry = Zend_Registry::getInstance();
$registry->set("smartyView", $view);


/** 
 * Zend_Cache configuration http://framework.zend.com/manual/en/zend.cache.theory.html#zend.cache.factory 
**/

$cache = Zend_Cache::factory('Core', 'File',
                             array('lifetime'=>10, 'automatic_serialization' => true),
                             array('cache_dir'=>'../var/cache'));
$registry->set("cache", $cache);

/* Zend_Log configuration */
$logPriorityFilter = new Zend_Log_Filter_Priority(Zend_Log::ERR);
// remember priority filter to use with other log files 
$registry->set("logPriorityFilter", $logPriorityFilter);
try {
    $log = new Zend_Log( new Zend_Log_Writer_Stream(MAIN_PATH.'/var/log/debug.log','a+')); 
    $log->addFilter($logPriorityFilter);
    $registry->set("log", $log);
} catch (Zend_Log_Exception $e) {
    // problem with logging (e.g. no rights to write to file)
}


/* ViewRenderer with the SmartyView */
$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view);
$viewRenderer->setViewSuffix('html');

/* Register the helper to the HelperBroker */
Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

/* Common layout for pages */
$layout = Zend_Layout::startMvc();
$layout->setViewSuffix("html");
$layout->setView($view);
$layout->setLayoutPath(MODULES_PATH . "/default/layouts");

/* Dispatch the request */
//register custom route as default
$router = $frontController->getRouter();
$router->addRoute('default', new OX_UI_Controller_Router_Route_ModuleQueryString(array(), $frontController->getDispatcher()));
//$router->addRoute('module', new Zend_Controller_Router_Route_Module());
$frontController->dispatch();

//for non html responses (which most likely do not have layout)
if ($layout->isEnabled()) {
    echo "<!-- app version: " . OX_Common_Config::getApplicationVersion() . ", render time: " . $executionTimer->getTotalTime() . " s -->";
}