<?

require ("config.php");
require("kcsm.php");

page_header($strStats);
show_nav("1.6");
$client_query="
       SELECT
         clientID,
         clientname,
         contact,
         email,
         views,
         clicks,
         expire
       FROM
         $phpAds_tbl_clients";
if (isset($lowID) && strlen($lowID)>0)
{
	$client_query=$client_query."
       WHERE clientID > $lowID";
}
$client_query=$client_query."
       ORDER BY
         clientID
       LIMIT 10";
$res_clients = mysql_db_query($phpAds_db, $client_query) or mysql_die() ;

?>
<table width="100%" cellpadding=3 cellspacing=1 border=0>
<?
while ($row_clients = mysql_fetch_array($res_clients))
      {
      $total_adviews=0;
      $total_adclicks=0;
      $highID=$row_clients[clientID];
?>
      <tr>
       <td colspan="2" bgcolor="#CCCCCC"><?print $row_clients[clientname];?></td>
       <td colspan=2 bgcolor="#CCCCCC"><?print $strContact.": ";
         if (strlen($row_clients[contact])==0)
             print "None";
         else
             print "<A HREF=mailto:$row_clients[email]>$row_clients[contact]</a>";
       ?>
       </td>
      </tr>
      <?
      $res_banners = mysql_db_query($phpAds_db, "
                 SELECT
                   bannerID,
                   active,
                   weight,
                   format,
                   width,
                   height
                 FROM
                   $phpAds_tbl_banners
                 WHERE
                   clientID = $row_clients[clientID]
                 ") or mysql_die();
      while ($row_banners = mysql_fetch_array($res_banners)) 
      {
        ?>
        <tr>
        <td colspan="2" bgcolor="#eeeeee">
        <?
        if ($row_banners["format"] == "html")
        {
          echo htmlspecialchars(stripslashes($row_banners["banner"]));
        }
        else
        {
          echo "<img src=\"./viewbanner.php$fncpageid&bannerID=$row_banners[bannerID]\" width=$row_banners[width] height=$row_banners[height]>";
        }
        ?>
        </td>

        <td bgcolor="#eeeeee"><?print $strViews;?>: 
        <?
        $res_adviews = mysql_db_query($phpAds_db, "
                   SELECT
                     count(bannerID)
                   FROM
                     $phpAds_tbl_adviews
                   WHERE
                     bannerID = $row_banners[bannerID]
                   ") or mysql_die();
        print MYSQL_RESULT($res_adviews,0,"count(bannerID)");
        $total_adviews=$total_adviews+MYSQL_RESULT($res_adviews,0,"count(bannerID)");
        ?></td>
        <td bgcolor="#eeeeee"><?print $strClicks;?>:
        <?
        $res_adclicks = mysql_db_query($phpAds_db, "
                   SELECT
                     count(bannerID)
                   FROM
                     $phpAds_tbl_adclicks
                   WHERE
                     bannerID = $row_banners[bannerID]
                   ") or mysql_die();
        print MYSQL_RESULT($res_adclicks,0,"count(bannerID)");
        $total_adclicks=$total_adclicks+MYSQL_RESULT($res_adclicks,0,"count(bannerID)");
        ?></td>
      <?
      }
      ?>
      <tr>
       <td width=25% bgcolor="#CCCCCC"><?print $strTotalViews;?>: <?print $total_adviews;?></td>
       <td width=25% bgcolor="#CCCCCC"><?print $strViewCredits;?>: <?if ($row_clients[views]!=-1)print $row_clients[views];else print "Unlimited";?></td>
       <td width=25% bgcolor="#CCCCCC"><?print $strTotalClicks;?>: <?print $total_adclicks;?></td>
       <td width=25% bgcolor="#CCCCCC"><?print $strClickCredits;?>: <?if ($row_clients[clicks]!=-1)print $row_clients[clicks];else print "Unlimited";?></td>
      </tr>
      <?
        if ($row_clients[views]!=-1 || $row_clients[clicks]!=-1)
        {
        ?>
          <tr>
            <td colspan=2 bgcolor="#CCCCCC" align="center">
            <?
              if ($row_clients[views]==-1)
                  print "&nbsp;";
              else
                  print "<img src=graph.php?width=200&data=Views^$total_adviews^^Credits^$row_clients[views]^^></td>\n";
              print "<td colspan=2 bgcolor=\"#CCCCCC\" align=\"center\">";
              if ($row_clients[clicks]==-1)
                  print "&nbsp;";
              else
                  print "<img src=graph.php?width=200&data=Clicks^$total_adclicks^^Credits^$row_clients[clicks]^^></td>\n";
            ?>
          </tr>
        <?
        }
      ?>
      <tr><td><br></td></tr>
      <?
      }
      ?>
      </table>
      </td></tr>
      </table>
      <table border=0 width=100% bgcolor="#ffffff" cellspacing=0 cellpadding=0>
      <tr>
           <?
           if (isset($lowID) && strlen($lowID) > 0)
             print "<td><a href=creditstats.php?lowID=$prevlowID>$strPrevious 10</a></td>";
           ?>
       <td align=right><a href=creditstats.php?prevlowID=<?print $lowID."&lowID=".$highID;?>><?print $strNext;?> 10</a></td></tr>
	<tr><td colspan=2><br></td></tr>
<?    
page_footer();
?>
