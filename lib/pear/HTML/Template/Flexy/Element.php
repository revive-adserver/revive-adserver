<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997, 1998, 1999, 2000, 2001 The PHP Group             |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Alan Knowles <alan@akbkhome.com>                             |
// | Based on HTML_Common by: Adam Daniel <adaniel1@eesus.jnj.com>        |
// +----------------------------------------------------------------------+
//
// $Id: Element.php,v 1.36 2005/05/18 06:05:12 alan_k Exp $

/**
 * Lightweight HTML Element builder and render
 *
 * This differs from HTML_Common in the following ways:
 *
 * $element->attributes is Public
 * $element->override if set to anything other than false, renders the value rather than 
 *   the defined element
 *
 * $element->children is a recursvable child array which is rendered by toHTML
 * $element->toHtml() is implemented
 * $element->toHtmlNoClose() renders  only the first tag and children (designed for <form
 * No support for tab offsets, comments ...
 *
 * Full support for Select, and common Form elements using
 * setValue()
 * setOptions()
 * 
 * overlay support with SetFrom - base + inherited..
 *
 * attributes array values:
 *  key="value" // standard key="value" in output
 *  key = true // outputs just key.
 *
 * children can be 
 *  another HTML_Element
 *  or string (raw text)
 *
 *
 * @author      Adam Daniel <adaniel1@eesus.jnj.com>
 * @version     1.6
 * @since       PHP 4.0.3pl1
 * @abstract
 */
class HTML_Template_Flexy_Element {

    

    /**
     * Tag that this Element represents.
     * @var  array
     * @access   public
     */
    var $tag =  '';
    /**
     * Associative array of table attributes
     * Note Special values:
     *   true == only display the key 
     *   false == remove
     *
     * @var  array
     * @access   public
     */
    var $attributes = array();

    /**
     * Sequence array of children
     * children that are strings are assumed to be text 
     * @var  array
     * @access   public
     */
    var $children = array();
    
    /**
     * override the tag.
     * if this is set to anything other than false, it will be output 
     * rather than the tags+children
     * @var  array
     * @access   public
     */
    var $override = false;
    /**
     * prefix the tag.
     * this is output by toHtml as a prefix to the tag (can be used for require tags)
     * @var  array
     * @access   private
     */
    var $prefix = '';
    /**
     * suffix the tag.
     * this is output by toHtml as a suffix to the tag (can be used for error messages)
     * @var  array
     * @access   private
     */
    var $suffix = '';
    
    /**
     * a value for delayed merging into live objects
     * if you set this on an element, it is merged by setValue, at merge time.
     * @var  array
     * @access   public
     */
    var $value = null;
    /**
     * Class constructor
     * @param    mixed   $attributes     Associative array of table tag attributes 
     *                                   or HTML attributes name="value" pairs
     * @access   public
     */
    function HTML_Template_Flexy_Element($tag='', $attributes=null)
    {
        
        $this->tag = strtolower($tag);
        if (false !== strpos($tag, ':')) {
            $bits = explode(':',$this->tag);
            $this->tag = $bits[0] . ':'.strtolower($bits[1]);
        }
        
        $this->setAttributes($attributes);
    } // end constructor

      
    /**
     * Returns an HTML formatted attribute string
     * @param    array   $attributes
     * @return   string
     * @access   private
     */
    function attributesToHTML()
    {
        $strAttr = '';
        $xhtmlclose = '';
        
        foreach ($this->attributes as $key => $value) {
        
            // you shouldn't do this, but It shouldnt barf when you do..
            if (is_array($value) || is_object($value)) {
                continue;
            }
            
            if ($key == 'flexy:xhtml') {
                continue;
            }
            if ($value === false) {
                continue;
            }
            if ($value === true) {
                // this is not xhtml compatible..
                if ($key == '/') {
                    $xhtmlclose = ' /';
                    continue;
                }
                if (isset($this->attributes['flexy:xhtml'])) {
                    $strAttr .= " {$key}=\"{$key}\"";
                } else {
                    $strAttr .= ' ' . $key;
                }
            } else {
                // dont replace & with &amp;
                $strAttr .= ' ' . $key . '="' . 
                    str_replace('&amp;','&',htmlspecialchars($value)) . '"';
            }
            
        }
        $strAttr .= $xhtmlclose;
        return $strAttr;
    } // end func _getAttrString

