<?php
// Plugin Repository Server
define('PRS_PATH', dirname(__FILE__));

ini_set('include_path', '.:'.PRS_PATH.'/lib:'.PRS_PATH.'/lib/pear');

require_once('PEAR.php');


?>