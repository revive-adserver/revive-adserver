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
require ("config.php");
require ("lib-statistics.inc.php");


// Initialize random generator
mt_srand((double)microtime() * 1000000);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		bannerid = '$bannerid'
	") or phpAds_sqlDie();



if ($res)
{
	$row = phpAds_dbFetchArray($res);
	
	echo "<html><head><title>".strip_tags(phpAds_buildBannerName ($bannerid, $row['description'], $row['alt']))."</title>";
	echo "<link rel='stylesheet' href='images/".$phpAds_TextDirection."/interface.css'></head>";
	echo "<body marginheight='0' marginwidth='0' leftmargin='0' topmargin='0' bgcolor='#EFEFEF'>";
	echo "<table cellpadding='0' cellspacing='0' border='0'>";
	echo "<tr height='32'><td width='32'><img src='images/cropmark-tl.gif' width='32' height='32'></td>";
	echo "<td background='images/ruler-top.gif'>&nbsp;</td><td width='32'><img src='images/cropmark-tr.gif' width='32' height='32'></td></tr>";
	echo "<tr height='".$row['height']."'><td width='32' background='images/ruler-left.gif'>&nbsp;</td><td bgcolor='#FFFFFF' width='".$row['width']."'>";
	
	if ($row['contenttype'] == 'html')
	{
		$htmlcode = $row['htmlcache'];
		
		// Basic modifications
		$htmlcode = str_replace ('{url_prefix}', $phpAds_config['url_prefix'], $htmlcode);
		$htmlcode = str_replace ('{bannerid}', $bannerid, $htmlcode);
		$htmlcode = str_replace ('{zoneid}', '', $htmlcode);
		$htmlcode = str_replace ('{source}', '', $htmlcode);
		$htmlcode = str_replace ('{target}', '_blank', $htmlcode);
		$htmlcode = str_replace ('[bannertext]', '', $htmlcode);
		$htmlcode = str_replace ('[/bannertext]', '', $htmlcode);
		
		
		// Parse for variables
		$htmlcode = str_replace ('{timestamp}',	time(), $htmlcode);
		$htmlcode = str_replace ('%7Btimestamp%7D',	time(), $htmlcode);
		
		while (preg_match ('#(%7B|\{)random((%3A|:)([1-9]+)){0,1}(%7D|})#i', $htmlcode, $matches))
		{
			if ($matches[4])
				$randomdigits = $matches[4];
			else
				$randomdigits = 8;
			
			if (isset($lastdigits) && $lastdigits == $randomdigits)
				$randomnumber = $lastrandom;
			else
			{
				$randomnumber = '';
				
				for ($r=0; $r<$randomdigits; $r=$r+9)
					$randomnumber .= (string)mt_rand (111111111, 999999999);
				
				$randomnumber  = substr($randomnumber, 0 - $randomdigits);
			}
			
			$htmlcode = str_replace ($matches[0], $randomnumber, $htmlcode);
			
			$lastdigits = $randomdigits;
			$lastrandom = $randomnumber;
		}
		
		
		// Parse PHP code
		if ($phpAds_config['type_html_php'])
		{
			if (preg_match ("#(\<\?php(.*)\?\>)#i", $htmlcode, $parser_regs))
			{
				// Extract PHP script
				$parser_php 	= $parser_regs[2];
				$parser_result 	= '';
				
				// Replace output function
				$parser_php = preg_replace ("#echo([^;]*);#i", '$parser_result .=\\1;', $parser_php);
				$parser_php = preg_replace ("#print([^;]*);#i", '$parser_result .=\\1;', $parser_php);
				$parser_php = preg_replace ("#printf([^;]*);#i", '$parser_result .= sprintf\\1;', $parser_php);
				
				// Split the PHP script into lines
				$parser_lines = explode (";", $parser_php);
				for ($parser_i = 0; $parser_i < sizeof($parser_lines); $parser_i++)
				{
					if (trim ($parser_lines[$parser_i]) != '')
						eval (trim ($parser_lines[$parser_i]).';');
				}
				
				// Replace the script with the result
				$htmlcode = str_replace ($parser_regs[1], $parser_result, $htmlcode);
			}
		}
		
		
		// Output banner
		echo $htmlcode;
	}
	else
		echo phpAds_buildBannerCode ($row['bannerid'], true);
	
	echo "</td><td width='32'>&nbsp;</td></tr>";
	echo "<tr height='32'><td width='32'><img src='images/cropmark-bl.gif' width='32' height='32'></td><td>";
	
	if ($row['contenttype'] == 'txt')
		echo "&nbsp;";
	else
		echo "&nbsp;&nbsp;&nbsp;width: ".$row['width']."&nbsp;&nbsp;height: ".$row['height']."&nbsp".($row['bannertext'] ? '+ text&nbsp;' : '');
	
	echo "</td><td width='32'><img src='images/cropmark-br.gif' width='32' height='32'></td></tr>";
	echo "</table>";
	
	echo "</body></html>";
}


?>