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



// Figure out our location
define ('phpAds_path', '.');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/lib-db.inc.php");

if (($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon']) || $phpAds_config['acl'])
{
	require (phpAds_path."/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon'])
		require (phpAds_path."/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/lib-acl.inc.php");
}

require	(phpAds_path."/lib-view-main.inc.php");
require (phpAds_path."/lib-cache.inc.php");



/*********************************************************/
/* Java-encodes text                                     */
/*********************************************************/

function enjavanate ($str, $limit = 60)
{
	$str   = str_replace("\r", '', $str);
	
	print "var phpadsbanner = '';\n";
	
	while (strlen($str) > 0)
	{
		$line = substr ($str, 0, $limit);
		$str  = substr ($str, $limit);
		
		$line = str_replace('\'', "\\'", $line);
		$line = str_replace("\n", "\\n", $line);
		
		print "phpadsbanner += '$line';\n";
	}
}



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

header("Content-type: application/x-javascript");
enjavanate($output['html']);

$windowid = 'phpads_'.$output['bannerid'];



/*********************************************************/
/* Creat the Javascript for opening the popup            */
/*********************************************************/

?>

if (!window.<?php echo $windowid; ?>)
{
	var <?php echo $windowid; ?> =  window.open('', '<?php echo $windowid; ?>', 'height=<?php echo $output['height']; ?>,width=<?php echo $output['width']; ?>,toolbars=no,location=no,menubar=no,status=no,resizable=no,scrollbars=no');
	
	if (!<?php echo $windowid; ?>.document.title || <?php echo $windowid; ?>.document.title == '')
	{
		<?php if(isset($left) && isset($top)) { ?>
		<?php echo $windowid; ?>.moveTo (<?php echo $left; ?>,<?php echo $top; ?>);
		<?php } ?>
		
		<?php echo $windowid; ?>.document.open('text/html', 'replace');
		<?php echo $windowid; ?>.document.write('<html><head><title>');
		<?php echo $windowid; ?>.document.write('<?php echo ($output['alt'] ? $output['alt'] : 'Advertisement'); ?>');
		<?php echo $windowid; ?>.document.write('</title></head>');
		<?php echo $windowid; ?>.document.write('<body leftmargin=\'0\' topmargin=\'0\' marginwidth=\'0\' marginheight=\'0\'>');
		<?php echo $windowid; ?>.document.write(phpadsbanner);
		<?php echo $windowid; ?>.document.write('</body></html>');
		<?php echo $windowid; ?>.document.close();
	}
	
	<?php if (isset($popunder) && $popunder == '1') { ?>
	window.focus();
	<?php } ?>
	
	<?php if (isset($timeout) && $timeout > 0) { ?>
	window.setTimeout("<?php echo $windowid; ?>.close()", <?php echo $timeout * 1000; ?>);
	<?php } ?>
}