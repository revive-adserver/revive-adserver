<?php
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2006 Manuel Lemos, Tomas V.V.Cox,                 |
// | Stig. S. Bakken, Lukas Smith                                         |
// | All rights reserved.                                                 |
// +----------------------------------------------------------------------+
// | MDB2 is a merge of PEAR DB and Metabases that provides a unified DB  |
// | API as well as changeset abstraction for PHP applications.            |
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
//
// $Id$
//

require_once 'XML/Parser.php';
require_once 'MDB2/Schema/Validate.php';

if (empty($GLOBALS['_MDB2_Schema_Reserved'])) {
    $GLOBALS['_MDB2_Schema_Reserved'] = array();
}

/**
 * Parses an XML schema file
 *
 * @package MDB2_Schema
 * @category changeset
 * @access protected
 * @author
 */
class MDB2_Changeset_Parser extends XML_Parser
{
    var $instructionset = array('name'=>'','version'=>'', 'comments'=>'', 'constructive'=>array(),'destructive'=>array());

    var $constructive_changeset_definition = array('name'=>'','version'=>'', 'tables' => array());
    var $destructive_changeset_definition = array('name'=>'','version'=>'', 'tables' => array());
    var $test;

    var $events = array('tables'=>array());

    var $name;
    var $version;

    var $elements = array();
    var $element = '';
    var $count = 0;

    var $remove = array();
    var $add = array();
    var $change = array();

    var $table = array();
    var $table_name = '';
    var $field = array();
    var $field_name = '';
    var $index = array();
    var $index_name = '';
    var $var_mode = false;
    var $variables = array();
    var $error;
    var $structure = false;
    var $val;

    function __construct($variables, $fail_on_invalid_names = true, $structure = false, $valid_types = array(), $force_defaults = true)
    {
        // force ISO-8859-1 due to different defaults for PHP4 and PHP5
        // todo: this probably needs to be investigated some more andcleaned up
        parent::XML_Parser('ISO-8859-1');
        $this->variables = $variables;
        $this->structure = $structure;
//        $this->val =& new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);
    }

    function MDB2_Changeset_Parser($variables, $fail_on_invalid_names = true, $structure = false, $valid_types = array(), $force_defaults = true)
    {
        $this->__construct($variables, $fail_on_invalid_names, $structure, $valid_types, $force_defaults);
    }

    function startHandler($xp, $element, $attribs)
    {
        if (strtolower($element) == 'variable') {
            $this->var_mode = true;
            return;
        }

        $this->elements[$this->count++] = strtolower($element);
        $this->element = implode('-', $this->elements);

        switch ($this->element)
        {
            case 'instructionset':
            	break;
            case 'instructionset-name':
                $this->name = '';
            	break;
            case 'instructionset-version':
                $this->version = '';
            	break;
            case 'instructionset-constructive':
            	break;
            case 'instructionset-constructive-changeset':
            	break;
            case 'instructionset-constructive-changeset-name':
                $this->name = '';
            	break;
            case 'instructionset-constructive-changeset-version':
                $this->version = '';
            	break;
            case 'instructionset-constructive-changeset-add':
                $this->add = array();
            	break;
            case 'instructionset-constructive-changeset-add-table':
                $this->table_name = '';
                $this->table    = array();
            	break;
            case 'instructionset-constructive-changeset-change':
                $this->change = array();
            	break;
            case 'instructionset-constructive-changeset-change-table':
                $this->table = array();
            	break;
            case 'instructionset-constructive-changeset-change-table-name':
                $this->table_name = '';
            	break;
            case 'instructionset-constructive-changeset-change-table-add':
                $this->add = array();
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field':
                $this->field = array();
                $this->field_name = '';
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-name':
            case 'instructionset-constructive-changeset-change-table-add-field-type':
            case 'instructionset-constructive-changeset-change-table-add-field-notnull':
            case 'instructionset-constructive-changeset-change-table-add-field-default':
            case 'instructionset-constructive-changeset-change-table-add-field-was':
                break;
            case 'instructionset-constructive-changeset-change-table-change':
                $this->change = array();
            	break;
            case 'instructionset-constructive-changeset-change-table-change-field':
                $this->field = array();
                $this->field_name = '';
            	break;
            case 'instructionset-constructive-changeset-change-table-change-field-name':
            case 'instructionset-constructive-changeset-change-table-change-field-type':
            case 'instructionset-constructive-changeset-change-table-change-field-notnull':
            case 'instructionset-constructive-changeset-change-table-change-field-default':
            case 'instructionset-constructive-changeset-change-table-change-field-was':
                break;
            case 'instructionset-constructive-changeset-change-table-index':
                break;
            case 'instructionset-constructive-changeset-change-table-index-add':
                $this->index_name = '';
                $this->index    = array();
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-indexfield':
                $this->field_name = '';
                $this->field = array();
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-name':
            case 'instructionset-constructive-changeset-change-table-index-add-primary':
            case 'instructionset-constructive-changeset-change-table-index-add-unique':
            case 'instructionset-constructive-changeset-change-table-index-add-was':
            case 'instructionset-constructive-changeset-change-table-index-add-indexfield-name':
            case 'instructionset-constructive-changeset-change-table-index-add-indexfield-sorting':
                break;

            case 'instructionset-destructive':
            	break;
            case 'instructionset-destructive-changeset':
            	break;
            case 'instructionset-destructive-changeset-name':
                $this->name = '';
            	break;
            case 'instructionset-destructive-changeset-version':
                $this->version = '';
            	break;
            case 'instructionset-destructive-changeset-remove':
            	break;
            case 'instructionset-destructive-changeset-change':
            	break;
            case 'instructionset-destructive-changeset-change-table':
                $this->table_name = '';
                $this->table    = array();
            	break;
            case 'instructionset-destructive-changeset-change-table-name':
            	break;
            case 'instructionset-destructive-changeset-change-table-remove':
            	break;
            case 'instructionset-destructive-changeset-change-table-remove-field':
                $this->field = array();
                $this->field_name = '';
            	break;
            case 'instructionset-destructive-changeset-change-table-remove-field-name':
            	break;
            case 'instructionset-destructive-changeset-table-index':
                break;
            case 'instructionset-destructive-changeset-change-table-index':
                break;
            case 'instructionset-destructive-changeset-change-table-index-remove':
                $this->index_name = '';
                $this->index    = array();
                break;
            case 'instructionset-destructive-changeset-change-table-index-remove-name':
                break;


        }
    }

