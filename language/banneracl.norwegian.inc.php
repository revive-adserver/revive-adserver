<?
// Norwegian doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Tittel</b></td>
					<td bgcolor="#FFFFFF"><b>Argument</b></td>
					<td bgcolor="#FFFFFF"><b>Beskrivelse</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Klient IP</td>
					<td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask, for eksempel 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Vis banner bare for spesifikk IP region.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">User agent regexp</td>
					<td bgcolor="#FFFFFF">Regular expression matching a user agent, for example ^Mozilla/4.? </td>
		 			<td bgcolor="#FFFFFF">Vis banner bare for bestemte nettlesere.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Ukedag (0-6)</td>
					<td bgcolor="#FFFFFF">Dag i uka, fra 0 = Søndag til 6 = Lørdag</td>
					<td bgcolor="#FFFFFF">Vis banner bare for spesifikk ukedag.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Domene</td>
					<td bgcolor="#FFFFFF">Domene  suffix (f.eks. .jp, .edu, eller google.com)</td>
					<td bgcolor="#FFFFFF">Vis banner bare til spesifikt domene.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Kilde</td>
					<td bgcolor="#FFFFFF">Navn på kildeside</td>
					<td bgcolor="#FFFFFF">Vi banner bare på bestemte sider.</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF">Tid (0-23)</td>
                    <td bgcolor="#FFFFFF">Time på dagen, fra 0 = midnatt til 23 </td>
                    <td bgcolor="#FFFFFF">Vis banner bare for spesifikk tid på dagen.</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>For eksempel, dersom du ønsker å vise dette banneret bare i helger, trenger du å legge til to ACL poster:</p>
<ul>
	<li>Ukedag (0-6), <? echo $strAllow; ?>, argument 6 (for Lørdag)</li>
	<li>Ukedag (0-6), <? echo $strAllow; ?>, argument 0 (for Søndag)</li>
    <li>Ukedag (0-6), <? echo $strDeny; ?>, argument * (for hvilken som helst dag)</li>
</ul>
Legg merke til at den siste posten trenger ikke å være &quot;Ukedag&quot;. Hvilken som 
helst <? echo $strDeny; ?> * ACL vil være nok til å hindre banner hvis en tilordnet 
<? echo $strAllow; ?> ikke allerede er matchet.

<p>For å vise et banner mellom kl 17 og 20:</p>
<ul>
    <li>Tid, <? echo $strAllow; ?>, argument 17</li>  (17:00 - 17:59)
    <li>Tid, <? echo $strAllow; ?>, argument 18</li>  (18:00 - 18:59)
	<li>Tid, <? echo $strAllow; ?>, argument 19</li>  (19:00 - 19:59)
    <li>Tid, <? echo $strDeny; ?>, argument * (for hvilken som helst tid)</li>
</ul>
<?
// EOF Norwegian doc file for Banner ACL administration
?>
