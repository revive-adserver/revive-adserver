<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------
/**
* @package WACT_UTIL
* @version $Id: dataspace.inc.php,v 1.13 2004/11/15 01:46:04 jeffmoore Exp $
*/

/**
* The DataSpace is a container for a set of named data values (properties).
* @see http://wact.sourceforge.net/index.php/DataSpace
* @access public
* @abstract
* @package WACT
*/
class DataSpace {
    /**
    * Properties stored in the DataSpace are contained here
    * @var array
    * @access private
    */
    var $properties = array(); /* change to properties */

    /**
    * Filter object for transforming stored data
    * @var object
    * @access private
    */
    var $filter;

    /**
    * Gets a copy of a stored property by name
    * @param string name of property
    * @return mixed value of property or NULL if not found
    * @access public
    */
    function get($name) {
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }
    }

    /**
    * Gets a property value by navagating a dot separated path
    * that dereferences elements within the dataspace.
    * If an element cannot be dereferenced or is not set, the
    * value NULL is returned.
    * @param string name of property
    * @return mixed value of property or NULL if not found
    * @access public
    */
    function getPath($path) {
        if (($pos = strpos($path, '.')) === FALSE) {
            return $this->get($path);
        } else {
            $value = $this->get(substr($path, 0, $pos));
            $dataspace =& DataSpace::makeDataSpace($value);
            if (is_null($dataspace)) {
                return NULL;
            }
            return $dataspace->getPath(substr($path, $pos + 1));
        }
    }

    /**
    * Stores a copy of value into a Property
    * @param string name of property
    * @param mixed value of property
    * @return void
    * @access public
    */
    function set($name, $value) {
        $this->properties[$name] = $value;
    }

    /**
    * Stores a copy of value into a Property based on a dot separated
    * path.
    * If an element cannot be dereferenced, or is not set, it is 
    * converted to an array.
    * @param string name of property
    * @param mixed value of property
    * @return void
    * @access public
    */
    function setPath($path, $value) {
        if (strpos($path, '.') == FALSE) {
            return $this->set($path, $value);
        }
        $var =& $this->properties;
        do {
            $pos = strpos($path, '.');
            if ($pos === FALSE) {
                break;
            } else {
                $key = substr($path, 0, $pos);
            }
            if (is_object($var)) {
                if (method_exists($var, 'isDataSource')) {
                    return $var->setPath($path, $value);
                } else {
                    $var =& $var->$key;
                }
            } else if (is_array($var)) {
                $var =& $var[$key];
            } else {
                $var = array();
                $var =& $var[$key];
            }
            $path = substr($path, $pos + 1);
        } while (TRUE);
        if (is_object($var)) {
           if (method_exists($var, 'isDataSource')) {
                $var->set($path, $value);
           } else {
                $var->$path = $value;
           }
        } else if (is_array($var)) {
            $var[$path] = $value;
        } else {
            $var = array();
            $var[$path] = $value;
        }
    }

    /**
    * removes stored property value
    * @param string name of property
    * @return void
    * @access public
    */
    function remove($name) {
        unset($this->properties[$name]);
    }
    
    /**
    * removes all property values
    * @return void
    * @access public
    */
    function removeAll() {
        $this->properties = array();
    }

    /**
    * replaces the current properties of this dataspace with the proprties and values
    * passed as a parameter
    * @param array
    * @return void
    * @access public
    */
    function import($property_list) {
        $this->properties = $property_list;
    }

    /**
    * Append a new list of values to the DataSpace. Existing key values will be
    * overwritten if duplicated in the new value list.
    *
    * @param array a list of property names and the values to set them to
    * @return void
    * @access public
    */
    function merge($property_list) {
        foreach ($property_list as $name => $value) {
            $this->set($name, $value);
        }
    }

    /**
    * Returns a reference to the complete array of properties stored
    * @return array
    * @access public
    */
    function &export() {
        return $this->properties;
    }

    /**
    * Any class that implements the DataSource interface should implement this method
    * This is a PHP4 way of detecting which objects implement the interface.
    * @return Boolean always TRUE
    * @access public
    */
    function isDataSource() {
        return TRUE;
    }

    /**
    * Has a value been assigned under this name for this dataspace?
    * @param string name of property
    * @return boolean TRUE if property exists
    * @access public
    */
    function hasProperty($name) {
        return isset($this->properties[$name]);
    }
    
    /**
    * Return a unique list of available properties
    * This method is probably going to have capitalization problems.
    * @return array
    * @access public
    */
    function getPropertyList() {
        return array_keys($this->properties);
    }

    /**
    * Registers a filter with the dataspace. Filters are used to transform
    * stored properties.
    * @param object instance of filter class containing a doFilter() method
    * @return void
    * @access public
    * @deprecated
    */
    function registerFilter(&$filter) {
        $this->filter =& $filter;
    }

    /**
    * Prepares the dataspace, executing the doFilter() method of the
    * registered filter, if one exists
    * @return void
    * @access protected
    * @deprecated
    */
    function prepare() {
        if (isset($this->filter)) {
            $this->filter->doFilter($this->properties);
        }
    }

    /**
    * Static method to convert a variable into a dataspace.
    * @return void
    */
    function &makeDataSpace(&$var) {
        if (is_object($var)) {
            if (method_exists($var, 'isDataSource')) {
                return $var;
            } else {
                require_once WACT_ROOT . 'util/objectdataspace.inc.php';
                return new ObjectDataSpace($var);
            }
        } else if (is_array($var)) {
            $dataspace =& new dataSpace();
            $dataspace->properties = $var;
            return $dataspace;
        } else {
            return NULL;
        }
    }
    
   /**
	 * Below methods are added to provide a common interface between DataObjects and DAL
	 * @return boolean
	 * @access public
	 */
	function fetch()
	{
	    return $this->next();
	}
	
	/**
	 * Reset RecordSet
	 *
	 * @param boolean $autoFetch  If true fetch first record
	 * @return boolean  True on success
	 * @access public
	 */
	function find($autoFetch = false)
	{
	    if (!$this->reset()) {
	        return false;
	    }
	    if ($autoFetch) {
	        return $this->next();
	    }
	    return true;
	}
	
	/**
	 * Export parameters as array
	 *
	 * @return array
	 * @access public
	 */
	function toArray()
	{
	    return $this->export();
	}
	
	/**
     * OpenX uses in many places arrays containing all records, for example 
     * array of all zones Ids associated with specific advertiser.
     * It is not encouraged to use this method for all purposes as it's
     * better to loop through all records and analyze one at a time.
     * But if you are looping through records just to create a array
     * use this method instead.
     *
     * @param array $filter  Contains fields which should be returned in each row
     * @param string $indexWithPrimaryKey  Should the array be indexed with primary key
     * @param boolean $flattenIfOneOnly     Flatten multidimensional array into one dimensional
     *                                      if $filter array contains only one field name
     * @return array
     */
    function getAll($filter = array(), $indexWithPrimaryKey = null, $flattenIfOneOnly = true)
    {
        if (!is_array($filter)) {
    	    if (empty($filter)) $filter = array();
    	    $filter = array($filter);
    	}
    	
        $this->find();
    	
    	$rows = array();
    	$primaryValue = null;
    	
    	while ($this->fetch()) {
    	    $fields = $this->export();
    	    
    		$row = array();
    		foreach ($fields as $k => $v) {
    		    if ($filter && !in_array($k, $filter)) {
    		        continue;
    		    }
    		    if ($indexWithPrimaryKey && $k == $indexWithPrimaryKey) {
    		        $primaryValue = $v;
    		    } else {
    		        $row[$k] = $this->properties[$k];
    		    }
    		}
    		if ($flattenIfOneOnly && count($row) == 1) {
    		    $row = array_pop($row);
    		}
    		if ($indexWithPrimaryKey) {
    			$rows[$primaryValue] = $row;
    		} else {
    			$rows[] = $row;
    		}
    	}
    	return $rows;
    }
}

?>