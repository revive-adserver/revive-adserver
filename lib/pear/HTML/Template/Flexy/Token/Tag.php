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
// | Authors:  Alan Knowles <alan@akbkhome>                               |
// +----------------------------------------------------------------------+


$GLOBALS['_HTML_TEMPLATE_FLEXY_TOKEN_TAG']['activeSelect'] = false;
require_once 'HTML/Template/Flexy/Element.php';
/**
* A standard HTML Tag = eg. Table/Body etc.
*
* @abstract
* This is the generic HTML tag
* a simple one will have some attributes and a name.
*
*/

class HTML_Template_Flexy_Token_Tag extends HTML_Template_Flexy_Token {

    /**
    * HTML Tag: eg. Body or /Body - uppercase
    *
    * @var string
    * @access public
    */
    var $tag = '';
    /**
    * HTML Tag: (original case)
    *
    * @var string
    * @access public
    */
    var $oTag = '';
    /**
    * Associative array of attributes. (original case)
    *
    * key is the left, value is the right..
    * note:
    *     values are raw (eg. include "")
    *     valuse can be
    *                text = standard
    *                array (a parsed value with flexy tags in)
    *                object (normally some PHP code that generates the key as well..)
    *
    *
    * @var array
    * @access public
    */

    var $attributes = array();

    /**
    * Associative array of attributes ucase to Original Case for attributes..
    *
    * @var array
    * @access public
    */

    var $ucAttributes = array();



    /**
    * postfix tokens
    * used to add code to end of tags "<xxxx>here....children .. <close tag>"
    *
    * @var array
    * @access public
    */
    var $postfix = '';
     /**
    * prefix tokens
    * used to add code to beginning of tags TODO  "here<xxxx>....children .. <close tag>"
    *
    * @var array
    * @access public
    */
    var $prefix = '';


    /**
    * Alias to closing tag (built externally).
    * used to add < ? } ? > code to dynamic tags.
    * @var object alias
    * @access public
    */
    var $close; // alias to closing tag.



    /**
    * Setvalue - gets name, attribute as an array
    * @see parent::setValue()
    */

    function setValue($value)
    {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;
        $this->tag = strtoupper($value[0]);
        $this->oTag = $value[0];
        if (isset($value[1])) {
            $this->attributes = $value[1];
        }

        foreach(array_keys($this->attributes) as $k) {
            $this->ucAttributes[strtoupper($k)] =&  $this->attributes[$k];
        }

    }



    /**
    * getAttribute = reads an attribute value and strips the quotes
    *
    * TODO
    * does not handle values with flexytags in them
    *
    * @return   string (
    * @access   public
    */
    function getAttribute($key) {
        // all attribute keys are stored Upper Case,
        // however just to make sure we have not done a typo :)
        $key = strtoupper($key);
        //echo "looking for $key\n";
        //var_dump($this->attributes);

        // this is weird case isset() returns false on this being null!

        if (@$this->ucAttributes[$key] === true) {
            return true;
        }

        if (!isset($this->ucAttributes[$key])) {
            return false;
        }
        // general assumption - none of the tools can do much with dynamic
        // attributes - eg. stuff with flexy tags in it.
        if (!is_string($this->ucAttributes[$key])) {
            return false;
        }
        $v = $this->ucAttributes[$key];

        // unlikely :)
        if ($v=='') {
            return $v;
        }

        switch($v[0]) {
            case "\"":
            case "'":
                return substr($v,1,-1);
            default:
                return $v;
        }
    }

    /**
    * getAttributes = returns all the attributes key/value without quotes
    *
    *
    * @return   array
    * @access   string
    */

    function getAttributes() {
        $ret = array();
        foreach($this->attributes as $k=>$v) {
            if (substr(strtoupper($k),0,6) == 'FLEXY:') {
                continue;
            }
            $ret[$k] = $this->getAttribute($k);
        }
        return $ret;
    }

    /**
    * clearAttributes = removes an attribute from the object.
    *
    *
    * @return   array
    * @access   string
    */
    function clearAttribute($string) {
        if (isset($this->attributes[$string])) {
            unset($this->attributes[$string]);
        }
    }



}



