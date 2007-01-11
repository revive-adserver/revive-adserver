<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-maintenance.inc.php");
require ("lib-statistics.inc.php");
require ("lib-zones.inc.php");


// Register input variables
phpAds_registerGlobal ('action');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("5.3");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2"));
phpAds_MaintenanceSelection("stats");


/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($action) && $action == 'start')
{
	echo "<br><br>";
	
	echo "<div id='busy'>";
	echo "<img src='images/install-busy.gif' align='absmiddle'>&nbsp;";
	echo "<b>".$strConvertingStats."</b><br><br>";
	echo $strConvertingExplaination;
	echo "</div>";
	
	echo "<div id='done' style='display:none;'>";
	echo "<img src='images/info.gif' align='absmiddle'>&nbsp;";
	echo "<b>".$strConvertFinished."</b><br><br>";
	echo $strConvertFinishedExplaination;
	echo "</div>";
	
	echo "<br><br>";
	echo "<textarea name='result' class='flat' rows='12' cols='55' style='width:560px;' readonly></textarea>";
	echo "<br><br>";
	phpAds_ShowBreak();
}
else
{
	echo "<br><br>";
	echo $strConvertExplaination;
	
	echo "<br>";
	phpAds_ShowBreak();
	echo "<a href='maintenance-stats.php?action=start'><img src='images/".$phpAds_TextDirection."/icon-undo.gif' border='0' align='absmiddle'>&nbsp;".$strConvertStats."</a>";
	phpAds_ShowBreak();
}


/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

if (isset($action) && $action == 'start')
{
	  // Start conversion
    echo "<script language='Javascript'>\n";
    echo "<!--\n";
    
    echo "if (document.getElementById && !window.opera) {\n";
    
		echo "\tvar script = document.createElement('script');\n";
    echo "\tscript.src = \"maintenance-stats-convert.php?action=start\";\n";
    echo "\tdocument.getElementsByTagName('head')[0].appendChild(script);\n";
    
    echo "} else {\n";
    
    echo "\tdocument.write (\"";
		echo "<script language='JavaScript' src='";
		echo "maintenance-stats-convert.php?action=start";
		echo "'></script>";
		echo "\");\n";
    
    echo "}\n";
    
    echo "//-->\n";
    echo "</script>";
}

?>