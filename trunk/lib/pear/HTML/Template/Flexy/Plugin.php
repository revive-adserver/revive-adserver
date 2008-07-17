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
// $Id$
//
// Plugin API provides support for  < ? = $this->plugin(".....",.....); ? >
//  or {this.plugin(#xxxxx#,#xxxx#):h}
//
// BASICALLY THIS IS SAVANT'S PLUGIN PROVIDER.
// @author Paul M. Jones <pmjones@ciaweb.net>
 
 
class HTML_Template_Flexy_Plugin {
    
    /**
    * reference to main engine..
    *
    * @var object HTML_Template_Flexy
    * @access public
    */
    var $flexy; // reference to flexy.
    var $pluginCache = array(); // store of instanced plugins..
    
    /**
    * Call a Plugin method.
    *
    * Look up in all the plugins to see if the method exists, if it does, call it.
    * 
    * 
    * @param   array        name of method, arguments.
    * 
    *
    * @return   string      hopefully
    * @access   public
    */
  
    function call($args)
    {
        
        
        $method = $args[0];
        // attempt to load the plugin on-the-fly
        $class = $this->_loadPlugins($method);
         
        if (is_a($class,'PEAR_Error')) {
            //echo $class->toString();
            return $class->toString();
        }
        
         
        // first argument is always the plugin name; shift the first
        // argument off the front of the array and reduce the number of
        // array elements.
        array_shift($args);
        
        return call_user_func_array(array(&$this->plugins[$class],$method), $args);
    }
    
    /**
    * Load the plugins, and lookup which one provides the required method 
    *
    * 
    * @param   string           Name
    *
    * @return   string|PEAR_Error   the class that provides it.
    * @access   private
    */
    
    function _loadPlugins($name) 
    {
        // name can be:
        // ahref = maps to {class_prefix}_ahref::ahref
        $this->plugins = array();
        if (empty($this->plugins)) {
          
            foreach ($this->flexy->options['plugins'] as $cname=>$file) {
                if (!is_int($cname)) {
                    include_once $file;
                    $this->plugins[$cname] = new $cname;
                    $this->plugins[$cname]->flexy = &$this->flexy;
                    continue;
                }
                $cname = $file;
                require_once 'HTML/Template/Flexy/Plugin/'. $cname . '.php';
                $class = "HTML_Template_Flexy_Plugin_{$cname}";
                $this->plugins[$class] = new $class;
                $this->plugins[$class]->flexy = &$this->flexy;
            }
        }
                
        
        foreach ($this->plugins as $class=>$o) {
            //echo "checking :". get_class($o). ":: $name\n";
            if (method_exists($o,$name)) {
                return $class;
            }
        }
        return HTML_Template_Flexy::raiseError("could not find plugin with method: '$name'");
    }
    
    
}
