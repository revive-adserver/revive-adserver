<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
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
define ("phpAds_Affiliate", 4);


// Define client permissions bitwise, so 1, 2, 4, 8, 16, etc.
define ("phpAds_ModifyInfo", 1);
define ("phpAds_ModifyBanner", 2);
define ("phpAds_AddBanner", 4);
define ("phpAds_DisableBanner", 8);
define ("phpAds_ActivateBanner", 16);


// Define affiliate permissions bitwise, so 1, 2, 4, 8, 16, etc.
define ("phpAds_LinkBanners", 2);
define ("phpAds_AddZone", 4);
define ("phpAds_DeleteZone", 8);
define ("phpAds_EditZone", 16);


/*********************************************************/
/* Start or continue current session                     */
/*********************************************************/

function phpAds_Start()
{
	global $phpAds_config;
	global $Session;
	global $phpAds_productname;
	
	phpAds_SessionDataFetch();
	
	if ((!phpAds_isLoggedIn() || phpAds_SuppliedCredentials()) && !defined('phpAds_installing'))
	{
		// Load preliminary language settings
		@include (phpAds_path.'/language/english/default.lang.php');
		if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php'))
			@include (phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php');
		
		phpAds_SessionDataRegister(phpAds_Login());
	}
	
	// Overwrite certain preset preferences
	if (isset($Session['language']) && $Session['language'] != '' && $Session['language'] != $phpAds_config['language'])
	{
		$phpAds_config['language'] = $Session['language'];
	}
}



/*********************************************************/
/* Stop current session                                  */
/*********************************************************/

function phpAds_Logout()
{
	global $phpAds_config;
	
	phpAds_SessionDataDestroy();
	
	// Return to the login screen
	header ("Location: index.php");
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
		phpAds_Die ($strAccessDenied, $strNotAdmin);
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

function phpAds_getUserID ()
{
	global $Session;
	return ($Session['userid']);
}








/*********************************************************/
/* Private functions                                     */
/*********************************************************/

function phpAds_Login()
{
	global $phpAds_config;
	global $strPasswordWrong, $strEnableCookies, $strEnterBoth;
	
	global $HTTP_COOKIE_VARS;
	global $HTTP_POST_VARS;
	
	if (phpAds_SuppliedCredentials())
	{
		// Trim spaces from input
		$username  = trim($HTTP_POST_VARS['phpAds_username']);
		$password  = trim($HTTP_POST_VARS['phpAds_password']);
		$md5digest = trim($HTTP_POST_VARS['phpAds_md5']);
		
		// Add slashes to input if needed
		if (!ini_get ('magic_quotes_gpc'))
		{
			$username  = addslashes($username);
			$password  = addslashes($password);
			$md5digest = addslashes($md5digest);
		}
		
		// Convert plain text password to md5 digest
		if ($md5digest == '' && $password != '')
			$md5digest = md5($password);
		
		
		
		// Exit if not both username and password are given
		if ($md5digest == '' ||	$md5digest == md5('') || $username  == '')
		{
			$HTTP_COOKIE_VARS['sessionID'] = phpAds_SessionStart();
			phpAds_LoginScreen($strEnterBoth, $HTTP_COOKIE_VARS['sessionID']);
		}
		
		// Exit if cookies are disabled
		if ($HTTP_COOKIE_VARS['SessionID'] != $HTTP_POST_VARS['phpAds_cookiecheck'])
		{
			$HTTP_COOKIE_VARS['sessionID'] = phpAds_SessionStart();
			phpAds_LoginScreen($strEnableCookies, $HTTP_COOKIE_VARS['sessionID']);
		}
		
		
		
		if (phpAds_isAdmin($username, $md5digest))
		{
			// User is Administrator
			return (array ("usertype" 		=> phpAds_Admin,
						   "loggedin" 		=> "t",
						   "username" 		=> $username)
			       );
		}
		else
		{
			// Check client table
			
			$res = phpAds_dbQuery("
				SELECT
					clientid,
					permissions,
					language
				FROM
					".$phpAds_config['tbl_clients']."
				WHERE
					clientusername = '".$username."'
					AND MD5(clientpassword) = '".$md5digest."'
			") or phpAds_sqlDie();
			
			
			if (phpAds_dbNumRows($res) > 0)
			{
				// User found with correct password
				$row = phpAds_dbFetchArray($res);
				
				return (array ("usertype" 		=> phpAds_Client,
							   "loggedin" 		=> "t",
							   "username" 		=> $username,
							   "userid" 		=> $row['clientid'],
							   "permissions" 	=> $row['permissions'],
							   "language" 		=> $row['language'])
				       );
			}
			else
			{
				$res = phpAds_dbQuery("
					SELECT
						affiliateid,
						permissions,
						language
					FROM
						".$phpAds_config['tbl_affiliates']."
					WHERE
						username = '".$username."'
						AND MD5(password) = '".$md5digest."'
					");
				
				if ($res && phpAds_dbNumRows($res) > 0)
				{
					// User found with correct password
					$row = phpAds_dbFetchArray($res);
					
					return (array ("usertype" 		=> phpAds_Affiliate,
								   "loggedin" 		=> "t",
								   "username" 		=> $username,
								   "userid" 		=> $row['affiliateid'],
								   "permissions" 	=> $row['permissions'],
								   "language" 		=> $row['language'])
					       );
				}
				else
				{
					// Password is not correct or user is not known
					
					// Set the session ID now, some server do not support setting a cookie during a redirect
					$HTTP_COOKIE_VARS['sessionID'] = phpAds_SessionStart();
					phpAds_LoginScreen($strPasswordWrong, $HTTP_COOKIE_VARS['sessionID']);
				}
			}
		}
	}
	else
	{
		// User has not supplied credentials yet
		
		// Set the session ID now, some server do not support setting a cookie during a redirect
		$HTTP_COOKIE_VARS['sessionID'] = phpAds_SessionStart();
		phpAds_LoginScreen('', $HTTP_COOKIE_VARS['sessionID']);
	}
}


function phpAds_IsLoggedIn()
{
	global $Session;
	return (isset($Session['loggedin']) ? ($Session['loggedin'] == "t") : false);
}

function phpAds_SuppliedCredentials()
{
	global $HTTP_POST_VARS;
	
	return (isset($HTTP_POST_VARS['phpAds_username']) &&
		    isset($HTTP_POST_VARS['phpAds_password']) &&
			isset($HTTP_POST_VARS['phpAds_md5']));
}



function phpAds_isAdmin($username, $md5)
{
	global $phpAds_config;
	
	return ($username == $phpAds_config['admin'] && $md5 == md5($phpAds_config['admin_pw']));
}



function phpAds_LoginScreen($message='', $SessionID=0)
{
	global $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS;
	global $phpAds_config, $phpAds_productname;
	global $strUsername, $strPassword, $strLogin, $strWelcomeTo, $strEnterUsername, $strNoAdminInteface;
	
	phpAds_PageHeader(phpAds_Login);
	
	if ($phpAds_config['ui_enabled'] == true)
	{
		echo "<br>";
		phpAds_ShowBreak();
		echo "<br>";
		
		echo "<form name='login' method='post' onSubmit='return login_md5(this);' action='".basename($HTTP_SERVER_VARS['PHP_SELF']);
		echo (isset($HTTP_SERVER_VARS['QUERY_STRING']) && $HTTP_SERVER_VARS['QUERY_STRING'] != '' ? '?'.$HTTP_SERVER_VARS['QUERY_STRING'] : '')."'>";
		echo "<input type='hidden' name='phpAds_cookiecheck' value='".$HTTP_COOKIE_VARS['SessionID']."'>";
		echo "<input type='hidden' name='phpAds_md5' value=''>";
		echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr>";
		echo "<td width='80' valign='bottom'><img src='images/login-welcome.gif'>&nbsp;&nbsp;</td>";
		echo "<td width='100%' valign='bottom'>";
		echo "<span class='tab-s'>".$strWelcomeTo." ".(isset($phpAds_config['name']) && $phpAds_config['name'] != '' ? $phpAds_config['name'] : $phpAds_productname)."</span><br>";
		echo "<span class='install'>".$strEnterUsername."</span><br>";
		echo "<img src='images/break-el.gif' width='400' height='1' vspace='8'>";	
		echo "</td></tr><tr><td>&nbsp;</td><td>";
		echo "<table cellpadding='0' cellspacing='0' border='0'>";
		
		echo "<tr height='24'><td>".$strUsername.":&nbsp;</td><td><input class='flat' type='text' name='phpAds_username'></td></tr>";
		echo "<tr height='24'><td>".$strPassword.":&nbsp;</td><td><input class='flat' type='password' name='phpAds_password'></td></tr>";
		echo "<tr height='24'><td>&nbsp;</td><td><input type='submit' value='".$strLogin."'></td></tr>";
		echo "</table>";
		echo "</td></tr></table>";
		echo "</form>";
		
		phpAds_ShowBreak();
		
		if ($message != "")
		{
			echo "<img src='images/error.gif'>&nbsp;&nbsp;<span class='tab-r'>$message</span>";
		}
		
		echo "<script language='JavaScript' src='md5.js'></script>";
		echo "<script language='JavaScript'>";
		?>
<!--
		function login_md5(o) {
			if (o.phpAds_password.value != '')
			{
				o.phpAds_md5.value = MD5(o.phpAds_password.value);
				o.phpAds_password.value = '';
			}
			
			return true;
		}
				
		login_focus();
//-->
		<?php
		echo "</script>";
	}
	else
	{
		phpAds_ShowBreak();
		echo "<br><img src='images/info.gif' align='absmiddle'>&nbsp;";
		echo $strNoAdminInteface;
	}
	
	
	phpAds_PageFooter();
	exit;
}


?>