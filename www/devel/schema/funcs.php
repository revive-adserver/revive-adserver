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

?>