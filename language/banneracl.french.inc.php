<?
// english doc file for Banner ACL administration
?>
<BR>
<table border="0" width="100%">
	<TR>
		<TD bgcolor="#CCCCCC">
			<table width="100%" cellspacing="1" cellpadding="5">
				<tr> 
					
          <td bgcolor="#FFFFFF"><b>Titre</b></td>
					<td bgcolor="#FFFFFF"><b>Argument</b></td>
					<td bgcolor="#FFFFFF"><b>Description</b></td>
				</tr>
				<tr> 
					<td bgcolor="#FFFFFF">Client IP</td>
					
          <td bgcolor="#FFFFFF">IP net/mask: ip.ip.ip.ip/mask.mask.mask.mask (exemple 
            : 127.0.0.1/255.255.255.0)</td>
					
          <td bgcolor="#FFFFFF">Affiche la banni&egrave;re uniquement pour certaines 
            IP </td>
				</tr>
				<tr> 
					
          <td bgcolor="#FFFFFF">Navigateur regexp</td>
					
          <td bgcolor="#FFFFFF">Expression r&eacute;guli&egrave;re correspondant 
            &agrave; un navigateur (exemple ^Mozilla/4.?)</td>
		 			
          <td bgcolor="#FFFFFF">Affiche la banni&egrave;re uniquement pour certains 
            navigateurs </td>
				</tr>
				<tr> 
					
          <td bgcolor="#FFFFFF">Jour de la semaine (0-6)</td>
          <td bgcolor="#FFFFFF">Jour de la semaine, De 0 = Dimanche &agrave; 6 
            = Samedi </td>
          <td bgcolor="#FFFFFF">Affiche la banni&egrave;re uniquement un jour 
            sp&eacute;cifique </td>
				</tr>
				<tr>
					
          <td bgcolor="#FFFFFF">Domaine</td>
					
          <td bgcolor="#FFFFFF">Suffixe de domaine (ex : .fr, .edu, ou google.com)</td>
					
          <td bgcolor="#FFFFFF">Affiche la banni&egrave;re uniquement pour certains 
            domaines </td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">Source</td>
					
          <td bgcolor="#FFFFFF">Nom de la page source</td>
					
          <td bgcolor="#FFFFFF">Affiche la banni&egrave;re uniquement pour certaines 
            pages </td>
				</tr>
                <tr> 
                    
          <td bgcolor="#FFFFFF">Heure (0-23)</td>
                    
          <td bgcolor="#FFFFFF">Heure du jour, De 0 = minuit &agrave; 23 = 23:00</td>
                    
          <td bgcolor="#FFFFFF">Affiche la banni&egrave;re uniquement &agrave; 
            certaines heures</td>
                </tr>
			</table>
		</TD>
	</TR>
</table>
<p>Par exemple, si vous voulez afficher une banni&egrave;re uniquement le week-end, 
  vous aurez 2 ACL :</p>
<ul>
  <li>Jour de la Semaine (0-6), 
    <? echo $strAllow; ?>
    , argument 6 (Samedi)</li>
  <li>Jour de la Semaine (0-6), 
    <? echo $strAllow; ?>
    , argument 0 (Dimanche)</li>
  <li>Jour de la Semaine (0-6), 
    <? echo $strDeny; ?>
    , argument * (Pour tous les jours)</li>
</ul>
Notez que le dernier champ n'a pas forc&eacute;ment besoin d'&ecirc;tre positionn&eacute; 
sur &quot;Jour de la Semaine&quot;. N'importe quel ACL 
<? echo $strDeny; ?>
* suffira &agrave; interdire toute banni&egrave;re qui ne serait pas d&eacute;j&agrave; 
associ&eacute; avec un champ 
<? echo $strAllow; ?>
. 
<p>Pour afficher la banni&egrave;re entre 17 heures et 20 heures:</p>
<ul>
  <li>Heure, 
    <? echo $strAllow; ?>
    , argument 17</li>
  (17:00pm - 17:59pm) 
  <li>Heure, 
    <? echo $strAllow; ?>
    , argument 18</li>
  (18:00pm - 18:59pm) 
  <li>Heure, 
    <? echo $strAllow; ?>
    , argument 19</li>
  (19:00pm - 19:59pm) 
  <li>Heure, 
    <? echo $strDeny; ?>
    , argument * (Pour toutes les heures)</li>
</ul>
<?
// EOF english doc file for Banner ACL administration
?>
