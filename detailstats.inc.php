<?

function stats($what, $totalTitle, $avgTitle)
 {
 global $phpAds_db, $date_format, $phpAds_url_prefix,$pageid,$fncpageid;
 $result = mysql_db_query($phpAds_db, "
           SELECT
             *,
             count(*) as qnt,
             DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f
           FROM
             $what
           WHERE
             bannerID = $GLOBALS[bannerID]
           GROUP BY
             t_stamp_f  
           ORDER BY t_stamp DESC
           LIMIT 7           
           ") or mysql_die();
$max = 0;
$total = 0;
while ($row = mysql_fetch_array($result))
      {
      if ($row["qnt"] > $max) 
         $max = $row["qnt"];
      $total += $row["qnt"];
      }
@mysql_data_seek($result, 0);
$i = 0;  
while ($row = mysql_fetch_array($result))
      {
      $bgcolor="#F7F7F7";
      $i % 2 ? 0: $bgcolor= "#ECECFF";
      $i++;
      ?>
       <tr>
        <td bgcolor="#eeeeee">
         <?echo "$row[t_stamp_f]";?>
        </td>
        <td bgcolor="<?echo $bgcolor;?>">
         <img src="<?echo $phpAds_url_prefix;?>/bar.gif" width="<?echo ($row["qnt"]*150)/$max;?>" height="11"><img src="<?echo $phpAds_url_prefix;?>/bar_off.gif" width="<?echo 150-(($row["qnt"]*150)/$max);?>" height="11">
        </td>
        <td bgcolor="<?echo $bgcolor;?>">
         <b><?echo $row["qnt"];?></b>
        </td>
        <td bgcolor="<?echo $bgcolor;?>">
         <a href="dailystats.php<?echo ($fncpageid)?>&day=<?echo urlencode($row["t_stamp_f"]);?>&bannerID=<?echo $GLOBALS["bannerID"];?>"><?echo $GLOBALS["strDailyStats"];?></a>
        </td>
       </tr>

      <?
      }
      ?>
       <tr>
        <td bgcolor="#CCCCCC" colspan=2>
         <?echo $totalTitle;?>
        </td>
        <td bgcolor="#CCCCCC" colspan=2>
         <b><?echo $total;?></b>
        </td>
       </tr>
       <tr>
        <td bgcolor="#CCCCCC" colspan=2>
         <?echo $avgTitle;?>
        </td>
        <td bgcolor="#CCCCCC" colspan=2>
         <b><? printf("%.2f", $total/7);?></b>
        </td>
       </tr>
 <?       
 }

?>
 <table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr><td bgcolor=#99999>
<table width="100%" cellpadding=3 cellspacing=1 border=0>
<?

echo "<tr><td colspan=4 bgcolor='#FFFFFF'><b>$strViews:</b></td></tr>";
stats("$phpAds_tbl_adviews", $strTotalViews7Days, $strAvgViews7Days);
echo "<tr><td colspan=4 bgcolor='#FFFFFF'><b>$strClicks:</b></td></tr>";
stats("$phpAds_tbl_adclicks", $strTotalClicks7Days, $strAvgClicks7Days);
?>

      </table></td></tr>
       </table>