    /**
     * Static Method to get key/value array from attributes.
     * Returns a valid atrributes array from either a string or array
     * @param    mixed   $attributes     Either a typical HTML attribute string or an associative array
     * @access   private
     */
    function parseAttributes($attributes)
    {
        if (is_array($attributes)) {
            $ret = array();
            foreach ($attributes as $key => $value) {
                if (is_int($key)) {
                    $ret[strtolower($value)] = true;
                } else {
                    $ret[strtolower($key)]   = $value;
                }
            }
            return $ret;

        } elseif (is_string($attributes)) {
            $preg = "/(([A-Za-z_:]|[^\\x00-\\x7F])([A-Za-z0-9_:.-]|[^\\x00-\\x7F])*)" .
                "([ \\n\\t\\r]+)?(=([ \\n\\t\\r]+)?(\"[^\"]*\"|'[^']*'|[^ \\n\\t\\r]*))?/";
            if (preg_match_all($preg, $attributes, $regs)) {
                for ($counter=0; $counter<count($regs[1]); $counter++) {
                    $name  = $regs[1][$counter];
                    $check = $regs[0][$counter];
                    $value = $regs[7][$counter];
                    if (trim($name) == trim($check)) {
                        $arrAttr[strtolower(trim($name))] = strtolower(trim($name));
                    } else {
                        if (substr($value, 0, 1) == "\"" || substr($value, 0, 1) == "'") {
                            $value = substr($value, 1, -1);
                        }
                        $arrAttr[strtolower(trim($name))] = trim($value);
                    }
                }
                return $arrAttr;
            }
        }
    } // end func _parseAttributes

     
     
       
    /**
     * Utility function to set values from common tag types.
     * @param    HTML_Element   $from  override settings from another element.
     * @access   public
     */
     
