<?
// dutch doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Titel</b></td>
					<td bgcolor="#FFFFFF"><b>Parameter</b></td>
					<td bgcolor="#FFFFFF"><b>Beschrijving</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">IP adres bezoeker</td>
					<td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask, bijvoorbeeld 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Toon een banner alleen voor een specifieke IP regio.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">User agent regexp</td>
					<td bgcolor="#FFFFFF">Reguliere expressie die overeenkomt met de useragent van een browser, bijvoorbeeld ^Mozilla/4.? </td>
		 			<td bgcolor="#FFFFFF">Toon een banner alleen voor een specifieke browser.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Weekdag (0-6)</td>
					<td bgcolor="#FFFFFF">Dag van de week, from 0 = Zondag to 6 = Zaterdag</td>
					<td bgcolor="#FFFFFF">Toon een banner alleen op een specifieke dag van de week.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Domein</td>
					<td bgcolor="#FFFFFF">Domein extentie (bijv. .jp, .edu, of google.com)</td>
					<td bgcolor="#FFFFFF">Toon een banner alleen voor een specifiek domein.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Bronpagina</td>
					<td bgcolor="#FFFFFF">Naam van de bronpagina</td>
					<td bgcolor="#FFFFFF">Toon een banner alleen op een specifieke pagina.</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF">Tijd</td>
                    <td bgcolor="#FFFFFF">Uur van de dag, van 0 (middernacht) tot 23 (11 uur 's avonds</td>
                    <td bgcolor="#FFFFFF">Toon een banner alleen op een specifiek uur van de dag.</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>Bijvoorbeeld, als u alleen in het weekeinde een banner wilt tonen, moet u twee ACL's invoeren:</p>
<ul>
	<li>Weekdag (0-6), <? echo $strAllow; ?>, parameter 6 (voor Zaterdag)</li>
	<li>Weekdag (0-6), <? echo $strAllow; ?>, parameter 0 (voor Zondag)</li>
    <li>Weekdag (0-6), <? echo $strDeny; ?>, parameter * (voor de overige dagen)</li>
</ul>
Opmerking: De laatste ACL had niet perse gedefinieerd te hoeven worden als &quot;Weekdag (0-6)&quot;.
Iedere &quot;<? echo $strDeny; ?> *&quot; ACL had volstaan om de advertentie te weigeren in het geval 
dat de daar bovenstaande ACL's niet gelden.

<p>Toon alleen een banner tussen 5 uur 's middags en 8 uur 's avonds:</p>
<ul>
    <li>Tijd, <? echo $strAllow; ?>, parameter 17</li>  (17:00 - 17:59pm)
    <li>Tijd, <? echo $strAllow; ?>, parameter 18</li>  (18:00 - 18:59pm)
	<li>Tijd, <? echo $strAllow; ?>, parameter 19</li>  (19:00 - 19:59pm)
    <li>Tijd, <? echo $strDeny; ?>, parameter * (voor de overige uren)</li>
</ul>
<?
// EOF dutch doc file for Banner ACL administration
?>
