<?php
// {{{ error reporting
error_reporting(E_ERROR);
// }}}
// {{{ DSN Constants
/**
 * Constants used in PackageName_MDB2
 */
define ('DSN_PHPTYPE',  'mysql');
define ('DSN_USERNAME', 'username');
define ('DSN_PASSWORD', 'password');
define ('DSN_HOSTNAME', 'hostname');
define ('DSN_DATABASE', 'databasename');
// }}}

//uncomment the following to run tests in a checkout
//set_include_path(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.get_include_path());

?>
