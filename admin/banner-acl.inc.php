<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Define variable types
$acl_types = array(
		'none'		=> '',
		'clientip'	=> $strClientIP,
		'useragent'	=> $strUserAgent,
		'weekday'	=> $strWeekDay,
		'domain'	=> $strDomain,
		'source'	=> $strSource,
		'time'		=> $strTime,
		'language'	=> $strLanguage
	);

$aclad_types = array(
		'allow' => $strEqualTo,
		'deny'  => $strDifferentFrom
	);

$aclcon_types = array(
		'or'  => $strOR,
		'and' => $strAND
	);


/*********************************************************/
/* Generate condition selection                          */
/*********************************************************/

function phpAds_ACLConditionSelect ($default, $acl_order)
{
	global $aclcon_types;
	
	if ($acl_order == 0)
	{
		echo "<input type='hidden' name='acl_con' value='and'>&nbsp;";
	}
	else
	{
		echo "<select name='acl_con'>";
		
		reset($aclcon_types);
		while (list ($aclcon_type, $aclcon_name) = each ($aclcon_types))
		{
			echo "<option value=";
			printf("\"%s\" %s>", $aclcon_type, $aclcon_type == $default ? 'selected':''); 
			echo "$aclcon_name\n";
		}
		
		echo "</select>";
	}
}



/*********************************************************/
/* Generate type selection                               */
/*********************************************************/

function phpAds_ACLTypeSelect ($default)
{
	global $acl_types;
	
	echo "<select name='acl_type'>";
	
	reset($acl_types);
	while (list ($acl_type, $acl_name) = each ($acl_types))
	{
		echo "<option value=";
		printf("\"%s\" %s>", $acl_type, $acl_type == $default ? 'selected':''); 
		echo "$acl_name\n";
	}
	
	echo "</select>";
}



/*********************************************************/
/* Generate allow/deny selection                         */
/*********************************************************/

function phpAds_ACLAdSelect ($default)
{
	global $aclad_types;
	
	echo "<select name='acl_ad'>";
	
	reset($aclad_types);
	while (list ($acl_ad, $acl_name) = each ($aclad_types))
	{
		echo "<option value=";
		printf("\"%s\" %s>", $acl_ad, $acl_ad == $default ? 'selected':''); 
		echo "$acl_name\n";
	}
	
	echo "</select>";
}



/*********************************************************/
/* Generate ACL form                                     */
/*********************************************************/

function phpAds_ShowRow ($row, $total, $update, $count=1) 
{
	global $PHP_SELF, $strSave, $strDelete, $strUp, $strDown, $campaignid, $strDayShortCuts;
	
	$bgcolor = $count % 2 == 0 ? "#F6F6F6" : "#FFFFFF";
	
	
	// Begin form
	echo "<tr height='35' bgcolor='$bgcolor'>";
	echo "<form action='".basename($PHP_SELF)."' method='get'>";
	echo "<input type='hidden' name='campaignid' value='".$campaignid."'>";
	echo "<input type='hidden' name='bannerid' value='".$row['bannerid']."'>";
	echo "<input type='hidden' name='acl_order' value='".$row['acl_order']."'>";
	echo "<input type='hidden' name='update' value='".$update."'>";
	
	
	echo "<td width='75'>&nbsp;";
	phpAds_ACLConditionSelect (isset($row['acl_con']) ? $row['acl_con'] : "", isset($row['acl_order']) ? $row['acl_order'] : "");
	echo "</td><td width='175'>";
	phpAds_ACLTypeSelect (isset($row['acl_type']) ? $row['acl_type'] : "");
	echo "</td><td width='350' colspan='2'>";
	phpAds_ACLAdSelect (isset($row['acl_ad']) ? $row['acl_ad']: "");
	echo "</td></tr>";
	
	
	// Show ACL data
	echo "<tr bgcolor='$bgcolor'><td>&nbsp;</td><td>&nbsp;</td><td colspan='2'>";
	
	if ($row['acl_type'] == 'weekday')
	{
		$data_array = explode (',', $row['acl_data']);
		
		echo "<table width='275' cellpadding='0' cellspacing='0' border='0'>";
		for ($i = 0; $i < 7; $i++)
		{
			if ($i % 4 == 0) echo "<tr>";
			echo "<td><input type='checkbox' name='acl_data[]' value='$i'".($row['acl_data'] == '*' || in_array ($i, $data_array) ? ' CHECKED' : '').">&nbsp;".$strDayShortCuts[$i]."&nbsp;&nbsp;</td>";
			if (($i + 1) % 4 == 0) echo "</tr>";
		}
		if (($i + 1) % 4 != 0) echo "</tr>";
		echo "</table>";
	}
	elseif ($row['acl_type'] == 'time')
	{
		$data_array = explode (',', $row['acl_data']);
		
		echo "<table width='275' cellpadding='0' cellspacing='0' border='0'>";
		for ($i = 0; $i < 24; $i++)
		{
			if ($i % 4 == 0) echo "<tr>";
			echo "<td><input type='checkbox' name='acl_data[]' value='$i'".($row['acl_data'] == '*' || in_array ($i, $data_array) ? ' CHECKED' : '').">&nbsp;".$i.":00&nbsp;&nbsp;</td>";
			if (($i + 1) % 4 == 0) echo "</tr>";
		}
		if (($i + 1) % 4 != 0) echo "</tr>";
		echo "</table>";
	}
	else
	{
		echo "<input type='text' size='40' name='acl_data' value='".(isset($row['acl_data']) ? $row['acl_data'] : "")."'>";
	}
	
	echo "</td></tr>";
	
	
	// Show buttons
	echo "<tr height='35' bgcolor='$bgcolor'><td>&nbsp;</td><td>&nbsp;</td><td>";
	echo "<input type='image' name='btnsave' src='images/save.gif' border='0' align='absmiddle' alt='$strSave'>";
	echo "&nbsp;&nbsp;";
	
	if ($row['acl_order'] < $total)
		echo "<input type='image' name='btndel' src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>";
	else
		echo "<img src='images/icon-recycle-d.gif' align='absmiddle' alt='$strDelete'>";
	echo "&nbsp;&nbsp;";
	
	echo "</td><td align='right'>";
	
	if ($row['acl_order'] && $row['acl_order'] < $total)
		echo "<input type='image' name='btnup' src='images/triangle-u.gif' border='0' alt='$strUp'>";
	else
		echo "<img src='images/triangle-u-d.gif' alt='$strUp'>";
	
	if ($row['acl_order'] < $total - 1)
		echo "<input type='image' name='btndown' src='images/triangle-d.gif' border='0' alt='$strDown'>";
	else
		echo "<img src='images/triangle-d-d.gif' alt='$strDown'>";
	
	echo "&nbsp;</td>";
	
	
	// End of form
	echo "</form>";
	echo "</tr>";
}

?>
