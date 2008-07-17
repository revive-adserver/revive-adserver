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
* Replace XML tags with echo '<' .'?xml';
*
 
* @package    HTML_Template_Flexy
*  
*/  
 

class HTML_Template_Flexy_Compiler_Regex_Xml 
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
      /* 
    * replace the xml tags
    * 
    * @param   string The template
    * @access   public
    */
    function pre_replace_xml ($input) 
    {
        $input = str_replace("?>","<?php  echo '?'.'>'; ?>\n",$input);
        $input = str_replace("<?xml","<?php  echo '<'.'?xml'; ?>",$input);
        return  $input;
    }
     
    
}

?>
