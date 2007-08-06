<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------
/**
* @package WACT_DB
* @version $Id: mdbc.inc.php,v 1.4 2004/11/20 17:23:16 jeffmoore Exp $
*/
//--------------------------------------------------------------------------------
/**
* Define globals
*/
$GLOBALS['DatabaseConnectionObjList'] = array();

class MDBC_ConnectionConfiguration {

    var $config_name;
    
    function MDBC_ConnectionConfiguration($config_name) {
        $this->config_name = $config_name;
    }

    function get($option) {
        return ConfigManager::getOption('db', $this->config_name, $option);
    }
}

/**
* Manages a list of named database connections.
* This class is not instantiated as is used only as a namespace for the methods it
* contains.
* @see http://wact.sourceforge.net/index.php/MDBC
* @access public
* @package WACT_DB
*/
class MDBC { 

    /**
    * Create a new connection based on a named database configuration
    * @return Connection reference
    * @access public
    */
    function &newConnection($name) {
        $ConnectionConfiguration =& new MDBC_ConnectionConfiguration($name);
        $driver = $ConnectionConfiguration->get("driver");
        $ConnectionClass = $driver . 'Connection'; 

        require_once(WACT_ROOT . 'db/drivers/' . $driver . '.inc.php'); 
        return new $ConnectionClass($ConnectionConfiguration);
    } 

    /**
    * Return a named database connection managed by this class
    * @return Connection reference
    * @access public
    */
    function &getConnection($name) {
        if (!isset($GLOBALS['DatabaseConnectionObjList'][$name])) {
            $GLOBALS['DatabaseConnectionObjList'][$name] =& MDBC::newConnection($name);
        }
        return $GLOBALS['DatabaseConnectionObjList'][$name];
    }
}

?>