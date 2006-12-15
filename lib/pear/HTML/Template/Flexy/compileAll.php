#!/usr/bin/php -q
<?php
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author:  Alan Knowles <alan@akbkhome.com>
// +----------------------------------------------------------------------+
//
// $Id: compileAll.php,v 1.3 2003/08/01 08:50:27 alan_k Exp $
//

@include 'HTML/Template/Flexy.php';
if (!class_exists('HTML_Template_Flexy')) {
    ini_set('include_path',dirname(__FILE__).'/../../../');
    include 'HTML/Template/Flexy.php';
}
require_once 'PEAR.php';

if (!ini_get('register_argc_argv')) {
    PEAR::raiseError("\nERROR: You must turn register_argc_argv On in you php.ini file for this to work\neg.\n\nregister_argc_argv = On\n\n", null, PEAR_ERROR_DIE);
    exit;
}

if (!@$_SERVER['argv'][1]) {
    PEAR::raiseError("\nERROR: compileAll.php usage:\n\nC:\php\pear\HTML\Template\Flexy\compileAll.php example.ini\n\n", null, PEAR_ERROR_DIE);
    exit;
}

$config = parse_ini_file($_SERVER['argv'][1], true);

$options = &PEAR::getStaticProperty('HTML_Template_Flexy','options');
$options = $config['HTML_Template_Flexy'];

if (!$options) {
    PEAR::raiseError("\nERROR: could not read ini file\n\n", null, PEAR_ERROR_DIE);
    exit;
}

set_time_limit(0);
//DB_DataObject::debugLevel(5);
$flexy= new HTML_Template_Flexy;
$flexy->compileAll();
?>
