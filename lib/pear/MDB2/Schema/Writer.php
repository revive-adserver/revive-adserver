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
// | Author: Lukas Smith <smith@pooteeweet.org>                           |
// +----------------------------------------------------------------------+

/**
 * Writes an XML schema file
 *
 * @package MDB2_Schema
 * @category Database
 * @access protected
 * @author  Lukas Smith <smith@pooteeweet.org>
 */
class MDB2_Schema_Writer
{
    // {{{ properties

    var $valid_types = array();

    var $fp;

    // }}}
    // {{{ constructor

    function __construct($valid_types = array())
    {
        $this->valid_types = $valid_types;
    }

    // }}}
    // {{{ raiseError()

    /**
     * This method is used to communicate an error and invoke error
     * callbacks etc.  Basically a wrapper for PEAR::raiseError
     * without the message string.
     *
     * @param int|PEAR_Error  integer error code or and PEAR_Error instance
     * @param int      error mode, see PEAR_Error docs
     *
     *                 error level (E_USER_NOTICE etc).  If error mode is
     *                 PEAR_ERROR_CALLBACK, this is the callback function,
     *                 either as a function name, or as an array of an
     *                 object and method name.  For other error modes this
     *                 parameter is ignored.
     * @param string   Extra debug information.  Defaults to the last
     *                 query and native error code.
     * @return object  a PEAR error object
     * @access  public
     * @see PEAR_Error
     */
    function &raiseError($code = null, $mode = null, $options = null, $userinfo = null)
    {
        $error =& MDB2_Schema::raiseError($code, $mode, $options, $userinfo);
        return $error;
    }

    // }}}
    // {{{ _escapeSpecialChars()

    /**
     * add escapecharacters to all special characters in a string
     *
     * @param string string that should be escaped
     * @return string escaped string
     * @access protected
     */
    function _escapeSpecialChars($string)
    {
        if (!is_string($string)) {
            $string = strval($string);
        }

        $escaped = '';
        for ($char = 0, $count = strlen($string); $char < $count; $char++) {
            switch ($string[$char]) {
            case '&':
                $escaped.= '&amp;';
                break;
            case '>':
                $escaped.= '&gt;';
                break;
            case '<':
                $escaped.= '&lt;';
                break;
            case '"':
                $escaped.= '&quot;';
                break;
            case '\'':
                $escaped.= '&apos;';
                break;
            default:
                $code = ord($string[$char]);
                if ($code < 32 || $code > 127) {
                    $escaped.= "&#$code;";
                } else {
                    $escaped.= $string[$char];
                }
                break;
            }
        }
        return $escaped;
    }

    // }}}
    // {{{ _dumpBoolean()

    /**
     * dump the structure of a sequence
     *
     * @param string boolean value or variable definition
     * @return string with xml boolea definition
     * @access private
     */
    function _dumpBoolean($boolean)
    {
        if (is_string($boolean)) {
            if ($boolean !== 'true' || $boolean !== 'false'
                || preg_match('/<variable>.*</variable>/', $boolean)
            ) {
                return $boolean;
            }
        }
        return $boolean ? 'true' : 'false';
    }

    // }}}
    // {{{ dumpSequence()

    /**
     * dump the structure of a sequence
     *
     * @param string sequence name
     * @param string end of line characters
     * @return mixed string xml sequence definition on success, or a error object
     * @access public
     */
    function dumpSequence($sequence_definition, $sequence_name, $eol, $dump = MDB2_SCHEMA_DUMP_ALL)
    {
        $buffer = "$eol <sequence>$eol  <name>$sequence_name</name>$eol";
        if ($dump == MDB2_SCHEMA_DUMP_ALL || $dump == MDB2_SCHEMA_DUMP_CONTENT) {
            if (!empty($sequence_definition['start'])) {
                $start = $sequence_definition['start'];
                $buffer.= "  <start>$start</start>$eol";
            }
        }

        if (!empty($sequence_definition['on'])) {
            $buffer.= "  <on>$eol";
            $buffer.= "   <table>".$sequence_definition['on']['table'];
            $buffer.= "</table>$eol   <field>".$sequence_definition['on']['field'];
            $buffer.= "</field>$eol  </on>$eol";
        }
        $buffer.= " </sequence>$eol";

        return $buffer;
    }

