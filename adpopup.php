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



// Figure out our location
define ('phpAds_path', '.');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/libraries/lib-io.inc.php");
require (phpAds_path."/libraries/lib-db.inc.php");

if (($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon']) || $phpAds_config['acl'])
{
	require (phpAds_path."/libraries/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon'])
		require (phpAds_path."/libraries/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/libraries/lib-limitations.inc.php");
}

require	(phpAds_path."/libraries/lib-view-main.inc.php");
require (phpAds_path."/libraries/lib-cache.inc.php");



/*********************************************************/
/* Java-encodes text                                     */
/*********************************************************/

function enjavanateOld ($str, $limit = 60)
{
	print "\n\t\tvar phpadsbanner = '';\n";
	
	while (strlen($str) > 0)
	{
		$line = substr ($str, 0, $limit);
		$str  = substr ($str, $limit);
		
		$line = str_replace('\\', "\\\\", $line);
		$line = str_replace('\'', "\\'", $line);
		$line = str_replace("\r", '', $line);
		$line = str_replace("\n", "\\n", $line);
		$line = str_replace("\t", "\\t", $line);
		$line = str_replace('<', "<'+'", $line);
		
		print "\t\tphpadsbanner += '$line';\n";
	}
	
	print "\n";
}

function enjavanateCode ($str, $limit = 60)
{
	global $windowid;
	
	$str = str_replace("\r", '', $str);
	
	while (strlen($str) > 0)
	{
		$line = substr ($str, 0, $limit);
		$str  = substr ($str, $limit);
		
		while (substr($line, strlen($line)-1, 1) == "\\")
		{
			$line .= substr($str, 0, 1);
			$str = substr($str, 1);
		}
		
		$line = str_replace('\\', "\\\\", $line);
		$line = str_replace('\'', "\\'", $line);
		$line = str_replace("\r", '', $line);
		$line = str_replace("\n", "\\n", $line);
		$line = str_replace("\t", "\\t", $line);
		
		echo "\t\t".$windowid.".document.write('$line');\n";
	}
}

function enjavanateBanner ($output, $limit = 60)
{
	$str = $output['html'];
	$ret =  "\tvar phpadsbanner = '';\n";
	
	while (strlen($str) > 0)
	{
		$line = substr ($str, 0, $limit);
		$str  = substr ($str, $limit);
		
		$line = str_replace('\\', "\\\\", $line);
		$line = str_replace('\'', "\\'", $line);
		$line = str_replace("\r", '', $line);
		$line = str_replace("\n", "\\n", $line);
		$line = str_replace("\t", "\\t", $line);
		$line = str_replace('<', "<'+'", $line);
		
		$ret .= "\tphpadsbanner += '$line';\n";
	}
	
	$ret .= "\n\tdocument.write('<html><head><title>');\n";
	$ret .= "\tdocument.write('".($output['alt'] ? $output['alt'] : 'Advertisement')."');\n";
	$ret .= "\tdocument.write('</title></head>');\n";
	$ret .= "\tdocument.write('<body leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">');\n";
	$ret .= "\tdocument.write(phpadsbanner);\n";
	$ret .= "\tdocument.write('</body></html>');\n";
	
	return $ret;
}



/*********************************************************/
/* Register input variables                              */
/*********************************************************/

phpAds_registerGlobal ('what', 'clientid', 'clientID', 'context',
					   'target', 'source', 'withtext', 'withText',
					   'left', 'top', 'popunder', 'timeout', 'delay');



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($clientID) && !isset($clientid))	$clientid = $clientID;
if (isset($withText) && !isset($withtext))  $withtext = $withText;

if (!isset($what)) 		$what = '';
if (!isset($clientid)) 	$clientid = 0;
if (!isset($target)) 	$target = '_new';
if (!isset($source)) 	$source = '';
if (!isset($withtext)) 	$withtext = '';
if (!isset($context)) 	$context = '';


// Get the banner
$output = view_raw ($what, $clientid, $target, $source, $withtext, $context);

// Exit if no banner was fetched
if (!$output['bannerid'])
	exit;


header("Content-type: application/x-javascript");

$windowid = 'phpads_'.$output['bannerid'];



/*********************************************************/
/* Create the Javascript for opening the popup           */
/*********************************************************/

?>


function <?php echo $windowid; ?>_pop(e)
{
	if (!window.<?php echo $windowid; ?>)
	{
		var <?php echo $windowid; ?> =  window.open('', '<?php echo $windowid; ?>', 'height=<?php echo $output['height']; ?>,width=<?php echo $output['width']; ?>,toolbars=no,location=no,menubar=no,status=no,resizable=no,scrollbars=no');
		
		if (!<?php echo $windowid; ?>.document.title || <?php echo $windowid; ?>.document.title == '')
		{
			<?php if(isset($left) && isset($top)) { ?>
			<?php echo $windowid; ?>.moveTo (<?php echo $left; ?>,<?php echo $top; ?>);
			<?php } ?>
			
			<?php echo $windowid; ?>.document.open('text/html', 'replace');
	<?php
			if (strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'MSIE') && !strstr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'Opera'))
			{
				echo enjavanateCode("<html><head>")."\n";
				
				echo enjavanateCode("<script language='JavaScript'>");
				echo enjavanateCode("function showbanner() {");		
				echo enjavanateCode(enjavanateBanner($output)); 
				echo enjavanateCode("}");		
				echo enjavanateCode("</script>")."\n";
				
				echo enjavanateCode("</head>");		
				echo enjavanateCode("<body onLoad='showbanner()'>");
			}
			else
			{
				enjavanateOld($output['html']);
				
				echo enjavanateCode("<html><head><title>");
				echo enjavanateCode($output['alt'] ? $output['alt'] : 'Advertisement');
				echo enjavanateCode("</title></head>");
				echo enjavanateCode("<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>");
	?>
			<?php echo $windowid; ?>.document.write(phpadsbanner);
	<?php
			}
			
			echo enjavanateCode("</body></html>");
	?>
			
			<?php echo $windowid; ?>.document.close();
		}

		<?php if (isset($popunder) && $popunder == '1') { ?>
	window.focus();
		<?php } else {?>
	<?php echo $windowid; ?>.focus();
		<?php } ?>
	
		<?php if (isset($timeout) && $timeout > 0) { ?>
	window.setTimeout("<?php echo $windowid; ?>.close()", <?php echo $timeout * 1000; ?>);
		<?php } ?>
	
	}
	
	return true;
}

<?php if (isset($delay) && $delay == 'exit') { ?>

if (window.captureEvents && Event.UNLOAD) 
	window.captureEvents (Event.UNLOAD);

window.onunload = <?php echo $windowid; ?>_pop;

<?php } elseif (isset($delay) && $delay > 0) { ?>

window.setTimeout("<?php echo $windowid; ?>_pop();", <?php echo $delay * 1000; ?>);

<?php } else {?>

<?php echo $windowid; ?>_pop();

<?php } ?>