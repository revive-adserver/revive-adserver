<?php
if (! defined('MAIN_PATH')) {
    define('APP_PATH', dirname(__FILE__));
    define('MAIN_PATH', APP_PATH . '/..');
    define('APP_LIB_PATH', MAIN_PATH. DIRECTORY_SEPARATOR. 'library');
    define('ZEND_LIB_PATH', MAX_PATH.DIRECTORY_SEPARATOR.'lib'); //oxp lib path with Loader.php
    define('SMARTY_LIB_PATH', MAX_PATH.DIRECTORY_SEPARATOR.'lib/smarty'); //oxp lib path with Loader.php
    define('VAR_PATH', MAIN_PATH . '/var');
    define('CACHE_PATH', MAX_PATH . '/var/cache');
    define('MODULES_PATH', APP_PATH . '/modules');
}
?>