    // }}}
    // {{{ dumpDatabase()

    /**
     * Dump a previously parsed database structure in the Metabase schema
     * XML based format suitable for the Metabase parser. This function
     * may optionally dump the database definition with initialization
     * commands that specify the data that is currently present in the tables.
     *
     * @param array associative array that takes pairs of tag
     *              names and values that define dump options.
     *                 array (
     *                     'output_mode'    =>    String
     *                         'file' :   dump into a file
     *                         default:   dump using a function
     *                     'output'        =>    String
     *                         depending on the 'Output_Mode'
     *                                  name of the file
     *                                  name of the function
     *                     'end_of_line'        =>    String
     *                         end of line delimiter that should be used
     *                         default: "\n"
     *                 );
     * @param integer determines what data to dump
     *                      MDB2_SCHEMA_DUMP_ALL       : the entire db
     *                      MDB2_SCHEMA_DUMP_STRUCTURE : only the structure of the db
     *                      MDB2_SCHEMA_DUMP_CONTENT   : only the content of the db
     * @return mixed MDB2_OK on success, or a error object
     * @access public
     */
    function dumpDatabase($database_definition, $arguments, $dump = MDB2_SCHEMA_DUMP_ALL)
    {
        if (!empty($arguments['output'])) {
            if (!empty($arguments['output_mode']) && $arguments['output_mode'] == 'file') {
                $fp = fopen($arguments['output'], 'w');
                if ($fp === false) {
                    return $this->raiseError(MDB2_SCHEMA_ERROR_WRITER, null, null,
                        'it was not possible to open output file');
                }

                $output = false;
            } elseif (is_callable($arguments['output'])) {
                $output = $arguments['output'];
            } else {
                return $this->raiseError(MDB2_SCHEMA_ERROR_WRITER, null, null,
                    'no valid output function specified');
            }
        } else {
            return $this->raiseError(MDB2_SCHEMA_ERROR_WRITER, null, null,
                'no output method specified');
        }

        $eol = isset($arguments['end_of_line']) ? $arguments['end_of_line'] : "\n";

        $sequences = array();
        if (!empty($database_definition['sequences'])
            && is_array($database_definition['sequences'])
        ) {
            foreach ($database_definition['sequences'] as $sequence_name => $sequence) {
                $table = !empty($sequence['on']) ? $sequence['on']['table'] :'';
                $sequences[$table][] = $sequence_name;
            }
        }

        $buffer = '<?xml version="1.0" encoding="ISO-8859-1" ?>'.$eol;
        $buffer.= $this->_getXSLRef($arguments).$eol;
        $buffer.= "<database>$eol$eol <name>".$database_definition['name']."</name>";
        $buffer.= "$eol <create>".$this->_dumpBoolean($database_definition['create'])."</create>";
        $buffer.= "$eol <overwrite>".$this->_dumpBoolean($database_definition['overwrite'])."</overwrite>$eol";
        $buffer.= $this->writeCustomTags($arguments, $eol);

        if ($output) {
            call_user_func($output, $buffer);
        } else {
            fwrite($fp, $buffer);
        }

        if (!empty($database_definition['tables']) && is_array($database_definition['tables'])) {
            foreach ($database_definition['tables'] as $table_name => $table) {
                $buffer = "$eol <table>$eol$eol  <name>$table_name</name>$eol";
                if ($dump == MDB2_SCHEMA_DUMP_ALL || $dump == MDB2_SCHEMA_DUMP_STRUCTURE) {
                    $buffer.= "$eol  <declaration>$eol";
                    if (!empty($table['fields']) && is_array($table['fields'])) {
                        foreach ($table['fields'] as $field_name => $field) {
                            if (empty($field['type'])) {
                                return $this->raiseError(MDB2_SCHEMA_ERROR_VALIDATE, null, null,
                                    'it was not specified the type of the field "'.
                                    $field_name.'" of the table "'.$table_name);
                            }
                            if (!empty($this->valid_types) && !array_key_exists($field['type'], $this->valid_types)) {
                                return $this->raiseError(MDB2_SCHEMA_ERROR_UNSUPPORTED, null, null,
                                    'type "'.$field['type'].'" is not yet supported');
                            }
                            $buffer.= "$eol   <field>$eol    <name>$field_name</name>$eol    <type>";
                            $buffer.= $field['type']."</type>$eol";
                            if (!empty($field['unsigned'])) {
                                $buffer.= "    <unsigned>".$this->_dumpBoolean($field['unsigned'])."</unsigned>$eol";
                            }
                            if (!empty($field['length'])) {
                                $buffer.= '    <length>'.$field['length']."</length>$eol";
                            }
                            if (!empty($field['notnull'])) {
                                $buffer.= "    <notnull>".$this->_dumpBoolean($field['notnull'])."</notnull>$eol";
                            } else {
                                $buffer.= "    <notnull>false</notnull>$eol";
                            }
                            if (!empty($field['fixed']) && $field['type'] === 'text') {
                                $buffer.= "    <fixed>".$this->_dumpBoolean($field['fixed'])."</fixed>$eol";
                            }
                            if (array_key_exists('default', $field)
                                && $field['type'] !== 'clob' && $field['type'] !== 'blob'
                            ) {
                                $buffer.= '    <default>'.$this->_escapeSpecialChars($field['default'])."</default>$eol";
                            }
                            if (!empty($field['autoincrement'])) {
                                $buffer.= "    <autoincrement>" . $field['autoincrement'] ."</autoincrement>$eol";
                            }
                            $buffer.= "   </field>$eol";
                        }
                    }

                    if (!empty($table['indexes']) && is_array($table['indexes'])) {
                        foreach ($table['indexes'] as $index_name => $index) {
                            if ($index_name === 'primary') {
                                $index_name = $table_name . "_pkey";
                            }
                            $buffer.= "$eol   <index>$eol    <name>$index_name</name>$eol";
                            if (!empty($index['unique'])) {
                                $buffer.= "    <unique>".$this->_dumpBoolean($index['unique'])."</unique>$eol";
                            }

                            if (!empty($index['primary'])) {
                                $buffer.= "    <primary>".$this->_dumpBoolean($index['primary'])."</primary>$eol";
                            }

                            foreach ($index['fields'] as $field_name => $field) {
                                $buffer.= "    <field>$eol     <name>$field_name</name>$eol";
                                if (!empty($field) && is_array($field)) {
                                    $buffer.= '     <sorting>'.$field['sorting']."</sorting>$eol";
                                }
                                $buffer.= "    </field>$eol";
                            }
                            $buffer.= "   </index>$eol";
                        }
                    }
                    $buffer.= "$eol  </declaration>$eol";
                }

                if ($output) {
                    call_user_func($output, $buffer);
                } else {
                    fwrite($fp, $buffer);
                }

                $buffer = '';
                if ($dump == MDB2_SCHEMA_DUMP_ALL || $dump == MDB2_SCHEMA_DUMP_CONTENT) {
                    if (!empty($table['initialization']) && is_array($table['initialization'])) {
                        $buffer = "$eol  <initialization>$eol";
                        foreach ($table['initialization'] as $instruction) {
                            switch ($instruction['type']) {
                            case 'insert':
                                $buffer.= "$eol   <insert>$eol";
                                foreach ($instruction['data']['field'] as $field) {
                                    $field_name = $field['name'];
                                    $buffer.= "$eol    <field>$eol     <name>$field_name</name>$eol";
                                    $buffer.= $this->writeExpression($field['group'], 5, $arguments);
                                    $buffer.= "    </field>$eol";
                                }
                                $buffer.= "$eol   </insert>$eol";
                                break;
                            case 'update':
                                $buffer.= "$eol   <update>$eol";
                                foreach ($instruction['data']['field'] as $field) {
                                    $field_name = $field['name'];
                                    $buffer.= "$eol    <field>$eol     <name>$field_name</name>$eol";
                                    $buffer.= $this->writeExpression($field['group'], 5, $arguments);
                                    $buffer.= "    </field>$eol";
                                }

                                if (!empty($instruction['data']['where'])
                                    && is_array($instruction['data']['where'])
                                ) {
                                    $buffer.= "    <where>$eol";
                                    $buffer.= $this->writeExpression($instruction['data']['where'], 5, $arguments);
                                    $buffer.= "    </where>$eol";
                                }

                                $buffer.= "$eol   </update>$eol";
                                break;
                            case 'delete':
                                $buffer.= "$eol   <delete>$eol$eol";
                                if (!empty($instruction['data']['where'])
                                    && is_array($instruction['data']['where'])
                                ) {
                                    $buffer.= "    <where>$eol";
                                    $buffer.= $this->writeExpression($instruction['data']['where'], 5, $arguments);
                                    $buffer.= "    </where>$eol";
                                }
                                $buffer.= "$eol   </delete>$eol";
                                break;
                            }
                        }
                        $buffer.= "$eol  </initialization>$eol";
                    }
                }
                $buffer.= "$eol </table>$eol";
                if ($output) {
                    call_user_func($output, $buffer);
                } else {
                    fwrite($fp, $buffer);
                }

                if (isset($sequences[$table_name])) {
                    foreach ($sequences[$table_name] as $sequence) {
                        $result = $this->dumpSequence(
                            $database_definition['sequences'][$sequence],
                            $sequence, $eol, $dump
                        );
                        if (PEAR::isError($result)) {
                            return $result;
                        }

                        if ($output) {
                            call_user_func($output, $result);
                        } else {
                            fwrite($fp, $result);
                        }
                    }
                }
            }
        }

        if (isset($sequences[''])) {
            foreach ($sequences[''] as $sequence) {
                $result = $this->dumpSequence(
                    $database_definition['sequences'][$sequence],
                    $sequence, $eol, $dump
                );
                if (PEAR::isError($result)) {
                    return $result;
                }

                if ($output) {
                    call_user_func($output, $result);
                } else {
                    fwrite($fp, $result);
                }
            }
        }

        $buffer = "$eol</database>$eol";
        if ($output) {
            call_user_func($output, $buffer);
        } else {
            fwrite($fp, $buffer);
            fclose($fp);
        }

        return MDB2_OK;
    }

