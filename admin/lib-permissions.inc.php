<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer                                 */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("lib-sessions.inc.php");


// Define usertypes bitwise, so 1, 2, 4, 8, 16, etc.
define ("phpAds_Admin", 1);
define ("phpAds_Client", 2);


// Define permissions bitwise, so 1, 2, 4, 8, 16, etc.
define ("phpAds_ModifyInfo", 1);
define ("phpAds_ModifyBanner", 2);
define ("phpAds_AddBanner", 4);
define ("phpAds_DisableBanner", 8);
define ("phpAds_ActivateBanner", 16);



/*********************************************************/
/* Start or continue current session                     */
/*********************************************************/

function phpAds_Start()
{
	global $Session, $phpAds_language;
	
	phpAds_SessionDataFetch();
	
	if (!phpAds_isLoggedIn() || phpAds_SuppliedCredentials())
	{
		// Load preliminary language settings
		require("../language/$phpAds_language.inc.php");
		
		phpAds_SessionDataRegister(phpAds_Login());
	}
	
	// Overwrite certain preset preferences
	if (isset($Session['language']) && $Session['language'] != '' && $Session['language'] != $phpAds_language)
	{
		$phpAds_language = $Session['language'];
	}
}



/*********************************************************/
/* Stop current session                                  */
/*********************************************************/

function phpAds_Logout()
{
	global $phpAds_url_prefix;

	phpAds_SessionDataDestroy();
	
	// Return to the login screen
	header ("Location: $phpAds_url_prefix/admin/index.php");
}



/*********************************************************/
/* Check if user has permission to view this page        */
/*********************************************************/

function phpAds_checkAccess ($allowed)
{
	global $Session;
	global $strNotAdmin, $strAccessDenied;
	
	if (!($allowed & $Session['usertype']))
	{
		// No permission to access this page!
		phpAds_PageHeader(0);
		php_die ($strAccessDenied, $strNotAdmin);
	}
}



/*********************************************************/
/* Check if user is of a certain usertype                */
/*********************************************************/

function phpAds_isUser ($allowed)
{
	global $Session;
	
	if (isset($Session['usertype']))
		return ($allowed & (int)$Session['usertype']);
	else
		return false;
}



/*********************************************************/
/* Check if user has clearance to do a certain task      */
/*********************************************************/

function phpAds_isAllowed ($allowed)
{
	global $Session;
	return ($allowed & (int)$Session['permissions']);
}



/*********************************************************/
/* Get the ID of the current user                        */
/*********************************************************/

function phpAds_clientID ()
{
	global $Session;
	return ($Session['clientID']);
}








/*********************************************************/
/* Private functions                                     */
/*********************************************************/

function phpAds_Login()
{
	global $phpAds_tbl_clients;
	global $phpAds_username, $phpAds_password, $phpAds_cookiecheck;
	global $strPasswordWrong;
	global $SessionID;
	
	if (phpAds_SuppliedCredentials())
	{
		if ($SessionID != $phpAds_cookiecheck)
		{
			// Cookiecheck failed
				$sessionID = phpAds_SessionStart();
				phpAds_LoginScreen("You need to enable cookies before you can use phpAdsNew", $sessionID);
		}
		
		if (phpAds_isAdmin($phpAds_username, $phpAds_password))
		{
			// User is Administrator
			return (array ("usertype" 		=> phpAds_Admin,
						   "loggedin" 		=> "true",
						   "username" 		=> $phpAds_username,
						   "password" 		=> $phpAds_password,
						   "stats_compact" 	=> "false",
						   "stats_view" 	=> "all",
						   "stats_order" 	=> "bannerid")
			       );
		}
		else
		{
			$res = db_query("
				SELECT
					clientID,
					permissions,
					language
				FROM
					$phpAds_tbl_clients
				WHERE
					clientusername = '$phpAds_username'
					AND clientpassword = '$phpAds_password'
				") or mysql_die();
				
			
			if (mysql_num_rows($res) > 0 && $phpAds_username != "" && $phpAds_password != "")
			{
				// User found with correct password
				$row = mysql_fetch_array($res);
				
				return (array ("usertype" 		=> phpAds_Client,
							   "loggedin" 		=> "true",
							   "username" 		=> $phpAds_username,
							   "password" 		=> $phpAds_password,
							   "clientID" 		=> $row['clientID'],
							   "permissions" 	=> $row['permissions'],
							   "language" 		=> $row['language'],
							   "stats_compact" 	=> "false",
							   "stats_view" 	=> "all",
							   "stats_order" 	=> "bannerid")
				       );
			}
			else
			{
				// Password is not correct or user is not known
				
				// Set the session ID now, some server do not support setting a cookie during a redirect
				$sessionID = phpAds_SessionStart();
				phpAds_LoginScreen($strPasswordWrong, $sessionID);
			}
		}
	}
	else
	{
		// User has not supplied credentials yet
		
		// Set the session ID now, some server do not support setting a cookie during a redirect
		$sessionID = phpAds_SessionStart();
		phpAds_LoginScreen('', $sessionID);
	}
}


function phpAds_IsLoggedIn()
{
	global $Session;
	return (isset($Session['loggedin']) ? ($Session['loggedin'] == "true") : false);
}


function phpAds_SuppliedCredentials()
{
	global $phpAds_username, $phpAds_password;
	
	return (isset($phpAds_username) && isset($phpAds_password));
}



function phpAds_isAdmin($username, $password)
{
	global $phpAds_admin, $phpAds_admin_pw;
	
	return ($username == $phpAds_admin && $password == $phpAds_admin_pw);
}



function phpAds_LoginScreen($message='', $SessionID=0)
{
	phpAds_PageHeader(0);
	if ($message != "") echo "<b>$message</b><br>";
	?>
	<form method="post" action="<?echo basename($GLOBALS["PHP_SELF"]); echo $GLOBALS["QUERY_STRING"] != "" ? "?".$GLOBALS["QUERY_STRING"] : "" ;?>" >
	<table>
		<input type="hidden" name="phpAds_cookiecheck" value="<?echo $SessionID; ?>">
		<tr>
			<td><?echo $GLOBALS["strUsername"];?>:</td>
			<td><input type="text" name="phpAds_username"></td>
		</tr>
		<tr>
			<td><?echo $GLOBALS["strPassword"];?>:</td>
			<td><input type="password" name="phpAds_password"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" VALUE="<? echo $GLOBALS['strLogin']; ?>"></td>
		</tr>
	</table>
	</form>
	<?	
	
	phpAds_PageFooter();
	exit;
}


?>
