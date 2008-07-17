<?php
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Bertrand Mansion <bmansion@mamasam.com>                     |
// +----------------------------------------------------------------------+
//
// $Id$

/**
* Config parser for common PHP configuration array
* such as found in the horde project.
*
* Options expected is:
* 'name' => 'conf'
* Name of the configuration array.
* Default is $conf[].
* 'useAttr' => true
* Whether we render attributes
*
* @author      Bertrand Mansion <bmansion@mamasam.com>
* @package     Config
*/
class Config_Container_PHPArray {

    /**
    * This class options:
    * - name of the config array to parse/output
    *   Ex: $options['name'] = 'myconf';
    * - Whether to add attributes to the array
    *   Ex: $options['useAttr'] = false;
    *
    * @var  array
    */
    var $options = array('name' => 'conf',
                         'useAttr' => true);

    /**
    * Constructor
    *
    * @access public
    * @param    string  $options    Options to be used by renderer
    */
    function Config_Container_PHPArray($options = array())
    {
        foreach ($options as $key => $value) {
            $this->options[$key] = $value;
        }
    } // end constructor

    /**
    * Parses the data of the given configuration file
    *
    * @access public
    * @param string $datasrc    path to the configuration file
    * @param object $obj        reference to a config object
    * @return mixed    returns a PEAR_ERROR, if error occurs or true if ok
    */
    function &parseDatasrc($datasrc, &$obj)
    {
        if (empty($datasrc)) {
            return PEAR::raiseError("Datasource file path is empty.", null, PEAR_ERROR_RETURN);
        }
        if (is_array($datasrc)) {
            $this->_parseArray($datasrc, $obj->container);
        } else {
            if (!file_exists($datasrc)) {
                return PEAR::raiseError("Datasource file does not exist.", null, PEAR_ERROR_RETURN);        
            } else {
                include($datasrc);
                if (!isset(${$this->options['name']}) || !is_array(${$this->options['name']})) {
                    return PEAR::raiseError("File '$datasrc' does not contain a required '".$this->options['name']."' array.", null, PEAR_ERROR_RETURN);
                }
            }
            $this->_parseArray(${$this->options['name']}, $obj->container);
        }
        return true;
    } // end func parseDatasrc

    /**
    * Parses the PHP array recursively
    * @param array  $array      array values from the config file
    * @param object $container  reference to the container object
    * @access private
    * @return void
    */
    function _parseArray($array, &$container)
    {
        foreach ($array as $key => $value) {
            switch ((string)$key) {
                case '@':
                    $container->setAttributes($value);
                    break;
                case '#':
                    $container->setType('directive');
                    $container->setContent($value);
                    break;
                default:
                    if (is_array($value)) {
                        $section =& $container->createSection($key);
                        $this->_parseArray($value, $section);
                    } else {
                        $container->createDirective($key, $value);
                    }
            }
        }
    } // end func _parseArray

    /**
    * Returns a formatted string of the object
    * @param    object  $obj    Container object to be output as string
    * @access   public
    * @return   string
    */
    function toString(&$obj)
    {
        if (!isset($string)) {
            $string = '';
        }
        switch ($obj->type) {
            case 'blank':
                $string .= "\n";
                break;
            case 'comment':
                $string .= '// '.$obj->content."\n";
                break;
            case 'directive':
                $attrString = '';
                $parentString = $this->_getParentString($obj);
                $attributes = $obj->getAttributes();
                if ($this->options['useAttr'] && is_array($attributes) && count($attributes) > 0) {
                    // Directive with attributes '@' and value '#'
                    $string .= $parentString."['#']";
                    foreach ($attributes as $attr => $val) {
                        $attrString .= $parentString."['@']"
                                    ."['".$attr."'] = '".addslashes($val)."';\n";
                    }
                } else {
                    $string .= $parentString;
                }
                $string .= ' = ';
                if (is_string($obj->content)) {
                    $string .= "'".addslashes($obj->content)."'";
                } elseif (is_int($obj->content) || is_float($obj->content)) {
                    $string .= $obj->content;
                } elseif (is_bool($obj->content)) {
                    $string .= ($obj->content) ? 'true' : 'false';
                }
                $string .= ";\n";
                $string .= $attrString;
                break;
            case 'section':
                $attrString = '';
                $attributes = $obj->getAttributes();
                if ($this->options['useAttr'] && is_array($attributes) && count($attributes) > 0) {
                    $parentString = $this->_getParentString($obj);
                    foreach ($attributes as $attr => $val) {
                        $attrString .= $parentString."['@']"
                                    ."['".$attr."'] = '".addslashes($val)."';\n";
                    }
                }
                $string .= $attrString;
                if ($count = count($obj->children)) {
                    for ($i = 0; $i < $count; $i++) {
                        $string .= $this->toString($obj->getChild($i));
                    }
                }
                break;
            default:
                $string = '';
        }
        return $string;
    } // end func toString

    /**
    * Returns a formatted string of the object parents
    * @access private
    * @return string
    */
    function _getParentString(&$obj)
    {
        $string = '';
        if (!$obj->isRoot()) {
            if (!$obj->parent->isRoot()) {
                $string = is_int($obj->name) ? "[".$obj->name."]" : "['".$obj->name."']";
            } else {
                if (empty($this->options['name'])) {
                    $string .= '$'.$obj->name;
                } else {
                    $string .= '$'.$this->options['name']."['".$obj->name."']";
                }
            }
            $string = $this->_getParentString($obj->parent).$string;
            $count = $obj->parent->countChildren(null, $obj->name);
            if ($count > 1) {
                $string .= '['.$obj->getItemPosition().']';
            }
        }
        return $string;
    } // end func _getParentString

    /**
    * Writes the configuration to a file
    *
    * @param  mixed  datasrc        info on datasource such as path to the configuraton file
    * @param  string configType     (optional)type of configuration
    * @access public
    * @return string
    */
    function writeDatasrc($datasrc, &$obj)
    {
        $fp = @fopen($datasrc, 'w');
        if ($fp) {
            $string = "<?php\n". $this->toString($obj) ."?>"; // <? : Fix my syntax coloring
            $len = strlen($string);
            @flock($fp, LOCK_EX);
            @fwrite($fp, $string, $len);
            @flock($fp, LOCK_UN);
            @fclose($fp);
            return true;
        } else {
            return PEAR::raiseError('Cannot open datasource for writing.', 1, PEAR_ERROR_RETURN);
        }
    } // end func writeDatasrc
} // end class Config_Container_PHPArray
?>