<?php
/*
	// Require the initialisation file
	require_once '../../init.php';
	
	// Required files
	require_once MAX_PATH . '/www/admin/config.php';
	require_once MAX_PATH . '/lib/max/language/Loader.php';
	require_once MAX_PATH . '/lib/max/Admin/Languages.php';
	
	//get language sections from en
	$sections = array();
	$sections[0] = 'default';
	$sections[1] = 'index';
	$sections[2] = 'installer';
	$sections[3] = 'invocation';
	$sections[4] = 'maintenance';
	$sections[5] = 'settings';	
	$sections[6] = 'settings-help';	
	$sections[7] = 'timezones';	
	$sections[8] = 'userlog';	
	
	//take languages	
	$aLanguages = new MAX_Admin_Languages;	
	$languages = $aLanguages->AvailableLanguages();
		
	//load all sections for all languages	
	foreach ($languages as $languageKey => $languageName) {
	  // set language	
	  echo ("Checking language: ".$languageName."<br>");	
	  foreach ($sections as $section) {	
	    echo (" \t- Checking section: ".$section." in language ".$languageKey."<br>");	
	    Language_Loader::load($section, $languageKey);	
	  }	
	}	
		
	// TODO: translation for plugins?
*/	
?>

<?php
// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

//get language sections from en
$sections = array('default','index','installer','invocation','maintenance','settings','settings-help','timezones','userlog');

//take languages
$aLanguages = new MAX_Admin_Languages;
$languages = $aLanguages->AvailableLanguages();

//load all sections for all languages
foreach ($languages as $languageKey => $languageName) {
  // set language
  echo ("Checking language: ".$languageName."<br>");
  foreach ($sections as $section) {
    echo (" \t- Checking section: ".$section." in language [".$languageKey."]<br>");
    Language_Loader::load($section, $languageKey);
  }
}

//get plugins
$plugins = array(
           '1' => array(
                 'pluginName' =>'invocationTags',
                 'packages' => MAX_Plugin::getPlugins('invocationTags')
                 ),
           '2' => array(
                 'pluginName' => '3rdPartyServers',
                 'packages' => MAX_Plugin::getPlugins('3rdPartyServers')
                  ),
           '3' => array(
                 'pluginName' => 'authentication',
                 'packages' => MAX_Plugin::getPlugins('authentication')
                 ),
           '4' => array(
                 'pluginName' => 'deliveryLimitations',
                 'packages' => MAX_Plugin::getPlugins('deliveryLimitations')
                 ),
           '5' => array(
                 'pluginName' => 'reports',
                 'packages' => MAX_Plugin::getPlugins('reports')
                 ),
           '6' => array(
                 'pluginName' =>'statisticsFieldsDelivery',
                 'packages' => MAX_Plugin::getPlugins('statisticsFieldsDelivery')
                 ),
);

foreach ($languages as $languageKey => $languageName) {
  // set language
  echo ("Checking language: ".$languageName."<br>");
  foreach ($plugins as $plugin) {
    echo ("*** Checking plugin: ".$plugin['pluginName']." in language [".$languageKey."]<br>");
    //MAX_Plugin_Translation::includePluginLanguageFile($module, $package, $language, $path = null)
    MAX_Plugin_Translation::includePluginLanguageFile($plugin['pluginName'], null, $languageKey);
    echo("Translations: <br>");
    print_r ($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$plugin['pluginName']]);
    echo("<br> ********************************************************************************* <br><br>");
    if (isset($plugin['packages'])) {
      foreach ($plugin['packages'] as $package) {
        MAX_Plugin_Translation::includePluginLanguageFile($plugin['pluginName'], $package->package, $languageKey);
        echo("Translations with packages: {$package->package} <br>");
        print_r ($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$plugin['pluginName']]);
        echo("<br> ********************************************************************************* <br><br>");
      }
    }
  }
}  

?>