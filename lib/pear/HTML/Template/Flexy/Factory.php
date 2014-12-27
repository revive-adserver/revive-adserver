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
//  Factory tools for managing groups of HTML_Elements

require_once 'HTML/Template/Flexy/Element.php';

class HTML_Template_Flexy_Factory {


    /**
    * fromArray - builds a set of elements from a key=>value array (eg. DO->toArray())
    * the second parameter is an optional HTML_Element array to merge it into.
    *
    *
    * @param   array   key(tag name) => value
    * @param   optional array   key(tag name) => HTML_Element
    *
    * @return   array    Array of HTML_Elements
    * @access   public
    */

    function fromArray($ar,$ret=array())
    {

        foreach($ar as $k=>$v) {
            if (is_array($v)) {
                $ret = HTML_Template_Flexy_Factory::fromArrayPrefixed($k,$v,$ret);
            }


            if (!isset($ret[$k])) {
                $ret[$k] = new HTML_Template_Flexy_Element();
            }
            $ret[$k]->setValue($v);
        }
        return $ret;
    }

    /**
    * fromArrayPrefixed - takes a multi dimensional array, and builds the 'xxx[sss][xx]' => value
    *
    * @param   array   key(tag name) => value
    * @param   array   key(tag name) => value
    * @param   optional array   key(tag name) => HTML_Element
    *
    * @return   array    Array of HTML_Elements
    * @access   public
    */

    function fromArrayPrefixed($prefix, $ar,$ret=array())
    {

        foreach($ar as $k=>$v) {
            if (is_array($v)) {
                $ret = HTML_Template_Flexy_Factory::fromArrayPrefixed($prefix.'['.$k.']',$v,$ret);
                if (!isset($ret[$prefix.'['.$k.'][]'])) {
                    $ret[$prefix.'['.$k.'][]'] = new HTML_Template_Flexy_Element();
                }
                $ret[$prefix.'['.$k.'][]']->setValue($v);
            }

            if (!isset($ret[$prefix.'['.$k.']'])) {
                $ret[$prefix.'['.$k.']'] = new HTML_Template_Flexy_Element();
            }
            $ret[$prefix.'['.$k.']']->setValue($v);



        }
        return $ret;
    }


    /**
    * setErrors - sets the suffix of an element to a value..
    *
    * HTML_Element_Factory::setErrors($elements,array('name','not long enough'));
    *
    * @depreciated  - this is really outside the scope of Factory - it should be
    *                   seperated into a rendering toolkit of some kind.

    * @param   array    of HTML_Element's
    * @param    array   key(tag name) => error
    * @param    string sprintf error format..
    *
    * @return   array    Array of HTML_Elements
    * @access   public
    */

    function &setErrors(&$ret,$set,$format='<span class="error">%s</span>')
    {
        if (empty($ret) || !is_array($ret)) {
            $ret = array();
        }
        // check what you send this.. !!!
        if (!is_array($set)) {
            return HTML_Template_Flexy::raiseError(
                'invalid arguments "$set" (should be an array) sent to HTML_Template_Flexy_Factory::setErrors',
                0, HTML_TEMPLATE_FLEXY_ERROR_DIE);
        }
        foreach($set as $k=>$v) {
            if (!$v) {
                continue;
            }
            if (!isset($ret[$k])) {
                $ret[$k] = new HTML_Template_Flexy_Element;
            }
            $ret[$k]->suffix .= sprintf($format,$v);
        }
        return $ret;
    }


    /**
    * setRequired - sets the prefix of an element to a value..
    *
    * HTML_Element_Factory::setRequired($elements,array('name',true));
    *
    * @depreciated  - this is really outside the scope of Factory - it should be
    *               seperated into a rendering toolkit
    *
    * @param    array   of HTML_Element's
    * @param    array  key(tag name) => error
    * @param    string sprintf error format..
    *
    *
    * @return   array    Array of HTML_Elements
    * @access   public
    */

    function &setRequired(&$ret,$set,$format='<span class="required">*</span>')
    {


        if (empty($ret) || !is_array($ret)) {
            $ret = array();
        }
        foreach($set as $k=>$v) {
            if (!$v) {
                continue;
            }
            if (!isset($ret[$k])) {
                $ret[$k] = new HTML_Template_Flexy_Element();
            }
            $ret[$k]->prefix .= sprintf($format,$v);
        }
        return $ret;
    }


    /**
    * freeze - freeze's an element. - just copies the value to the override.
    * this probably needs more thought.. - it would probably need to merge
    * the full tag info with types, to be usefull..
    *
    * $ar = HTML_Element_Factory::freeze($ar);
    *
    * @depreciated  - this is really outside the scope of Factory - it should be
    *               seperated into a rendering toolkit
    *
    *
    * @param   array   (return by referencekey(tag name) => HTML_Element
    *
    * @return   array    Array of HTML_Elements
    * @access   public
    */
    function freeze(&$array) {

        foreach($array as $k=>$v) {
            $array[$k]->override = $array[$k]->value;
        }
    }


}
