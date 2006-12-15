<?php
//
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
 

/**
* A Math Filter 
*
* enable simple maths to be done in the template
*
* TODO: add an {if:t.xxx%2} type syntax.. 
*
* @package    HTML_Template_Flexy
*  
*/  
 

class HTML_Template_Flexy_Compiler_Regex_Math {
    /*
    *   @var    string   $start    the start tag for the template (escaped for regex)
    */
    var $start = '\{'; 
    /*
    *   @var    string   $stop    the stopt tag for the template (escaped for regex)
    */
    var $stop = '\}';  //ending template tag
     /**
    * Standard Set Engine
    * 
    * 
    * @param   object HTML_Template_Flexy   the main engine
    * @access   private
    */
    function _set_engine(&$engine) {
       
    }
 
    /* 
    * allow simple add multiply, divide and subtraction
    * 
    * eg.
    * {(12+t.somevar)*2} maps to =(12+$t->somevar)*2
    *
    * @param   string The template
    * @access   public
    */
    function variables ($input) {
        $input = preg_replace(
            "/".$this->start."([0-9\(\)+*\/-]*)([a-z0-9]+)([0-9\(\)+*\/-]*)".$this->stop."/ie",
            "'<?=\\1($'.str_replace('.','->','\\2').')\\3?>'",
            $input);
            
        return $input;
    }
  

}

?>