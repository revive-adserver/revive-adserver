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
* The rtf SimpleTags filter
*
* really an extension of simple tags with \\\{ and \\\\} as the tag delimiters
* can parse an RTF template and generate a file.
*
* usually best used with callback ouput buffering to reduce memory loads.
*
* @package    HTML_Template_Flexy
*  
*/ 
 

require_once "HTML/Template/Flexy/Filter/SimpleTags.php";

class HTML_Template_Flexy_Compiler_Regex_RtfSimpleTags extends HTML_Template_Flexy_Compiler_Regex_simpletags 
{
    /*
    *   @var    string   $start    the start tag for the template (escaped for regex)
    */
    var $start = '\\\{';
    /*
    *   @var    string   $stop    the stopt tag for the template (escaped for regex)
    */    
    var $stop= '\\\}';
    
    
}

?>