#!/usr/bin/php
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors:  nobody <nobody@localhost>                                  |
// +----------------------------------------------------------------------+
//
// This is a temporary file - it includes some of the
// Code that will have to go in the Engine eventually..
// Used to test parsing and generation.

//ini_set('include_path', ini_get('include_path').realpath(dirname(__FILE__) . '/../../..'));
require_once 'Gtk/VarDump.php';
require_once 'Console/Getopt.php';
require_once 'HTML/Template/Flexy.php';
require_once 'HTML/Template/Flexy/Compiler.php';

// this is the main runable...

class HTML_Template_Flexy_Test {


    function __construct () {
        // for testing!
        $GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions'] = array(
            'compileDir' => dirname(__FILE__),
            'locale' => 'en',


        );

        $this->parseArgs();
        $this->parse();

    }



    function parseArgs() {
        // mapp of keys to values..


        $args = Console_Getopt::ReadPHPArgV();
        $vals = Console_Getopt::getopt($args,'');
        //print_r($vals);
        $files = $vals[1];

        if (!$files) {
            $this->error(0,"No Files supplied");
        }

        foreach($files as $file) {
            $realpath = realpath($file);
            if (!$realpath) {
                 $this->error(0,"File $path Does not exist");
            }
            $this->files[] = $realpath;
        }


    }

    var $files; // array of files to compile
    var $quickform;

    function parse() {
        foreach($this->files as $file) {
            $flexy = new HTML_Template_Flexy(array(
                    'compileToString'=>true,
                    'valid_functions' => 'include'
            ));
            $compiler =  HTML_Template_Flexy_Compiler::factory($flexy->options);
            $result = $compiler->compile($flexy,file_get_contents($file));
            echo $result;
            print_r(array_unique($GLOBALS['_HTML_TEMPLATE_FLEXY_TOKEN']['gettextStrings']));
            print_r($flexy->elements);

        }





    }

    function error($id,$msg) {
        echo "ERROR $id : $msg\n";
        exit(255);
    }

    function debug($id,$msg) {
        echo "Debug Message ($id) : $msg\n";
    }


}



new HTML_Template_Flexy_Test;
?>
