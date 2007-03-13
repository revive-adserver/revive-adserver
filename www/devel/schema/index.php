<?php

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

require_once MAX_DEV.'/lib/xajax.inc.php';
require_once 'oaSchema.php';

$oaSchema = & new Openads_Schema_Manager();

if (array_key_exists('btn_copy_final', $_POST))
{
    $oaSchema->createTransitional();
}
else if (array_key_exists('btn_delete_trans', $_POST))
{
    $oaSchema->deleteTransitional();
}
else if (array_key_exists('btn_compare_schemas', $_POST))
{
    $oaSchema->createChangeset();
    header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
    readfile($oaSchema->file_changes_core);
    exit();
}
else if (array_key_exists('btn_changeset_delete', $_POST))
{
    $oaSchema->deleteChangeset();
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
    $oaSchema->indexAdd($table, $index_name, $index_fields);
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
else if (array_key_exists('btn_table_edit', $_POST))
{
    $table = $_POST['btn_table_edit'];
}
else if (array_key_exists('btn_table_delete', $_POST))
{
    $table = $_POST['table_delete'];
    $oaSchema->tableDelete($table);
    unset($table);
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
