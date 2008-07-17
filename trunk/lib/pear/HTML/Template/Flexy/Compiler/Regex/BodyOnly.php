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
* The html Body only filter
*
* @abstract 
* a Simple filter to remove the everything thats not in the body!
*
* @package    HTML_Template_Flexy
*  
*/ 
 

class HTML_Template_Flexy_Compiler_Regex_BodyOnly 
{ 

    /**
    * Standard Set Engine
    * 
    * 
    * @param   object HTML_Template_Flexy   the main engine
    * @access   private
    */
  
    function _set_engine(&$engine) 
    {
    }
    /**
    * Strip everything before and including the  BODY  tag
    * 
    * @param   string The template
    * @access   public
    */
     
    function strip_body_head ($input) 
    {
        if (!preg_match("/^(.*)<body/si", $input)) {
            return $input;
        }
        $input = preg_replace("/^(.*)<body/si", "",$input);
        $input = preg_replace("/^([^>]*)>/si", "",$input);
        return $input;
    }
    /**
    * Strip everything after and including the  end BODY tag
    * 
    * @param    string The template
    * @access   public
    */
    function strip_body_foot ($input) 
    {
        if (!preg_match("/<\/body>.*/si", $input)) {
            return $input;
        }
        $input = preg_replace("/<\/body>.*/si", "",$input);
        return $input;
    
    
    }
    
}

?>