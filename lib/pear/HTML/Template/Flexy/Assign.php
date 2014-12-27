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
//  Provider for Assign API ( Eg. $flexy->assign(...) )

define('HTML_TEMPLATE_FLEXY_ASSIGN_ERROR_INVALIDARGS', -100);

class HTML_Template_Flexy_Assign {

    /**
    * The variables stored in the Assigner
    *
    * @var array
    * @access public
    */
    var $variables = array();
    /**
    * The references stored in the Assigner
    *
    * @var array
    * @access public
    */
    var $references = array();


    /**
    *
    * Assigns a token-name and value to $this->_token_vars for use in a
    * template.
    *
    * There are three valid ways to assign values to a template.
    *
    * Form 1: $args[0] is a string and $args[1] is mixed. This means
    * $args[0] is a token name and $args[1] is the token value (which
    * allows objects, arrays, strings, numbers, or anything else).
    * $args[1] can be null, which means the corresponding token value in
    * the template will also be null.
    *
    * Form 2: $args[0] is an array and $args[1] is not set. Assign a
    * series of tokens where the key is the token name, and the value is
    * token value.
    *
    * Form 3: $args[0] is an object and $args[1] is not set.  Assigns
    * copies of all object variables (properties) to tokens; the token
    * name and value is a copy of each object property and value.
    *
    * @access public
    *
    * @param string|array|object $args[0] This param can be a string, an
    * array, or an object.  If $args[0] is a string, it is the name of a
    * variable in the template.  If $args[0] is an array, it must be an
    * associative array of key-value pairs where the key is a variable
    * name in the template and the value is the value for that variable
    * in the template.  If $args[0] is an object, copies of its
    * properties will be assigned to the template.
    *
    * @param mixed $args[1] If $args[0] is an array or object, $args[1]
    * should not be set.  Otherwise, a copy of $args[1] is assigned to a
    * template variable named after $args[0].
    *
    * @return bool|PEAR_Error Boolean true if all assignments were
    * committed, or a PEAR_Error object if there was an error.
    *
    * @throws SAVANT_ERROR_ASSIGN Unknown reason for error, probably
    * because you passed $args[1] when $args[0] is an array or object.
    *
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * @see assignRef()
    *
    * @see assignObject()
    *
    */

    function assign($args)
    {
        // in Form 1, $args[0] is a string name and $args[1] is mixed.
        // in Form 2, $args[0] is an associative array.
        // in Form 3, $args[0] is an object.

        $count = count($args);

        // -------------------------------------------------------------
        //
        // Now we assign variable copies.
        //

        // form 1 (string name and mixed value)
        // don't check isset() on $args[1] becuase a 'null' is not set,
        // and we might want to pass a null.
        if (is_string($args[0]) && $count > 1) {
            if (isset($this->references[$args[0]])) {
                unset($this->references[$args[0]]);
            }
            // keep a copy in the token vars array
            $this->variables[$args[0]] = $args[1];

            // done!
            return true;
        }

        // form 2 (assoc array)
        if (is_array($args[0]) && $count == 1) {

            foreach ($args[0] as $key=>$val) {
                $this->assign($key, $val);
            }

            // done!
            return true;
        }

        // form 3 (object props)
        if (is_object($args[0]) && $count == 1) {

            // get the object properties
            $data = get_object_vars($args[0]);
            foreach ($data as $key=>$val) {
                $this->assign($key, $val);
            }

            // done!
            return true;
        }


        // -------------------------------------------------------------
        //
        // Final error catch.  We should not have gotten to this point.
        //

        return HTML_Template_Flexy::raiseError(
            "invalid type sent to assign, ". print_r($args,true),
            HTML_TEMPLATE_FLEXY_ASSIGN_ERROR_INVALIDARGS
        );
    }


    /**
    *
    * Assign a token by reference.  This allows you change variable
    * values within the template and have those changes reflected back
    * at the calling logic script.  Works as with form 2 of assign().
    *
    * @access public
    *
    * @param string $name The template token-name for the reference.
    *
    * @param mixed &$ref The variable passed by-reference.
    *
    * @return bool|PEAR_Error Boolean true on success, or a PEAR_Error
    * on failure.
    *
    * @throws SAVANT_ERROR_ASSIGN_REF Unknown reason for error.
    *
    * @see assign()
    * @author Paul M. Jones <pmjones@ciaweb.net>
    * @see assignObject()
    *
    */

    function assignRef($name, &$ref)
    {
        // look for the proper case: name and variable
        if (is_string($name) && isset($ref)) {
            if (isset($this->variables[$name])) {
                unset($this->variables[$name]);
            }
            //
            // assign the token as a reference
            $this->references[$name] =& $ref;

            // done!
            return true;
        }

        // final error catch
        return HTML_Template_Flexy::raiseError(
            "invalid type sent to assignRef, ". print_r($name,true),
            HTML_TEMPLATE_FLEXY_ASSIGN_ERROR_INVALIDARGS

        );
    }




}