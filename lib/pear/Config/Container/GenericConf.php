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
// | Author: Bertrand Mansion <bmansion@mamasam.com>                      |
// +----------------------------------------------------------------------+

/**
* Config parser for  generic .conf files like
* htdig.conf...
*
* @author      Bertrand Mansion <bmansion@mamasam.com>
* @package     Config
*/
class Config_Container_GenericConf {

    /**
    * This class options:
    *   Ex: $options['comment'] = '#';
    *   Ex: $options['equals'] = ':';
    *   Ex: $options['newline'] = '\\';
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
        if (empty($options['comment'])) {
            $options['comment'] = '#';
        }
        if (empty($options['equals'])) {
            $options['equals'] = ':';
        }
        if (empty($options['newline'])) {
            $options['newline'] = '\\';
        }
        $this->options = $options;
    } // end constructor

    /**
    * Parses the data of the given configuration file
    *
    * @access public
    * @param string $datasrc    path to the configuration file
    * @param object $obj        reference to a config object
    * @return mixed returns a PEAR_ERROR, if error occurs or true if ok
    */
    function &parseDatasrc($datasrc, &$obj)
    {
        if (!is_readable($datasrc)) {
            return PEAR::raiseError("Datasource file cannot be read.", null, PEAR_ERROR_RETURN);
        }

        $lines = file($datasrc);
        $n = 0;
        $lastline = '';
        $currentSection =& $obj->container;
        foreach ($lines as $line) {
            $n++;
            if (!preg_match('/^\s*'.$this->options['comment'].'/', $line) &&
                 preg_match('/^\s*(.*)\s+'.$this->options['newline'].'\s*$/', $line, $match)) {
                // directive on more than one line
                $lastline .= $match[1].' ';
                continue;
            }
            if ($lastline != '') {
                $line = $lastline.trim($line);
                $lastline = '';
            }
            if (preg_match('/^\s*'.$this->options['comment'].'+\s*(.*?)\s*$/', $line, $match)) {
                // a comment
                $currentSection->createComment($match[1]);
            } elseif (preg_match('/^\s*$/', $line)) {
                // a blank line
                $currentSection->createBlank();
            } elseif (preg_match('/^\s*(\w+)'.$this->options['equals'].'\s*((.*?)|)\s*$/', $line, $match)) {
                // a directive
                $currentSection->createDirective($match[1], $match[2]);
            } else {
                return PEAR::raiseError("Syntax error in '$datasrc' at line $n.", null, PEAR_ERROR_RETURN);
            }
        }
        return true;
    } // end func parseDatasrc

    /**
    * Returns a formatted string of the object
    * @param    object  $obj    Container object to be output as string
    * @access public
    * @return string
    */
    function toString(&$obj)
    {
        $string = '';
        switch ($obj->type) {
            case 'blank':
                $string = "\n";
                break;
            case 'comment':
                $string = $this->options['comment'].$obj->content."\n";
                break;
            case 'directive':
                $string = $obj->name.$this->options['equals'].$obj->content."\n";
                break;
            case 'section':
                // How to deal with sections ???
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
} // end class Config_Container_GenericConf
?>