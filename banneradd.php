<?

require ("config.php");
require("kcsm.php");

kc_auth_admin();

if (!empty($bannerID))
   {
   $Session["bannerID"] = "$bannerID";
   }

// If the form is being submitted, add a new record to banners
if (isset($submit))
   {
   switch($bannertype) 
          {
          case "mysql":
               if (!empty($mysql_banner) && $mysql_banner != "none")
                  {
                  $size = GetImageSize($mysql_banner);
                  $final["width"] = $size[0];
                  $final["height"] = $size[1];
                  $ext = substr($mysql_banner_name, strrpos($mysql_banner_name, ".")+1);
                  switch (strtoupper($ext)) 
                         {
                         case "JPEG":
                              $final["format"] = "jpeg";
                              break;
                         case "JPG":
                              $final["format"] = "jpeg";
                              break;
                         case "HTML":
                              $final["format"] = "html";
                              break;
                         case "PNG":
                              $final["format"] = "png";
                              break;
                         case "GIF":
                              $final["format"] = "gif";
                         }
                  $final["banner"] = addslashes(fread(fopen($mysql_banner, "r"), filesize($mysql_banner)));
                  }
               $final["alt"] = $mysql_alt;
               $final["bannertext"] = $mysql_bannertext;
               $final["url"] = $mysql_url;
               break;
          case "url":
               $final["width"] = $url_width;
               $final["height"] = $url_height;
               $final["format"] = "url";
               $final["banner"] = $url_banner;
               $final["alt"] = $url_alt;
               $final["bannertext"] = $url_bannertext;               
               $final["url"] = $url_url;               
               break;
          case "html";
               $final["format"] = "html";
               $final["banner"] = $html_banner;
               $final["width"] = "";
               $final["height"] = "";
               $final["alt"] = "";
               $final["bannertext"] = "";
               $final["url"] = $html_url;       
          }
    $final["clientID"] = (IsSet($Session["clientID"]) ? $Session["clientID"] : "0");
   if (!empty($Session["bannerID"]))
      $final["bannerID"] = $Session["bannerID"];
   $final["active"] = "true";
   $final["keyword"] = $keyword;
   $final["weight"] = $weight;

   // Don't add an empty banner
   if (empty($final["banner"]) || $final["banner"] == "none")
      unset($final["banner"]);

   $message = empty($Session["bannerID"]) ? $strBannerAdded : $strBannerModified;

   // Construct appropiate SQL query
   // If bannerID==null, thehn this is an INSERT, else it's an UPDATE
   if (!isset($final["bannerID"]))
      { //INSERT
      $values_fields = "";
      $values = "";
      while (list($name, $value) = each($final))
            {
            $values_fields .= "$name, ";
            $values .= "'$value', ";
            }

      // Cut trailing commas
      $values_fields = ereg_replace(", $", "", $values_fields);
      $values = ereg_replace(", $", "", $values);
   
      // Execute query
      $sql_query = "
              INSERT
                INTO $phpAds_tbl_banners
                ($values_fields)
              VALUES
                (
                $values
                )";
      $res = mysql_db_query($phpAds_db, $sql_query) or mysql_die();     
      }
   else 
      { // UPDATE
      $set = "";
      while (list($name, $value) = each($final))
            {
            $set .= "$name = '$value', ";
            }

      // Cut trailing commas
      $set = ereg_replace(", $", "", $set);
   
      // Execute query
      $sql_query = "
              UPDATE
                $phpAds_tbl_banners
              SET
                $set
              WHERE
                bannerID = $final[bannerID]";
      $res = mysql_db_query($phpAds_db, $sql_query) or mysql_die();     
      }
   unset($Session["bannerID"]); 
   Header("Location: banner.php$fncpageid&message=".urlencode($message));
   exit;
   }
