<?
// english doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Tytu³</b></td>
					<td bgcolor="#FFFFFF"><b>Argument</b></td>
					<td bgcolor="#FFFFFF"><b>Opis</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">IP Klienta</td>
					<td bgcolor="#FFFFFF">Sieæ/maska IP: ip.ip.ip.ip/maska.maska.maska.maska, np. 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Wy¶wietla banner tylko dla konkretnych regionów IP.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Nazwa przegl±darki</td>
					<td bgcolor="#FFFFFF">Nazwa podana przez przegl±darkê, np. ^Mozilla/4.? </td>
		 			<td bgcolor="#FFFFFF">Wy¶wietla banner tylko dla konkretnych przegl±darek.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Dzieñ Tygodnia (0-6)</td>
					<td bgcolor="#FFFFFF">Dzieñ tygodnia, od 0 = Niedziala do 6 = Sobota</td>
					<td bgcolor="#FFFFFF">Display banner only on a specific day of the week.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Domena</td>
					<td bgcolor="#FFFFFF">Koñcówka domeny (np. .jp, .edu, .pl, lub google.com)</td>
					<td bgcolor="#FFFFFF">Wy¶wietla banner tylko dla niektórych domen.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">¬ród³o</td>
					<td bgcolor="#FFFFFF">Nazwa strony ¼ród³owej</td>
					<td bgcolor="#FFFFFF">Wy¶wietla banner tylko na niektórych stronach.</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF">Czas (0-23)</td>
                    <td bgcolor="#FFFFFF">Godzina dnia, od 0 = pó³noc do 23 = 23:00</td>
                    <td bgcolor="#FFFFFF">Wy¶wietlaj banner tylko w pewne godziny dnia.</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>Na przyk³ad je¶li chcesz wy¶wietlaæ banner tylko w weekendy, powiniene¶ dodaæ dwa wpisy ACL:</p>
<ul>
	<li>Dzieñ tygodnia (0-6), <? echo $strAllow; ?>, argument 6 (dla Soboty)</li>
	<li>Dzieñ tygodnia (0-6), <? echo $strAllow; ?>, argument 0 (dla Niedzieli)</li>
    <li>Dzieñ tygodnia (0-6), <? echo $strDeny; ?>, argument * (dla ka¿dego dnia)</li>
</ul>
Zauwa¿, ¿e ostatni wpis nie musia³ byæ &quot;Dzieñ tygodnia&quot;. Ka¿de ACL <? echo $strDeny; ?> *
wystarczy³oby aby uniemo¿liwiæ wy¶wietlanie bannera, je¶li odpowiedni <? echo $strAllow; ?> nie by³by jeszcze pozytywnie zweryfikowany.

<p>Aby pokazaæ banner miêdzy godzin± 17 i 20:</p>
<ul>
    <li>Czas, <? echo $strAllow; ?>, argument 17</li>  (17:00 - 17:59)
    <li>Czas, <? echo $strAllow; ?>, argument 18</li>  (18:00 - 18:59)
	<li>Czas, <? echo $strAllow; ?>, argument 19</li>  (19:00 - 19:59)
    <li>Czas, <? echo $strDeny; ?>, argument * (dla dowolnego czasu)</li>
</ul>
<?
// EOF english doc file for Banner ACL administration
?>
