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
    var $instructionset = array('name'=>'','version'=>'', 'constructive'=>array(),'destructive'=>array());

    var $constructive_changeset_definition = array('name'=>'','version'=>'', 'tables' => array());
    var $destructive_changeset_definition = array('name'=>'','version'=>'', 'tables' => array());


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
            	break;
            case 'instructionset-version':
            	break;
            case 'instructionset-constructive':
            	break;
            case 'instructionset-constructive-changeset':
            	break;
            case 'instructionset-constructive-changeset-name':
            	break;
            case 'instructionset-constructive-changeset-version':
            	break;
            case 'instructionset-constructive-changeset-add':
            	break;
            case 'instructionset-constructive-changeset-add-table':
            	break;
            case 'instructionset-constructive-changeset-change':
            	break;
            case 'instructionset-constructive-changeset-change-table':
            	break;
            case 'instructionset-constructive-changeset-change-table-name':
            	break;
            case 'instructionset-constructive-changeset-change-table-add':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-name':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-type':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-notnull':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-default':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-was':
            	break;
            case 'instructionset-constructive-changeset-change-table-index':
                break;
            case 'instructionset-constructive-changeset-change-table-index-add':
                break;

            case 'instructionset-destructive':
            	break;
            case 'instructionset-destructive-changeset':
            	break;
            case 'instructionset-destructive-changeset-name':
            	break;
            case 'instructionset-destructive-changeset-version':
            	break;
            case 'instructionset-destructive-changeset-version-change':
            	break;
            case 'instructionset-destructive-changeset-version-change-table':
            	break;
            case 'instructionset-destructive-changeset-version-change-table-name':
            	break;
            case 'instructionset-destructive-changeset-version-change-table-remove':
            	break;
            case 'instructionset-destructive-changeset-version-change-table-remove-field':
            	break;
            case 'instructionset-destructive-changeset-version-change-table-remove-field-name':
            	break;
            case 'instructionset-destructive-changeset-change-table-index':
                break;
            case 'instructionset-destructive-changeset-change-table-index-remove':
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
            	break;
            case 'instructionset-name':
            	break;
            case 'instructionset-version':
            	break;
            case 'instructionset-constructive':
            	break;
            case 'instructionset-constructive-changeset':
            	break;
            case 'instructionset-constructive-changeset-name':
            	break;
            case 'instructionset-constructive-changeset-version':
            	break;
            case 'instructionset-constructive-changeset-add':
            	break;
            case 'instructionset-constructive-changeset-add-table':
            	break;
            case 'instructionset-constructive-changeset-change':
            	break;
            case 'instructionset-constructive-changeset-change-table':
            	break;
            case 'instructionset-constructive-changeset-change-table-name':
            	break;
            case 'instructionset-constructive-changeset-change-table-add':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-name':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-type':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-notnull':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-default':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-was':
            	break;
            case 'instructionset-constructive-changeset-change-table-index':
                break;
            case 'instructionset-constructive-changeset-change-table-index-add':
                break;

            case 'instructionset-destructive':
            	break;
            case 'instructionset-destructive-changeset':
            	break;
            case 'instructionset-destructive-changeset-name':
            	break;
            case 'instructionset-destructive-changeset-version':
            	break;
            case 'instructionset-destructive-changeset-version-change':
            	break;
            case 'instructionset-destructive-changeset-version-change-table':
            	break;
            case 'instructionset-destructive-changeset-version-change-table-name':
            	break;
            case 'instructionset-destructive-changeset-version-change-table-remove':
            	break;
            case 'instructionset-destructive-changeset-version-change-table-remove-field':
            	break;
            case 'instructionset-destructive-changeset-version-change-table-remove-field-name':
            	break;
            case 'instructionset-destructive-changeset-change-table-index':
                break;
            case 'instructionset-destructive-changeset-change-table-index-remove':
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
        switch ($this->element)
        {
            case 'instructionset':
            	break;
            case 'instructionset-name':
                if (isset($this->instructionset['name'])) {
                    $this->instructionset['name'].= $data;
                } else {
                    $this->instructionset['name'] = $data;
                }
            	break;
            case 'instructionset-version':
                if (isset($this->instructionset['version'])) {
                    $this->instructionset['version'].= $data;
                } else {
                    $this->instructionset['version'] = $data;
                }
            	break;
            case 'instructionset-constructive':
            	break;
            case 'instructionset-constructive-changeset':
            	break;
            case 'instructionset-constructive-changeset-name':
                if (isset($this->constructive_changeset_definition['name'])) {
                    $this->constructive_changeset_definition['name'].= $data;
                } else {
                    $this->constructive_changeset_definition['name'] = $data;
                }
            	break;
            case 'instructionset-constructive-changeset-version':
                if (isset($this->constructive_changeset_definition['version'])) {
                    $this->constructive_changeset_definition['version'].= $data;
                } else {
                    $this->constructive_changeset_definition['version'] = $data;
                }
            	break;
            case 'instructionset-constructive-changeset-add':
            	break;
            case 'instructionset-constructive-changeset-add-table':
                $this->table_name = $data;
                if (!isset($this->constructive_changeset_definition['tables']['add'][$this->table_name]))
                {
                    $this->constructive_changeset_definition['tables']['add'][$this->table_name] = true;
                }
            	break;
            case 'instructionset-constructive-changeset-change':
            	break;
            case 'instructionset-constructive-changeset-change-table':
            	break;
            case 'instructionset-constructive-changeset-change-table-name':
                $this->table_name = $data;
                if (!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name] = array();
                }
            	break;
            case 'instructionset-constructive-changeset-change-table-add':
                if (!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]['add']))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'] = array();
                }
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field':
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-name':
                $this->field_name = $data;
                if (!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'][$this->field_name]))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'][$this->field_name] = array();
                }
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-type':
                if (!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'][$this->field_name]['type']))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'][$this->field_name]['type'] = $data;
                }
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-notnull':
                if (!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'][$this->field_name]['notnull']))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'][$this->field_name]['notnull'] = $data;
                }
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-default':
                if (!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'][$this->field_name]['default']))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'][$this->field_name]['default'] = $data;
                }
            	break;
            case 'instructionset-constructive-changeset-change-table-add-field-was':
                if (!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'][$this->field_name]['was']))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name]['add'][$this->field_name]['was'] = $data;
                }
            	break;
            case 'instructionset-constructive-changeset-change-table-index':
                if(!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name]['index'] = array();
                }
                break;
            case 'instructionset-constructive-changeset-change-table-index-add':
                if(!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']['add']))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']['add'] = array();
                }
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-name':
                $this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']['add']['name'] = $data;
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-unique':
                $this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']['add']['unique'] = $data;
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-was':
                $this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']['add']['was'] = $data;
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-field':
                if (!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']['add']['field']))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']['add']['field'] = array();
                }
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-field-name':
                $this->field_name = $data;
                if (!isset($this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']['add']['field'][$this->field_name]))
                {
                    $this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']['add']['field'][$this->field_name] = array();
                }
                break;
            case 'instructionset-constructive-changeset-change-table-index-add-field-sorting':
                $this->constructive_changeset_definition['tables']['change'][$this->table_name]['index']['add']['field'][$this->field_name]['sorting'] = $data;
                break;


            case 'instructionset-destructive':
            	break;
            case 'instructionset-destructive-changeset':
            	break;
            case 'instructionset-destructive-changeset-name':
                if (isset($this->destructive_changeset_definition['name'])) {
                    $this->destructive_changeset_definition['name'].= $data;
                } else {
                    $this->destructive_changeset_definition['name'] = $data;
                }
            	break;
            case 'instructionset-destructive-changeset-version':
                if (isset($this->destructive_changeset_definition['version'])) {
                    $this->destructive_changeset_definition['version'].= $data;
                } else {
                    $this->destructive_changeset_definition['version'] = $data;
                }
            	break;
            case 'instructionset-destructive-changeset-version-change':
            	break;
            case 'instructionset-destructive-changeset-version-change-table':
            	break;
            case 'instructionset-destructive-changeset-version-change-table-name':
                $this->table_name = $data;
                if (!isset($this->destructive_changeset_definition['tables']['change'][$this->table_name]))
                {
                    $this->destructive_changeset_definition['tables']['change'][$this->table_name] = array();
                }
            	break;
            case 'instructionset-destructive-changeset-version-change-table-remove':
                if (!isset($this->destructive_changeset_definition['tables']['change'][$this->table_name]['remove']))
                {
                    $this->destructive_changeset_definition['tables']['change'][$this->table_name]['remove'] = true;
                }
            	break;
            case 'instructionset-destructive-changeset-version-change-table-remove-field':
            	break;
            case 'instructionset-destructive-changeset-version-change-table-remove-field-name':
                $this->field_name = $data;
                if (!isset($this->destructive_changeset_definition['tables']['change'][$this->table_name]['remove'][$this->field_name]))
                {
                    $this->destructive_changeset_definition['tables']['change'][$this->table_name]['remove'][$this->field_name] = true;
                }
            	break;

            case 'instructionset-destructive-changeset-change-table-index':
                break;
            case 'instructionset-destructive-changeset-change-table-index-remove':
//                $this->destructive_changeset_definition['tables']['change'][$this->table_name]['index']['remove']['field'] = array();
                break;
            case 'instructionset-destructive-changeset-change-table-index-remove-name':
                $this->field_name = $data;
                $this->destructive_changeset_definition['tables']['change'][$this->table_name]['index']['remove'][$this->field_name] = true;
                break;
        }
    }

    function setData(&$array, $key, $value)
    {
        $array[(count($array)-1)][$key] = $value;
    }
}

?>
