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

require_once MAX_PATH . '/lib/pear/XML/Parser.php';

/**
 * Parser for phpMyAdmin-style XML data dumps.
 *
 * Only configured tables (conf.php) will be recognised.
 * If the data dump contains entries for other tables,
 * there is no guarantee what will happen.
 *
 * @todo Handle unknown tables by raising an error (or ignoring them)
 */
class MAX_TestData_XML_Parser extends XML_Parser
{

  var $aTables;

  var $tableName;

  var $currTag;

  var $currData;

  var $currHandler;

  var $aRow;

  var $aDataset;

  var $outputMode;

  /**
   * Constructor.
   *
   * @param string $outputMode
   */
  function MAX_TestData_XML_Parser($outputMode = 'text')
  {
    $conf = $GLOBALS['_MAX']['CONF'];

    parent::XML_Parser();

    // The configuration file holds all the defined table names.
    // HACK: The parser currently gets very confused when it encounters 'category' fields
    //       if there is a table defined with that name.
    $configured_tables = $conf['table'];
    unset($configured_tables['category']);
    $this->aTables = array_keys($configured_tables);

    $this->aDataset = array();

    $this->outputMode = $outputMode;

  }

  function setInput($fp)
  {
      if (in_array($fp, $this->aTables))
      {
          $this->tableName = $fp;
      }
      parent::setInput(MAX_PATH . '/tests/data/testData_'.$fp.'.xml');
  }

 /**
  * handle start element
  *
  * @access private
  * @param  resource  xml parser resource
  * @param  string    name of the element
  * @param  array     attributes
  */
  function startHandler($xp, $name, $attribs)
  {
    if (strtolower($name) == 'max_0_3'){
    }
    else if (in_array(strtolower($name), $this->aTables))
    {
        $this->tableName = strtolower($name);
    }
    else
    {
        if (!empty($attribs))
        {
            if (array_key_exists('CDTYPE',$attribs))
            {
                if ($attribs['CDTYPE'] == 'hex')
                {
                    $this->currHandler = 'hex2bin';
                }
                else if ($attribs['CDTYPE'] == 'html')
                {
                    $this->currHandler = 'htmlenc';
                }
            };
        }
        $this->currTag = strtolower(trim($name));
    }
  }

 /**
  * handle start element
  *
  * @access private
  * @param  resource  xml parser resource
  * @param  string    name of the element
  */
  function endHandler($xp, $name)
  {
    $this->currDataType = '';
    $this->currHandler  = '';

    if (strtolower($name) == $this->tableName)
    {
        if ($this->outputMode == 'text')
        {
            array_push($this->aDataset, $this->aRow);
        }
        else if ($this->outputMode == 'insert')
        {
            $keys   = implode(',',array_keys($this->aRow));
            $vals   = "'".implode("','",array_values($this->aRow))."'";
            $tmp    = "INSERT INTO ".$this->tableName." (".$keys.") VALUES (".$vals.");";
            array_push($this->aDataset, $tmp);
        }
        $this->aRow = array();
    }
    else
    {
        $this->aRow[$this->currTag] = $this->currData;
    }
  }

 /**
  * handle character data
  *
  * @access private
  * @param  resource  xml parser resource
  * @param  string    character data
  */
  function cdataHandler($xp, $cdata)
  {
    if ($this->outputMode == 'insert')
    {
        if ($this->currHandler)
        {
            $this->currData = call_user_method($this->currHandler, $this, trim($cdata));
        }
        else
        {
            $this->currData = trim($cdata);
        }
        $this->currData = mysql_escape_string($this->currData);
    }
    else
    {
        $this->currData = trim($cdata);
    }
  }

  function hex2bin($data)
  {
     if (substr($data, 0, 2)=='0x')
     {
        $data = substr($data, 2);
     }
     $len = strlen($data);
     return pack("H" . $len, $data);
  }

  function htmlenc($data)
  {
     return $data;
  }

  /**
   * for use if inheriting from simple.php
   */
//  function handleElement($name, $attribs, $data)
//  {
//    if (strtolower($name) == 'max_0_3'){
//    }
//    else if (in_array(strtolower($name), $this->aTables))
//    {
//        $this->tableName = strtolower($name);
//
//        if (count($this->aRow) > 0)
//        {
//            if ($this->outputMode == 'insert')
//            {
//                if ($this->currHandler)
//                {
//                    $this->currData = call_user_method($this->currHandler, $this, trim($data));
//                }
//                else
//                {
//                    $this->currData = trim($data);
//                }
//                    $this->currData = mysql_escape_string($this->currData);
//                    $keys   = implode(',',array_keys($this->aRow));
//                    $vals   = "'".implode("','",array_values($this->aRow))."'";
//                    $tmp    = "INSERT INTO ".$this->tableName." (".$keys.") VALUES (".$vals.");";
//                    array_push($this->aDataset, $tmp);
//            }
//            else
//            {
//                $this->currData = trim($data);
//            }
//        }
//    }
//    else
//    {
//        if (!empty($attribs))
//        {
//            if (array_key_exists('CDTYPE',$attribs))
//            {
//                if ($attribs['CDTYPE'] == 'hex')
//                {
//                    $this->currHandler = 'hex2bin';
//                }
//                else if ($attribs['CDTYPE'] == 'html')
//                {
//                    $this->currHandler = 'htmlenc';
//                }
//            };
//        }
//        $this->currTag = strtolower(trim($name));
//    }
//  }
}

?>

