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
/**
 * OpenX Schema Management Utility
 *
 * @author     Monique Szpak <monique.szpak@openx.org>
 *
 * $Id $
 *
 */
require_once './init.php';
require_once MAX_PATH.'/www/devel/lib/xajax.inc.php';

DEFINE('DATATYPE_MEDIUMINT' , 1);
DEFINE('DATATYPE_DATETIME'  , 2);
DEFINE('DATATYPE_TEXT'      , 3);

$aDataTypeDescriptions = array(
                                1=>'Medium Integer',
                                2=>'Date/Time',
                                3=>'Text'
                              );

$aMatches = array();
$aReport = array();


if (array_key_exists('btn_schema_generate', $_POST))
{
    if (is_array($_POST['xml_files']))
    {
        foreach ($_POST['xml_files'] AS $k => $file)
        {
            $aReport[$file] = generateSchema($file);
        }
    }
}

include 'tpl/schema.html';

function reportSchemaTypes($file)
{
    $oDbh = &OA_DB::singleton();
    $oSchema = & MDB2_Schema::factory($oDbh,array());

    $aDef = $oSchema->parseDatabaseDefinitionFile(MAX_PATH.'/etc/changes/'.$file);
    $aResult = array();
    foreach ($aDef['tables'] as $table => $aTableDef)
    {
        foreach ($aTableDef['fields'] as $field => $aFieldDef)
        {
            if (($aFieldDef['type']=='openads_mediumint') && ($aFieldDef['length']!=9))
            {
                $aResult[DATATYPE_MEDIUMINT][$table][$field] = $aFieldDef['type'].'='.$aFieldDef['length'];
            }
            if (($aFieldDef['type']=='openads_text') && $aFieldDef['length'])
            {
                $aResult[DATATYPE_TEXT][$table][$field] = $aFieldDef['type'].'='.$aFieldDef['length'];
            }
            if ($aFieldDef['type']=='openads_timestamp')
            {
                $aResult[DATATYPE_DATETIME][$table][$field] = $aFieldDef['type'];
            }
        }
    }

    return $aResult;
}

function generateSchema($file)
{
    $aReport = reportSchemaTypes($file);

    $data = file_get_contents(MAX_PATH.'/etc/changes/'.$file);

    $patternText = "/(<type>)(openads_text)(<\/type>\n[\s]+<length>[\d]+<\/length>)/i";
    $replacement = '${1}openads_varchar${3}';
    $data = preg_replace($patternText, $replacement, $data);

    $patternText = "/(<type>openads_mediumint<\/type>\n[\s]+<length>)([\d]+)(<\/length>)/i";
    $replacement = '${1}9${3}';
    $data = preg_replace($patternText, $replacement, $data);

    $patternText = "/(<type>)(openads_timestamp)(<\/type>)/i";
    $replacement = '${1}openads_datetime${3}';
    $data = preg_replace($patternText, $replacement, $data);

    $fp = fopen(MAX_PATH.'/var/'.$file,'w+');
    if ($fp)
    {
        fwrite($fp, $data);
        fclose($fp);
    }

    return $aReport;
}

function reportSchemaWrongTextTypes($file)
{
    $data = file_get_contents(MAX_PATH.'/etc/changes/'.$file);

    //$patternText = "/(<field>\n[\s\W]+(<name>(?P<fieldname>[\w\W\d]+)<\/name>)\n[\s\W]+)<type>openads_text<\/type>(\n[\s\W]+(<length>(?P<fieldlength>[\d]+)<\/length>)\n[\s\w\W]+<\/field>)/U";

//    $patternText = "/(<field>(?P<fielddef>[\w\W\d\s]+)<\/field>)/U";
//    $i = preg_match_all($patternText, $data, $aMatches);

    //$patternText = "/(<table>(?P<fields><field>(?P<fielddef>[\w\W\d\s]+)<\/field>+)<\/table>)/U";
    $patternText = "/(<table>[\w\W\d\s]<\/table>)/U";
    $i = preg_match_all($patternText, $data, $aMatches);


    foreach ($aMatches['fieldname'] as $k => $v)
    {
        $aReport[DATATYPE_TEXT][$v] = $aMatches['fieldtype'].'='.$aMatches['fieldlength'][$k];
    }
    return $aReport;
}


?>
