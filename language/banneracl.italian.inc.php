<?
// italian doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Titolo</b></td>
					<td bgcolor="#FFFFFF"><b>Argomento</b></td>
					<td bgcolor="#FFFFFF"><b>Descrizione</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">IP del Client</td>
					<td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask, esempio 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Visualizza i banner solo per IP Specifici.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Espressione Regolare del Browser</td>
					<td bgcolor="#FFFFFF">Espressione regolare sulla corrispondenza del client, esempio ^Mozilla/4.? </td>
					<td bgcolor="#FFFFFF">Visualizza i banner solo per specifici browser.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Giorno della settimana (0-6)</td>
					<td bgcolor="#FFFFFF">Giorno della settimana, da 0 = Domenica a 6 = Sabato</td>
					<td bgcolor="#FFFFFF">Visualizza i banner solo in alcuni giorni della settimana.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Domini</td>
					<td bgcolor="#FFFFFF">Visualizza solo per specifici suffissi di dominio(esempio. .jp, .edu, o google.com)</td>
					<td bgcolor="#FFFFFF">Visualizza i banner solo per specifici domini.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Origine</td>
					<td bgcolor="#FFFFFF">Nome della pagina</td>
					<td bgcolor="#FFFFFF">Visualizza i banner solo per domini specifici.</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF">Orario (0-23)</td>
                    <td bgcolor="#FFFFFF">Ora del giorno, da 0 = mezzanotte alle 23 = 11:00 pm</td>
                    <td bgcolor="#FFFFFF">Visualizza i banner solo in orari del giorno specifici.</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>Per esempio, se vuoi visualizzare questo banner solo nei fine settimana, devi impostare due ACL:</p>
<ul>
	<li>Giorno della settimana (0-6), <? echo $strAllow; ?>, argomento 6 (per Sabato)</li>
	<li>Giorno della settimana (0-6), <? echo $strAllow; ?>, argomento 0 (per Domenica)</li>
    <li>Giorno della settimana (0-6), <? echo $strDeny; ?>, argomento * (per ogni giorno)</li>
</ul>
Nota che l'ultimo inserimento &quot;Ogni giorno della settimana&quot;.  Ogni riga <? echo $strDeny; ?> *
ACL e' sufficente per negare ogni banner collegato con un <? echo $strAllow; ?> che non corrisponde.

<p>Per visualizzare il banner dalle 5 del pomeriggio alle 8 del pomeriggio:</p>
<ul>
    <li>Orario, <? echo $strAllow; ?>, Argomento 17</li>  (5:00pm - 5:59pm)
    <li>Orario, <? echo $strAllow; ?>, Argomento 18</li>  (6:00pm - 6:59pm)
	<li>Orario, <? echo $strAllow; ?>, Argomento 19</li>  (7:00pm - 7:59pm)
    <li>Orario, <? echo $strDeny; ?>, Argomento * (per ogni ora)</li>
</ul>
<?
// EOF italian doc file for Banner ACL administration
?>