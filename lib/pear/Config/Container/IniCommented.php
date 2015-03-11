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
* Config parser for PHP .ini files with comments
*
* @author      Bertrand Mansion <bmansion@mamasam.com>
* @package     Config
*/
class Config_Container_IniCommented {

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
    * @return mixed returns a PEAR_ERROR, if error occurs or true if ok
    */
    function &parseDatasrc($datasrc, &$obj)
    {
        if (!file_exists($datasrc)) {
            return PEAR::raiseError("Datasource file does not exist.", null, PEAR_ERROR_RETURN);
        }
        $lines = file($datasrc);
        $n = 0;
        $lastline = '';
        $currentSection =& $obj->container;
        foreach ($lines as $line) {
            $n++;
            if (preg_match('/^\s*;(.*?)\s*$/', $line, $match)) {
                // a comment
                $currentSection->createComment($match[1]);
            } elseif (preg_match('/^\s*$/', $line)) {
                // a blank line
                $currentSection->createBlank();
            } elseif (preg_match('/^\s*([a-zA-Z0-9_\-\.\s]*)\s*=\s*(.*)\s*$/', $line, $match)) {
                // a directive

                $values = $this->_quoteAndCommaParser($match[2]);
                if (PEAR::isError($values)) {
                    return PEAR::raiseError($values);
                }

                if (count($values)) {
                    foreach($values as $value) {
                        if ($value[0] == 'normal') {
                            $currentSection->createDirective($match[1], $value[1]);
                        }
                        if ($value[0] == 'comment') {
                            $currentSection->createComment(substr($value[1], 1));
                        }
                    }
                }
            } elseif (preg_match('/^\s*\[\s*(.*)\s*\]\s*$/', $line, $match)) {
                // a section
                $currentSection =& $obj->container->createSection($match[1]);
            } else {
                return PEAR::raiseError("Syntax error in '$datasrc' at line $n.", null, PEAR_ERROR_RETURN);
            }
        }
        return true;
    } // end func parseDatasrc

    /**
     * Quote and Comma Parser for INI files
     *
     * This function allows complex values such as:
     *
     * <samp>
     * mydirective = "Item, number \"1\"", Item 2 ; "This" is really, really tricky
     * </samp>
     * @param  string  $text    value of a directive to parse for quotes/multiple values
     * @return array   The array returned contains multiple values, if any (unquoted literals
     *                 to be used as is), and a comment, if any.  The format of the array is:
     *
     * <pre>
     * array(array('normal', 'first value'),
     *       array('normal', 'next value'),...
     *       array('comment', '; comment with leading ;'))
     * </pre>
     * @author Greg Beaver <cellog@users.sourceforge.net>
     * @access private
     */
    function _quoteAndCommaParser($text)
    {
        $text = trim($text);
        if ($text == '') {
            return array();
        }

        // tokens
        $tokens['normal'] = array('"', ';', ',');
        $tokens['quote'] = array('"', '\\');
        $tokens['escape'] = false; // cycle
        $tokens['after_quote'] = array(',', ';');

        // events
        $events['normal'] = array('"' => 'quote', ';' => 'comment', ',' => 'normal');
        $events['quote'] = array('"' => 'after_quote', '\\' => 'escape');
        $events['after_quote'] = array(',' => 'normal', ';' => 'comment');

        // state stack
        $stack = array();

        // return information
        $return = array();
        $returnpos = 0;
        $returntype = 'normal';

        // initialize
        array_push($stack, 'normal');
        $pos = 0; // position in $text

        do {
            $char = $text{$pos};
            $state = $this->_getQACEvent($stack);

            if ($tokens[$state]) {
                if (in_array($char, $tokens[$state])) {
                    switch($events[$state][$char]) {
                        case 'quote' :
                            if ($state == 'normal' &&
                                isset($return[$returnpos]) &&
                                !empty($return[$returnpos][1])) {
                                return PEAR::raiseError("invalid ini syntax, quotes cannot follow text '$text'",
                                                        null, PEAR_ERROR_RETURN);
                            }
                            if ($returnpos >= 0 && isset($return[$returnpos])) {
                                // trim any unnecessary whitespace in earlier entries
                                $return[$returnpos][1] = trim($return[$returnpos][1]);
                            } else {
                                $returnpos++;
                            }
                            $return[$returnpos] = array('normal', '');
                            array_push($stack, 'quote');
                            continue 2;
                        break;
                        case 'comment' :
                            // comments go to the end of the line, so we are done
                            $return[++$returnpos] = array('comment', substr($text, $pos));
                            return $return;
                        break;
                        case 'after_quote' :
                            array_push($stack, 'after_quote');
                        break;
                        case 'escape' :
                            // don't save the first slash
                            array_push($stack, 'escape');
                            continue 2;
                        break;
                        case 'normal' :
                        // start a new segment
                            if ($state == 'normal') {
                                $returnpos++;
                                continue 2;
                            } else {
                                while ($state != 'normal') {
                                    array_pop($stack);
                                    $state = $this->_getQACEvent($stack);
                                }
                            }
                        break;
                        default :
                            PEAR::raiseError("::_quoteAndCommaParser oops, state missing", null, PEAR_ERROR_DIE);
                        break;
                    }
                } else {
                    if ($state != 'after_quote') {
                        if (!isset($return[$returnpos])) {
                            $return[$returnpos] = array('normal', '');
                        }
                        // add this character to the current ini segment if non-empty, or if in a quote
                        if ($state == 'quote') {
                            $return[$returnpos][1] .= $char;
                        } elseif (!empty($return[$returnpos][1]) ||
                                 (empty($return[$returnpos][1]) && trim($char) != '')) {
                            if (!isset($return[$returnpos])) {
                                $return[$returnpos] = array('normal', '');
                            }
                            $return[$returnpos][1] .= $char;
                        }
                    } else {
                        if (trim($char) != '') {
                            return PEAR::raiseError("invalid ini syntax, text after a quote not allowed '$text'",
                                                    null, PEAR_ERROR_RETURN);
                        }
                    }
                }
            } else {
                // no tokens, so add this one and cycle to previous state
                $return[$returnpos][1] .= $char;
                array_pop($stack);
            }
        } while (++$pos < strlen($text));
        return $return;
    } // end func _quoteAndCommaParser

    /**
     * Retrieve the state off of a state stack for the Quote and Comma Parser
     * @param  array  $stack    The parser state stack
     * @author Greg Beaver <cellog@users.sourceforge.net>
     * @access private
     */
    function _getQACEvent($stack)
    {
        return array_pop($stack);
    } // end func _getQACEvent

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
                /*} elseif ( strpos($content, '\'') !== false ||
                           strpos($content, '\\') !== false )  // OPENX FIX :)
                {
                    // leave unquoted*/
                } elseif ( strpos($content, '"') !== false ) // OPENX FIX :)
                {
                    // can't do anything with double quotes, they will break parse_ini_file()
                } elseif (
                            strlen(trim($content)) < strlen($content) ||
                            preg_match( '/[\W]/', $content, $aMatches)   // OPENX FIX :)
                         )
                {
                    $content = '"'.$content.'"';    // OPENX FIX :)
                                                    // removed addslashes as parse_ini_file works correct only with unescaped chars
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
                    $string = "\n[".$obj->name."]\n";
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
} // end class Config_Container_IniCommented
?>