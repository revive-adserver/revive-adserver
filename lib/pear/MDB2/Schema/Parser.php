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
class MDB2_Schema_Parser extends XML_Parser
{
    var $database_definition = array('tables' => array(), 'sequences' => array());
    var $elements = array();
    var $element = '';
    var $count = 0;
    var $table = array();
    var $table_name = '';
    var $field = array();
    var $field_name = '';
    var $init = array();
    var $init_function = array();
    var $init_expression = array();
    var $index = array();
    var $index_name = '';
    var $var_mode = false;
    var $variables = array();
    var $sequence = array();
    var $sequence_name = '';
    var $error;
    var $structure = false;
    var $val;
    var $validate = true;

    function __construct($variables, $fail_on_invalid_names = true, $structure = false, $valid_types = array(), $force_defaults = true)
    {
        // force ISO-8859-1 due to different defaults for PHP4 and PHP5
        // todo: this probably needs to be investigated some more andcleaned up
        parent::__construct('ISO-8859-1');
        $this->variables = $variables;
        $this->structure = $structure;
        $this->val = new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);
    }

    function startHandler($xp, $element, $attribs)
    {
        if (strtolower($element) == 'variable') {
            $this->var_mode = true;
            return;
        }

        $this->elements[$this->count++] = strtolower($element);
        $this->element = implode('-', $this->elements);

        switch ($this->element) {
        /* Initialization */
        case 'database-table-initialization':
            $this->table['initialization'] = array();
            break;

        /* Insert */
        /* insert: field+ */
        case 'database-table-initialization-insert':
            $this->init = array('type' => 'insert', 'data' => array('field' => array()));
            break;

        /* Update */
        /* update: field+, where? */
        case 'database-table-initialization-update':
            $this->init = array('type' => 'update', 'data' => array('field' => array()));
            break;

        /* Delete */
        /* delete: where */
        case 'database-table-initialization-delete':
            $this->init = array('type' => 'delete', 'data' => array('where' => array()));
            break;

        /* Insert and Update */
        case 'database-table-initialization-insert-field':
        case 'database-table-initialization-update-field':
            $this->init['data']['field'][] = array('name' => '', 'group' => array());
            break;
        case 'database-table-initialization-insert-field-value':
        case 'database-table-initialization-update-field-value':
            /* if value tag is empty cdataHandler is not called so we must force value element creation here */
            $this->setData($this->init['data']['field'], 'group', array('type' => 'value', 'data' => ''));
            break;
        case 'database-table-initialization-insert-field-null':
        case 'database-table-initialization-update-field-null':
            $this->setData($this->init['data']['field'], 'group', array('type' => 'null'));
            break;
        case 'database-table-initialization-insert-field-function':
        case 'database-table-initialization-update-field-function':
            $this->init_function = array();
            break;
        case 'database-table-initialization-insert-field-expression':
        case 'database-table-initialization-update-field-expression':
            $this->init_expression = array();
            break;

        /* Update and Delete */
        case 'database-table-initialization-update-where':
        case 'database-table-initialization-delete-where':
            $this->init['data']['where'] = array('type' => '', 'data' => array());
            break;

        case 'database-table-initialization-update-where-expression':
        case 'database-table-initialization-delete-where-expression':
            $this->init_expression = array();
            break;

        /* One level simulation of expression-function recursion */
        case 'database-table-initialization-insert-field-expression-function':
        case 'database-table-initialization-update-field-expression-function':
        case 'database-table-initialization-update-where-expression-function':
        case 'database-table-initialization-delete-where-expression-function':
            $this->init_function = array();
            break;

        /* One level simulation of function-expression recursion */
        case 'database-table-initialization-insert-field-function-expression':
        case 'database-table-initialization-update-field-function-expression':
        case 'database-table-initialization-update-where-function-expression':
        case 'database-table-initialization-delete-where-function-expression':
            $this->init_expression = array();
            break;

        /* Definition */
        case 'database-table':
            $this->table_name = '';
            $this->table = array('fields' => array(), 'indexes' => array());
            break;
        case 'database-table-declaration-field':
            $this->field_name = '';
            $this->field = array();
            break;
        case 'database-table-declaration-field-default':
            $this->field['default'] = '';
            break;
        case 'database-table-declaration-index':
            $this->index_name = '';
            $this->index = array('fields' => array());
            break;
        case 'database-sequence':
            $this->sequence_name = '';
            $this->sequence = array();
            break;
        case 'database-table-declaration-index-field':
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
        /* Initialization */

        /* Insert and Delete */
        case 'database-table-initialization-insert-field':
        case 'database-table-initialization-update-field':
            /* field are now accepting functions and expressions
            we can't determine the return type of them
            $result = $this->val->validateInsertField($this);
            if (PEAR::isError($result)) {
                $this->raiseError($result->getUserinfo(), 0, $xp, $result->getCode());
            }
            */
            break;
        case 'database-table-initialization-insert-field-function':
        case 'database-table-initialization-update-field-function':
            $this->setData($this->init['data']['field'], 'group', array('type' => 'function', 'data' => $this->init_function));
            break;
        case 'database-table-initialization-insert-field-expression':
        case 'database-table-initialization-update-field-expression':
            $this->setData($this->init['data']['field'], 'group', array('type' => 'expression', 'data' => $this->init_expression));
            break;

        /* Delete and Update */
        case 'database-table-initialization-update-where-expression':
        case 'database-table-initialization-delete-where-expression':
            $this->init['data']['where']['type'] = 'expression';
            $this->init['data']['where']['data'] = $this->init_expression;
            break;

        /* All */
        case 'database-table-initialization-insert':
        case 'database-table-initialization-delete':
        case 'database-table-initialization-update':
            $this->table['initialization'][] = $this->init;
            break;

        /* One level simulation of expression-function recursion */
        case 'database-table-initialization-insert-field-expression-function':
        case 'database-table-initialization-update-field-expression-function':
        case 'database-table-initialization-update-where-expression-function':
        case 'database-table-initialization-delete-where-expression-function':
            $this->init_expression['operants'][] = array('type' => 'function', 'data' => $this->init_function);
            break;

        /* One level simulation of function-expression recursion */
        case 'database-table-initialization-insert-field-function-expression':
        case 'database-table-initialization-update-field-function-expression':
        case 'database-table-initialization-update-where-function-expression':
        case 'database-table-initialization-delete-where-function-expression':
            $this->init_function['arguments'][] = array('type' => 'expression', 'data' => $this->init_expression);
            break;

        /* Table definition */
        case 'database-table':
            if ($this->validate)
            {
                $result = $this->val->validateTable($this->database_definition['tables'], $this->table, $this->table_name);
                if (PEAR::isError($result)) {
                    $this->customRaiseError($result->getUserinfo(), 0, $xp, $result->getCode());
                }
            }
            $this->database_definition['tables'][$this->table_name] = $this->table;
            break;
        case 'database-table-name':
            if (isset($this->structure_tables[$this->table_name])) {
                $this->table = $this->structure_tables[$this->table_name];
            }
            break;

        /* Field declaration */
        case 'database-table-declaration-field':
            if ($this->validate)
            {
                $result = $this->val->validateField($this->table['fields'], $this->field, $this->field_name);
                if (PEAR::isError($result)) {
                    $this->customRaiseError($result->getUserinfo(), 0, $xp, $result->getCode());
                }
            }
            $this->table['fields'][$this->field_name] = $this->field;
            break;

        /* Index declaration */
        case 'database-table-declaration-index':
            if ($this->validate)
            {
                $result = $this->val->validateIndex($this->table['indexes'], $this->index, $this->index_name);
                if (PEAR::isError($result)) {
                    $this->customRaiseError($result->getUserinfo(), 0, $xp, $result->getCode());
                }
            }
            $this->table['indexes'][$this->index_name] = $this->index;
            break;
        case 'database-table-declaration-index-field':
            if ($this->validate)
            {
                $result = $this->val->validateIndexField($this->index['fields'], $this->field, $this->field_name);
                if (PEAR::isError($result)) {
                    $this->customRaiseError($result->getUserinfo(), 0, $xp, $result->getCode());
                }
            }
            $this->index['fields'][$this->field_name] = $this->field;
            break;

        /* Sequence declaration */
        case 'database-sequence':
            if ($this->validate)
            {
                $result = $this->val->validateSequence($this->database_definition['sequences'], $this->sequence, $this->sequence_name);
                if (PEAR::isError($result)) {
                    $this->customRaiseError($result->getUserinfo(), 0, $xp, $result->getCode());
                }
            }
            $this->database_definition['sequences'][$this->sequence_name] = $this->sequence;
            break;

        /* End of File */
        case 'database':
            if ($this->validate)
            {
                $result = $this->val->validateDatabase($this->database_definition);
                if (PEAR::isError($result)) {
                    $this->customRaiseError($result->getUserinfo(), 0, $xp, $result->getCode());
                }
            }
            break;
        }

        unset($this->elements[--$this->count]);
        $this->element = implode('-', $this->elements);
    }

    function &customRaiseError($msg = null, $xmlecode = 0, $xp = null, $ecode = MDB2_SCHEMA_ERROR_PARSE)
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
                $this->customRaiseError('variable "'.$data.'" not found', null, $xp);
                return;
            }
            $data = $this->variables[$data];
        }

        switch ($this->element) {
        /* Initialization */

        /* Insert and Update */
        case 'database-table-initialization-insert-field-name':
        case 'database-table-initialization-update-field-name':
            $this->setData($this->init['data']['field'], 'name', $data);
            break;
        case 'database-table-initialization-insert-field-value':
        case 'database-table-initialization-update-field-value':
            $this->setData($this->init['data']['field'], 'group', array('type' => 'value', 'data' => $data));
            break;
        case 'database-table-initialization-insert-field-function-name':
        case 'database-table-initialization-update-field-function-name':
            $this->init_function['name'] = $data;
            break;
        case 'database-table-initialization-insert-field-function-value':
        case 'database-table-initialization-update-field-function-value':
            $this->init_function['arguments'][] = array('type' => 'value', 'data' => $data);
            break;
        case 'database-table-initialization-insert-field-function-column':
        case 'database-table-initialization-update-field-function-column':
            $this->init_function['arguments'][] = array('type' => 'column', 'data' => $data);
            break;

        /* Update */
        case 'database-table-initialization-update-field-column':
            $this->setData($this->init['data']['field'], 'group', array('type' => 'column', 'data' => $data));
            break;

        /* All */
        case 'database-table-initialization-insert-field-expression-operator':
        case 'database-table-initialization-update-field-expression-operator':
        case 'database-table-initialization-update-where-expression-operator':
        case 'database-table-initialization-delete-where-expression-operator':
            $this->init_expression['operator'] = $data;
            break;
        case 'database-table-initialization-insert-field-expression-value':
        case 'database-table-initialization-update-field-expression-value':
        case 'database-table-initialization-update-where-expression-value':
        case 'database-table-initialization-delete-where-expression-value':
            $this->init_expression['operants'][] = array('type' => 'value', 'data' => $data);
            break;
        case 'database-table-initialization-insert-field-expression-column':
        case 'database-table-initialization-update-field-expression-column':
        case 'database-table-initialization-update-where-expression-column':
        case 'database-table-initialization-delete-where-expression-column':
            $this->init_expression['operants'][] = array('type' => 'column', 'data' => $data);
            break;

        case 'database-table-initialization-insert-field-function-function':
        case 'database-table-initialization-insert-field-function-expression':
        case 'database-table-initialization-insert-field-expression-expression':
        case 'database-table-initialization-update-field-function-function':
        case 'database-table-initialization-update-field-function-expression':
        case 'database-table-initialization-update-field-expression-expression':
        case 'database-table-initialization-update-where-expression-expression':
        case 'database-table-initialization-delete-where-expression-expression':
            /* Recursion to be implemented yet */
            break;

        /* One level simulation of expression-function recursion */
        case 'database-table-initialization-insert-field-expression-function-name':
        case 'database-table-initialization-update-field-expression-function-name':
        case 'database-table-initialization-update-where-expression-function-name':
        case 'database-table-initialization-delete-where-expression-function-name':
            $this->init_function['name'] = $data;
            break;
        case 'database-table-initialization-insert-field-expression-function-value':
        case 'database-table-initialization-update-field-expression-function-value':
        case 'database-table-initialization-update-where-expression-function-value':
        case 'database-table-initialization-delete-where-expression-function-value':
            $this->init_function['arguments'][] = array('type' => 'value', 'data' => $data);
            break;
        case 'database-table-initialization-insert-field-expression-function-column':
        case 'database-table-initialization-update-field-expression-function-column':
        case 'database-table-initialization-update-where-expression-function-column':
        case 'database-table-initialization-delete-where-expression-function-column':
            $this->init_function['arguments'][] = array('type' => 'column', 'data' => $data);
            break;

        /* One level simulation of function-expression recursion */
        case 'database-table-initialization-insert-field-function-expression-operator':
        case 'database-table-initialization-update-field-function-expression-operator':
            $this->init_expression['operator'] = $data;
            break;
        case 'database-table-initialization-insert-field-function-expression-value':
        case 'database-table-initialization-update-field-function-expression-value':
            $this->init_expression['operants'][] = array('type' => 'value', 'data' => $data);
            break;
        case 'database-table-initialization-insert-field-function-expression-column':
        case 'database-table-initialization-update-field-function-expression-column':
            $this->init_expression['operants'][] = array('type' => 'column', 'data' => $data);
            break;

        /* Database */
        case 'database-name':
            if (isset($this->database_definition['name'])) {
                $this->database_definition['name'].= $data;
            } else {
                $this->database_definition['name'] = $data;
            }
            break;
        case 'database-create':
            if (isset($this->database_definition['create'])) {
                $this->database_definition['create'].= $data;
            } else {
                $this->database_definition['create'] = $data;
            }
            break;
        case 'database-overwrite':
            if (isset($this->database_definition['overwrite'])) {
                $this->database_definition['overwrite'].= $data;
            } else {
                $this->database_definition['overwrite'] = $data;
            }
            break;
        case 'database-version':
            if (isset($this->database_definition['version'])) {
                $this->database_definition['version'].= $data;
            } else {
                $this->database_definition['version'] = $data;
            }
            break;
        case 'database-status':
            if (isset($this->database_definition['status'])) {
                $this->database_definition['status'].= $data;
            } else {
                $this->database_definition['status'] = $data;
            }
            break;
        case 'database-application':
            if (isset($this->database_definition['application'])) {
                $this->database_definition['application'].= $data;
            } else {
                $this->database_definition['application'] = $data;
            }
            break;
        case 'database-table-name':
            if (isset($this->table_name)) {
                $this->table_name.= $data;
            } else {
                $this->table_name = $data;
            }
            break;
        case 'database-table-was':
            if (isset($this->table['was'])) {
                $this->table['was'].= $data;
            } else {
                $this->table['was'] = $data;
            }
            break;

        /* Field declaration */
        case 'database-table-declaration-field-name':
            if (isset($this->field_name)) {
                $this->field_name.= $data;
            } else {
                $this->field_name = $data;
            }
            break;
        case 'database-table-declaration-field-type':
            if (isset($this->field['type'])) {
                $this->field['type'].= $data;
            } else {
                $this->field['type'] = $data;
            }
            break;
        case 'database-table-declaration-field-was':
            if (isset($this->field['was'])) {
                $this->field['was'].= $data;
            } else {
                $this->field['was'] = $data;
            }
            break;
        case 'database-table-declaration-field-notnull':
            if (isset($this->field['notnull'])) {
                $this->field['notnull'].= $data;
            } else {
                $this->field['notnull'] = $data;
            }
            break;
        case 'database-table-declaration-field-fixed':
            if (isset($this->field['fixed'])) {
                $this->field['fixed'].= $data;
            } else {
                $this->field['fixed'] = $data;
            }
            break;
        case 'database-table-declaration-field-unsigned':
            if (isset($this->field['unsigned'])) {
                $this->field['unsigned'].= $data;
            } else {
                $this->field['unsigned'] = $data;
            }
            break;
        case 'database-table-declaration-field-autoincrement':
            if (isset($this->field['autoincrement'])) {
                $this->field['autoincrement'].= $data;
            } else {
                $this->field['autoincrement'] = $data;
            }
            break;
        case 'database-table-declaration-field-default':
            if (isset($this->field['default'])) {
                $this->field['default'].= $data;
            } else {
                $this->field['default'] = $data;
            }
            break;
        case 'database-table-declaration-field-length':
            if (isset($this->field['length'])) {
                $this->field['length'].= $data;
            } else {
                $this->field['length'] = $data;
            }
            break;

        /* Index declaration */
        case 'database-table-declaration-index-name':
            if (isset($this->index_name)) {
                $this->index_name.= $data;
            } else {
                $this->index_name = $data;
            }
            break;
        case 'database-table-declaration-index-primary':
            if (isset($this->index['primary'])) {
                $this->index['primary'].= $data;
            } else {
                $this->index['primary'] = $data;
            }
            break;
        case 'database-table-declaration-index-unique':
            if (isset($this->index['unique'])) {
                $this->index['unique'].= $data;
            } else {
                $this->index['unique'] = $data;
            }
            break;
        case 'database-table-declaration-index-was':
            if (isset($this->index['was'])) {
                $this->index['was'].= $data;
            } else {
                $this->index['was'] = $data;
            }
            break;
        case 'database-table-declaration-index-field-name':
            if (isset($this->field_name)) {
                $this->field_name.= $data;
            } else {
                $this->field_name = $data;
            }
            break;
        case 'database-table-declaration-index-field-sorting':
            if (isset($this->field['sorting'])) {
                $this->field['sorting'].= $data;
            } else {
                $this->field['sorting'] = $data;
            }
            break;
        /* Add by Leoncx */
        case 'database-table-declaration-index-field-length':
            if (isset($this->field['length'])) {
                $this->field['length'].= $data;
            } else {
                $this->field['length'] = $data;
            }
            break;

        /* Sequence declaration */
        case 'database-sequence-name':
            if (isset($this->sequence_name)) {
                $this->sequence_name.= $data;
            } else {
                $this->sequence_name = $data;
            }
            break;
        case 'database-sequence-was':
            if (isset($this->sequence['was'])) {
                $this->sequence['was'].= $data;
            } else {
                $this->sequence['was'] = $data;
            }
            break;
        case 'database-sequence-start':
            if (isset($this->sequence['start'])) {
                $this->sequence['start'].= $data;
            } else {
                $this->sequence['start'] = $data;
            }
            break;
        case 'database-sequence-on-table':
            if (isset($this->sequence['on']['table'])) {
                $this->sequence['on']['table'].= $data;
            } else {
                $this->sequence['on']['table'] = $data;
            }
            break;
        case 'database-sequence-on-field':
            if (isset($this->sequence['on']['field'])) {
                $this->sequence['on']['field'].= $data;
            } else {
                $this->sequence['on']['field'] = $data;
            }
            break;
        }
    }

    function setData(&$array, $key, $value)
    {
        $lastIdx = count($array) - 1;
        if (isset($value['data']) && isset($array[$lastIdx][$key]['data'])) {
            // Value is an array and has a data member, there might be something
            // already stored, so we need to append rather then replace.
            $value['data'] = $array[$lastIdx][$key]['data'].$value['data'];
        } elseif (is_string($value) && isset($array[$lastIdx][$key])) {
            $value =  $array[$lastIdx][$key].$value;
        }
        $array[$lastIdx][$key] = $value;
    }
}

?>
