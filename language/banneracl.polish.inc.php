<?
// english doc file for Banner ACL administration
?>
<HR SIZE="1">
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Title</b></td>
					<td bgcolor="#FFFFFF"><b>Argument</b></td>
					<td bgcolor="#FFFFFF"><b>Description</B.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Client IP</td>
					<td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask, for example 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Display banner only for a specific IP region.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">User agent regexp</td>
					<td bgcolor="#FFFFFF">Regular expression matching a user agent, for example ^Mozilla/4.? </td>
		 			<td bgcolor="#FFFFFF">Display banner only for certain browsers.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Weekday (0-6)</td>
					<td bgcolor="#FFFFFF">Day of the week, from 0 = Sunday to 6 = Saturday</td>
					<td bgcolor="#FFFFFF">Display banner only on a specific day of the week.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Domain</td>
					<td bgcolor="#FFFFFF">2-3 letter combination of domain suffix</td>
					<td bgcolor="#FFFFFF">Displays banner only to certain domain.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Source</td>
					<td bgcolor="#FFFFFF">Name of source page</td>
					<td bgcolor="#FFFFFF">Displays banner only on certain pages.</td>
				</tr>
			</table>
		</TD>
	</TR>
</table>
<p>For example, if you want to display this banner only on weekends, you would add two ACL entries:</p>
<ul>
	<li>Weekday (0-6), <? echo $strAllow; ?>, argument 6 (for Saturday)</li>
	<li>Weekday (0-6), <? echo $strAllow; ?>, argument 0 (for Sunday)</li>
</ul>
<?
// EOF english doc file for Banner ACL administration
?>
