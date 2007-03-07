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

function editFieldProperty($form)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert(print_r($form,true));
	foreach ($form as $k => $v)
	{
    	$objResponse->addAssign($k,"style.display", 'inline');
    	$objResponse->addAssign('span_'.$k,"style.display", 'none');
        $objResponse->addAssign('btn_'.$k,"style.display", 'none');
    }
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