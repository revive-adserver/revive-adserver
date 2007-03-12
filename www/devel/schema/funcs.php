<?php

/**
 * functions registered with xAjax
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */

function testAjax($form)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert('testing ajax');
	$objResponse->addAlert(print_r($form,true));
	return $objResponse;
}

function expandTable($table)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAssign($table,"style.display", 'block');
	$objResponse->addAssign('img_expand_'.$table,"style.display", 'none');
	$objResponse->addAssign('img_collapse_'.$table,"style.display", 'inline');
	return $objResponse;
}

function collapseTable($table)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAssign($table,"style.display", 'none');
	$objResponse->addAssign('img_expand_'.$table,"style.display", 'inline');
	$objResponse->addAssign('img_collapse_'.$table,"style.display", 'none');
	return $objResponse;
}

function editFieldProperty($form, $elementId, $elementNo)
{
	$objResponse = new xajaxResponse();
	$id = $elementId.'_'.$elementNo;
	$objResponse->addAssign('fld_old_'.$id,"style.display", 'none');
    $objResponse->addAssign('fld_new_'.$id,"style.display", 'inline');
    $objResponse->addAssign('btn_field_save_'.$id,"style.display", 'inline');
    $objResponse->addAssign('btn_exit_'.$id,"style.display", 'inline');
	return $objResponse;
}

function exitFieldProperty($form, $elementId, $elementNo)
{
	$objResponse = new xajaxResponse();
	$id = $elementId.'_'.$elementNo;
    $objResponse->addAssign('fld_new_'.$id,"value", '');
	$objResponse->addAssign('fld_old_'.$id,"style.display", 'inline');
    $objResponse->addAssign('fld_new_'.$id,"style.display", 'none');
    $objResponse->addAssign('btn_field_save_'.$id,"style.display", 'none');
    $objResponse->addAssign('btn_exit_'.$id,"style.display", 'none');
	return $objResponse;
}

function saveFieldProperty($form, $elementId, $elementNo)
{
//    global $dump_options, $schema_trans;
//	$objResponse = new xajaxResponse();
//    $schema = & connect($dump_options);
//    $db_definition = $schema->parseDatabaseDefinitionFile($schema_trans);
//    $table = $form['table_edit'];
//    $field_name_old = $form['field_'.$elementNo];
//    $field_name_new = $form['inp_'.$elementId.$elementNo];
//    $fld_definition = $db_definition['tables'][$table]['fields'][$field_name_old];
//    $fld_definition['was'] = $field_name_old;
//    $db_definition['tables'][$table]['fields'][$field_name_new] = $fld_definition;
//    unset($db_definition['tables'][$table]['fields'][$field_name_old]);
//    $dump = $schema->dumpDatabase($db_definition, $dump_options, MDB2_SCHEMA_DUMP_STRUCTURE, false);
//	$id = $elementId.'_'.$elementNo;
//    $objResponse->addAssign('fld_'.$id,"value", $field_name_new);
//	$objResponse->addAssign('fld_'.$id,"style.display", 'inline');
//    $objResponse->addAssign('inp_'.$id,"style.display", 'none');
//    $objResponse->addAssign('btn_save_'.$id,"style.display", 'none');
//    $objResponse->addAssign('btn_exit_'.$id,"style.display", 'none');
//	return $objResponse;
}

/**
 * other routines
 */

function connect($options)
{
    $dsn['phptype']     = $GLOBALS['_MAX']['CONF']['database']['type'];
    $dsn['hostspec']    = $GLOBALS['_MAX']['CONF']['database']['host'];
    $dsn['username']    = '';
    $dsn['password']    = '';
    $dsn['database']    = '';

    return MDB2_Schema::factory(Openads_Dal::singleton($dsn), $options);
}

function validate_table($schema, $db_definition, $tbl_definition, $tbl_name)
{
    // these should be inline with actual options set for schema instance
    $fail_on_invalid_names = array();
    $valid_types = $schema->options['valid_types'];
    $force_defaults = '';

    $validator =& new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);

    $result = $validator->validateTable($db_definition['tables'], $tbl_definition, $tbl_name);
    if (PEAR::isError($result)) {
        return false;
    } else {
        return true;
    }
}

function validate_field($schema, $db_definition, $tbl_name, $fld_definition, $fld_name)
{
    // these should be inline with actual options set for schema instance
    $fail_on_invalid_names = array();
    $valid_types = $schema->options['valid_types'];
    $force_defaults = '';

    $validator =& new MDB2_Schema_Validate($fail_on_invalid_names, $valid_types, $force_defaults);

    $result = $validator->validateField($db_definition['tables'][$tbl_name]['fields'], $fld_definition, $fld_name);
    if (PEAR::isError($result)) {
        return false;
    } else {
        return true;
    }
}

function field_relations($schema, &$tbl_definition, $fld_name_old, $fld_name_new)
{
    if (!empty($tbl_definition['indexes']) && is_array($tbl_definition['indexes']))
    {
        foreach ($tbl_definition['indexes'] as $idx_name => $index)
        {
            if (is_array($index['fields']) && array_key_exists($fld_name_old, $index['fields']))
            {
                foreach ($index['fields'] AS $k => $v)
                {
                    if ($fld_name_old == $k)
                    {
                        $fields_ordered[$fld_name_new] = $v;
                    }
                    else
                    {
                        $fields_ordered[$k] = $v;
                    }
                }
                $tbl_definition['indexes'][$idx_name]['fields'] = $fields_ordered;
//                    $tbl_definition['indexes'][$idx_name]['fields'][$fld_name_new] = $tbl_definition['indexes'][$idx_name]['fields'][$fld_name_old];
//                    unset($tbl_definition['indexes'][$idx_name]['fields'][$fld_name_old]);
            }
        }
    }
    return true;
}

?>