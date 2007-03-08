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

function toggleReadonly($form, $elementId)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert('toggleReadonly '.$elementId);
  	//$objResponse->addAssign($element,"readonly", $readonly);
	return $objResponse;
}

function editFieldProperty($form, $elementId)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAssign('fld_'.$elementId,"style.display", 'none');
    $objResponse->addAssign('inp_'.$elementId,"style.display", 'inline');
	return $objResponse;
}

function selectDataDictionary($form)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert(print_r($form,true));
    $options = '<option value="id_med">id => mediumint notnull default=0 unsigned autoincrement</option>
<option value="id_med_inc">id_inc => mediumint notnull default=0 unsigned</option>
<option value="name">name => varchar(255) notnull</option>
<option value="desc">description => text notnull</option>';
	foreach ($form as $k => $v)
	{
      	$objResponse->addAssign($k.'_value',"innerHTML", $options);
       	$objResponse->addAssign('span_'.$k,"style.display", 'inline');
	}
	return $objResponse;
}

?>