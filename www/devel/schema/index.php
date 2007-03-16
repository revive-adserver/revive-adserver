<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
 * Openads Schema Management Utility
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */

require_once '../../../init.php';
define('MAX_DEV', MAX_PATH.'/www/devel');

require_once 'oaSchema.php';

//$current_file = !empty($_REQUEST['xml_file']) ? $_REQUEST['xml_file'] : 'core';

if (array_key_exists('xml_file', $_POST))
{
    setcookie('schemaFile', $_POST['xml_file']);
    $schemaFile = $_POST['xml_file'];
    if ($_POST['table_edit'])
    {
        $_POST['table_edit'] = '';
    }
}
else if (array_key_exists('xajax', $_POST))
{
   $schemaFile = $_COOKIE['schemaFile'];
}
else
{
    $schemaFile = $_COOKIE['schemaFile'];
    if (!$schemaFile)
    {
        setcookie('schemaFile', 'tables_core.xml');
        $schemaFile = 'tables_core.xml';
    }
}

$oaSchema = & new Openads_Schema_Manager($schemaFile);

if (($aErrs = $oaSchema->checkPermissions()) !== true) {
    die(join("<br />\n", $aErrs));
}

require_once MAX_DEV.'/lib/xajax.inc.php';

if (array_key_exists('btn_changeset_archive', $_POST))
{
    header('Location: archive.php');
    exit;
}
else if (array_key_exists('btn_copy_final', $_POST))
{
    $oaSchema->createTransitional();
}
else if (array_key_exists('btn_delete_trans', $_POST))
{
    $oaSchema->deleteTransitional();
}
else if (array_key_exists('btn_compare_schemas', $_POST))
{
    setcookie('changesetFile', '');
    if ($oaSchema->createChangeset($oaSchema->changes_trans, $_POST['comments']))
    {
        header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
        readfile($oaSchema->changes_trans);
        exit();
    }
}
else if (array_key_exists('btn_changeset_delete', $_POST))
{
    $oaSchema->deleteChangesTrans();
}
else if (array_key_exists('btn_commit_final', $_POST))
{
    $oaSchema->commitFinal($_POST['comments']);
}

$oaSchema->setWorkingFiles();


if (array_key_exists('btn_field_save', $_POST))
{
    $table = $_POST['table_edit'];
    $field_name_old = $_POST['field_name'];
    $field_name_new = $_POST['fld_new_name'];
    $field_type_old = $_POST['field_type'];
    $field_type_new = $_POST['fld_new_type'];
    $oaSchema->fieldSave($table, $field_name_old, $field_name_new, $field_type_old, $field_type_new);
}
else if (array_key_exists('btn_field_add', $_POST))
{
    $table = $_POST['table_edit'];
    $field_name = $_POST['field_add'];
    $dd_field_name = $_POST['sel_field_add'];
    $oaSchema->fieldAdd($table, $field_name, $dd_field_name);
}
else if (array_key_exists('btn_field_del', $_POST))
{
    $table = $_POST['table_edit'];
    $field = $_POST['field_name'];
    $oaSchema->fieldDelete($table, $field);
}
else if (array_key_exists('btn_index_del', $_POST))
{
    $table = $_POST['table_edit'];
    $index = $_POST['index_name'];
    $oaSchema->indexDelete($table, $index);
}
else if (array_key_exists('btn_index_add', $_POST))
{
    $table = $_POST['table_edit'];
    $index_name = $_POST['index_add'];
    $index_fields = $_POST['sel_idxfld_add'];
    $unique = $_POST['idx_unique'];
    $primary = $_POST['idx_primary'];
    $oaSchema->indexAdd($table, $index_name, $index_fields, $primary, $unique);
}
else if (array_key_exists('btn_index_save', $_POST))
{
    $table = $_POST['table_edit'];
    $index_name = $_POST['index_name'];
    $index_no = $_POST['index_no'];
    $index_def = $_POST['idx'][$index_no];
    $oaSchema->indexSave($table, $index_name, $index_def);
}
else if (array_key_exists('btn_link_del', $_POST))
{
    $table = $_POST['table_edit'];
    $link_name = $_POST['link_name'];
    $oaSchema->linkDelete($table, $link_name);
}
else if (array_key_exists('btn_link_add', $_POST))
{
    $table = $_POST['table_edit'];
    $link_add = $_POST['link_add'];
    $link_add_target = $_POST['link_add_target'];
    $oaSchema->linkAdd($table, $link_add, $link_add_target);
}
else if (array_key_exists('btn_table_save', $_POST))
{
    $table = $_POST['table_edit'];
    $table_name_new = $_POST['tbl_new_name'];
    $ok = $oaSchema->tableSave($table, $table_name_new);
    if ($ok) {
        $table = $table_name_new;
    }
}
else if (array_key_exists('btn_table_edit', $_POST))
{
    $table = $_POST['btn_table_edit'];
}
else if (array_key_exists('btn_table_delete', $_POST))
{
    $table = $_POST['table_edit'];
    $oaSchema->tableDelete($table);
    unset($table);
}
else if (array_key_exists('btn_table_cancel', $_POST))
{
    $table = '';
}
else if (array_key_exists('btn_table_new', $_POST))
{
    if (array_key_exists('new_table_name', $_POST))
    {
        $table = $_POST['new_table_name'];
        $oaSchema->tableNew($table);
        unset($table);
    }
}
else if (array_key_exists('table_edit', $_POST))
{
    $table = $_POST['table_edit'];
}

if (!$table)
{
    header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
    readfile($oaSchema->working_file_schema);
    exit();
}
else
{
    $oaSchema->parseWorkingDefinitionFile();
    $dd_definition  = $oaSchema->dd_definition;
    $db_definition  = $oaSchema->db_definition;
    $tbl_definition = $oaSchema->db_definition['tables'][$table];
    $links          = $oaSchema->readForeignKeys($table);
    $tbl_links      = $links[$table];
    $link_targets   = $oaSchema->getLinkTargets();

    include 'edit.html';
    exit();
}

?>