    function endHandler($xp, $element)
    {
        if (strtolower($element) == 'variable') {
            $this->var_mode = false;
            return;
        }
        switch ($this->element)
        {
            case 'instructionset':
                $this->instructionset['events'] = $this->events;
                $this->instructionset['test'] = $this->test;
            	break;
            case 'instructionset-name':
                $this->instructionset['name'] = $this->name;
            	break;
            case 'instructionset-version':
                $this->instructionset['version'] = $this->version;
            	break;
            case 'instructionset-constructive':
                $this->instructionset['constructive'] = $this->constructive_changeset_definition;
            	break;
            case 'instructionset-constructive-changeset':
            	break;
            case 'instructionset-constructive-changeset-name':
                $this->constructive_changeset_definition['name'] = $this->name;
            	break;
            case 'instructionset-constructive-changeset-version':
                $this->constructive_changeset_definition['version'] = $this->version;
            	break;
            case 'instructionset-constructive-changeset-add':
            	break;
            case 'instructionset-constructive-changeset-add-table':
                if (!isset($this->constructive_changeset_definition['tables']['add'][$this->table_name]))
                {
                    $this->constructive_changeset_definition['tables']['add'][$this->table_name] = true;
                    $this->events['tables'][$this->table_name]['self']['beforeAddTable'] = "beforeAddTable_{$this->table_name}";
                    $this->events['tables'][$this->table_name]['self']['afterAddTable']  = "afterAddTable_{$this->table_name}";
                    //$this->events['tables'][$this->table_name]['was']  = "";
                }
            	break;
            case 'instructionset-constructive-changeset-change':
            	break;
            case 'instructionset-constructive-changeset-change-table':
            	break;
            case 'instructionset-constructive-changeset-change-table-name':
                if (!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name] = array();
//                    $this->events['tables'][$this->table_name]['fields']  = array();
//                    $this->events['tables'][$this->table_name]['indexes']  = array();
//                    $this->events['tables'][$this->table_name]['self']  = array();
                }
            	break;
            case 'instructionset-constructive-changeset-change-table-add':
                $this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'] = $this->add;
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field':
                $this->add['fields'][$this->field_name] = $this->field;
                $this->events['tables'][$this->table_name]['fields'][$this->field_name]['beforeAddField'] = "beforeAddField_{$this->table_name}_{$this->field_name}";
                $this->events['tables'][$this->table_name]['fields'][$this->field_name]['afterAddField']  = "afterAddField_{$this->table_name}_{$this->field_name}";
                //$this->events['tables'][$this->table_name]['fields'][$this->field_name]['was']  = $this->field['was'];
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-name':
            case 'instructionset-constructive-changeset-change-table-add-field-type':
            case 'instructionset-constructive-changeset-change-table-add-field-notnull':
            case 'instructionset-constructive-changeset-change-table-add-field-default':
            case 'instructionset-constructive-changeset-change-table-add-field-was':
            	break;
            case 'instructionset-constructive-changeset-change-table-change':
                $this->constructive_changeset_definition['tables']['change'][$this->table_name]['change'] = $this->change;
            	break;
            case 'instructionset-constructive-changeset-change-table-change-field':
                $this->change['fields'][$this->field_name] = $this->field;
                $this->events['tables'][$this->table_name]['fields'][$this->field_name]['beforeAlterField'] = "beforeAlterField_{$this->table_name}_{$this->field_name}";
                $this->events['tables'][$this->table_name]['fields'][$this->field_name]['afterAlterField']  = "afterAlterField_{$this->table_name}_{$this->field_name}";
                //$this->events['tables'][$this->table_name]['fields'][$this->field_name]['was']  = $this->field['was'];
            	break;
            case 'instructionset-constructive-changeset-change-table-change-field-name':
            case 'instructionset-constructive-changeset-change-table-change-field-type':
            case 'instructionset-constructive-changeset-change-table-change-field-notnull':
            case 'instructionset-constructive-changeset-change-table-change-field-default':
            case 'instructionset-constructive-changeset-change-table-change-field-was':
            	break;
            case 'instructionset-constructive-changeset-change-table-index':
                break;
            case 'instructionset-constructive-changeset-change-table-index-add':
                $this->constructive_changeset_definition['tables']['change'][$this->table_name]['indexes']['add'][$this->index_name] = $this->index;
                $this->events['tables'][$this->table_name]['indexes'][$this->index_name]['beforeAddIndex'] = "beforeAddIndex_{$this->table_name}_{$this->index_name}";
                $this->events['tables'][$this->table_name]['indexes'][$this->index_name]['afterAddIndex']  = "afterAddIndex_{$this->table_name}_{$this->index_name}";
                //$this->events['tables'][$this->table_name]['indexes'][$this->index_name]['was']  = $this->index['was'];
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-indexfield':
                $this->index['fields'][$this->field_name] = $this->field;
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-name':
            case 'instructionset-constructive-changeset-change-table-index-add-primary':
            case 'instructionset-constructive-changeset-change-table-index-add-unique':
            case 'instructionset-constructive-changeset-change-table-index-add-was':
            case 'instructionset-constructive-changeset-change-table-index-add-indexfield-name':
            case 'instructionset-constructive-changeset-change-table-index-add-indexfield-sorting':
                break;

            case 'instructionset-destructive':
                $this->instructionset['destructive'] = $this->destructive_changeset_definition;
            	break;
            case 'instructionset-destructive-changeset':
            	break;
            case 'instructionset-destructive-changeset-name':
                $this->destructive_changeset_definition['name'] = $this->name;
            	break;
            case 'instructionset-destructive-changeset-version':
                $this->destructive_changeset_definition['version'] = $this->version;
            	break;
            case 'instructionset-destructive-changeset-remove':
            	break;
            case 'instructionset-destructive-changeset-change':
            	break;
            case 'instructionset-destructive-changeset-change-table':
            	break;
            case 'instructionset-destructive-changeset-remove-table':
                $this->destructive_changeset_definition['tables']['remove'][$this->table_name] = true;
                $this->events['tables'][$this->table_name]['self']['beforeRemoveTable'] = "beforeRemoveTable_{$this->table_name}";
                $this->events['tables'][$this->table_name]['self']['afterRemoveTable']  = "afterRemoveTable_{$this->table_name}";
            	break;
            case 'instructionset-destructive-changeset-change-table-name':
                $this->destructive_changeset_definition['tables']['change'][$this->table_name] = array();
            	break;
            case 'instructionset-destructive-changeset-change-table-remove':
            	break;
            case 'instructionset-destructive-changeset-change-table-remove-field':
                //$this->destructive_changeset_definition['tables']['change'][$this->table_name]['remove'] = array();
            	break;
            case 'instructionset-destructive-changeset-change-table-remove-field-name':
                $this->destructive_changeset_definition['tables']['change'][$this->table_name]['remove'][$this->field_name] = true;
                $this->events['tables'][$this->table_name]['fields'][$this->field_name]['beforeRemoveField'] = "beforeRemoveField_{$this->table_name}_{$this->field_name}";
                $this->events['tables'][$this->table_name]['fields'][$this->field_name]['afterRemoveField']  = "afterRemoveField_{$this->table_name}_{$this->field_name}";
            	break;

            case 'instructionset-destructive-changeset-change-table-index':
                break;
            case 'instructionset-destructive-changeset-change-table-index-remove':
                $this->destructive_changeset_definition['tables']['change'][$this->table_name]['indexes']['remove'][$this->index_name] = true;
                $this->events['tables'][$this->table_name]['indexes'][$this->index_name]['beforeRemoveIndex'] = "beforeRemoveIndex_{$this->table_name}_{$this->index_name}";
                $this->events['tables'][$this->table_name]['indexes'][$this->index_name]['afterRemoveIndex']  = "afterRemoveIndex_{$this->table_name}_{$this->index_name}";
                break;
            case 'instructionset-destructive-changeset-change-table-index-remove-name':
                break;

        }

