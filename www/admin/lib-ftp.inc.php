<?php

/*----------------------------------------------------------------------*/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by TOMO <groove@spencernetwork.org>               */
/* For more information visit: http://www.phpadsnew.com                 */
/*----------------------------------------------------------------------*/



$ftp_debug = FALSE;
$ftp_umask = 0022;
$ftp_timeout = 30;


if (!defined("FTP_BINARY")) {
	define("FTP_BINARY", 1);
}
if (!defined("FTP_ASCII")) {
	define("FTP_ASCII", 0);
}


function ftp_connect($server, $port = 21)
{
	global $ftp_timeout;
	
	ftp_debug("Trying to ".$server.":".$port." ...\n");
	$sock = @fsockopen($server, $port, $errno, $errstr, $ftp_timeout);
	if ($sock && ftp_ok($sock)) {
		ftp_debug("Connected to remote host \"".$server.":".$port."\"\n");
		return $sock;
	} else {
		ftp_debug("Cannot connect to remote host \"".$server.":".$port."\"\n");
		ftp_debug("Error : ".$errstr." (".$errno.")\n");
		return FALSE;
	}
}

function ftp_login($sock, $user, $pass)
{
	ftp_putcmd($sock, "USER", $user);
	if (!ftp_ok($sock)) {
		return FALSE;
	}
	ftp_putcmd($sock, "PASS", $pass);
	if (ftp_ok($sock)) {
		ftp_debug("Authentication succeeded\n");
		return TRUE;
	} else {
		ftp_debug("Error : Authentication failed\n");
		return FALSE;
	}
}

function ftp_pwd($sock)
{
	ftp_putcmd($sock, "PWD");
	$response = ftp_getresp($sock);
	if (!$response) {
		return FALSE;
	}
	if (ereg("^[123]", $response)) {
		return ereg_replace("^[0-9]{3} \"(.+)\" .+\r\n", "\\1", $response);
	} else {
		return FALSE;
	}
}

function ftp_size($sock, $pathname)
{
	ftp_putcmd($sock, "SIZE", $pathname);
	$response = ftp_getresp($sock);
	if (!$response) {
		return FALSE;
	}
	if (ereg("^[123]", $response)) {
		return ereg_replace("^[0-9]{3} ([0-9]+)\r\n", "\\1", $response);
	} else {
		return -1;
	}
}

function ftp_mdtm($sock, $pathname)
{
	ftp_putcmd($sock, "MDTM", $pathname);
	$response = ftp_getresp($sock);
	if (!$response) {
		return FALSE;
	}
	if (ereg("^[123]", $response)) {
		$mdtm = ereg_replace("^[0-9]{3} ([0-9]+)\r\n", "\\1", $response);
		list ($year, $mon, $day, $hour, $min, $sec) = sscanf($mdtm, "%4d%2d%2d%2d%2d%2d");
		$timestamp = mktime($hour, $min, $sec, $mon, $day, $year);
		return $timestamp;
	} else {
		return -1;
	}
}

function ftp_systype($sock)
{
	ftp_putcmd($sock, "SYST");
	$data = ftp_getresp($sock);
	if ($data) {
		$DATA = explode(" ", $data);
		return $DATA[1];
	} else {
		return FALSE;
	}
}

function ftp_cdup($sock)
{
	ftp_putcmd($sock, "CDUP");
	return ftp_ok($sock);
}

function ftp_chdir($sock, $dir)
{
	ftp_putcmd($sock, "CWD", $dir);
	return ftp_ok($sock);
}

function ftp_delete($sock, $pathname)
{
	ftp_putcmd($sock, "DELE", $pathname);
	return ftp_ok($sock);
}

function ftp_rmdir($sock, $pathname)
{
	ftp_putcmd($sock, "RMD", $pathname);
	return ftp_ok($sock);
}

function ftp_mkdir($sock, $pathname)
{
	ftp_putcmd($sock, "MKD", $pathname);
	return ftp_ok($sock);
}

function ftp_rename($sock, $from, $to)
{
	if (!ftp_file_exists($sock, $from)) {
		ftp_debug("Error : No such file or directory \"".$from."\"\n");
		return FALSE;
	}
	
	ftp_putcmd($sock, "RNFR", $from);
	
	if (!ftp_ok($sock)) {
		return FALSE;
	}
	
	ftp_putcmd($sock, "RNTO", $to);
	
	return ftp_ok($sock);
}

function ftp_nlist($sock, $arg = "", $pathname = "")
{
	ftp_putcmd($sock, "PASV");
	$string = ftp_getresp($sock);
	
	if ($arg == "") {
		$nlst = "NLST";
	} else {
		$nlst = "NLST ".$arg;
	}
	ftp_putcmd($sock, $nlst, $pathname);
	
	$sock_data = ftp_open_data_connection($string);
	if (!$sock_data) {
		return FALSE;
	}
	if (ftp_ok($sock)) {
		ftp_debug("Connected to remote host\n");
	} else {
		ftp_debug("Cannot connect to remote host\n");
		return FALSE;
	}
	
	while (!feof($sock_data)) {
		$list[] = ereg_replace("[\r\n]", "", fgets($sock_data, 512));
	}
	ftp_close_data_connection($sock_data);
	ftp_debug(implode("\n", $list));
	
	if (ftp_ok($sock)) {
		return $list;
	} else {
		return FALSE;
	}
}

