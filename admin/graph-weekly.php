<?
/* graph-weekly.php,v 1.0 2000/12/29 11:06:00 martin braun*/

/* placed to GNU by martin@braun.cc */

require ("config.php");

$where=urldecode($where); 


// NOTE: compact stats and verbose stats don't mix in here. It's one or the other.

// get week signs for mySQL queries
require("stats-weekly.inc.php");

list($php_week_sign, $mysql_week_sign) = GetWeekSigns();

mysql_select_db($GLOBALS["phpAds_db"]);

$text=array(
    'value1' => $GLOBALS['strViews'],
    'value2' => $GLOBALS['strClicks']);
    
if ($phpAds_compact_stats) {
    // get totals from compact stats
    $query="
    	SELECT 
    		sum(views), 
    		sum(clicks), 
    		DATE_FORMAT(day,'".$mysql_week_sign."'),
    		DATE_FORMAT(day,'%Y".$mysql_week_sign."') AS week 
    	FROM
    		".$GLOBALS['phpAds_tbl_adstats']."
    	WHERE 
    		".$where."
    	GROUP BY 
    		week
    	ORDER BY 
    		week DESC
    	LIMIT ".$max_weeks;
    
    $result = db_query($query) or mysql_die();
    
    $items = array();
    $num2 = mysql_num_rows($result);
    $i=0;
    while ($row = mysql_fetch_row($result))   
    {
    	$items[$i]=array();
    	$items[$i]['value1'] = $row[0];     // views
    	$items[$i]['value2'] = $row[1];     // clicks
    	$items[$i]['text'] = $row[2];       // week sign
    	$i++;
    }
}
else
{
    $query="
    	SELECT 
    		count(*), 
    		DATE_FORMAT(t_stamp,'".$mysql_week_sign."'),
    		DATE_FORMAT(t_stamp,'%Y".$mysql_week_sign."') AS week 
    	FROM
    		".$GLOBALS['phpAds_tbl_adviews']."
    	WHERE 
    		".$where."
    	GROUP BY 
    		week
    	ORDER BY 
    		week DESC
    	LIMIT ".$max_weeks;
    
    $query2="
    	SELECT 
    		count(*), 
    		DATE_FORMAT(t_stamp,'".$mysql_week_sign."'),
    		DATE_FORMAT(t_stamp,'%Y".$mysql_week_sign."') AS week 
    	FROM
    		".$GLOBALS['phpAds_tbl_adclicks']."
    	WHERE
    		".$where."
    	GROUP BY 
    		week
    	ORDER BY 
    		week DESC
    	LIMIT ".$max_weeks;
                
    $result = db_query($query) or mysql_die();
    $result2 = db_query($query2) or mysql_die();
    
    $items = array();
    $num2 = mysql_num_rows($result2);
    $row2 = mysql_fetch_row($result2);
    $i=0;
    while ($row = mysql_fetch_row($result))   
    {
    	$items[$i]=array();
    	$items[$i]['value1'] = $row[0];
    	$items[$i]['value2'] = 0;
    	$items[$i]['text'] = $row[1];
    	if ($row[2]==$row2[2])
    	{
    		$items[$i]['value2'] = $row2[0];
    		if ( $i < $num2 - 1 )
    			$row2 = mysql_fetch_row($result2);
    	}
    	else
    		$items[$i]['value2'] = 0;
    	$i++;
    }
}

include('lib-graph.inc.php');
?>
 
