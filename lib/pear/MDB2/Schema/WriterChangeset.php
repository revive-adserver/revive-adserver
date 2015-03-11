<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once("MDB2/Schema/Writer.php");

/**
 * Writes an XML changeset file
 */
class MDB2_Schema_Changeset_Writer extends MDB2_Schema_Writer
{
    // {{{ properties

    var $valid_types = array();

    var $eol = '';

    var $indent = 0;

    var $buffer = '';

    // }}}
    // {{{ dumpChanges()
    /**
     * dump a set of changes to file
     *
     * @param array $changes
     * @param array $arguments
     * @return string
     */

    function dumpChanges($changes, $arguments = array())
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

        $this->buffer = $this->_getXMLversion().$eol;
        $this->buffer.= $this->_getXSLRef($arguments).$eol;

        $changeset = $this->splitChanges($changes);

        $this->spaces = -2;
        $this->eol = $eol;
        $this->writeXMLline("changeset", '', 'IN');
        $this->writeXMLline("name", $changes['name'], 'IN', true);
        $this->writeXMLline("version", $changes['version'], '', true);
        $this->writeXMLline("version", $changes['comments'], '', true);
        $this->addChangesToBuffer($changes);
        $this->writeXMLline("/changeset", '', 'OUT');

        if ($output) {
            call_user_func($output, $this->buffer);
        } else {
            fwrite($fp, $this->buffer);
        }

