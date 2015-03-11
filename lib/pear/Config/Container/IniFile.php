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

/**
* Config parser for PHP .ini files
* Faster because it uses parse_ini_file() but get rid of comments,
* quotes, types and converts On, Off, True, False, Yes, No to 0 and 1.
*
* @author      Bertrand Mansion <bmansion@mamasam.com>
* @package     Config
*/
class Config_Container_IniFile {

    /**
    * This class options
    * Not used at the moment
    *
    * @var  array
    */
    var $options = array();

    /**
    * Constructor
    *
    * @access public
    * @param    string  $options    (optional)Options to be used by renderer
    */
    function __construct($options = array())
    {
        $this->options = $options;
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
        if (!file_exists($datasrc)) {
            return PEAR::raiseError("Datasource file does not exist.", null, PEAR_ERROR_RETURN);
        }
        $currentSection =& $obj->container;
        $confArray = parse_ini_file($datasrc, true);
        if (!$confArray) {
            return PEAR::raiseError("File '$datasrc' does not contain configuration data.", null, PEAR_ERROR_RETURN);
        }
        foreach ($confArray as $key => $value) {
            if (is_array($value)) {
                $currentSection =& $obj->container->createSection($key);
                foreach ($value as $directive => $content) {
                    // try to split the value if comma found
                    if (strpos($content, '"') === false) {
                        $values = preg_split('/\s*,\s+/', $content);
                        if (count($values) > 1) {
                            foreach ($values as $k => $v) {
                                $currentSection->createDirective($directive, $v);
                            }
                        } else {
                            $currentSection->createDirective($directive, $content);
                        }
                    } else {
                        $currentSection->createDirective($directive, $content);
                    }
                }
            } else {
                $currentSection->createDirective($key, $value);
            }
        }
        return true;
    } // end func parseDatasrc

    /**
    * Returns a formatted string of the object
    * @param    object  $obj    Container object to be output as string
    * @access   public
    * @return   string
    */
    function toString(&$obj)
    {
        static $childrenCount, $commaString;

        if (!isset($string)) {
            $string = '';
        }
        switch ($obj->type) {
            case 'blank':
                $string = "\n";
                break;
            case 'comment':
                $string = ';'.$obj->content."\n";
                break;
            case 'directive':
                $count = $obj->parent->countChildren('directive', $obj->name);
                $content = $obj->content;
                if ($content === false) {
                    $content = '0';
                } elseif ($content === true) {
                    $content = '1';
                } elseif (strlen(trim($content)) < strlen($content) ||
                          strpos($content, ',') !== false ||
                          strpos($content, ';') !== false ||
                          strpos($content, '"') !== false ||
                          strpos($content, '%') !== false ||
                          strpos($content, '~') !== false ||
                          strpos($content, '!') !== false ||
                          strpos($content, '|') !== false ||
                          strpos($content, '&') !== false ||
                          strpos($content, '(') !== false ||
                          strpos($content, ')') !== false ||
                          $content === 'none') {
                    $content = '"'.addslashes($content).'"';
                }
                if ($count > 1) {
                    // multiple values for a directive are separated by a comma
                    if (isset($childrenCount[$obj->name])) {
                        $childrenCount[$obj->name]++;
                    } else {
                        $childrenCount[$obj->name] = 0;
                        $commaString[$obj->name] = $obj->name.'=';
                    }
                    if ($childrenCount[$obj->name] == $count-1) {
                        // Clean the static for future calls to toString
                        $string .= $commaString[$obj->name].$content."\n";
                        unset($childrenCount[$obj->name]);
                        unset($commaString[$obj->name]);
                    } else {
                        $commaString[$obj->name] .= $content.', ';
                    }
                } else {
                    $string = $obj->name.'='.$content."\n";
                }
                break;
            case 'section':
                if (!$obj->isRoot()) {
                    $string = '['.$obj->name."]\n";
                }
                if (count($obj->children) > 0) {
                    for ($i = 0; $i < count($obj->children); $i++) {
                        $string .= $this->toString($obj->getChild($i));
                    }
                }
                break;
            default:
                $string = '';
        }
        return $string;
    } // end func toString
} // end class Config_Container_IniFile
?>