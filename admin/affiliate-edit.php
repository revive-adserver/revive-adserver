<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-zones.inc.php");
require ("lib-languages.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	$affiliateid = phpAds_getUserID();
}



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{
	if (phpAds_isUser(phpAds_Admin))
	{
		$error = false;
		$errormessage ='';
		
		if (isset($username) && $username != '')
		{
			$res = phpAds_dbQuery("
				SELECT
					*
				FROM
					".$phpAds_config['tbl_clients']."
				WHERE
					clientusername = '$username'
			") or phpAds_sqlDie(); 
			
			$duplicateclient = (phpAds_dbNumRows($res) > 0);
			$duplicateadmin  = ($phpAds_config['admin'] == $username);
			
			if ($affiliateid == '')
			{
				$res = phpAds_dbQuery("
					SELECT
						*
					FROM
						".$phpAds_config['tbl_affiliates']."
					WHERE
						username = '$username'
				") or phpAds_sqlDie(); 
				
				if (phpAds_dbNumRows($res) > 0 || $duplicateclient || $duplicateadmin)
				{
					$error = true;
					$errormessage = 'duplicateusername';
					
					$username = '';
					$password = '';
				}
			}
			else
			{
				$res = phpAds_dbQuery("
					SELECT
						*
					FROM
						".$phpAds_config['tbl_affiliates']."
					WHERE
						username = '$username' AND
						affiliateid != '$affiliateid'
					") or phpAds_sqlDie(); 
				
				if (phpAds_dbNumRows($res) > 0 || $duplicateclient || $duplicateadmin)
				{
					$error = true;
					$errormessage = 'duplicateusername';
					
					$username = '';
					$password = '';
				}
			}
		}
		
		$res = phpAds_dbQuery("
			REPLACE INTO
				".$phpAds_config['tbl_affiliates']."
				(
				affiliateid,
				name,
				website,
				contact,
				email,
				language,
				username,
				password
				)
			 VALUES (
			 	'".$affiliateid."',
				'".$name."',
				'".$website."',
				'".$contact."',
				'".$email."',
				'".$language."',
				'".$username."',
				'".$password."'
				)
			") or phpAds_sqlDie();
		
		if ($error == false)
		{
			if (!$affiliateid)
			{
				$affiliateid = phpAds_dbInsertID();
				
				header ("Location: zone-edit.php?affiliateid=$affiliateid");
				exit;
			}
			else
			{
				header ("Location: affiliate-index.php");
				exit;
			}
		}
		else
		{
			if (!$affiliateid)
				$affiliateid = phpAds_dbInsertID();
			
			header ("Location: affiliate-edit.php?affiliateid=$affiliateid&errormessage=".urlencode($errormessage));
			exit;
		}
	}
	else
	{
		$res = phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_affiliates']."
			SET
				name='".$name."',
				website='".$website."',
				contact='".$contact."',
				email='".$email."',
				language='".$language."',
				password='".$password."'
			WHERE
				affiliateid=".$affiliateid."
			") or phpAds_sqlDie();
		
		header ("Location: zone-index.php?affiliateid=".$affiliateid);
		exit;
	}
}


/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if ($affiliateid != "")
{
	if (phpAds_isUser(phpAds_Admin))
	{
		$extra = '';
		
		$res = phpAds_dbQuery("
			SELECT
				*
			FROM
				".$phpAds_config['tbl_affiliates']."
			") or phpAds_sqlDie();
		
		$extra = "";
		while ($row = phpAds_dbFetchArray($res))
		{
			if ($affiliateid == $row['affiliateid'])
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
			else
				$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
			
			$extra .= "<a href='affiliate-edit.php?affiliateid=". $row['affiliateid']."'>".phpAds_buildAffiliateName ($row['affiliateid'], $row['name'])."</a>";
			$extra .= "<br>"; 
		}
		$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
		
		phpAds_PageHeader("4.2.2", $extra);
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
			phpAds_ShowSections(array("4.2.2", "4.2.3"));
	}
	else
	{
		phpAds_PageHeader("2.2");
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
			phpAds_ShowSections(array("2.1", "2.2"));
	}
}
else
{
	phpAds_PageHeader("4.2.1");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
		phpAds_ShowSections(array("4.2.1"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($affiliateid) && $affiliateid != '')
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_affiliates']."
		WHERE
			affiliateid = ".$affiliateid."
		") or phpAds_sqlDie();
	
	if (phpAds_dbNumRows($res))
	{
		$affiliate = phpAds_dbFetchArray($res);
	}
}

?>


<br><br>

<form name="affiliateform" method="post" action="affiliate-edit.php">
<input type="hidden" name="affiliateid" value="<?php if(isset($affiliateid) && $affiliateid != '') echo $affiliateid;?>">

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strBasicInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strName;?></td>
		<td><input type="text" name="name" size='35' style="width:350px;" value="<?php if(isset($affiliate["name"]))echo $affiliate["name"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'>Website</td>
		<td><input type="text" name="website" size='35' style="width:350px;" value="<?php if(isset($affiliate["website"]))echo $affiliate["website"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strContact;?></td>
		<td><input type="text" name="contact" size='35' style="width:350px;" value="<?php if(isset($affiliate["contact"]))echo $affiliate["contact"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strEMail;?></td>
		<td><input type="text" name="email" size='35' style="width:350px;" value="<?php if(isset($affiliate["email"]))echo $affiliate["email"];?>"></td>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $GLOBALS['strLanguage']; ?></td>	
		<td>
			<select name="language">
		<?php
		echo "<option value='' SELECTED>".$GLOBALS['strDefault']."</option>\n"; 
		
		$languages = phpAds_AvailableLanguages();
		
		while (list($k, $v) = each($languages))
			echo "<option value='$k'>$v</option>\n";

		?>
			</select>
		</td>
	</tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>

<br><br>
<br><br>

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='3'><b><?php echo $strLoginInformation;?></b></td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>

	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
			<?php
				if (isset($errormessage) && $errormessage == 'duplicateusername')
				{
					?>
	<tr><td width='30'>&nbsp;</td>
	    <td height='10' colspan='2'><img src='images/error.gif' align='absmiddle'>&nbsp;<font color='#AA0000'><b><?php echo $strDuplicateClientName; ?></b></font></td></tr>
	<tr><td height='10' colspan='3'>&nbsp;</td></tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>	
					<?php
				}
			?>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?echo $strUsername;?></td>
		<?php
		if (phpAds_isUser(phpAds_Admin))
		{
			?>
			<td width='370'><input type="text" name="username" size='25' value="<?php if(isset($affiliate["username"])) echo $affiliate["username"];?>">
			<?php
		}
		else 
		{
			?>
			<td width='370'><?php if(isset($affiliate["username"]))echo $affiliate["username"];?>
			<?php
		}
		?>
	</tr>
	<tr>
		<td><img src='images/spacer.gif' height='1' width='100%'></td>
		<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
	</tr>
	<tr>
		<td width='30'>&nbsp;</td>
		<td width='200'><?php echo $strPassword;?></td>
		<td width='370'><input type="text" name="password" size='25' value="<?php if(isset($affiliate["password"])) echo $affiliate["password"];?>">
	</tr>
	<tr><td height='10' colspan='2'>&nbsp;</td></tr>
	<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
</table>
		
	
<br><br>

<input type="submit" name="submit" value="<?php if (isset($affiliateid) && $affiliateid != '') echo $strSaveChanges; else echo ' Next > '; ?>">
</form>



<?php

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
