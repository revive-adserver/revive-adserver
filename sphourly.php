<? 
require ("config.php");

// NOTE: None of this works for the compact database format since hours are not tracked

if (!$phpAds_compact_stats) {
    $where=urldecode($where); 
    
    mysql_select_db($phpAds_db);
    $query="select count(*), DATE_FORMAT(t_stamp, '%k') as hour from $phpAds_tbl_adviews where ($where) GROUP BY hour";
    $query2="select count(*), DATE_FORMAT(t_stamp, '%k') as hour from $phpAds_tbl_adclicks where ($where) GROUP BY hour";
    $result = db_query($query);
    $result2 = db_query($query2);
    
    $text=array(
    	"value1" => $GLOBALS['strViews'],
    	"value2" => $GLOBALS['strClicks']
    	);
     
    $items = array();
    // preset array (not every hour may be occupied)
    for ($i=0;$i<=23;$i++)
    {
    	$items[$i] = array();
    	$items[$i]['value1'] = 0;
    	$items[$i]['value2'] = 0;
    	$items[$i]['text'] = '';
    }
    while ($row = mysql_fetch_row($result))
    {
    	$i=$row[1];
    	$items[$i]['value1'] = $row[0];
    	$items[$i]['text'] = sprintf("%d",$i);
    }
    while ($row2 = mysql_fetch_row($result2))
    {
    	$i=$row2[1];
    	$items[$i]['value2'] = $row2[0];
    	$items[$i]['text'] = sprintf("%d",$i);
    }          
                      
    $width=385;   // absolute definition due to width/height declaration in stats.inc.php
    $height=150;  // adapt this if embedding html-document will change
    
    include("stats.graph.inc.php");
}
?>
