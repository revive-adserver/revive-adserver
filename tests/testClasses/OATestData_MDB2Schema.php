<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/tests/testClasses/OATestData.php';

/**
 *
 * @abstract A base class for loading test data using MDB2_Schema
 * @package Test Classes
 * @author Monique Szpak <monique.szpak@openads.org>
  *
 */
class OA_Test_Data_MDB2Schema extends OA_Test_Data
{

    var $directory;
    var $datafile;
    var $oSchema;
    var $oTable;


    /**
     * The constructor method.
     */
    function OA_Test_Data_MDB2Schema()
    {

    }

    /**
     * verify the input file
     * instantiate the schema and table objects
     *
     * @param string $datafile
     * @param string $directory
     * @return boolean
     */
    function init($datafile='fjsdj', $directory='/tests/datasets/mdb2schema/')
    {
        if (!parent::init())
        {
            return false;
        }
        if (!$directory)
        {
            $directory = '/tests/datasets/mdb2schema/';
        }
        $this->directory = $directory;
        if (substr_count($this->directory, MAX_PATH)<1)
        {
            $this->directory = MAX_PATH.$this->directory;
        }
        $this->datafile = $datafile;
        if (!file_exists($this->directory.$this->datafile))
        {
            return false;
        }
        $this->oSchema  =&  MDB2_Schema::factory($this->oDbh);
        if (PEAR::isError($this->oSchema))
        {
            return false;
        }
        $this->oTable = new OA_DB_Table();
        if (PEAR::isError($this->oTable))
        {
            return false;
        }
        return true;
    }

    function _initSchemaVersion($version)
    {
        return $this->oTable->init(MAX_PATH.'/etc/changes/schema_tables_core_'.$version.'.xml');
    }

    /**
     *
     * A method to parse the content file to an array
     * Along with it's associated table schema definition
     *
     *
     * @access private
     * @return array
     */
    function _getContentDefinition()
    {
        $aContent = $this->oSchema->parseDatabaseContentFile($this->directory.$this->datafile, array(), false, false, $this->oTable->aDefinition);
        if (PEAR::isError($aContent))
        {
            return false;
        }
        if (!$this->_initSchemaVersion($aContent['version']))
        {
            return false;
        }
        return $aContent;
    }
    /**
     *
     * A method to load data for testing
     *
     * @return boolean
     */
    function generateTestData()
    {
        $aContent = $this->_getContentDefinition();
        if (!$aContent)
        {
            return false;
        }
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        foreach ($aContent['tables'] as $table_name => $aTable)
        {
            $this->aIds[$table_name] = array();
            if (empty($aTable['initialization']))
            {
                continue;
            }
            $this->_fixTestData($aTable);
            $aTable['fields'] = $this->oTable->aDefinition['tables'][$table_name]['fields'];
            $aTableResult = $this->oSchema->initializeTable($prefix.$table_name, $aTable,true);
            $this->aIds[$table_name] = $aTableResult['aIds'];
        }
        return true;
    }

    /**
     * fixes datetime values for pgsql
     *
     * @param array $aTable
     */
    function _fixTestData(&$aTable)
    {
        if ($this->oDbh->dbsyntax == 'pgsql') {
            // Remove those ugly 0000-00-00
            foreach ($aTable['initialization'] as $k1 => $v1) {
                foreach ($v1['data']['field'] as $k2 => $v2) {
                    if ($v2['group']['data'] === '0000-00-00') {
                        unset($aTable['initialization'][$k1]['data']['field'][$k2]);
                    }
                }
            }
        }
    }
}

?>
