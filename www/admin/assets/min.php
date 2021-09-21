<?php
/**
 * Front controller for default Minify implementation.
 *
 * Modified to suit AC / PC / UI lib code.
 *
 * @package Minify
 */

define('LIB_PATH', '../../../lib');
define('OX_PATH', realpath('../../..'));

// setup include path
set_include_path(LIB_PATH . '/minify' . PATH_SEPARATOR . get_include_path());

// load config
require 'minify-init.php';

require LIB_PATH . '/OX/Admin/UI/Minify/Server.php';

OX_UI_Minify_Server::serve();
