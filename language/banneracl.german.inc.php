<?
// banneracl.german.inc.php
// fixed by silicon (silicon@ins.at)
// german doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
    <TR>
        <TD bgcolor="#CCCCCC">
            <table width="100%" cellspacing="1" cellpadding="5">
                <tr>
                    <td bgcolor="#FFFFFF"><b>Regel</b></td>
                    <td bgcolor="#FFFFFF"><b>Optionen</b></td>
                    <td bgcolor="#FFFFFF"><b>Beschreibung</b></td>
                </tr>
                <tr>
                    <td bgcolor="#FFFFFF">Client IP</td>
                    <td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask, z.B. 127.0.0.1/255.255.255.0</td>
                    <td bgcolor="#FFFFFF">Banner nur in einer bestimmten IP-Region anzeigen.</td>
                </tr>
                <tr>
                    <td bgcolor="#FFFFFF">RegExp f&uuml;r Browser</td>
                    <td bgcolor="#FFFFFF">Regular expression bestimmt Browser, z.B. ^Mozilla/4.? </td>
                    <td bgcolor="#FFFFFF">Banner nur bei bestimmten Browsern zeigen.</td>
                </tr>
                <tr>
                    <td bgcolor="#FFFFFF">Wochentag (0-6)</td>
                    <td bgcolor="#FFFFFF">Wochentag, von 0 (= Sonntag) bis 6 (= Samstag)</td>
                    <td bgcolor="#FFFFFF">Banner nur an bestimmten Wochentagen zeigen.</td>
                </tr>
                <tr>
                    <td bgcolor="#FFFFFF">Domain</td>
                    <td bgcolor="#FFFFFF">Domain-Endung (zB. .at, .edu, oder google.com)</td>
                    <td bgcolor="#FFFFFF">Banner nur an Benutzer bestimmter Domains zeigen.</td>
                </tr>
                <tr>
                    <td bgcolor="#FFFFFF">Quelle</td>
                    <td bgcolor="#FFFFFF">Name der Quellseite</td>
                    <td bgcolor="#FFFFFF">Banner nur auf bestimmten Seiten zeigen.</td>
                </tr>
        <tr>
            <td bgcolor="#FFFFFF">Time (0-23)</td>
            <td bgcolor="#FFFFFF">Stunde, von 0 (= mitternacht) bis 23 (= 23:00)</td>
            <td bgcolor="#FFFFFF">Banner nur zu bestimmten Stunden zeigen.</td>
        </tr>
            </table>
        </TD>
    </TR>
</table>
<p>Wenn Sie zum Beispiel ein Banner nur an Wochenenden zeigen wollen geben Sie die folgenden beiden ACL-Werte ein:</p>
<ul>
    <li>Wochentag (0-6), <? echo $strAllow; ?>, Option 6 (f&uuml;r Samstag)</li>
    <li>Wochentag (0-6), <? echo $strAllow; ?>, Option 0 (f&uuml;r Sonntag)</li>
    <li>Wochentag (0-6), <? echo $strDeny; ?>, Option * (f&uuml;r jeden Tag)</li>
</ul>
Anmerkung: der letzte Eintrag muss nicht unbedingt ein &quot;Wochentag&quot; Wert sein.  Jede <? echo $strDeny; ?> *
ACL reicht aus um das Banner zu blocken, wenn kein zugeordnetes <? echo $strAllow; ?> Argument zutrifft.

<p>Um ein Banner zwischen 17:00 und 20:00 zu zeigen:</p>
<ul>
    <li>Time, <? echo $strAllow; ?>, Option 17</li>  (17:00 - 17:59)
    <li>Time, <? echo $strAllow; ?>, Option 18</li>  (18:00 - 18:59)
    <li>Time, <? echo $strAllow; ?>, Option 19</li>  (19:00pm - 19:59pm)
    <li>Time, <? echo $strDeny; ?>, Option * (f&uuml;r jede Zeit)</li>
</ul>
<?
// EOF german doc file for Banner ACL administration
?>
