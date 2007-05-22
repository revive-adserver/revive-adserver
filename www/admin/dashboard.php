<?php // $Revision: 3830 $

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
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Register input variables
phpAds_registerGlobal ('expand', 'collapse', 'hideinactive', 'listorder', 'orderdirection');


// Security check
if (!phpAds_isUser(phpAds_Admin)) {
	phpAds_PageHeader("1");
	phpAds_Die ($strAccessDenied, $strNotAdmin);
	
}

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("6.1");

echo "<script type='text/javascript'>
function iframeLoaded(e,elem,d){
	top.document.getElementById(\"dashboardLoading\").style.display=\"none\";
	if(!d)elem.style.position=\"\";
}
</script>
<style type='text/css'>
	#dashboardError{
		text-align: center;
		border: 1px solid #fff;
		height: 800px;
		width: 800px;
		background: #fff url(images/dashboard_teaser_transparent.jpg) no-repeat top center;		
	}
	#dashboardError .inner{
		text-align: center;
		font-size: 15px;
		padding: 2px 10px;
		margin: 100px auto;
		width: 300px;
		border: 1px solid #999;
		-moz-border-radius: 5px;
		background: #e9e9e9;
	}
	#dashboardError .header{
		background:#06c;
		color: #fff;
		height: 20px;
		margin-top: 5px;
		margin-bottom: 8px;
		padding-left: 5px;
		text-align: left;		
	}
	#dashboardError .header span{
		float:right;background: #e9e9e9 url(images/ltr/tab-eb.gif) no-repeat top right;
		width: 10px;
		height: 20px;		
	}
	#dashboardError .errorMsg{
		background:#fcfcfc;
		color:#333;
		border: 1px solid #fff;
		margin-bottom: 9px;
		padding-top: 5px;
	}
	#dashboardError .errorMsg p{
		background:#fcfcfc;
		color:#b80000;
		border: 0px solid #de8bcd;
		margin: 8px 0;
		height: auto;
		padding: 0;
		text-align: center;
	}
	#dashboardError .footer{
		text-align: left;
		margin-bottom: 3px;
		font-size: 10px;
	}
	#dashboardLoading{
		height: 250px;
		width: 450px;
		margin-top: 20px;
		margin-left: 40px;
		padding-top: 180px;
		background:url(images/ajax-loader-clock.gif) no-repeat 200px 100px;
		text-align: center;
		font-size: 11px;
		font-weight: bold;		
	}
</style>";

// display loading div
echo '<div id="dashboardLoading">Loading dashboard data...</div>';

// make sure that part of response is setn to the server
// fsockopen below is blocking so user would wait for its result
// otherwise
flush();


// init problems string
$sConnectionProblems = '';

// try opening connection to the sync server
$fp = @fsockopen($GLOBALS['aDashboardServer']['host'], 80, $errno, $errstr, 30);

// opening connection failed - display error message and leave
if (!$fp) {
    $sConnectionProblems = 'Problems with connecting to dashboard server - <strong>'.$GLOBALS['aDashboardServer']['host'].'</strong><br />' .
    		"\n" .'<!-- ERROR ' .
    		"\n" .'number: '. $errno . ', string: ' . $errstr .
    		"\n" .'-->' .
    		"\n" .'';
} 
else {
	// opening connection was ok so now try
	// a sample GET request to make URL of the iframe's src
	// is properly declared
	$out = "GET ".$GLOBALS['aDashboardServer']['path']." HTTP/1.1\r\n";
    $out .= "Host: ".$GLOBALS['aDashboardServer']['host']."\r\n";
    $out .= "User-agent: Openads/2.0\r\n";
    $out .= "Connection: Close\r\n";
    $out .= "\r\n";

	// send request
    fwrite($fp, $out);
    
    // read response
    $aResponse = array();
    while (!feof($fp)) {
        $sLine = htmlspecialchars(trim(fgets($fp, 128)));
        list(,$sHeaderName,$sHeaderValue) = preg_split('/(.*?): /', $sLine,-1,PREG_SPLIT_DELIM_CAPTURE);
        if(!strcasecmp($sHeaderName, 'x-Openads-height')){
        	$iIframeHeight = $sHeaderValue;
        }
        
        if(!strcasecmp($sHeaderName, 'x-Openads-width')){
        	$iIframeWidth = $sHeaderValue;
        }
        
        $aResponse[] = $sLine;
    }
    
    // check first line of the response 
    // should be 200 - ok header
    // otherwise report an error
    if( !preg_match( '#HTTP/1.1 200 OK#', $aResponse[0] ) ) {
    	// display information about problems
    	$sConnectionProblems = 'Problems with fetching dashboard content';
    	$sConnectionProblems .= "\n<!--- HTTP RESPONSE \n";
    	$sConnectionProblems .= $aResponse[0];
    	$sConnectionProblems .= "\nhttp target: ".$GLOBALS['aDashboardServer']['path']."\n";
    	$sConnectionProblems .= "\n-->\n";
    }
    fclose($fp);
}

// connection attempt was ok - go ahead and display iframe
if( empty($sConnectionProblems) ) {
	// initialize extra query params array
	$aQuery = array();
	//echo '<pre>',print_r($GLOBALS['conf'],1),'</pre>';
	// add info about data sharing
	if($GLOBALS['pref']['updates_cs_data_enabled']) {	
		$aQuery[] = 'updates_cs_data_enabled=1';
	}
	
	// add admin info
	if(!phpAds_isAllowed(phpAds_Admin)){
		$aQuery[] = 'instance_id='.$GLOBALS['pref']['instance_id'];
	}
	
	$aQuery[] = 'admin_path=http://'.$GLOBALS['conf']['webpath']['admin'];	
	// build src for iframe
	$src = 	$GLOBALS['aDashboardServer']['protocol'].$GLOBALS['aDashboardServer']['host'].$GLOBALS['aDashboardServer']['path'];
	
	// append query to the src 
	$src .= '?'.base64_encode(join('|', $aQuery));

	// display iframe - hide it for loading purposes
	echo 
			"<div>" .
				"<iframe width='".(empty($iIframeWidth)?'750':$iIframeWidth)."' height='".(empty($iIframeHeight)?'750':$iIframeHeight)."' frameborder='0' style='position: absolute; top: -100000px;' src='".$src."' onload='iframeLoaded(event,this);' />" .
					"<noframes>We're really sorry but your browser does not support frames. Please enable them or upgrade.</noframes>" .
			"</div>";
}
else { // errors during connection
	
	// hide loading div
	echo "<script type='text/javascript'>" .
		"iframeLoaded('',1);" .
		"</script>";
	
	// display info about problems
	echo 
		"<div id='dashboardError'>" .
			"<div class='inner'>" .
				"<p class='header'><span></span>Openads Dashboard</p>" .
				"<div class='errorMsg'>" .
					"Unable to load Community Intelligence dashboard:" .
						"<p>".$sConnectionProblems."</p>" .
					"<span style='font-size: x-small;'>Try again in a few minutes or check the " .
					"<a target='_blank' href='http://docs.openads.org/openads-2.3-guide/community-statistics.html'>" .
					"help documentation</a></span>" .
				"</div>" .
				"<div class='footer'>" .
					"<a href='http://www.openads.org/' target='_blank'>Openads</a>" .
				"</div>" .
			"</div>" .
	 	"</div>";
}
/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();


?>