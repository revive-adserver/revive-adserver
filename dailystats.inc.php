<?

function stats($what)
 {
 global $phpAds_db, $phpAds_url_prefix;
 $result = mysql_db_query($phpAds_db, "
          SELECT
            *,
            DATE_FORMAT(t_stamp, '$GLOBALS[time_format]') as t_stamp_f,
            DATE_FORMAT(t_stamp, '%H') as hour,
            count(*) as qnt
          FROM
            $what
          WHERE
            bannerID = $GLOBALS[bannerID]
            AND DATE_FORMAT(t_stamp, '$GLOBALS[date_format]') = '$GLOBALS[day]'
          GROUP BY 
            hour
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
         <?echo $row["hour"];?>:00        </td>
        <td bgcolor="<?echo $bgcolor;?>">
        <img src="<?echo $phpAds_url_prefix;?>/bar.gif" width="<?echo ($row["qnt"]*150)/$max;?>" height="11"><img src="<?echo $phpAds_url_prefix;?>/bar_off.gif" width="<?echo 150-(($row["qnt"]*150)/$max);?>" height="11">
        </td>
        <td bgcolor="<?echo $bgcolor;?>"><b>
        <?
        echo $row["qnt"];
        ?>
         </b>
        </td>
       </tr>
       <?
       }
 }
 ?>
  <table width="100%" cellspacing=0 cellpadding=0 border=0>
<tr><td bgcolor=#99999>
<table width="100%" cellpadding=2 cellspacing=1 border=0> <?

echo "<tr><td colspan=3 bgcolor='#FFFFFF'><b>$strViews:</b></td></tr>";
stats("$phpAds_tbl_adviews");
echo "<tr><td colspan=3 bgcolor='#FFFFFF'><b>$strClicks:</b></td></tr>";
stats("$phpAds_tbl_adclicks");
 ?>
<tr><td colspan=3 bgcolor='#FFFFFF'><b><?print($strTopTenHosts);?>:</b></td></tr>
<?
 $result = mysql_db_query($phpAds_db, "
          SELECT
            *,
            count(*) as qnt
          FROM
            $phpAds_tbl_adviews
          WHERE
            bannerID = $GLOBALS[bannerID]
            AND DATE_FORMAT(t_stamp, '$GLOBALS[date_format]') = '$GLOBALS[day]'
          GROUP BY
            host
          ORDER BY
            qnt DESC
          LIMIT 10
          ") or mysql_die();

 $i = 0;
 while ($row = mysql_fetch_array($result))
       {
       $bgcolor="#F7F7F7";
       $i % 2 ? 0: $bgcolor= "#ECECFF";
       $i++;
       ?>
       <tr>
        <td bgcolor="#eeeeee" colspan="2">
         <?echo $row["host"];?>
        </td>
        <td bgcolor="<?echo $bgcolor;?>">
        <b><?echo $row["qnt"];?></b>
        </td>
       </tr>
       <?
       }

?>
      </table></td></tr>
 </table>
