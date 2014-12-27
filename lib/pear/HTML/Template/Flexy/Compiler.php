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
// | Authors: Alan Knowles <alan@akbkhome.com>                            |
// +----------------------------------------------------------------------+
//
//  Base Compiler Class (Interface)

/**
* Compiler Globals go here..
* public (to it's children)
*
* @var array
* @access public (to it's children)
*/

$GLOBAL['_HTML_TEMPLATE_FLEXY_COMPILER'] = array();


class HTML_Template_Flexy_Compiler {


    /**
    * Options
    *
    * @var array
    * @access public
    */
    var $options;

    /**
    * Factory constructor
    *
    * @param   array    options     only ['compiler']  is used directly
    *
    * @return   object    The Compiler Object
    * @access   public
    */
    function factory($options)
    {
        if (empty($options['compiler'])) {
            $options['compiler'] = 'Flexy';
        }

        require_once 'HTML/Template/Flexy/Compiler/'.ucfirst( $options['compiler'] ) .'.php';
        $class = 'HTML_Template_Flexy_Compiler_'.$options['compiler'];
        $ret = new $class;
        $ret->options = $options;
        return $ret;
    }


    /**
    * The compile method.
    *
    * @param object HTML_Template_Flexy that is requesting the compile
    * @return   object  HTML_Template_Flexy
    * @return   string   to compile (if not using a file as the source)
    * @access   public
    */
    function compile(&$flexy,$string = false)
    {
        echo "No compiler implemented!";
    }

    /**
    * Append HTML to compiled ouput
    * These are hooks for passing data to other processes
    *
    * @param   string to append to compiled
    *
    * @return   string to be output
    * @access   public
    */
    function appendHtml($string)
    {

        return $string;
    }
    /**
    * Append PHP Code to compiled ouput
    * These are hooks for passing data to other processes
    *
    * @param   string PHP code to append to compiled
    *
    * @return   string to be output
    * @access   public
    */

    function appendPhp($string)
    {

        return '<?php '.$string.'?>';
    }
    /**
    * Compile All templates in the
    * These are hooks for passing data to other processes
    *
    * @param   string PHP code to append to compiled
    *
    * @return   string to be output
    * @access   public
    */

    function compileAll(&$flexy, $dir = '',$regex='/.html$/')
    {
        $this->flexy = &$flexy;
        $this->compileDir($dir,$regex);
    }


    function compileDir($dir = '',$regex='/.html$/')
    {


        foreach ($this->flexy->options['templateDir'] as $base) {
            if (!file_exists($base . DIRECTORY_SEPARATOR  . $dir)) {
                continue;
            }
            $dh = opendir($base . DIRECTORY_SEPARATOR  . $dir);
            while (($name = readdir($dh)) !== false) {
                if (!$name) {  // empty!?
                    continue;
                }
                if ($name{0} == '.') {
                    continue;
                }

                if (is_dir($base . DIRECTORY_SEPARATOR  . $dir . DIRECTORY_SEPARATOR  . $name)) {
                    $this->compileDir($dir . DIRECTORY_SEPARATOR  . $name,$regex);
                    continue;
                }

                if (!preg_match($regex,$name)) {
                    continue;
                }
                //echo "Compiling $dir". DIRECTORY_SEPARATOR  . "$name \n";
                $this->flexy->compile($dir . DIRECTORY_SEPARATOR  . $name);
            }
        }

    }


}
