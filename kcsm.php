<?php

// $Id$

/*	Kyle Cordes's Session Management for PHP3
	"KCSM"

	MySQL test version 0.2

	I now set a "browser session" cookie instead of a fixed life span cookie.
	My session expiration is "60 minutes of non-use"; while the user is actively
	using the system the session does not expire.
*/

function kc_login()
{
	global $phpAds_hostname, $phpAds_mysqluser, $phpAds_mysqlpassword, $phpAds_db, $username, $password, $phpAds_admin, $phpAds_admin_pw, $strUsername, $strPassword, $PHP_SELF, $clientID, $phpAds_tbl_session, $phpAds_tbl_clients;
	if (isset($username) && $username == $phpAds_admin && $password == $phpAds_admin_pw)
		return(true);
	if (isset($username) && isset($password) && !strstr($PHP_SELF, "admin"))
	{
		$res = db_query("
			SELECT
				clientID
			FROM
				$phpAds_tbl_clients
			WHERE
				clientusername = '$username'
				AND clientpassword = '$password'
			") or mysql_die();
		if (mysql_num_rows($res) > 0)
		{
			$clientID = mysql_result($res, 0, 0);
			return (true);
		}
	}
	page_header($GLOBALS["strAuthentification"]);    
	?>
	<form method="post" action="<?echo basename($PHP_SELF);?>">
	<table>
		<tr>
			<td><?echo $strUsername;?>:</td>
			<td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td><?echo $strPassword;?>:</td>
			<td><input type="password" name="password"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" VALUE="<? echo $GLOBALS['strLogin']; ?>"></td>
		</tr>
	</table>
	</form>
	<?
	page_footer();
	return (false);
}

function kc_start()
{
	global $SessionID, $Session, $Session_onStart, $phpAds_tbl_session;
	register_shutdown_function("kc_end");

	// This has a potential security risk: if s/o guesses a valid (ie it's right now
	// stored in the session-table) SessionID, he won't be authenticated but 
	// automagically takes over this session.
	if(isset($SessionID) && !empty($SessionID))
	{
		$result = db_query("SELECT SessionData FROM $phpAds_tbl_session WHERE SessionID='$SessionID'" .
			" AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(LastUsed) < 3600") or mysql_die();
		if($row = mysql_fetch_array($result))
		{
			$Session = unserialize(stripslashes($row[0]));
			return;
		}
	}

	// else, new session
	if (kc_login())
	{
		$SessionID = uniqid("phpads");	// can put a prefix below per app if needed.
		$Session = array();
		$Session["username"] = $GLOBALS["username"];
		$Session["password"] = $GLOBALS["password"];
		if(isset($GLOBALS["clientID"]))
			$Session["clientID"] = $GLOBALS["clientID"];
		$url = parse_url($GLOBALS["phpAds_url_prefix"]);
		SetCookie("SessionID", $GLOBALS["SessionID"], 0, $url["path"]);
	}
	else
		exit;
}

function kc_end()
{
	global $SessionID, $Session, $phpAds_tbl_session;

	if(isset($SessionID))
		$foo = db_query("REPLACE INTO $phpAds_tbl_session VALUES ('$SessionID', '" .
			AddSlashes(serialize($Session)) . "', null )") or mysql_die();
	srand((double)microtime()*1000000);
	if(rand(1, 100) == 42)	// (randomly) purge old sessions
		$foo = db_query("DELETE FROM $phpAds_tbl_session WHERE UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(LastUsed) > 43200") or mysql_die();
}

function kc_abandon()
{
	global $SessionID, $Session, $phpAds_tbl_session;

	$foo = db_query("DELETE FROM $phpAds_tbl_session WHERE SessionID='$SessionID'") or mysql_die();

	$url = parse_url($GLOBALS["phpAds_url_prefix"]);
	SetCookie("SessionID", "", 0, $url["path"]);

	$Session = "";
	$SessionID = "";
	unset($SessionID);
	unset($Session);
}

function kc_auth_admin()
{
	global $Session, $phpAds_admin, $phpAds_admin_pw, $strAccessDenied, $strNotAdmin;

	// call the start function automatically:
	if (($Session["username"] != $phpAds_admin || $Session["password"] != $phpAds_admin_pw))
	{
		// php_die($strAccessDenied, "$strNotAdmin.");
		kc_abandon();
		header("Location: ./admin.php");
	}
}

kc_start();

?>