        unset($this->elements[--$this->count]);
        $this->element = implode('-', $this->elements);
    }

    function &raiseError($msg = null, $xmlecode = 0, $xp = null, $ecode = MDB2_SCHEMA_ERROR_PARSE)
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
                $this->raiseError('variable "'.$data.'" not found', null, $xp);
                return;
            }
            $data = $this->variables[$data];
        }
//        $i = array_search($this->element, $this->instructionset);
//        if (!$i)
//        {
            $this->test[] = $this->element;
//        }
        switch ($this->element)
        {
            case 'instructionset':
            	break;
            case 'instructionset-name':
                $this->name = $data;
            	break;
            case 'instructionset-version':
                $this->version = $data;
            	break;
            case 'instructionset-comments':
                $this->comments = $data;
            	break;
            case 'instructionset-constructive':
            	break;
            case 'instructionset-constructive-changeset':
            	break;
            case 'instructionset-constructive-changeset-name':
                $this->name = $data;
            	break;
            case 'instructionset-constructive-changeset-version':
                $this->version = $data;
            	break;
            case 'instructionset-constructive-changeset-add':
            	break;
            case 'instructionset-constructive-changeset-add-table':
                $this->table_name = $data;
            	break;
            case 'instructionset-constructive-changeset-change':
            	break;
            case 'instructionset-constructive-changeset-change-table':
            	break;
            case 'instructionset-constructive-changeset-change-table-name':
                $this->table_name = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-add':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-name':
                $this->field_name = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-type':
                $this->field['type'] = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-length':
                $this->field['length'] = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-notnull':
                $this->field['notnull'] = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-default':
                $this->field['default'] = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-was':
                $this->field['was'] = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-change':
            	break;
            case 'instructionset-constructive-changeset-change-table-change-field':
            	break;
            case 'instructionset-constructive-changeset-change-table-change-field-name':
                $this->field_name = $data;
                break;
            case 'instructionset-constructive-changeset-change-table-change-field-type':
                $this->field['type'] = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-change-field-length':
                $this->field['length'] = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-change-field-notnull':
                $this->field['notnull'] = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-change-field-default':
                $this->field['default'] = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-change-field-was':
                $this->field['was'] = $data;
            	break;
            case 'instructionset-constructive-changeset-change-table-index':
                break;
            case 'instructionset-constructive-changeset-change-table-index-add':
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-name':
                $this->index_name = $data;
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-primary':
                $this->index['primary'] = $data;
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-unique':
                $this->index['unique'] = $data;
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-was':
                $this->index['was'] = $data;
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-indexfield':
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-indexfield-name':
                $this->field_name = $data;
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-indexfield-sorting':
                $this->field['sorting'] = $data;
                break;


            case 'instructionset-destructive':
            	break;
            case 'instructionset-destructive-changeset':
            	break;
            case 'instructionset-destructive-changeset-name':
                $this->name = $data;
            	break;
            case 'instructionset-destructive-changeset-version':
                $this->version = $data;
            	break;
            case 'instructionset-destructive-changeset-remove':
            	break;
            case 'instructionset-destructive-changeset-change':
            	break;
            case 'instructionset-destructive-changeset-change-table':
            	break;
            case 'instructionset-destructive-changeset-remove-table':
                $this->table_name = $data;
            	break;
            case 'instructionset-destructive-changeset-change-table-name':
                $this->table_name = $data;
            	break;
            case 'instructionset-destructive-changeset-change-table-remove':
            	break;
            case 'instructionset-destructive-changeset-change-table-remove-field':
            	break;
            case 'instructionset-destructive-changeset-change-table-remove-field-name':
                $this->field_name = $data;
            	break;

            case 'instructionset-destructive-changeset-change-table-index':
                break;
            case 'instructionset-destructive-changeset-change-table-index-remove':
//                $this->destructive_changeset_definition['tables']['change'][$this->table_name]['indexes']['remove']['field'] = array();
                break;
            case 'instructionset-destructive-changeset-change-table-index-remove-name':
                $this->index_name = $data;
                break;
        }
    }

    function setData(&$array, $key, $value)
    {
        $array[(count($array)-1)][$key] = $value;
    }
}

?>
