<?
// romanian doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Titlu</b></td>
					<td bgcolor="#FFFFFF"><b>Argument</b></td>
					<td bgcolor="#FFFFFF"><b>Descriere</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF"><? echo $GLOBALS['strClientIP'];?></td>
					<td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask, de exemplu 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Restricitie afisare banner pentru o anumita regiune IP.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF"><? echo $GLOBALS['strUserAgent'];?></td>
					<td bgcolor="#FFFFFF">Regexp corespunzator unui anumit tip de browser, de exemplu ^Mozilla/4.? </td>
		 			<td bgcolor="#FFFFFF">Restrictie afisare banner pentru anumite tipuri de browser.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF"><? echo $GLOBALS['strWeekDay'];?></td>
					<td bgcolor="#FFFFFF">Ziua din saptamana, de la  0 = Duminica la 6 = Sambata</td>
					<td bgcolor="#FFFFFF">Restricitie afisare banner intr-o anumita zi a saptamanii.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF"><? echo $GLOBALS['strDomain'] ;?></td>
					<td bgcolor="#FFFFFF">Suffix domeniu (de exemplu. .jp, .edu, or google.com)</td>
					<td bgcolor="#FFFFFF">Restricitie afisare banner pentru un anumit domeniu.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF"><? echo $GLOBALS['strSource'];?></td>
					<td bgcolor="#FFFFFF">Numele paginii sursa</td>
					<td bgcolor="#FFFFFF">Restricitie afisare banner numai pe anumite pagini.</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF"><? echo $GLOBALS['strTime'];?></td>
                    <td bgcolor="#FFFFFF">Ora din zi, de la 0 = miezul noptii la 23 = 11:00 pm</td>
                    <td bgcolor="#FFFFFF">Restrictie afisare banner doar la anumite ore.</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>De exemplu, daca ati dori afisarea unui banner doar in wekend, ar trebui sa adaugati urmatoarele inregistrari ACL:</p>
<ul>
	<li><? echo $GLOBALS['strWeekDay'];?>, <? echo $strAllow; ?>, argument 6 (pentru Sambata)</li>
	<li><? echo $GLOBALS['strWeekDay'];?>, <? echo $strAllow; ?>, argument 0 (pentru Duminica)</li>
    <li><? echo $GLOBALS['strWeekDay'];?>, <? echo $strDeny; ?>, argument * (pentru orice zi)</li>
</ul>
De remarcat faptul ca ultima inregistrare nu era neaparat necesar sa fie de tip &quot;<? echo $GLOBALS['strWeekDay'];?>&quot;.  Orice inregistrare de tipul  <? echo $strDeny; ?> *
este suficienta atat timp cat nu a fost gasita mai sus o inregistrare de tip <? echo $strAllow; ?>.

<p>Pentru a afisa bannerul intre 5pm si 8pm:</p>
<ul>
    <li><? echo $GLOBALS['strTime'];?>, <? echo $strAllow; ?>, argument 17</li>  (5:00pm - 5:59pm)
    <li><? echo $GLOBALS['strTime'];?>, <? echo $strAllow; ?>, argument 18</li>  (6:00pm - 6:59pm)
	<li><? echo $GLOBALS['strTime'];?>, <? echo $strAllow; ?>, argument 19</li>  (7:00pm - 7:59pm)
    <li><? echo $GLOBALS['strTime'];?>, <? echo $strDeny; ?>, argument * (pentru orice ora)</li>
</ul>
<?
// EOF Romanian doc file for Banner ACL administration
?>