    // }}}
    // {{{ writeExpression()

    /**
     * Dumps the structure of an element. Elements can be value, column,
     * function or expression.
     *
     * @param array  multi dimensional array that represents the parsed element
     *                of a DML instruction.
     * @param integer  base indentation width
     * @param array  associative array that takes pairs of tag
     *                names and values that define dump options.
     *
     * @return string
     *
     * @access public
     * @see MDB2_Schema_Writer::dumpDatabase()
     */
    function writeExpression($element, $offset = 0, $arguments = null)
    {
        $eol = isset($arguments['end_of_line']) ? $arguments['end_of_line'] : "\n";
        $str = '';
        $indent = str_repeat(' ', $offset);
        $noffset = $offset + 1;

        switch ($element['type']) {
            case 'value':
                $str.= "$indent<value>".$this->_escapeSpecialChars($element['data'])."</value>$eol";
            break;
            case 'column':
                $str.= "$indent<column>".$this->_escapeSpecialChars($element['data'])."</column>$eol";
            break;
            case 'function':
                $str.= "$indent<function>$eol$indent <name>".$this->_escapeSpecialChars($element['data']['name'])."</name>$eol";

                if (!empty($element['data']['arguments'])
                    && is_array($element['data']['arguments'])
                ) {
                    foreach ($element['data']['arguments'] as $v) {
                        $str.= $this->writeExpression($v, $noffset, $arguments);
                    }
                }

                $str.= "$indent</function>$eol";
            break;
            case 'expression':
                $str.= "$indent<expression>$eol";
                $str.= $this->writeExpression($element['data']['operants'][0], $noffset, $arguments);
                $str.= "$indent <operator>".$element['data']['operator']."</operator>$eol";
                $str.= $this->writeExpression($element['data']['operants'][1], $noffset, $arguments);
                $str.= "$indent</expression>$eol";
            break;
        }
        return $str;
    }