    function setValue($value) {
        // store the value in all situations
        $this->value = $value;
        $tag = strtolower($this->tag);
        if (strpos($tag,':') !==  false) {
            $bits = explode(':',$tag);
            $tag = $bits[1];
        }
        switch ($tag) {
            case 'input':
                switch (isset($this->attributes['type']) ? strtolower($this->attributes['type']) : '') {
                    case 'checkbox':
                        if (isset($this->attributes['checked'])) {
                            unset($this->attributes['checked']);
                        }
                        // if value is nto set, it doesnt make any difference what you set ?
                        if (!isset($this->attributes['value'])) {
                            return;
                        }
                        //print_r($this); echo "SET TO "; serialize($value);
                        if (substr($this->attributes['name'],-2) == '[]') {
                            if (is_array($value) && 
                                in_array((string) $this->attributes['value'],$value)
                                ) {
                                $this->attributes['checked'] =  true;
                            }
                            return;
                        }
                        if ($this->attributes['value'] == $value) {
                            $this->attributes['checked'] =  true;
                        }
                        
                        
                        return;
                    case 'radio':
                        if (isset($this->attributes['checked'])) {
                            unset($this->attributes['checked']);
                        }
                        
                        if ($this->attributes['value'] == $value) {
                            $this->attributes['checked'] =  true;
                        }
                        return;
                    
                    default:
                        // no other input accepts array as a value.
                        if (is_array($value)) {
                            return;
                        }
                    
                        $this->attributes['value'] = $value;
                        return;
                }
                
            case 'select':
                
                if (!is_array($value)) {
                    $value = array($value);
                }
                
                // its setting the default value..
                
                foreach($this->children as $i=>$child) {
                    
                    if (is_string($child)) {
                        continue;
                    }
                    if ($child->tag == 'optgroup') {
                        foreach($this->children[$i]->children as $ii=>$child) {
                        
                            // does the value exist and match..
                            if (isset($child->attributes['value']) 
                                && in_array((string) $child->attributes['value'], $value)) 
                            {
                                $this->children[$i]->children[$ii]->attributes['selected'] = 
                                    isset($this->attributes['flexy:xhtml']) ? 'selected' : true;
                                continue;
                            }
                            if (isset($child->attributes['value']) && 
                                isset($this->children[$i]->children[$ii]->attributes['selected'])) 
                            {
                                unset($this->children[$i]->children[$ii]->attributes['selected']);
                                continue;
                            }
                            // value doesnt exst..
                          
                            if (isset($this->children[$i]->children[$ii]->attributes['selected'])) {
                                unset($this->children[$i]->children[$ii]->attributes['selected']);
                                continue;
                            }
                        }
                        continue;
                    }
                    
                    // standard option value...
                    //echo "testing {$child->attributes['value']} against ". print_r($value,true)."\n";
                    // does the value exist and match..
                    
                    if (isset($child->attributes['value']) 
                        && in_array((string) $child->attributes['value'], $value)) 
                    {
                       // echo "MATCH!\n";
                      
                        $this->children[$i]->attributes['selected'] = 
                            isset($this->attributes['flexy:xhtml']) ? 'selected' : true;;
                        continue;
                    }
                    // no value attribute try and use the contents.
                    if (!isset($child->attributes['value'])
                        && is_string($child->children[0])
                        && in_array((string) $child->children[0], $value))
                    {
                        
                        $this->children[$i]->attributes['selected'] =
                            isset($this->attributes['flexy:xhtml']) ? 'selected' : true;
                        continue;
                    }
                     
                    if (isset($child->attributes['value']) && 
                        isset($this->children[$i]->attributes['selected'])) 
                    {
                        //echo "clearing selected\n";
                        unset($this->children[$i]->attributes['selected']);
                        continue;
                    }
                    // value doesnt exst..
                    
                    if (isset($this->children[$i]->attributes['selected'])) {
                        //echo "clearing selected\n";
                        unset($this->children[$i]->attributes['selected']);
                        continue;
                    }
                    
                    
                }
                return;
            case 'textarea':
                $this->children = array(htmlspecialchars($value));
                return;
            case '':  // dummy objects.
                $this->value = $value;
                return;
                
            // XUL elements
            case 'menulist':
                require_once 'HTML/Template/Flexy/Element/Xul.php';
                HTML_Template_Flexy_Element_Xul::setValue($this,$value);
                return ;
                
            default:
                if (is_array($value)) {
                    return;
                }
                $this->value = $value;
        }
            
        
    
    
    }
    /**
     * Utility function equivilant to HTML_Select - loadArray ** 
     * but using 
     * key=>value maps 
     * <option value="key">Value</option>
     * Key=key (eg. both the same) maps to
     * <option>key</option>
     * and label = array(key=>value) maps to 
     * <optgroup label="label"> <option value="key">value</option></optgroup>
     * 
     * $element->setOptions(array('a'=>'xxx','b'=>'yyy'));
     * or
     * $element->setOptions(array('a','b','c','d'),true);
     *
     *
     *.
     * @param    HTML_Element   $from  override settings from another element.
     * @param    HTML_Element   $noValue  ignore the key part of the array
     * @access   public
     */
     
    function setOptions($array,$noValue=false) {
        if (!is_array($array)) {
            $this->children = array();
            return;
        }
        
        
        $tag = strtolower($this->tag);
        $namespace = '';
        if (false !== strpos($this->tag, ':')) {
            
            $bits = explode(':',$this->tag);
            $namespace = $bits[0] . ':';
            $tag = strtolower($bits[1]);
            
        }
        // if we have specified a xultag!!?
        if (strlen($tag) && ($tag != 'select')) {
                require_once 'HTML/Template/Flexy/Element/Xul.php';
                return HTML_Template_Flexy_Element_Xul::setOptions($this,$array,$noValue);
        }
        
        foreach($array as $k=>$v) {
            if (is_array($v)) {     // optgroup
                $child = new HTML_Template_Flexy_Element($namespace . 'optgroup',array('label'=>$k));
                foreach($v as $kk=>$vv) {
                    $atts=array();
                    if (($kk != $vv) && !$noValue) {
                        $atts = array('value'=>$kk);
                    }
                    $add = new HTML_Template_Flexy_Element($namespace . 'option',$atts);
                    $add->children = array(htmlspecialchars($vv));
                    $child->children[] = $add;
                }
                $this->children[] = $child;
                continue;
            } 
            $atts=array();
            if (($k !== $v) && !$noValue) {
                $atts = array('value'=>$k);
            } else {
                $atts = array('value'=>$v);
            }
            $add = new HTML_Template_Flexy_Element($namespace . 'option',$atts);
            $add->children = array(htmlspecialchars($v));
            $this->children[] = $add;
        }
       
    }
    /**
     * Sets the HTML attributes
     * @param    mixed   $attributes     Either a typical HTML attribute string or an associative array
     * @access   public
     */
     
