<?
// Danish doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Titel</b></td>
					<td bgcolor="#FFFFFF"><b>Argument</b></td>
					<td bgcolor="#FFFFFF"><b>Beskrivelse</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Klient IP</td>
					<td bgcolor="#FFFFFF">IP net/mask: f.eks. 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Vis kun banner for specifik IP-region.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">User agent regexp</td>
					<td bgcolor="#FFFFFF">Regular expression der matcher "user agent", f.eks. ^Mozilla/4.? </td>
		 			<td bgcolor="#FFFFFF">Vis kun banner for specifikke browsere.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Ugedag (0-6)</td>
					<td bgcolor="#FFFFFF">Dag på ugen, fra 0 = søndag til 6 = lørdag</td>
					<td bgcolor="#FFFFFF">Vis kun banner på en specifik ugedag.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Domæne</td>
					<td bgcolor="#FFFFFF">Domæne suffix (f.eks. .jp, .edu, eller google.com)</td>
					<td bgcolor="#FFFFFF">Vis kun banner for et specifikt domæne.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Kilde</td>
					<td bgcolor="#FFFFFF">Navn på kildeside</td>
					<td bgcolor="#FFFFFF">Vis kun banner på specielle sider.</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF">Tid (0-23)</td>
                    <td bgcolor="#FFFFFF">Tid på dagen, fra 0 = midnat til 23</td>
                    <td bgcolor="#FFFFFF">Vis kun banner på et specielt tidspunkt.</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>Hvis du f.eks. kun vil vise dette banner i weekenderne, tilføjes der to ACL'er:</p>
<ul>
	<li>Ugedag (0-6), <? echo $strAllow; ?>, argument 6 (for lørdag)</li>
	<li>Ugedag  (0-6), <? echo $strAllow; ?>, argument 0 (for søndag)</li>
  <li>Ugedag (0-6), <? echo $strDeny; ?>, argument * (for alle dage)</li>
</ul>
Bemærk at den sidste ACL behøver ikke at være en &quot;Ugedag&quot;. Enhver <? echo $strDeny; ?> *
ACL ville være nok til at nægte en reklame hvis en associeret <? echo $strAllow; ?> ikke allerede var blevet matchet.

<p>For at vise et banner mellem kl. 17 og 20:</p>
<ul>
  <li>Tid, <? echo $strAllow; ?>, argument 17</li>
  <li>Tid, <? echo $strAllow; ?>, argument 18</li>
	<li>Tid, <? echo $strAllow; ?>, argument 19</li>
  <li>Tid, <? echo $strDeny; ?>, argument * (for ethvert tidspunkt)</li>
</ul>
<?
// EOF Danish doc file for Banner ACL administration
?>
