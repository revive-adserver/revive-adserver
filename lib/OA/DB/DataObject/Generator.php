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

require_once 'DB/DataObject/Generator.php';

/**
 * Extending standard PEAR DB_DataObject Generator tool
 *
 * @package    OpenXDB
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OA_DB_DataObject_Generator extends DB_DataObject_Generator
{

    /**
     * overrides derivedHookFunctions from parent class
     * used to call addational functions in DB_DataObject_Generator
     */
    function derivedHookFunctions($input = "")
    {
        return $this->_generateDefaultsArray($this->table);
    }
        
   /**
    * Generate array of defaults values
    *
    * @param    string  table name.
    * @return   string
    */
    function _generateDefaultsArray($table)
    {
        $__DB= &$GLOBALS['_DB_DATAOBJECT']['CONNECTIONS'][$this->_database_dsn_md5];
        if (!in_array($__DB->phptype, array('mysql','mysqli'))) {
            return; // cant handle non-mysql introspection for defaults.
        }
        //$defs = $this->_definitions[$this->table];
        $defs = $this->_generateDefinitionsTable();  // simplify this!?
        
        $res = $__DB->getAll('DESCRIBE ' . $table,DB_FETCHMODE_ASSOC);
        $aDefaults = array();
        foreach($res as $aField) {
            // this is initially very dumb... -> and it may mess up..
            $type = $defs['table'][$aField['Field']];
            
            //var_dump(array($ar['Field'], $ar['Default'], $defaults[$ar['Field']]));

            $value = $aField['Default'];
            $field = $aField['Field'];
            $key   = $aField['Key'];
            // what about multiple keys, foreign keys ?
            if (   ($key == 'PRI')
                || ($value === '')
                || ($value === NULL)
               )
            {
                continue;
            }
            else
            {
                switch (true) {

                    case ($type & DB_DATAOBJECT_BOOL):
                        $aDefaults[$field] = (int)(boolean) $value;
                        break;
                    
                    // Check DATE/TIME type first instead of STR (many date/time fields has multiple types including DB_DATAOBJECT_STR) 
                    case ($type & DB_DATAOBJECT_MYSQLTIMESTAMP): // not supported yet..
                    case ($type & DB_DATAOBJECT_DATE):
                    case ($type & DB_DATAOBJECT_TIME):
                        if ($field == 'updated')
                        {
                            $aDefaults[$field] = "'%DATE_TIME%'";
                        }
                        elseif ($field == 'total_basket_value') //recognized as DB_DATAOBJECT_MYSQLTIMESTAMP & DB_DATAOBJECT_INT
                        {
                            $aDefaults[$field] = $value;
                        }
                        else
                        {
                            $aDefaults[$field] = "'%NO_DATE_TIME%'";
                        }
                        break;

                    case ($type & DB_DATAOBJECT_STR):
                        $aDefaults[$field] =  "'" . addslashes($value) . "'";
                        break;

                    case ($type &  DB_DATAOBJECT_INT):
                        $aDefaults[$field] = $value;
                        break;

                    default:
                        $aDefaults[$field] = $value;
                        break;

                }
            }
        }
        $ret = '';
        if (!empty($aDefaults))
        {
            $ret = "\n".'    var $defaultValues = array('. "\n";
                    foreach($aDefaults as $k=>$v)
                    {
                        $ret .= '                \''.addslashes($k).'\' => ' . $v . ",\n";

                    }
            $ret .= "                );\n";
        }
        return $ret;
    }
    
}
?>