    // }}}
    // {{{ dumpDatabaseHeader()

    /**
     * Dump a previously parsed database structure in the Metabase schema
     * XML based format suitable for the Metabase parser. This function
     * may optionally dump the database definition with initialization
     * commands that specify the data that is currently present in the tables.
     *
     * @param array associative array that takes pairs of tag
     *              names and values that define dump options.
     *                 array (
     *                     'output_mode'    =>    String
     *                         'file' :   dump into a file
     *                         default:   dump using a function
     *                     'output'        =>    String
     *                         depending on the 'Output_Mode'
     *                                  name of the file
     *                                  name of the function
     *                     'end_of_line'        =>    String
     *                         end of line delimiter that should be used
     *                         default: "\n"
     *                 );
     * @param integer determines what data to dump
     *                      MDB2_SCHEMA_DUMP_ALL       : the entire db
     *                      MDB2_SCHEMA_DUMP_STRUCTURE : only the structure of the db
     *                      MDB2_SCHEMA_DUMP_CONTENT   : only the content of the db
     * @return mixed MDB2_OK on success, or a error object
     * @access public
     */
    function dumpDatabaseHeader($database_definition, $arguments)
    {
        if (!empty($arguments['output'])) {
            if (!empty($arguments['output_mode']) && $arguments['output_mode'] == 'file') {
                $this->fp = fopen($arguments['output'], 'w');
                if ($this->fp === false) {
                    return $this->raiseError(MDB2_SCHEMA_ERROR_WRITER, null, null,
                        'it was not possible to open output file');
                }

                $output = false;
            } elseif (is_callable($arguments['output'])) {
                $output = $arguments['output'];
            } else {
                return $this->raiseError(MDB2_SCHEMA_ERROR_WRITER, null, null,
                    'no valid output function specified');
            }
        } else {
            return $this->raiseError(MDB2_SCHEMA_ERROR_WRITER, null, null,
                'no output method specified');
        }

        $eol = isset($arguments['end_of_line']) ? $arguments['end_of_line'] : "\n";

        $buffer = '<?xml version="1.0" encoding="ISO-8859-1" ?>'.$eol;
        $buffer.= $this->_getXSLRef($arguments).$eol;
        $buffer.= "<database>$eol$eol <name>".$database_definition['name']."</name>";
        $buffer.= "$eol <create>".$this->_dumpBoolean($database_definition['create'])."</create>";
        $buffer.= "$eol <overwrite>".$this->_dumpBoolean($database_definition['overwrite'])."</overwrite>$eol";
        $buffer.= $this->writeCustomTags($arguments, $eol);

        if ($output) {
            call_user_func($output, $buffer);
        } else {
            fwrite($this->fp, $buffer);
        }
    }

