<?php

/**
* it under the terms of the GNU Lesser General Public License as
* published by the Free Software Foundation; either version 2.1 of the
* License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, but
* WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
* 
* @license http://www.gnu.org/copyleft/lesser.html LGPL
* 
*/
class HTML_Template_Flexy_Plugin_Savant {
    /** 
    * Output an HTML <a href="">...</a> tag.
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * 
    * @access public
    * 
    * @param string $href The URL for the resulting <a href="">...</a> tag.
    * 
    * @param string $text The text surrounded by the <a>...</a> tag set.
    * 
    * @param string $extra Any "extra" HTML code to place within the <a>
    * opening tag.
    * 
    * @return string
    */
    
    
     
    function ahref($href, $text, $extra = null)
    {
        $output = '<a href="' . $href . '"';
        
        if (! is_null($extra)) {
            $output .= ' ' . $extra;
        }
        
        $output .= '>' . $text . '</a>';
        
        return $output;
    }
 
    /**
    * 
    * Output a single checkbox <input> element.
      
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param string $name The HTML "name=" value for the checkbox.
    * 
    * @param mixed $value The value of the checkbox if checked.
    * 
    * @param mixed $selected Check $value against this; if they match,
    * mark the checkbox as checked.
    * 
    * @param string $set_unchecked If null, this will add no HTML to the
    * output. However, if set to any non-null value, the value will be
    * added as a hidden element before the checkbox so that if the
    * checkbox is unchecked, the hidden value will be returned instead
    * of the checked value.
    * 
    * @param string $extra Any "extra" HTML code to place within the
    * checkbox element.
    * 
    * @return string
    * 
    */
    function checkbox(
        $name,
        $value,
        $selected = null,
        $set_unchecked = null,
        $extra = null)
    {
        $html = '';
        
        if (! is_null($set_unchecked)) {
            // this sets the unchecked value of the checkbox.
            $html .= "<input type=\"hidden\" ";
            $html .= "name=\"$name\" ";
            $html .= "value=\"$set_unchecked\" />\n";
        }
        
        $html .= "<input type=\"checkbox\" ";
        $html .= "name=\"$name\" ";
        $html .= "value=\"$value\"";
                
        if ($value == $selected) {
            $html .= " checked=\"checked\"";
        }
        
        $html .= " $extra />";
        
        return $html;
    }
     
    /**
    * 
    * Output a set of checkbox <input>s.
    * 
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param string $name The HTML "name=" value of all the checkbox
    * <input>s. The name will get [] appended to it to make it an array
    * when returned to the server.
    * 
    * @param array $options An array of key-value pairs where the key is
    * the checkbox value and the value is the checkbox label.
    * 
    * @param string $set_unchecked If null, this will add no HTML to the
    * output. However, if set to any non-null value, the value will be
    * added as a hidden element before every checkbox so that if the
    * checkbox is unchecked, the hidden value will be returned instead
    * of the checked value.
    * 
    * @param string $sep The HTML text to place between every checkbox
    * in the set.
    * 
    * @param string $extra Any "extra" HTML code to place within the
    * checkbox element.
    * 
    * @return string
    * 
    */

    function checkboxes(
         
        $name,
        $options,
        $selected = array(),
        $set_unchecked = null,
        $sep = "<br />\n",
        $extra = null)
    {
        // force $selected to be an array.  this allows multi-checks to
        // have multiple checked boxes.
        settype($selected, 'array');
        
        // the text to be returned
        $html = '';
        
        if (is_array($options)) {
            
            // an iteration counter.  we use this to track which array
            // elements are checked and which are unchecked.
            $i = 0;
            
            foreach ($options as $value => $label) {
                
                if (! is_null($set_unchecked)) {
                    // this sets the unchecked value of the checkbox.
                    $html .= "<input type=\"hidden\" ";
                    $html .= "name=\"{$name}[$i]\" ";
                    $html .= "value=\"$set_unchecked\" />\n";
                }
                
                
                $html .= "<input type=\"checkbox\" ";
                $html .= "name=\"{$name}[$i]\" ";
                $html .= "value=\"$value\"";
                
                if (in_array($value, $selected)) {
                    $html .= " checked=\"checked\"";
                }
                
                if (! is_null($extra)) {
                    $html .= " $extra";
                }
                
                $html .= " />$label$sep";
                
                $i++;
            }
        }
        
        return $html;
    }

 
    