        return $this->buffer;
    }

    // }}}
    // {{{ splitChanges()

    function splitChanges($changes)
    {
        if (is_array($changes) and (count($changes)>0))
        {
            $constructive = array();
            $constructive['tables'] = array();
            $constructive['name'] = $changes['name'];
            $constructive['version'] = $changes['version'];
            $destructive = array();
            $destructive['tables'] = array();
            $destructive['name'] = $changes['name'];
            $destructive['version'] = $changes['version'];

            if (isset($changes['tables']['add']))
            {
                $constructive['tables']['add'] = array();
                foreach ($changes['tables']['add'] AS $table=>$aVal)
                {
                    if (is_array($aVal) && isset($aVal['was']) && ($table!=$aVal['was'])) // && ($table == $aVal['was']))
                    {
                        $constructive['tables']['rename'][$table] = $aVal['was'];
                    }
                    else
                    {
                        $constructive['tables']['add'][$table] = $table;
                    }
                }
            }
            if (isset($changes['tables']['change']))
            {
                $constructive['tables']['change'] = array();
                foreach ($changes['tables']['change'] AS $table=>$aTable)
                {
                    $constructive['tables']['change'][$table] = array();
                    if (isset($aTable['add']))
                    {
                        foreach ($aTable['add'] as $field => $fld_def)
                        {
//                            if (isset($fld_def['autoincrement']) && $fld_def['autoincrement'] )
//                            {
//                                $constructive['tables']['change'][$table]['rename'][$field] = $fld_def;
//                            }
//                            else
//                            {
                                $constructive['tables']['change'][$table]['add'][$field] = $fld_def;
//                            }
                        }
                        //$constructive['tables']['change'][$table]['add'] = $changes['tables']['change'][$table]['add'];
                    }
                    if (isset($aTable['remove']))
                    {
                        $destructive['tables']['change'][$table]['remove'] = $changes['tables']['change'][$table]['remove'];
                    }
                    if (isset($aTable['change']))
                    {
                        $constructive['tables']['change'][$table]['change'] = $changes['tables']['change'][$table]['change'];
                    }
                    if (isset($aTable['indexes']))
                    {
                        if (isset($aTable['indexes']['add']))
                        {
                            $constructive['tables']['change'][$table]['indexes']['add'] = $aTable['indexes']['add'];
                        }
                        if (isset($aTable['indexes']['remove']))
                        {
                            $constructive['tables']['change'][$table]['indexes']['remove'] = $aTable['indexes']['remove'];
                        }
                        if (isset($aTable['indexes']['change']))
                        {
                            foreach ($aTable['indexes']['change'] as $index => $aIdx_def)
                            {
                                $ignore = false;
                                if (isset($aIdx_def['primary']) && $aIdx_def['primary'])
                                {
                                    foreach ($aIdx_def['fields'] as $field => $aFld_def)
                                    {
                                        if (isset($constructive['tables']['change'][$table]['rename'][$field]))
                                        {
                                            $ignore = true;
                                        }
                                    }
                                }
                                if (!$ignore)
                                {
                                    if (!isset($constructive['tables']['change'][$table]['indexes']['add']))
                                    {
                                        $constructive['tables']['change'][$table]['indexes']['add'] = $aTable['indexes']['change'];
                                    }
                                    else
                                    {
                                        $constructive['tables']['change'][$table]['indexes']['add']= array_merge($constructive['tables']['change'][$table]['indexes']['add'], $aTable['indexes']['change']);
                                    }
                                    foreach ($aTable['indexes']['change'] AS $k=>$v)
                                    {
                                        $constructive['tables']['change'][$table]['indexes']['remove'][$k] = 'true';
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (isset($changes['remove']))
            {
                $destructive['remove'] = array();
                foreach ($changes['remove'] AS $table=>$bool)
                {
                    $destructive['remove'][$table] = $bool;
                }
            }
        }
        $result['constructive'] = $constructive;
        $result['destructive']  = $destructive;
        return $result;
    }

    // }}}
    // {{{ dumpSplitChanges()

    function dumpSplitChanges($changes, $arguments = array())
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

        $this->buffer = $this->_getXMLversion().$eol;
        $this->buffer.= $this->_getXSLRef($arguments).$eol;

        // is the changeset a previously split one that just needs re-writing?
        // or is it a raw compare result changeset?  if so, split it
        if ((!isset($arguments['rewrite'])) || (!$arguments['rewrite']))
        {
            $changeset = $this->splitChanges($changes);
        }

        $this->spaces = -2;
        $this->eol = $eol;
        $this->writeXMLline("instructionset", '', 'IN');
        $this->writeXMLline("name", $changes['name'], 'IN', true);
        $this->writeXMLline("version", $changes['version'], '', true);
        $this->writeXMLline("comments", $changes['comments'], '', true);

        $this->writeXMLline("constructive");
        $this->writeXMLline("changeset", '', 'IN');
        $this->writeXMLline("name", $changeset['constructive']['name'], 'IN', true);
        $this->writeXMLline("version", $changeset['constructive']['version'], '', true);
        $this->addChangesToBuffer($changeset['constructive']);
        $this->writeXMLline("/changeset", '', 'OUT');
        $this->writeXMLline("/constructive", '', 'OUT');

        $this->writeXMLline("destructive");
        $this->writeXMLline("changeset", '', 'IN');
        $this->writeXMLline("name", $changeset['destructive']['name'], 'IN', true);
        $this->writeXMLline("version", $changeset['destructive']['version'], '', true);
        $this->addChangesToBuffer($changeset['destructive']);
        $this->writeXMLline("/changeset", '', 'OUT');
        $this->writeXMLline("/destructive", '', 'OUT');

        $this->writeXMLline("/instructionset", '', 'OUT');

        if ($output) {
            call_user_func($output, $this->buffer);
        } else {
            fwrite($fp, $this->buffer);
        }

        return $this->buffer;
    }

    // }}}
    // {{{ rewriteSplitChanges()

    function rewriteSplitChanges($changeset, $arguments = array())
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

        $this->buffer = $this->_getXMLversion().$eol;
        $this->buffer.= $this->_getXSLRef($arguments).$eol;

        $this->spaces = -2;
        $this->eol = $eol;
        $this->writeXMLline("instructionset", '', 'IN');
        $this->writeXMLline("name", $changeset['name'], 'IN', true);
        $this->writeXMLline("version", $changeset['version'], '', true);
        $this->writeXMLline("comments", $changeset['comments'], '', true);

        $this->writeXMLline("constructive");
        $this->writeXMLline("changeset", '', 'IN');
        $this->writeXMLline("name", $changeset['constructive']['name'], 'IN', true);
        $this->writeXMLline("version", $changeset['constructive']['version'], '', true);
        $this->addChangesToBuffer($changeset['constructive']);
        $this->writeXMLline("/changeset", '', 'OUT');
        $this->writeXMLline("/constructive", '', 'OUT');

        $this->writeXMLline("destructive");
        $this->writeXMLline("changeset", '', 'IN');
        $this->writeXMLline("name", $changeset['destructive']['name'], 'IN', true);
        $this->writeXMLline("version", $changeset['destructive']['version'], '', true);
        $this->addChangesToBuffer($changeset['destructive']);
        $this->writeXMLline("/changeset", '', 'OUT');
        $this->writeXMLline("/destructive", '', 'OUT');

        $this->writeXMLline("/instructionset", '', 'OUT');

        if ($output) {
            call_user_func($output, $this->buffer);
        } else {
            fwrite($fp, $this->buffer);
        }

        return $this->buffer;
    }

    // }}}
    // {{{ addChangesToBuffer()

    /**
     * add something to the buffer
     *
     * @param array $changes
     */
    function addChangesToBuffer($changes)
    {
        if (is_array($changes) and (count($changes)))
        {
            if (isset($changes['remove']))
            {
                $this->writeXMLline("remove");
                foreach ($changes['remove'] AS $table=>$bool)
                {
                    $this->writeXMLline("table", $table, 'IN', true);
                }
                $this->writeXMLline("/remove", '', 'OUT');
            }
            if (isset($changes['tables']['add']))
            {
                $this->writeXMLline("add");
                foreach ($changes['tables']['add'] AS $table=>$was)
                {
                    $this->writeXMLline("table", '', 'IN');
                    $this->writeXMLline("name", $table, '', true);
                    $this->writeXMLline("was", $was, '', true);
                    $this->writeXMLline("/table", '', 'OUT');
                }
                $this->writeXMLline("/add", '', 'OUT');
            }
            if (isset($changes['tables']['rename']))
            {
                $this->writeXMLline("rename");
                foreach ($changes['tables']['rename'] AS $table=>$aTable)
                {
                    $this->writeXMLline("table", '', 'IN');
                    $this->writeXMLline("name", $table, '', true);
                    $this->writeXMLline("was", $aTable['was'], '', true);
                    $this->writeXMLline("/table", '', 'OUT');
                }
                $this->writeXMLline("/rename", '', 'OUT');
            }
            if (isset($changes['tables']['change']))
            {
                $this->writeXMLline("change");
                foreach ($changes['tables']['change'] AS $table=>$aTable)
                {
                    $this->writeXMLline("table", '', 'IN');
                    $this->writeXMLline("name", $table, 'INANDOUT', true);
                    if (isset($aTable['add']))
                    {
                        $this->writeXMLline("add", '', 'IN');
                        //small bodgette to allow for discrepancy between a comparison changeset and
                        //a parsed changeset
                        if (isset($aTable['add']['fields']))
                        {
                            $aFields = $aTable['add']['fields'];
                        }
                        else
                        {
                            $aFields = $aTable['add'];
                        }
                        foreach ($aFields AS $field=>$aField)
                        {
                            $this->writeXMLline("field", '', 'IN');
                            $this->writeXMLline("name", $field, 'IN', true);
                            foreach ($aField AS $k=>$v)
                            {
                                if (!is_array($v))
                                {
                                    $this->writeXMLline($k, $v, '', true);
                                }
                            }
                            $this->writeXMLline("/field", '', 'OUT');
                        }
                        $this->writeXMLline("/add", '', 'OUT');
                    }
                    if (isset($aTable['rename']))
                    {
                        $this->writeXMLline("rename", '', 'IN');
                        //small bodgette to allow for discrepancy between a comparison changeset and
                        //a parsed changeset
                        if (isset($aTable['rename']['fields']))
                        {
                            $aFields = $aTable['rename']['fields'];
                        }
                        else
                        {
                            $aFields = $aTable['rename'];
                        }
                        foreach ($aFields AS $field=>$aField)
                        {
                            $this->writeXMLline("field", '', 'IN');
                            $this->writeXMLline("name", $field, 'IN', true);
                            foreach ($aField AS $k=>$v)
                            {
                                if (!is_array($v))
                                {
                                    $this->writeXMLline($k, $v, '', true);
                                }
                            }
                            $this->writeXMLline("/field", '', 'OUT');
                        }
                        $this->writeXMLline("/rename", '', 'OUT');
                    }
                    if (isset($aTable['remove']))
                    {
                        $this->writeXMLline("remove");
                        $aFields = $aTable['remove'];
                        foreach ($aFields AS $field=>$bool)
                        {
                            $this->writeXMLline("field", '', 'IN');
                            $this->writeXMLline("name", $field, 'IN', true);
                            $this->writeXMLline("/field", '', 'OUT');
                        }
                        $this->writeXMLline("/remove", '', 'OUT');
                    }
                    if (isset($aTable['change']))
                    {
                        $this->writeXMLline("change");
                        $dent = 'IN';
                        foreach ($aTable['change'] AS $field=>$aField)
                        {
                            $this->writeXMLline("field", '', $dent);
                            $this->writeXMLline("name", $field, 'IN', true);
                            foreach ($aField AS $k=>$v)
                            {
                                if (!is_array($v))
                                {
                                    $val = $aField['definition'][$k];
                                    $this->writeXMLline($k, $val, '', true);
                                }
                            }
                            $dent = '';
                            $this->writeXMLline("/field", '', 'OUT');
                        }
                        $this->writeXMLline("/change", '', 'OUT');
                    }
                    if (isset($aTable['indexes']))
                    {
                        if (isset($aTable['indexes']['add']))
                        {
                            $aIndex = $aTable['indexes']['add'];
                            $this->writeXMLline("index");
                            foreach ($aIndex AS $name=>$def)
                            {
                                $this->writeXMLline("add", '', 'IN');
                                $this->writeXMLline('name',$name, 'IN', true);
                                if (isset($aIndex[$name]['was']))
                                {
                                    $this->writeXMLline("was", $aIndex[$name]['was'], '', true);
                                }
                                if (isset($aIndex[$name]['unique']))
                                {
                                    $this->writeXMLline("unique", 'true', '', true);
                                }
                                if (isset($aIndex[$name]['primary']))
                                {
                                    $this->writeXMLline("primary", 'true', '', true);
                                }
                                foreach ($def['fields'] AS $field=>$val)
                                {
                                    $this->writeXMLline('indexfield');
                                    $this->writeXMLline('name', $field, 'IN', true);
                                    if (isset($val['sorting']))
                                    {
                                        $this->writeXMLline("sorting", $val['sorting'], '', true);
                                    }
                                    if (isset($val['order']))
                                    {
                                        $this->writeXMLline("order", $val['order'], '', true);
                                    }
                                    $this->writeXMLline('/indexfield', '', 'OUT');
                                }
                                $this->writeXMLline("/add", '', 'OUT');
                            }
                            $this->writeXMLline("/index", '', 'OUT');
                        }
                        if (isset($aTable['indexes']['remove']))
                        {
                            $aIndex = $aTable['indexes']['remove'];
                            $this->writeXMLline("index");
                            //$dent = 'IN';
                            foreach ($aIndex AS $name=>$array)
                            {
                                $this->writeXMLline("remove", '', 'IN');
                                $this->writeXMLline("name", $name, 'INANDOUT', true);
                                //$dent = '';
                                $this->writeXMLline("/remove", '', 'OUT');
                            }
                            $this->writeXMLline("/index", '', 'OUT');
                        }
                    }
                    $this->writeXMLline("/table", '', 'OUT');
                }
                $this->writeXMLline("/change", '', 'OUT');
            }
        }
    }

    // }}}
    // {{{ writeXMLline()

    /**
     * write a line of XML
     *
     * @param string $tag : tag name
     * @param string $data : tag contents
     * @param string $dent : indent (IN, OUT, default = '')
     * @param boolean $close : close this tag (default false)
     */
    function writeXMLline($tag, $data='', $dent='', $close=false)
    {
        if (($dent=='IN') || ($dent=='INANDOUT'))
        {
            $this->spaces+= 2;
        }
        else if ($dent=='OUT')
        {
            $this->spaces-= 2;
        }
        if ($this->spaces<0)
        {
            $this->spaces=0;
        }
        $this->buffer.= str_repeat(' ', $this->spaces);
        $this->buffer.= '<'.$tag.'>';
        $this->buffer.= $this->_escapeSpecialChars($data);
        $this->buffer.= ($close ? '</'.$tag.'>' : '');
        $this->buffer.= $this->eol;
        if ($dent=='INANDOUT')
        {
            $this->spaces-= 2;
        }
    }

    // }}}
    // {{{ array_to_xml()

    /**
     * convert an array to xml
     *
     * @param array $array
     * @param string $buffer
     * @param string $eol
     */
    function array_to_xml($array, &$buffer, $eol)
    {
        foreach ($array AS $k => $v)
        {
            if (is_array($k))
            {
                $this->array_to_xml($k, $buffer, $eol);
            }
            else
            {
                $buffer.= "<{$k}>";
                if (is_array($v))
                {
                    $this->array_to_xml($v, $buffer, $eol);
                }
                else
                {
                    $buffer.= $v;
                }
                $buffer.= "</{$k}>{$eol}";
            }
        }
    }

    // }}}
}
?>