    // {{{ dumpDatabaseTable()

    /**
     * Dump a previously parsed database structure in the Metabase schema
     * XML based format suitable for the Metabase parser. This function
     * may optionally dump the database definition with initialization
     * commands that specify the data that is currently present in the tables.
     *
     * @param array associative array that takes pairs of tag
     *              names and values that define dump options.
     *                 array (
     *                     'output_mode'    =>    String
     *                         'file' :   dump into a file
     *                         default:   dump using a function
     *                     'output'        =>    String
     *                         depending on the 'Output_Mode'
     *                                  name of the file
     *                                  name of the function
     *                     'end_of_line'        =>    String
     *                         end of line delimiter that should be used
     *                         default: "\n"
     *                 );
     * @param integer determines what data to dump
     *                      MDB2_SCHEMA_DUMP_ALL       : the entire db
     *                      MDB2_SCHEMA_DUMP_STRUCTURE : only the structure of the db
     *                      MDB2_SCHEMA_DUMP_CONTENT   : only the content of the db
     * @return mixed MDB2_OK on success, or a error object
     * @access public
     */
    function dumpDatabaseTable($table_name, $table, $arguments)
    {
        $eol = isset($arguments['end_of_line']) ? $arguments['end_of_line'] : "\n";
        if (!empty($table) && is_array($table))
        {
            $buffer = "$eol <table>$eol$eol  <name>$table_name</name>$eol";
            $buffer.= "$eol  <initialization>$eol";
            foreach ($table as $k=>$instruction)
            {
                switch ($instruction['type'])
                {
                case 'insert':
                    $buffer.= "$eol   <insert>$eol";
                    foreach ($instruction['data']['field'] as $field) {
                        $field_name = $field['name'];
                        $buffer.= "$eol    <field>$eol     <name>$field_name</name>$eol";
                        $buffer.= $this->writeExpression($field['group'], 5, $arguments);
                        $buffer.= "    </field>$eol";
                    }
                    $buffer.= "$eol   </insert>$eol";
                    break;
                case 'update':
                    $buffer.= "$eol   <update>$eol";
                    foreach ($instruction['data']['field'] as $field) {
                        $field_name = $field['name'];
                        $buffer.= "$eol    <field>$eol     <name>$field_name</name>$eol";
                        $buffer.= $this->writeExpression($field['group'], 5, $arguments);
                        $buffer.= "    </field>$eol";
                    }

                    if (!empty($instruction['data']['where'])
                        && is_array($instruction['data']['where'])
                    ) {
                        $buffer.= "    <where>$eol";
                        $buffer.= $this->writeExpression($instruction['data']['where'], 5, $arguments);
                        $buffer.= "    </where>$eol";
                    }

                    $buffer.= "$eol   </update>$eol";
                    break;
                case 'delete':
                    $buffer.= "$eol   <delete>$eol$eol";
                    if (!empty($instruction['data']['where'])
                        && is_array($instruction['data']['where'])
                    ) {
                        $buffer.= "    <where>$eol";
                        $buffer.= $this->writeExpression($instruction['data']['where'], 5, $arguments);
                        $buffer.= "    </where>$eol";
                    }
                    $buffer.= "$eol   </delete>$eol";
                    break;
                }
            }
            $buffer.= "$eol  </initialization>$eol";
            $buffer.= "$eol </table>$eol";
            fwrite($this->fp, $buffer);
        }
    }

