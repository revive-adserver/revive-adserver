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


// Set define to prevent duplicate include
define ('LIBMAIL_INCLUDED', true);


/*********************************************************/
/* Send an email                                         */
/*********************************************************/

function phpAds_sendMail ($email, $readable, $subject, $contents)
{
	global $phpAds_config, $phpAds_CharSet;
	
	// Build To header
	if (!get_cfg_var('SMTP'))
		$param_to = '"'.$readable.'" <'.$email.'>';
	else
		$param_to = $email;
	
	// Build additional headers
	$param_headers = "Content-Transfer-Encoding: 8bit\r\n";
	
	if (isset($phpAds_CharSet))
		$param_headers .= "Content-Type: text/plain; charset=".$phpAds_CharSet."\r\n"; 
	
	if (get_cfg_var('SMTP'))
		$param_headers .= 'To: "'.$readable.'" <'.$email.">\r\n";
	
	$param_headers .= 'From: "'.$phpAds_config['admin_fullname'].'" <'.$phpAds_config['admin_email'].'>'."\r\n";
	
	if ($phpAds_config['admin_email_headers'] != '')
		$param_headers .= "\r\n".$phpAds_config['admin_email_headers'];
	
	// Use only \n as header separator when qmail is used
	if ($phpAds_config['qmail_patch'])
		$param_headers = str_replace("\r", '', $param_headers);
	
	// Add \r to linebreaks in the contents for MS Exchange compatibility
	$contents = str_replace("\n", "\r\n", $contents);
	
	return (@mail ($param_to, $subject, $contents, $param_headers));
}


?>