    /**
    * 
    * Cycle through a series of values based on an iteration number,
    * with optional group repetition.
    * 
    * For example, if you have three values in a cycle (a, b, c) the iteration
    * returns look like this:
    * 
    * 0	=> a
    * 1	=> b
    * 2	=> c
    * 3	=> a
    * 4	=> b
    * 5	=> c
    * 
    * If you repeat each cycle value (a,b,c) 2 times on the iterations,
    * the returns look like this:
    * 
    * 0 => a
    * 1 => a
    * 2 => b
    * 3 => b
    * 4 => c
    * 5 => c
    * 
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param int $iteration The iteration number for the cycle.
    * 
    * @param array $values The values to cycle through.
    * 
    * @param int $repeat The number of times to repeat a cycle value.
    * 
    * @return string
    * 
    */
    function cycle($iteration, $values = null, $repeat = 1)
    {
        settype($values, 'array');
        
        // prevent divide-by-zero errors
        if ($repeat == 0) {
            $repeat = 1;
        }
        
        return $values[($iteration / $repeat) % count($values)];
    }
    
    
    /**
    * 
    * Output a formatted date using strftime() conventions.
    * 
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param string $datestring Any date-time string suitable for
    * strtotime().
    * 
    * @param string $format The strftime() formatting string.
    * 
    * @return string
    * 
    */

    function dateformat($datestring, $format = false)
    {
        if ($format === false) {
            $format = isset($this->flexy->options['plugin.dateformat']) ?
                $this->flexy->options['plugin.dateformat'] : '%d %b %Y';
        }
        if (trim($datestring) == '') {
            return '';
        }
        
        $date = strtotime($datestring);
        if ($date > 1) {
            return strftime($format, $date);    
        }
        require_once 'Date.php';
        $date = new Date($date);
        return $date->format($format);
            
    }
   /**
    * 
    * Output a formatted number using number_format
    * 
    * 
     * 
    * @param string $datestring Any date-time string suitable for
    * strtotime().
    * 
    * @param string $format The strftime() formatting string.
    * 
    * @return string
    * 
    */

    function numberformat($number, $dec=false,$point=false,$thousands=false)
    {
        if (!strlen(trim($number))) {
            return;
        }
        // numberformat int decimals, string dec_point, string thousands_sep
        $dec = ($dec !== false) ? $dec : (
            isset($this->flexy->options['plugin.numberformat.decimals']) ?
                $this->flexy->options['plugin.numberformat.decimals'] : 2
            );
        $point = ($point !== false) ? $point : (
            isset($this->flexy->options['plugin.numberformat.point']) ?
                $this->flexy->options['plugin.numberformat.point'] : '.');
        $thousands = ($thousands !== false) ? $thousands : (
            isset($this->flexy->options['plugin.numberformat.thousands']) ?
                $this->flexy->options['plugin.numberformat.thousands'] : ',');
                
        
        return number_format($number,$dec,$point,$thousands);
    }

    
    
    /**
    * 
    * Output an <image ... /> tag.
    * 
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param string $src The image source as a relative or absolute HREF.
    * 
    * @param string $link Providing a link will make the image clickable,
    * leading to the URL indicated by $link; defaults to null.
    * 
    * @param string $alt Alternative descriptive text for the image;
    * defaults to the filename of the image.
    * 
    * @param int $border The border width for the image; defaults to zero.
    * 
    * @param int $width The displayed image width in pixels; defaults to
    * the width of the image.
    * 
    * @param int $height The displayed image height in pixels; defaults to
    * the height of the image.
    * 
    */
 