function ftp_rawlist($sock, $pathname = "")
{
	ftp_putcmd($sock, "PASV");
	$response = ftp_getresp($sock);
	
	ftp_putcmd($sock, "LIST", $pathname);
	
	$sock_data = ftp_open_data_connection($response);
	if (!$sock_data) {
		return FALSE;
	}
	if (ftp_ok($sock)) {
		ftp_debug("Connected to remote host\n");
	} else {
		ftp_debug("Cannot connect to remote host\n");
		return FALSE;
	}
	
	while (!feof($sock_data)) {
		$list[] = ereg_replace("[\r\n]", "", fgets($sock_data, 512));
	}
	ftp_debug(implode("\n", $list));
	ftp_close_data_connection($sock_data);
	
	if (ftp_ok($sock)) {
		return $list;
	} else {
		return FALSE;
	}
}

function ftp_get($sock, $localfile, $remotefile, $mode = 1)
{
	global $ftp_umask;
	
	if ($mode) {
		$type = "I";
	} else {
		$type = "A";
	}
	
	if (!ftp_file_exists($sock, $remotefile)) {
		ftp_debug("Error : No such file or directory \"".$remotefile."\"\n");
		ftp_debug("Error : GET failed\n");
		return FALSE;
	}
	
	if (@file_exists($localfile)) {
		ftp_debug("Warning : local file will be overwritten\n");
	} else {
		umask($ftp_umask);
	}
	
	$fp = @fopen($localfile, "w");
	if (!$fp) {
		ftp_debug("Error : Cannot create \"".$localfile."\"");
		ftp_debug("Error : GET failed\n");
		return FALSE;
	}
	
	ftp_putcmd($sock, "PASV");
	$string = ftp_getresp($sock);
	
	ftp_putcmd($sock, "TYPE", $type);
	ftp_getresp($sock);
	
	ftp_putcmd($sock, "RETR", $remotefile);
	
	$sock_data = ftp_open_data_connection($string);
	if (!$sock_data) {
		return FALSE;
	}
	if (ftp_ok($sock)) {
		ftp_debug("Connected to remote host\n");
	} else {
		ftp_debug("Cannot connect to remote host\n");
		ftp_debug("Error : GET failed\n");
		return FALSE;
	}
	
	ftp_debug("Retrieving remote file \"".$remotefile."\" to local file \"".$localfile."\"\n");
	while (!feof($sock_data)) {
		fputs($fp, fread($sock_data, 4096));
	}
	fclose($fp);
	
	ftp_close_data_connection($sock_data);
	
	return ftp_ok($sock);
}

function ftp_fget($sock, $fp, $remotefile, $mode = 1)
{
	global $ftp_umask;
	
	if ($mode) {
		$type = "I";
	} else {
		$type = "A";
	}
	
	if (!ftp_file_exists($sock, $remotefile)) {
		ftp_debug("Error : No such file or directory \"".$remotefile."\"\n");
		ftp_debug("Error : GET failed\n");
		return FALSE;
	}
	
	ftp_putcmd($sock, "PASV");
	$string = ftp_getresp($sock);
	
	ftp_putcmd($sock, "TYPE", $type);
	ftp_getresp($sock);
	
	ftp_putcmd($sock, "RETR", $remotefile);
	
	$sock_data = ftp_open_data_connection($string);
	if (!$sock_data) {
		return FALSE;
	}
	if (ftp_ok($sock)) {
		ftp_debug("Connected to remote host\n");
	} else {
		ftp_debug("Cannot connect to remote host\n");
		ftp_debug("Error : GET failed\n");
		return FALSE;
	}
	
	ftp_debug("Retrieving remote file \"".$remotefile."\" to local file \"".$localfile."\"\n");
	while (!feof($sock_data)) {
		fputs($fp, fread($sock_data, 4096));
	}
	
	ftp_close_data_connection($sock_data);
	
	return ftp_ok($sock);
}

