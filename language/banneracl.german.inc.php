<?
// German doc file for Banner ACL administration
?>
<HR SIZE="1">
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Titel</b></td>
					<td bgcolor="#FFFFFF"><b>Argument</b></td>
					<td bgcolor="#FFFFFF"><b>Beschreibung</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Besucher IP</td>
					<td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask, zum Beispiel 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Zeige Banner nur bei einem speziellen Bereich von Besucher-IPs.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Besucher Browser regexp</td>
					<td bgcolor="#FFFFFF">Regulärer Ausdruck der zu einem Browser passt, zum Beispiel ^Mozilla/4.?</td>
		 			<td bgcolor="#FFFFFF">Zeige Banner nur bei bestimmten Browsern.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Wochentag (0-6)</td>
					<td bgcolor="#FFFFFF">Tag der Woche, von 0 = Sonntag bis 6 = Samstag</td>
					<td bgcolor="#FFFFFF">Zeige Banner nur an einem bestimmten Wochentag.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Domain</td>
					<td bgcolor="#FFFFFF">2-3 Buchstaben-Kombination für ein Domain-Suffix (TLD)</td>
					<td bgcolor="#FFFFFF">Zeige Banner nur bei bestimmter Domain.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Quelle</td>
					<td bgcolor="#FFFFFF">Name der HTML-Seite</td>
					<td bgcolor="#FFFFFF">Zeige Banner nur auf bestimmten Seiten.</td>
				</tr>
			</table>
		</TD>
	</TR>
</table>
<p>Wenn Sie z.B. ein Banner nur am Wochenende zur Anzeige bringen wollen, fügen Sie zwei neue Regeln hinzu:</p>
<ul>
	<li>Wochentag (0-6), Regel "<? echo $strAllow; ?>", Argument 6 (für Samstag)</li>
	<li>Wochentag (0-6), Regel "<? echo $strAllow; ?>", Argument 0 (für Sonntag)</li>
</ul>
<?
// EOF German doc file for Banner ACL administration
?>
