<?php
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2006 Manuel Lemos, Tomas V.V.Cox,                 |
// | Stig. S. Bakken, Lukas Smith                                         |
// | All rights reserved.                                                 |
// +----------------------------------------------------------------------+
// | MDB2 is a merge of PEAR DB and Metabases that provides a unified DB  |
// | API as well as database abstraction for PHP applications.            |
// | This LICENSE is in the BSD license style.                            |
// |                                                                      |
// | Redistribution and use in source and binary forms, with or without   |
// | modification, are permitted provided that the following conditions   |
// | are met:                                                             |
// |                                                                      |
// | Redistributions of source code must retain the above copyright       |
// | notice, this list of conditions and the following disclaimer.        |
// |                                                                      |
// | Redistributions in binary form must reproduce the above copyright    |
// | notice, this list of conditions and the following disclaimer in the  |
// | documentation and/or other materials provided with the distribution. |
// |                                                                      |
// | Neither the name of Manuel Lemos, Tomas V.V.Cox, Stig. S. Bakken,    |
// | Lukas Smith nor the names of his contributors may be used to endorse |
// | or promote products derived from this software without specific prior|
// | written permission.                                                  |
// |                                                                      |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT    |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS    |
// | FOR A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE      |
// | REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,          |
// | INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, |
// | BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS|
// |  OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED  |
// | AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT          |
// | LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY|
// | WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE          |
// | POSSIBILITY OF SUCH DAMAGE.                                          |
// +----------------------------------------------------------------------+
// | Author: Christian Dickmann <dickmann@php.net>                        |
// +----------------------------------------------------------------------+

require_once 'XML/Parser.php';
require_once 'MDB2/Schema/Validate.php';

if (empty($GLOBALS['_MDB2_Schema_Reserved'])) {
    $GLOBALS['_MDB2_Schema_Reserved'] = array();
}

/**
 * Parses an XML schema file
 *
 * @package MDB2_Schema
 * @category Database
 * @access protected
 * @author  Christian Dickmann <dickmann@php.net>
 */
class MDB2_Dictionary_Parser extends XML_Parser
{
    var $dictionary_definition = array();
    var $elements = array();
    var $element = '';
    var $count = 0;
    var $field = array();
    var $field_name = '';
    var $var_mode = false;
    var $variables = array();
    var $error;
    var $val;

    function __construct($variables, $fail_on_invalid_names = true, $structure = false, $valid_types = array(), $force_defaults = true)
    {
        // force ISO-8859-1 due to different defaults for PHP4 and PHP5
        // todo: this probably needs to be investigated some more andcleaned up
        parent::__construct('ISO-8859-1');
        $this->variables = $variables;
        $this->structure = $structure;
        $this->val = new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);
    }

    function startHandler($xp, $elem, $attribs)
    {
        if (strtolower($elem) == 'variable') {
            $this->var_mode = true;
            return;
        }

        $this->elements[$this->count++] = strtolower($elem);
        $this->element = implode('-', $this->elements);

        switch ($this->element) {
        case 'dictionary-field':
            $this->field_name = '';
            $this->field = array();
            break;
        }
    }

    function endHandler($xp, $element)
    {
        if (strtolower($element) == 'variable') {
            $this->var_mode = false;
            return;
        }

        switch ($this->element) {

        /* Field declaration */
        case 'dictionary-field':
//            $result = $this->val->validateField($this->table['fields'], $this->field, $this->field_name);
            if (PEAR::isError($result)) {
                $this->raiseInstanceError($result->getUserinfo(), 0, $xp, $result->getCode());
            } else {
                $this->dictionary_definition[$this->field_name] = $this->field;
                //$this->dictionary_definition['options'][] = "<option value=\"{$this->field_name}\">{$this->field_name}</option>";
                //$this->dictionary_definition['list'][] = "<li value=\"{$this->field_name}s\">{$this->field_name}</li>";
            }
            break;
        }

        unset($this->elements[--$this->count]);
        $this->element = implode('-', $this->elements);
    }

    function &raiseInstanceError($msg = null, $xmlecode = 0, $xp = null, $ecode = MDB2_SCHEMA_ERROR_PARSE)
    {
        if (is_null($this->error)) {
            $error = '';
            if (is_resource($msg)) {
                $error.= 'Parser error: '.xml_error_string(xml_get_error_code($msg));
                $xp = $msg;
            } else {
                $error.= 'Parser error: '.$msg;
                if (!is_resource($xp)) {
                    $xp = $this->parser;
                }
            }
            if ($error_string = xml_error_string($xmlecode)) {
                $error.= ' - '.$error_string;
            }
            if (is_resource($xp)) {
                $byte = @xml_get_current_byte_index($xp);
                $line = @xml_get_current_line_number($xp);
                $column = @xml_get_current_column_number($xp);
                $error.= " - Byte: $byte; Line: $line; Col: $column";
            }
            $error.= "\n";
            $this->error =& MDB2_Schema::raiseError($ecode, null, null, $error);
        }
        return $this->error;
    }

    function cdataHandler($xp, $data)
    {
        if ($this->var_mode == true) {
            if (!isset($this->variables[$data])) {
                $this->raiseInstanceError('variable "'.$data.'" not found', null, $xp);
                return;
            }
            $data = $this->variables[$data];
        }

        switch ($this->element) {

        /* Field declaration */
        case 'dictionary-field-name':
            if (isset($this->field_name)) {
                $this->field_name.= $data;
            } else {
                $this->field_name = $data;
            }
            break;
        case 'dictionary-field-type':
            if (isset($this->field['type'])) {
                $this->field['type'].= $data;
            } else {
                $this->field['type'] = $data;
            }
            break;
        case 'dictionary-field-notnull':
            if (isset($this->field['notnull'])) {
                $this->field['notnull'].= $data;
            } else {
                $this->field['notnull'] = $data;
            }
            break;
        case 'dictionary-field-unsigned':
            if (isset($this->field['unsigned'])) {
                $this->field['unsigned'].= $data;
            } else {
                $this->field['unsigned'] = $data;
            }
            break;
        case 'dictionary-field-autoincrement':
            if (isset($this->field['autoincrement'])) {
                $this->field['autoincrement'].= $data;
            } else {
                $this->field['autoincrement'] = $data;
            }
            break;
        case 'dictionary-field-default':
            if (isset($this->field['default'])) {
                $this->field['default'].= $data;
            } else {
                $this->field['default'] = $data;
            }
            break;
        case 'dictionary-field-length':
            if (isset($this->field['length'])) {
                $this->field['length'].= $data;
            } else {
                $this->field['length'] = $data;
            }
            break;
        case 'dictionary-field-scale':
            if (isset($this->field['scale'])) {
                $this->field['scale'].= $data;
            } else {
                $this->field['scale'] = $data;
            }
            break;
        }
    }

    function setData(&$array, $key, $value)
    {
        $array[(count($array)-1)][$key] = $value;
    }
}

?>