page_header("$strBannerAdmin");
// If we find an ID, means that we're in update mode  
if (isset($bannerID))
   {
   show_nav("1.3.2");
   $res = mysql_db_query($phpAds_db, "
          SELECT
            *
          FROM
            $phpAds_tbl_banners
          WHERE
            bannerID = $bannerID
          ") or mysql_die();
   $row = mysql_fetch_array($res);
   if (ereg("gif|png|jpeg", $row["format"]))
      $type = "mysql";
   else
      $type = $row["format"];
   }
else
   {
   show_nav("1.3.1");   
   }
?>

<form action="<?echo basename($PHP_SELF);?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="pageid" value="<? echo ($pageid) ?>">
			<table width="100%" cellspacing="0" cellpadding="1" bgcolor="#000099">
            <?
            if (!empty($row["bannerID"]))
               {
               ?>
                <tr>
                    <td bgcolor="#FFFFFF"><table><tr><td> <?echo $strCurrentBanner;?>: </td><td><?echo "<img src=\"./viewbanner.php?bannerID=$row[bannerID]\" width=$row[width] height=$row[height] alt=\"$row[alt]\" border=0>";?></td></tr></table></td>
                </tr>
               <?
               }
               ?>
              <tr align="center"> 
                <td> 
                  <font color="#FFFFFF"><b><?echo $strChooseBanner;?></b></font>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                    <tr>
                      <td> 
                        <table>
                          <tr> 
                              <td colspan=2 bgcolor="#000099" align=CENTER> <font color="#FFFFFF"><b> 
                                <input type="radio" name="bannertype" value="mysql"<?if (isset($type) && $type == "mysql") echo " checked";if (!isset($type)) echo "checked"?>>
                                <?echo $strMySQLBanner;?></b></font></td>
                          </tr>
                          <tr> 
                            <td><?echo $strNewBannerFile;?></td>
                            <td> 
                                <input type="file" name="mysql_banner">
                            </td>
                          </tr>
                          <tr> 
                            <td><?echo $strURL;?>:</td>
                            <td> 
                                <input size="40" type="text" name="mysql_url" value="<?if (isset($type) && $type == "mysql") echo $row["url"];?>">
                            </td>
                          </tr>
                          <tr> 
                            <td><?echo $strAlt;?>:</td>
                            <td> 
                                <input size="40" type="text" name="mysql_alt" value="<?if (isset($type) && $type == "mysql") echo $row["alt"];?>">
                            </td>
                          </tr>
                          <tr> 
                            <td><?echo $strTextBelow;?>:</td>
                            <td> 
                                <input size="40" type="text" name="mysql_bannertext" value="<?if (isset($type) && $type == "mysql") echo $row["bannertext"];?>">
                            </td>
                          </tr>
                          <tr> 
                              <td colspan=2 bgcolor="#000099" align=CENTER> <font color="#FFFFFF"><b> 
                                <input type="radio" name="bannertype" value="url"<?if (isset($type) && $type == "url") echo " checked";?>>
                                <?echo $strURLBanner;?></b></font></td>
                          </tr>
                          <tr> 
                              <td height="32"><?echo $strNewBannerURL;?>:</td>
                              <td height="32"> 
                                <input size="40" type="text" name="url_banner" value="<?if (isset($type) && $type == "url") echo $row["banner"];?>">
                            </td>
                          </tr>
                          <tr> 
                            <td><?echo $strURL;?></td>
                            <td> 
                                <input size="40" type="text" name="url_url" value="<?if (isset($type) && $type == "url") echo $row["url"];?>">
                            </td>
                          </tr>
                          <tr> 
                            <td><?echo $strWidth;?>:</td>
                            <td> 
                                <input size="40" type="text" name="url_width" value="<?if (isset($type) && $type == "url") echo $row["width"];?>">
                            </td>
                          </tr>
                          <tr> 
                            <td><?echo $strHeight;?>:</td>
                            <td> 
                                <input size="40" type="text" name="url_height" value="<?if (isset($type) && $type == "url") echo $row["height"];?>">
                            </td>
                          </tr>
                          <tr> 
                            <td><?echo $strAlt;?>:</td>
                            <td> 
                                <input size="40" type="text" name="url_alt" value="<?if (isset($type) && $type == "url") echo $row["alt"];?>">
                            </td>
                          </tr>
                          <tr> 
                            <td><?echo $strTextBelow;?>:</td>
                            <td> 
                                <input size="40" type="text" name="url_bannertext" value="<?if (isset($type) && $type == "url") echo $row["bannertext"];?>">
                            </td>
                          </tr>
                          <tr> 
                              <td colspan=2 bgcolor="#000099" align=CENTER> <font color="#FFFFFF"><b> 
                                <input type="radio" name="bannertype" value="html"<?if (isset($type) && $type == "html") echo " checked";?>>
                                <?echo $strHTMLBanner;?></b></font></td>
                          </tr>
                          <tr> 
                            <td><?echo $strHTML;?>:</td>
                            <td> 
                                <textarea cols="40" rows="5" name="html_banner"><?if (isset($type) && $type == "html") echo $row["banner"];?></textarea>
                            </td>
                          </tr>
                          <tr>
                            <td><?echo $strURL;?>:</td>
                            <td>
                                <input size="40" type="text" name="html_url" value="<?if (isset($type) && $type == "html") echo $row["url"];?>">
                            </td>
                          </tr>

                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

              <table cellpadding=0 cellspacing=0 width="100%">
                <tr> 
                  <td><?echo $strKeyword;?>:</td>
                  <td> 
                    <input size="40" type="text" name="keyword" value="<?if(isset($row["keyword"]))echo $row["keyword"];?>">
                  </td>
                </tr>
                <tr>
                  <td><?echo $strWeight;?>:</td>
                  <td>
                    <input size="40" type="text" name="weight" value="<?if(isset($row["weight"])){echo $row["weight"];}else{print "1";}?>">
                  </td>
                </tr>
                <tr> 
                  <td><?echo $strSubmit;?>:</td>
                  <td> 
                    <input type="submit" name="submit" value="<?echo $strGo;?>">
                  </td>
                </tr>
              </table>
            </form>
<?
 page_footer();
?>
