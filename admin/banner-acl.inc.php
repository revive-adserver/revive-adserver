<?
$acl_types = array(
		'none'	   => '',
		'clientip' => $strClientIP,
		'useragent' => $strUserAgent,
		'weekday'  => $strWeekDay,
		'domain'  => $strDomain,
		'source'  => $strSource,
		'time'    => $strTime
	);

$aclad_types = array(
		'allow' => $strAllow,
		'deny'  => $strDeny
	);


function acltypeselect($default)
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

function acladselect($default)
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

function showaclrow($row, $total, $update, $count=1) 
{
	global $PHP_SELF, $strSave, $strDelete, $strUp, $strDown, $clientID;
	
	$bgcolor = $count % 2 == 0 ? "#F6F6F6" : "#FFFFFF";
	
	?>
	<tr bgcolor='<?echo $bgcolor?>'>
		<form action="<?echo basename($PHP_SELF);?>" method="get">
		<input type="hidden" name="clientID" value="<? echo $clientID; ?>">
		<input type="hidden" name="bannerID" value="<? print $row['bannerID']; ?>">
		<input type="hidden" name="acl_order" value="<? print $row['acl_order']; ?>">
		<input type="hidden" name="update" value="<? print $update; ?>">

		<td height='35'>
			&nbsp;<? acltypeselect(isset($row['acl_type']) ? $row['acl_type'] : ""); ?>
		</td>
		<td height='35'>
			<? acladselect(isset($row['acl_ad']) ? $row['acl_ad']: ""); ?>
		</td>
		<td height='35'>
			<input type="text" size="15" name="acl_data" value="<? print isset($row['acl_data']) ? $row['acl_data'] : ""; ?>">
		</td>
		<td height='35'>
			<? if ($row['acl_order'] && $row['acl_order'] < $total) { ?>
				<input type="submit" name="submit" value="<?print $strUp?>">
			<? } else { ?>
				&nbsp;
			<? } ?>
		</td>
		<td height='35'>
			<? if ($row['acl_order'] < $total - 1) { ?>
				<input type="submit" name="submit" value="<?print $strDown?>">
			<? } else { ?>
				&nbsp;
			<? } ?>
		</td>
		<td height='35'>
			<input type="submit" name="submit" value="<?print $strSave?>">
		</td>
		<td height='35'>
			<? if ($row['acl_order'] < $total) { ?>
				<input type="submit" name="submit" value="<?print $strDelete?>">
			<? } else { ?>
				&nbsp;
			<? } ?>
		</td>
		</form>
	</tr>
	<tr><td height='1' colspan='7' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<?
}
?>