    function setAttributes($attributes)
    {
        $attrs= $this->parseAttributes($attributes);
        if (!is_array($attrs)) {
            return false;
        }
        foreach ($attrs as $key => $value) {
            $this->attributes[$key] = $value;
        }
    } // end func updateAttributes

    /**
     * Removes an attributes
     * 
     * @param     string    $attr   Attribute name
     * @since     1.4
     * @access    public
     * @return    void
     * @throws
     */
    function removeAttributes($attrs)
    {
        if (is_string($attrs)) {
            $attrs = array($attrs);
        }
        foreach ($attrs as $attr) { 
            if (isset($this->attributes[strtolower($attr)])) {
                 $this->attributes[strtolower($attr)] = false;
            } 
        }
    } //end func removeAttribute

      
    /**
     * Output HTML and children
     *
     * @access    public
     * @param     object    $overlay = merge data from object.
     * @return    string
     * @abstract
     */
    function toHtml($overlay=false)
    {
         
        //echo "BEFORE<PRE>";print_R($this);
        $ret = $this;
        if ($overlay !== false) {
            $ret = HTML_Template_Flexy::mergeElement($this,$overlay);
        }
        
        if ($ret->override !== false) {
            return $ret->override;
        }
        $prefix = $ret->prefix;
        if (is_object($prefix)) {
            $prefix = $prefix->toHtml();
        }
        $suffix = $ret->suffix;
        if (is_object($suffix)) {
            $suffix = $suffix->toHtml();
        }
        //echo "AFTER<PRE>";print_R($ret);
      
        $tag = $this->tag;
        if (strpos($tag,':') !==  false) {
            $bits = explode(':',$tag);
            $tag = $bits[1];
        }
        // tags that never should have closers  
        $close = "</{$ret->tag}>";
        if (in_array(strtoupper($tag),array("INPUT","IMG"))) {
            $close = '';
        }
        if (isset($this->attributes['/'])) {
            $close = '';
        }

        $close .= $suffix ;
       
        return "{$prefix}<{$ret->tag}".$ret->attributesToHTML() . '>'.$ret->childrenToHTML() .$close;
        
         
    } // end func toHtml
    
    
    /**
     * Output Open Tag and any children and not Child tag (designed for use with <form + hidden elements>
     *
     * @access    public
     * @param     object    $overlay = merge data from object.
     * @return    string
     * @abstract
     */
    function toHtmlnoClose($overlay=false)
    {
        $ret = $this;
        if ($ret->override !== false) {
            return $ret->override;
        }
        if ($overlay !== false) {
            $ret = HTML_Template_Flexy::mergeElement($this,$overlay);
        }
        
  
        return "<{$ret->tag}".$ret->attributesToHTML() . '>' . $ret->childrenToHTML();
       
         
    } // end func toHtml
    
    
    /**
     * Output HTML and children
     *
     * @access    public
     * @return    string
     * @abstract
     */
    function childrenToHtml()
    {
        $ret = '';
        foreach($this->children as $child) {
            if (!is_object($child)) {
                $ret .= $child;
                continue;
            }
            
            $ret .= $child->toHtml();
        }
        return $ret;
    } // end func toHtml
    
     
    
    
    
} // end class HTML_Template_Flexy_Element
