<?
// Swedish doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Titel</b></td>
					<td bgcolor="#FFFFFF"><b>Argument</b></td>
					<td bgcolor="#FFFFFF"><b>Beskrivning</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Klient-IP</td>
					<td bgcolor="#FFFFFF">IP-nät/mask: ip.ip.ip.ip/mask.mask.mask.mask, for example 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Visa enbart banner för den angivna IP-regionen.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Användaragent regexp</td>
					<td bgcolor="#FFFFFF">Regelbundet uttryck som matchar en användaragent, till exempel ^Mozilla/4.? </td>
		 			<td bgcolor="#FFFFFF">Visar enbart bannern för utvalda webbläsare.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Veckodag (0-6)</td>
					<td bgcolor="#FFFFFF">Veckodag, från 0 = söndag till 6 = lördag</td>
					<td bgcolor="#FFFFFF">Visa enbart banner på vissa veckodagar.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Domän</td>
					<td bgcolor="#FFFFFF">Domän-avslut (t.ex. .jp, .edu eller google.com)</td>
					<td bgcolor="#FFFFFF">Visa bannrar för utvalda domäner.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Källa</td>
					<td bgcolor="#FFFFFF">Namn på webbsidan</td>
					<td bgcolor="#FFFFFF">Visar enbart bannern på utvalda sidor.</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF">Tid (0-23)</td>
                    <td bgcolor="#FFFFFF">Tid på dygnet, från 0 = midnatt till 23</td>
                    <td bgcolor="#FFFFFF">Visar enbart bannern under de valda tidpunkterna.</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>Till exempel, om du enbart vill visa bannern på helgen, behöver du lägga till två ACL-kommandon:</p>
<ul>
	<li>Veckodag (0-6), <? echo $strAllow; ?>, argument 6 (för lördag)</li>
	<li>Veckodag (0-6), <? echo $strAllow; ?>, argument 0 (för söndag)</li>
    <li>Veckodag (0-6), <? echo $strDeny; ?>, argument * (för alla andra dagar)</li>
</ul>
Det sista kommandot behövde inte varit en &quot;veckodag&quot;.  Alla <? echo $strDeny; ?> *
ACL räcker för att banner ej ska visas om inte någon <? echo $strAllow; ?> redan har matchat och tillåtit att annonsen visas.

<p>För att visa bannern mellan 17 och 20:</p>
<ul>
    <li>Tid, <? echo $strAllow; ?>, argument 17</li>
    <li>Tid, <? echo $strAllow; ?>, argument 18</li>
	<li>Tid, <? echo $strAllow; ?>, argument 19</li>
    <li>Tid, <? echo $strDeny; ?>, argument * (för övriga tider)</li>
</ul>
<?
// EOF Swedish doc file for Banner ACL administration
?>