    function dumpDatabaseFooter()
    {
        $eol = isset($arguments['end_of_line']) ? $arguments['end_of_line'] : "\n";
        $buffer = "$eol</database>$eol";
        fwrite($this->fp, $buffer);
        fclose($this->fp);
        return MDB2_OK;
    }
    // {{{ _getXMLversion()

    function _getXMLversion()
    {
        return '<?xml version="1.0" encoding="ISO-8859-1" ?>';
    }

    // }}}
    // {{{ _getXSLRef()

    function _getXSLRef($arguments)
    {
        if (isset($arguments['xsl_file']))
        {
            $xsl_file = $arguments['xsl_file'];
            return '<?xml-stylesheet type="text/xsl" href="'.$xsl_file.'"?>';
        }
        return '';
    }

    // }}}
    // {{{ writeCustomTags()

    /**
     * write any custom tags
     * as supplied
     * only writes to <database> elem
     *
     * @param array $array
     * @param string $buffer
     * @param string $eol
     */
    function writeCustomTags($arguments, $eol)
    {
        $result = '';
        if (isset($arguments['custom_tags']) && is_array($arguments['custom_tags']))
        {
            foreach ($arguments['custom_tags'] AS $k => $v)
            {
                $result.= " <{$k}>{$v}</{$k}>{$eol}";
            }
        }
        return $result;
    }

}
?>
