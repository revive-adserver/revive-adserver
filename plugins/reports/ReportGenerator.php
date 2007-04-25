<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/Plugin/Common.php';

/**
 * Report interface
 *
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Radek Maciaszek <radek@m3.net>
 */
class ReportGenerator extends MAX_Plugin_Common
{

    function dataSequenceAndFormat($rows, $headers)
    {
        if(is_object($rows)) {
            $rows = (array) $rows;
        }
        $sequencedData = array();
        foreach ($rows as $rowKey => $row) {
            foreach($headers as $headerKey => $headerName) {
                if(!isset($row[$headerKey]) && !isset($row->$headerKey)) {
                    continue;
                }
                if(is_array($row)) {
                    $sequencedData[$rowKey][$headerKey]->value = $row[$headerKey];
                } else {
                    $sequencedData[$rowKey][$headerKey]->value = $row->$headerKey;
                }
                if(is_numeric($sequencedData[$rowKey][$headerKey]->value)) {
                    $sequencedData[$rowKey][$headerKey]->type = 'ss:Type="Number"';
                } else {
                    $sequencedData[$rowKey][$headerKey]->type = 'ss:Type="String"';
                }
            }
        }
        return $sequencedData;
    }

    /**
    * Send HTTP headers for the Excel file.
    *
    * @param string $filename The filename to use for HTTP headers
    * @access public
    */
    function sendHeaders($filename)
    {
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Pragma: public");
    }

    function formatFirstLastRow(&$data, $rows = 'rows', $firstRow = 'first_row', $lastRow = 'last_row')
    {
        if(empty($data->$rows) || (!$firstRow && !$lastRow)) {
            return;
        }

        foreach($data->$rows as $key => $row) {
            if($firstRow) {
                // move first row to $data->$firstRow
                $data->$firstRow = $row;
                $firstRow = null;
                unset($data->$rows[$key]);
            }
        }

        if($lastRow) {
            // move last row to $data->$lastRow
            $data->$lastRow = array_pop($data->$rows);
        }
    }

    function compileXml($fileName, &$data, &$options, $package)
    {
        require_once 'HTML/Template/Flexy.php';
        require_once 'PEAR.php';

        #-----------------------------------------------------------------------------
        # FLEXY parametrs
        #-----------------------------------------------------------------------------
        $options = &PEAR::getStaticProperty('HTML_Template_Flexy','options');
        $options = array(
        'templateDir'       => MAX_PATH . '/plugins/reports/'.$package.'/themes',
        'compileDir'        => MAX_PATH . '/var/templates_compiled',
        'forceCompile'      => 1,
        'debug'             => 0,
        'globals '          => 1,
        'filters'           => 'SimpleTags',
        'locale'            => 'en',
        'compiler'          => 'Standard',
        'valid_functions'   => 'include',
        'flexyIgnore'       => 0,
        );

        $output = new xmlFlexy();

        $templ = & new HTML_Template_Flexy($options);
        $templ->compile($fileName);

        $xml = &$templ->bufferedOutputObject($data, $elements = array());

        return $xml;
    }
}

/**
 * Flexy Class
 */
class xmlFlexy
{
    function isNumeric($string) {
        return is_numeric($string);
    }
}

?>
