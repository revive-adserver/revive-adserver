<?php

/* Set up ZF autoload so we don't have to explicitely require each Zend Framework class */

require_once dirname(__FILE__) . "/includes-init.php";

require APP_LIB_PATH . '/Zend/Loader/Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);