    function image(
        $src,
        $alt = null,
        $border = 0,
        $width = null,
        $height = null)
    {
        $size = '';
        
        // build the alt tag
        if (is_null($alt)) {
            $alt = basename($src);
        }
        
        $alt = ' alt="' . htmlentities($alt) . '"';
                
        // build the border tag
        $border = ' border="' . htmlentities($border) . '"';
        
        // get the width and height of the image
        if (is_null($width) && is_null($height)) {
        
            if (substr(strtolower($src), 0, 7) == 'http://' ||
                substr(strtolower($src), 0, 8) == 'https://') {
                
                // the image is not on the local filesystem
                $root = '';
            
            } else {
            
                // we need to set a base root path so we can find images on the
                // local file system
                $root = isset($GLOBALS['HTTP_SERVER_VARS']['DOCUMENT_ROOT'])
                    ? $GLOBALS['HTTP_SERVER_VARS']['DOCUMENT_ROOT'] . '/'
                    : '';
            }
            
            $info = @getimagesize($root . $src);
            
            $width = (is_null($width)) ? $info[0] : $width;
            $height = (is_null($height)) ? $info[1] : $height;
            
            unset($info);
        }
        
        // build the width tag
        if ($width > 0) {
            $size .= ' width="' . htmlentities($width) . '"';
        }
        
        // build the height tag
        if ($height > 0) {
            $size .= ' height="' . htmlentities($height) . '"';
        }
        
        // done!
        return '<img src="' . $src . '"' .
            $alt .
            $border .
            $size .
            ' />';
    }
 
    
    /**
    * 
    * Output a single <input> element.
    *  
    * @license http://www.gnu.org/copyleft/lesser.html LGPL
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param string $type The HTML "type=" value (e.g., 'text',
    * 'hidden', 'password').
    * 
    * @param string $name The HTML "name=" value.
    * 
    * @param mixed $value The initial value of the input element.
    * 
    * @param string $extra Any "extra" HTML code to place within the
    * checkbox element.
    * 
    * @return string
    * 
    */
    
    function input($type, $name, $value = '', $extra = '')
    {
        $output = "<input type=\"$type\" name=\"$name\" ";
        $output .= "value=\"$value\" $extra />";
        return $output;
    }
     
    /**
    * 
    * Output a <script></script> link to a JavaScript file.
    * 
    * 
    * @license http://www.gnu.org/copyleft/lesser.html LGPL
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param string $href The HREF leading to the JavaScript source
    * file.
    * 
    * @return string
    * 
    */

    function javascript($href)
    {
        return '<script language="javascript" type="text/javascript" src="' .
            $href . '"></script>';
    }
 

    /**
    * 
    * Output a value using echo after processing with optional modifier
    * functions.
    * 
    * Allows you to pass a space-separated list of value-manipulation
    * functions so that the value is "massaged" before output. For
    * example, if you want to strip slashes, force to lower case, and
    * convert to HTML entities (as for an input text box), you might do
    * this:
    * 
    * $this->modify($value, 'stripslashes strtolower htmlentities');
    * 
    * @license http://www.gnu.org/copyleft/lesser.html LGPL
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param string $value The value to be printed.
    * 
    * @param string $functions A space-separated list of
    * single-parameter functions to be applied to the $value before
    * printing.
    * 
    * @return string
    * 
    */
 
