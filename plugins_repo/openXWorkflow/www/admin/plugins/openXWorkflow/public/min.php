<?php
/**
 * Front controller for default Minify implementation.
 * 
 * Modified to suit AC / PC / UI lib code.
 * 
 * @package Minify
 */

define('LIB_PATH', '../library');
define('OX_PATH', '../../../../..');

// setup include path
set_include_path(OX_PATH . '/lib/minify' . PATH_SEPARATOR . get_include_path());

// load config
require '../application/minify-init.php';

require LIB_PATH . '/OX/UI/Minify/Server.php';

OX_UI_Minify_Server::serve();
