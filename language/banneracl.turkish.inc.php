<?
// english doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Baþlýk</b></td>
					<td bgcolor="#FFFFFF"><b>Deðer</b></td>
					<td bgcolor="#FFFFFF"><b>Açýklama</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Müþteri IP</td>
					<td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask, örnek: 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Bannerý belirtilen IP grubuna gösterir.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Tarayýcý regexp</td>
					<td bgcolor="#FFFFFF">Tarayýcý tanýyabilen regular expression, örneðin ^Mozilla/4.? </td>
		 			<td bgcolor="#FFFFFF">Bannerý belirtilen kritere uyan tarayýcýlara gösterir.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Günler (0-6)</td>
					<td bgcolor="#FFFFFF">Haftanýn günleri, 0 = Pazar, 6 = Cumartesi</td>
					<td bgcolor="#FFFFFF">Bannerý belirtilen günlerde gösterir.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Alanadý</td>
					<td bgcolor="#FFFFFF">Örneðin .jp, .edu, google.com)</td>
					<td bgcolor="#FFFFFF">Bannerý belirtilen ülkelere veya alan adlarýna gösterir.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Kaynak</td>
					<td bgcolor="#FFFFFF">Kaynak sayfanýn adý</td>
					<td bgcolor="#FFFFFF">Bannerý belirtilen sayfalarda gösterir.</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF">Saat (0-23)</td>
                    <td bgcolor="#FFFFFF">Günün saatleri, 0 = geceyarýsý,  23 = Gece 11</td>
                    <td bgcolor="#FFFFFF">Bannerý günün belirtilen saatlerinde gösterir.</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>Örneðin bu bannerý sadece hafta sonlarý göstermek istiyorsunuz, bu durumda 2 adet ACL eklemelisiniz:</p>
<ul>
	<li>Günler (0-6), <? echo $strAllow; ?>, deðer 6 (Cumartesi Ýçin)</li>
	<li>Günler (0-6), <? echo $strAllow; ?>, deðer 0 (Pazar Ýçin)</li>
    <li>Günler (0-6), <? echo $strDeny; ?>, deðer * (Diðer Günler Ýçin)</li>
</ul>
<!--Note that the last entry need not have been &quot;Weekday&quot;.  Any <? echo $strDeny; ?> *
ACL would suffice to deny any ad if an associated <? echo $strAllow; ?> had not already been matched.-->

<p>Bannerý akþam 5 ve akþam 8 arasý göstermek için:</p>
<ul>
    <li>Saat, <? echo $strAllow; ?>, deðer 17</li>  (17:00 - 17:59)
    <li>Saat, <? echo $strAllow; ?>, deðer 18</li>  (18:00 - 18:59)
	<li>Saat, <? echo $strAllow; ?>, deðer 19</li>  (19:00 - 19:59)
    <li>Saat, <? echo $strDeny; ?>, deðer * (diðer tüm saatler)</li>
</ul>
<?
// EOF english doc file for Banner ACL administration
?>
