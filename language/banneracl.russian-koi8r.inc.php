<?
// russian doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>Название</b></td>
					<td bgcolor="#FFFFFF"><b>Аргумент</b></td>
					<td bgcolor="#FFFFFF"><b>Описание</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Client IP</td>
					<td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask, например 127.0.0.1/255.255.255.0</td>
					<td bgcolor="#FFFFFF">Показывать баннер только для конкретного диапазона IP-адресов.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">User agent regexp</td>
					<td bgcolor="#FFFFFF">Regular expression matching a user agent, for example ^Mozilla/4.? </td>
		 			<td bgcolor="#FFFFFF">Показывать баннер только для конкретных браузеров.</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">День недели (0-6)</td>
					<td bgcolor="#FFFFFF">День недели, от 0 = Воскресенье до 6 = Суббота</td>
					<td bgcolor="#FFFFFF">Показывать баннер только по указанным дням недели.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Домен</td>
					<td bgcolor="#FFFFFF">Доменный суффикс (т.е. .jp, .edu, или google.com)</td>
					<td bgcolor="#FFFFFF">Показывать баннер только конкретному домену.</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Источник</td>
					<td bgcolor="#FFFFFF">Имя исходной страницы</td>
					<td bgcolor="#FFFFFF">Показывать баннер только на конкретных страницах.</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF">Время (0-23)</td>
                    <td bgcolor="#FFFFFF">Время суток, от 0 = полночь до 23 = 23:00</td>
                    <td bgcolor="#FFFFFF">Показывать баннер только в указанное время суток.</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>Например, если вы хотите показывать этот баннер только по выходным, нужно добавить две строки ACL:</p>
<ul>
	<li>День недели (0-6), <? echo $strAllow; ?>, аргумент 6 (Суббота)</li>
	<li>День недели (0-6), <? echo $strAllow; ?>, аргумент 0 (Воскресенье)</li>
    <li>День недели (0-6), <? echo $strDeny; ?>, аргумент * (любой день)</li>
</ul>
Заметьте, что последняя строка не обязательно должна была быть &quot;День недели&quot;. Любой <? echo $strDeny; ?> * ACL подходит для запрещения показа баннера, если еще ен произошло совпадения по соответствующему <? echo $strAllow; ?>.
<p>Для показа баннера между 17:00 и 20:00:</p>
<ul>
    <li>Время, <? echo $strAllow; ?>, аргумент 17</li>  (17:00 - 17:59)
    <li>Время, <? echo $strAllow; ?>, аргумент 18</li>  (18:00 - 18:59)
	<li>Время, <? echo $strAllow; ?>, аргумент 19</li>  (19:00 - 19:59)
    <li>Время, <? echo $strDeny; ?>, аргумент * (любое время)</li>
</ul>
<?
// EOF russian doc file for Banner ACL administration
?>