    function modify($value, $functions = null)
    {
        // is there a space-delimited function list?
        if (is_string($functions)) {
            
            // yes.  split into an array of the
            // functions to be called.
            $list = explode(' ', $functions);
            
            // loop through the function list and
            // apply to the output in sequence.
            foreach ($list as $func) {
                if (!function_exists($func)) {
                    continue;
                }
                // extend this..
                if (!in_array($func, array('htmlspecialchars','nl2br','urlencode'))) {
                    continue;
                }
                $value = $func($value);
                
            }
        }
        
        return $value;
    }
    

     
    /**
    * 
    * Output a series of HTML <option>s based on an associative array
    * where the key is the option value and the value is the option
    * label. You can pass a "selected" value as well to tell the
    * function which option value(s) should be marked as seleted.
    * 
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param array $options An associative array of key-value pairs; the
    * key is the option value, the value is the option lable.
    * 
    * @param mixed $selected A string or array that matches one or more
    * option values, to tell the function what options should be marked
    * as selected.  Defaults to an empty array.
    * 
    * @return string
    * 
    */
    function options( $options, $selected = array(), $extra = null)
    {
        $html = '';
        
        // force $selected to be an array.  this allows multi-selects to
        // have multiple selected options.
        settype($selected, 'array');
        
        // is $options an array?
        if (is_array($options)) {
            
            // loop through the options array
            foreach ($options as $value => $label) {
                
                $html .= '<option value="' . $value . '"';
                $html .= ' label="' . $label . '"';
                
                if (in_array($value, $selected)) {
                    $html .= ' selected="selected"';
                }
                
                if (! is_null($extra)) {
                    $html .= ' ' . $extra;
                }
                
                $html .= ">$label</option>\n";
            }
        }
        
        return $html;
    }
 

    /**
    * 
    * Output a set of radio <input>s with the same name.
    * 
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param string $name The HTML "name=" value of all the radio <input>s.
    * 
    * @param array $options An array of key-value pairs where the key is the
    * radio button value and the value is the radio button label.
    * 
    * $options = array (
    * 	0 => 'zero',
    *	1 => 'one',
    *	2 => 'two'
    * );
    * 
    * @param string $checked A comparison string; if any of the $option
    * element values and $checked are the same, that radio button will
    * be marked as "checked" (otherwise not).
    * 
    * @param string $extra Any "extra" HTML code to place within the
    * <input /> element.
    * 
    * @param string $sep The HTML text to place between every radio
    * button in the set.
    * 
    * @return string
    * 
    */

 
    function radios(
        $name,
        $options,
        $checked = null,
        $set_unchecked = null,
        $sep = "<br />\n",
        $extra = null)
    {
        $html = '';
        
        if (is_array($options)) {
            
            if (! is_null($set_unchecked)) {
                // this sets the unchecked value of the
                // radio button set.
                $html .= "<input type=\"hidden\" ";
                $html .= "name=\"$name\" ";
                $html .= "value=\"$set_unchecked\" />\n";
            }
            
            foreach ($options as $value => $label) {
                $html .= "<input type=\"radio\" ";
                $html .= "name=\"$name\" ";
                $html .= "value=\"$value\"";
                
                if ($value == $checked) {
                    $html .= " checked=\"checked\"";
                }
                $html .= " $extra />$label$sep";
            }
        }
        
        return $html;
    }
     
    /**
    * 
    * Output a <link ... /> to a CSS stylesheet.
    * 
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param string $href The HREF leading to the stylesheet file.
    * 
    * @return string
    * 
    */
 
    function stylesheet($href)
    {
        return '<link rel="stylesheet" type="text/css" href="' .
            $href . '" />';
    }

     
     
    
    /**
    * 
    * Output a single <textarea> element.
    * 
    * @license http://www.gnu.org/copyleft/lesser.html LGPL
    * 
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * 
    * @package Savant
    * 
    * @version $Id$
    * 
    * @access public
    * 
    * @param string $name The HTML "name=" value.
    * 
    * @param string $text The initial value of the textarea element.
    * 
    * @param int $tall How many rows tall should the area be?
    * 
    * @param mixed $wide The many columns wide should the area be?
    * 
    * @param string $extra Any "extra" HTML code to place within the
    * checkbox element.
    * 
    * @return string
    * 
    */
    
    function textarea($name, $text, $tall = 24, $wide = 80, $extra = '')
    {
        $output = "<textarea name=\"$name\" rows=\"$tall\" ";
        $output .= "cols=\"$wide\" $extra>$text</textarea>";
        return $output;
    }
}