function ftp_put($sock, $remotefile, $localfile, $mode = 1)
{
	if ($mode) {
		$type = "I";
	} else {
		$type = "A";
	}
	
	if (!file_exists($localfile)) {
		ftp_debug("Error : No such file or directory \"".$localfile."\"\n");
		ftp_debug("Error : PUT failed\n");
		return FALSE;
	}
	
	$fp = @fopen($localfile, "r");
	if (!$fp) {
		ftp_debug("Cannot read file \"".$localfile."\"\n");
		ftp_debug("Error : PUT failed\n");
		return FALSE;
	}
	
	ftp_putcmd($sock, "PASV");
	$string = ftp_getresp($sock);
	
	ftp_putcmd($sock, "TYPE", $type);
	ftp_getresp($sock);
	
	if (ftp_file_exists($sock, $remotefile)) {
		ftp_debug("Warning : Remote file will be overwritten\n");
	}
	
	ftp_putcmd($sock, "STOR", $remotefile);
	
	$sock_data = ftp_open_data_connection($string);
	if (!$sock_data) {
		return FALSE;
	}
	if (ftp_ok($sock)) {
		ftp_debug("Connected to remote host\n");
	} else {
		ftp_debug("Cannot connect to remote host\n");
		ftp_debug("Error : PUT failed\n");
		return FALSE;
	}
	
	ftp_debug("Storing local file \"".$localfile."\" to remote file \"".$remotefile."\"\n");
	while (!feof($fp)) {
		fputs($sock_data, fread($fp, 4096));
	}
	fclose($fp);
	
	ftp_close_data_connection($sock_data);
	
	return ftp_ok($sock);
}

function ftp_fput($sock, $remotefile, $fp, $mode = 1)
{
	if ($mode) {
		$type = "I";
	} else {
		$type = "A";
	}
	
	ftp_putcmd($sock, "PASV");
	$string = ftp_getresp($sock);
	
	ftp_putcmd($sock, "TYPE", $type);
	ftp_getresp($sock);
	
	if (ftp_file_exists($sock, $remotefile)) {
		ftp_debug("Warning : Remote file will be overwritten\n");
	}
	
	ftp_putcmd($sock, "STOR", $remotefile);
	
	$sock_data = ftp_open_data_connection($string);
	if (!$sock_data) {
		return FALSE;
	}
	if (ftp_ok($sock)) {
		ftp_debug("Connected to remote host\n");
	} else {
		ftp_debug("Cannot connect to remote host\n");
		ftp_debug("Error : PUT failed\n");
		return FALSE;
	}
	
	ftp_debug("Storing local file \"".$localfile."\" to remote file \"".$remotefile."\"\n");
	while (!feof($fp)) {
		fputs($sock_data, fread($fp, 4096));
	}
	
	ftp_close_data_connection($sock_data);
	
	return ftp_ok($sock);
}

function ftp_site($sock, $command)
{
	ftp_putcmd($sock, "SITE", $command);
	return ftp_ok($sock);
}

function ftp_quit($sock)
{
	ftp_putcmd($sock, "QUIT");
	if (ftp_ok($sock) && fclose($sock)) {
		ftp_debug("Disconnected from remote host\n");
		return TRUE;
	} else {
		return FALSE;
	}
}

/* Private Functions */

function ftp_putcmd($sock, $cmd, $arg = "")
{
	if (!$sock) {
		return FALSE;
	}
	
	if ($arg != "") {
		$cmd = $cmd." ".$arg;
	}
	
	fputs($sock, $cmd."\r\n");
	ftp_debug("> ".$cmd."\n");
	
	return TRUE;
}

function ftp_getresp($sock)
{
	if (!$sock) {
		return FALSE;
	}
	
	$response = "";
	do {
		$res = fgets($sock, 512);
		$response .= $res;
	} while (substr($res, 3, 1) != " ");
	
	ftp_debug(str_replace("\r\n", "\n", $response));
	
	return $response;
}

function ftp_ok($sock)
{
	if (!$sock) {
		return FALSE;
	}
	
	$response = ftp_getresp($sock);
	if (ereg("^[123]", $response)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function ftp_file_exists($sock, $pathname)
{
	if (!$sock) {
		return FALSE;
	}
	
	ftp_putcmd($sock, "MDTM", $pathname);
	if (ftp_ok($sock)) {
		ftp_debug("Remote file ".$pathname." exists\n");
		return TRUE;
	} else {
		ftp_debug("Remote file ".$pathname." does not exist\n");
		return FALSE;
	}
}

function ftp_close_data_connection($sock)
{
	ftp_debug("Disconnected from remote host\n");
	return fclose($sock);
}

function ftp_open_data_connection($string)
{
	$data = ereg_replace("^.*\\(([0-9]+,[0-9]+,[0-9]+,[0-9]+,[0-9]+,[0-9]+)\\).*$", "\\1", $string);
	$DATA = explode(",", $data);
	$ipaddr = $DATA[0].".".$DATA[1].".".$DATA[2].".".$DATA[3];
	$port = $DATA[4]*256 + $DATA[5];
	$data_connection = @fsockopen($ipaddr, $port);
	if ($data_connection) {
		ftp_debug("Trying to ".$ipaddr.":".$port." ...\n");
		return $data_connection;
	} else {
		ftp_debug("Error : Cannot open data connection to ".$this->server.":".$port."\n");
		ftp_debug("Error : ".$errstr." (".$errno.")\n");
		return FALSE;
	}
}

function ftp_debug($message = "")
{
	global $ftp_debug;
	
	if ($ftp_debug) {
		echo $message;
	}
	
	return TRUE;
}

?>