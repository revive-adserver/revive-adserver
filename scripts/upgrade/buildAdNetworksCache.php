<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

define('MAX_PATH', dirname(__FILE__) . '/../..');
define('OX_PATH', dirname(__FILE__) . '/../..');
error_reporting(E_ALL);

// setup environment - do not require config file
require_once MAX_PATH . '/init-parse.php';
require_once MAX_PATH . '/constants.php';
require_once MAX_PATH . '/variables.php';
setupServerVariables();
// set conf array to prevent loading config file
$GLOBALS['_MAX']['CONF'] = array();
$GLOBALS['_MAX']['CONF']['log']['enabled'] = false;
$GLOBALS['_MAX']['CONF']['webpath'] = null;
$GLOBALS['_MAX']['CONF']['openads']['sslPort'] = null;
$GLOBALS['_MAX']['HTTP'] = null;
$GLOBALS['_MAX']['PREF']['language'] = 'en';
$GLOBALS['_MAX']['CONF']['oacXmlRpc'] = array(
    'protocol'    => 'https',
    'host'        => 'oac.openx.org',
    'port'        => '443',
    'path'        => '/oac/xmlrpc',
    'captcha'     => '/oac/captcha'
);

// set pear path
$newPearPath = MAX_PATH . DIRECTORY_SEPARATOR.'lib' . DIRECTORY_SEPARATOR . 'pear';
if (!empty($existingPearPath)) {
    $newPearPath .= PATH_SEPARATOR . $existingPearPath;
}
ini_set('include_path', $newPearPath);
$GLOBALS['_MAX']['CONF']['database']['type'] = 'mysql';

setupConstants();
setupConfigVariables();
@set_time_limit(600);
increaseMemoryLimit(40 * 1024 * 1024); // 40MB


if (!is_writable(MAX_PATH.'/etc/permanentcache')) {
    die("The directory ".MAX_PATH.'/etc/permanentcache'." is not writable\n");
}

require MAX_PATH . '/lib/OA/XmlRpcClient.php';
require MAX_PATH . '/lib/OA/PermanentCache.php';

$oXml   = new OA_XML_RPC_Client('/oac/xmlrpc', 'https://oac.openx.org', 443);
$oCache = new OA_PermanentCache();

clean_up();

foreach (array('getCategories', 'getCountries', 'getLanguages') as $method) {
    echo $method.": "; flush();
    $msg = new XML_RPC_Message('oac.'.$method);
    $msg->addParam(XML_RPC_encode(array('protocolVersion' => 3, 'ph' => '')));
    $msg->addParam(new XML_RPC_Value('en', 'string'));
    $result = $oXml->send($msg);
    if (!$result || $result->faultCode() || $result->faultString()) {
        clean_up();
        die("failed\n");
    } else {
        $oCache->save(XML_RPC_decode($result->value()), "AdNetworks::{$method}");
        echo "processed"; eol_flush();
    }
    unset($result);
}

function eol_flush()
{
    echo (PHP_SAPI != 'cli' ? '<br />' : '')."\n";
    flush();
}

function clean_up()
{
    foreach (glob(MAX_PATH.'/etc/permanentcache/cache_adnetworks_*') as $fileName) {
        unlink($fileName);
    }
}

?>
