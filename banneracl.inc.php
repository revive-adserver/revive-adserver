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
	?>
	<SELECT name="acl_type">
	<?
	reset($acl_types);
	while ( list($acl_type, $acl_name) = each($acl_types) ) 
	{
		?>
		<OPTION value=<? printf("\"%s\" %s>", $acl_type, $acl_type == $default ? 'selected':''); print ("$acl_name\n"); ?>
		<?
	}
	?>
	</SELECT>
	<?
}

function acladselect($default)
{
	global $aclad_types;
	?>
	<SELECT name="acl_ad">
	<?
	reset($aclad_types);
	while ( list($acl_ad, $acl_name) = each($aclad_types) ) 
	{
		?>
		<OPTION value=<? printf("\"%s\" %s>", $acl_ad, $acl_ad == $default ? 'selected':''); print ("$acl_name\n"); ?>
		<?
	}
	?>
	</SELECT>
	<?
}

function showaclrow($row, $total, $update) 
{
	global $PHP_SELF, $strSave, $strDelete, $strUp, $strDown, $pageid;
	?>
	<TR>
		<FORM action="<?echo basename($PHP_SELF);?>" method="GET">
		<TD>
			<INPUT type="hidden" name="pageid" value="<? echo ($pageid) ?>">
			<INPUT type="hidden" name="bannerID" value="<? print $row['bannerID']; ?>">
			<INPUT type="hidden" name="acl_order" value="<? print $row['acl_order']; ?>">
			<INPUT type="hidden" name="update" value="<? print $update; ?>">
			<?
			acltypeselect(isset($row['acl_type']) ? $row['acl_type'] : ""); 
			?>
		</TD>
		<TD>
		<?
		acladselect(isset($row['acl_ad']) ? $row['acl_ad']: ""); 
		?>
		</TD>
		<TD>
			<INPUT type="text" size="25" name="acl_data" value="<? print isset($row['acl_data']) ? $row['acl_data'] : ""; ?>">
		</TD>
		<TD>
		<? 
		if ($row['acl_order'] && $row['acl_order'] < $total) 
		{
			?>
			<INPUT type="submit" name="submit" value="<?print $strUp?>">
			<? 
		} 
		?>
		</TD>
		<TD>
		<?
		if ($row['acl_order'] < $total - 1) 
		{
			?>
			<INPUT type="submit" name="submit" value="<?print $strDown?>">
			<?
		}
		?>
		</TD>
		<TD>
			<INPUT type="submit" name="submit" value="<?print $strSave?>">
		</TD>
		<TD>
		<?
		if ($row['acl_order'] < $total) 
		{
			?>
			<INPUT type="submit" name="submit" value="<?print $strDelete?>">
			<?
		} 
		?>
		</TD>
		</FORM>
	</TR>
	<?
}
?>
