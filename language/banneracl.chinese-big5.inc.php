<?
// english doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					<td bgcolor="#FFFFFF"><b>項目</b></td>
					<td bgcolor="#FFFFFF"><b>參數</b></td>
					<td bgcolor="#FFFFFF"><b>說明</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">使用者來源位址 (Client IP)</td>
					<td bgcolor="#FFFFFF">IP網路位址/子網路遮罩：ip.ip.ip.ip/mask.mask.mask.mask，如 127.0.0.1/255.255.255.0。</td>
					<td bgcolor="#FFFFFF">當使用者來源位置符合網路位址區段時才推播廣告。</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">使用者瀏覽器 (User agent regexp)</td>
					<td bgcolor="#FFFFFF">使用標準敘述語言(Regular expression)來比對使用者的瀏覽器版本，^Mozilla/4.? 。</td>
		 			<td bgcolor="#FFFFFF">當使用者瀏覽器版本符合設定時才推播廣告。</td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">星期 (Weekday 0-6)</td>
					<td bgcolor="#FFFFFF">星期中的每一天，0 代表星期日，6 代表星期六。</td>
					<td bgcolor="#FFFFFF">只在設定的當天才推播廣告。</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">網域名稱 (Domain)</td>
					<td bgcolor="#FFFFFF">網域名稱結尾，如：jp、.edu 或 google.com。</td>
					<td bgcolor="#FFFFFF">當使用者來源網域名稱符合設定時才推播廣告。</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">來源代碼 (Source)</td>
					<td bgcolor="#FFFFFF">各網頁自定的來源代碼。</td>
					<td bgcolor="#FFFFFF">當網頁的來源代碼符合設定時才推播廣告。</td>
				</tr>
                <tr> 
                    <td bgcolor="#FFFFFF">時間 (Time 00-23)</td>
                    <td bgcolor="#FFFFFF">依二十四小時制的時間，00 代表午夜，23 代表晚上十一點。</td>
                    <td bgcolor="#FFFFFF">只在設定的時間才推播廣告。</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>舉例來講，如果您只想要在週末時再推播廣告，您可以加入兩組推播條件：</p>
<ul>
	<li>星期 (Weekday 0-6)，<? echo $strAllow; ?>，參數 6 (代表星期六)</li>
	<li>星期 (Weekday 0-6)，<? echo $strAllow; ?>, 參數 0 (代表星期日)</li>
    <li>星期 (Weekday 0-6), <? echo $strDeny; ?>, 參數 * (代表整個星期)</li>
</ul>
在這個例子中，您並不需要特別加入最後一組「星期 (Weekday 0-6)」的推播條件設定，
因為當同一類型推播條件全部都不符合時，就會自動加入上述最後一行的推播條件。

<p>另外一個例子，如果要在每天晚上五點到八點推播廣告，要加入如下的推播條件設定：</p>
<ul>
    <li>時間 (Time)，<? echo $strAllow; ?>，參數 17</li>  (晚上 5:00 到晚上 5:59)
    <li>時間 (Time)，<? echo $strAllow; ?>，參數 18</li>  (晚上 6:00 到晚上 6:59)
    <li>時間 (Time)，<? echo $strAllow; ?>，參數 19</li>  (晚上 7:00 到晚上 7:59)
    <li>時間 (Time)，<? echo $strDeny; ?>，參數 * (整天)</li>
</ul>
<?
// EOF english doc file for Banner ACL administration
?>
