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
// | Authors:  Alan Knowles <alan@akbkhome.com>                           |
// +----------------------------------------------------------------------+
//
// $Id$
//
//  Description this class emulates the Smarty API to attempt to enable 
//  upgrading to flexy. (eg. for use with flexy templates (that have been
//  converted using the SmartyConverter Compiler.
//  
//  I've no idea how complete this will end up being..
//
//  Technically Smarty is LGPL - so theortically no code in here should
//  use the copy & paste the original smarty code....
//
 
// to use as a full emulator : 
// try 
// class Smarty extends HTML_Template_Flexy_SmartyAPI {
//   function Smarty() { parent::construct(); } 
// }


// not implemented: 
/*
append_by_ref
append
register_function / unregister_function
register_object / register_object
register_block / unregister_block
register_compiler_function / unregister_compiler_function
register_modifier / unregister_modifier
register_resource / unregister_resource
register_prefilter / unregister_prefilter
register_postfilter / unregister_postfilter
register_outputfilter / unregister_outputfilter
load_filter 
clear_cache
clear_all_cache
is_cached
template_exists
get_template_vars
get_config_vars
trigger_error

fetch
get_registered_object
config_load
clear_config
_* (all the privates)
*/

/**
* Smarty API emulator for Flexy 
* - designed to make transitions simpler
* - provides only basic support for variables
* - uses flexy templates (that have been converted previosly with the converor)
*  
* @version    $Id$
*/

class HTML_Template_Flexy_SmartyAPI {
    
    /**
    * where the data for the template gets stored.
    *
    * @var array
    * @access public 
    */
    var $vars = array();  

    /**
    * Standard Variable assignment
    *
    * @param   string|array    element name to assign value or assoc. array 
    * @param   mixed           value of element.
    * 
    * @return   none
    * @access   public
    */
    function assign($k,$v) 
    {
        if (is_array($k)) {
            $this->vars = $k + $this->vars;
            return;
        }
        $this->vars[$k] = $v;
    }
    /**
    * Standard Variable assignment (by reference)
    *
    * @param   string         element name to assign value 
    * @param   mixed           value of element.
    * 
    * @return   none
    * @access   public
    */
    function assign_by_ref($k, &$v)
    {
        $this->vars[$k] = &$v;
    }
    /**
    * Unset a variable assignment
    *
    * @param   string         element name to remove
     * 
    * @return   none
    * @access   public
    */
    function clear_assign($k) 
    {
        if (is_array($k)) {
            foreach ($k as $kk) {
                $this->clear_assign($kk);
            }
            return;
        }
    
        if (isset($this->vars[$k])) {
            unset($this->vars[$k]);
        }
    }
    /**
    * Unset all variables
    *
    * @return   none
    * @access   public
    */
    function clear_all_assign() 
    {
       $this->vars = array(); 
    
    }
    
    /**
    * output a template (optionally with flexy object & element.)
    *
    * @param   string         name of flexy template.
    * @param   object         object as per HTML_Template_Flexy:outputObject
    * @param   array          elements array as per HTML_Template_Flexy:outputObject    
    * 
    * @return   none
    * @access   public
    */
    function display($templatename,$object=null,$elements=array()) 
    {
        // some standard stuff available to a smarty template..
        $this->vars['SCRIPT_NAME'] =  $_SERVER['SCRIPT_NAME'];
        
        
        $o = PEAR::getStaticProperty('HTML_Template_Flexy','options');
         
        require_once 'HTML/Template/Flexy.php';
        $t = new HTML_Template_Flexy;
        $t->compile($templatename);
        $object = ($object !== null) ? $object : new StdClass;
        
        foreach($this->vars as $k=>$v) {
            $object->$k = $v;
        }
        $t->outputObject($object,$elements);
    }
    
}
    
