<?

if(!isset($pageid)) $pageid = "";
$fncpageid = "?pageid=$pageid";

// Show navigation
function show_nav($ID)
 {
 ?>
  </td>
 </tr>
 <tr>
  <td bgcolor="#CCCCCC">
 <?
 global $pages;
 $sections = explode(".", $ID);
 $sectionID = "";
 for ($i=0; $i<count($sections)-1; $i++)
     {
     $sectionID .= $sections[$i];
     list($filename, $title) = each($pages["$sectionID"]);
     $sectionID .= ".";     
     if(!isset($fncpageid))
     {
         $fncpageid = "";
     }
     echo "<a href=$filename$fncpageid>$title</a> <img src=$GLOBALS[phpAds_url_prefix]/arrow.gif width=8 height=7> ";
     }
 list($filename, $title) = each($pages["$ID"]);
 echo "$title<br>";
 ?>
  </td>
 </tr>
 <tr>
  <td>
 <?
 }

// some layout functions
function page_header($title = false)
 {
 global $pages, $phpAds_name;
 
// if(!$title)
// {
//     $title = $phpAds_name;
// }
 ?>
<html>
<head>
<title><?echo $title;?></title>
<meta name="author" content="Profi Online Service <http://www.profi.it>">
<style type="text/css">
<!--
body {  font-family: Arial, Helvetica, sans-serif; font-size: 10pt}
table { font-family: Arial, Helvetica, sans-serif; font-size: 10pt }
td { font-family: Arial, Helvetica, sans-serif; font-size: 10pt }
.heading { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14pt; font-weight: bold; color: white; margin-bottom: 0px;}
-->
</style>
</head>

<body bgcolor="#FFFFFF">
<table border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#000099">
  <tr>
    <td>
      <table border="0" align="center" bgcolor="#FFFFFF" cellspacing="0" cellpadding="5">
        <tr bgcolor="#000099"> 
          <td align=center><span class="heading"><?echo "$phpAds_name $title";?></span></td>
        </tr>
        <tr> 
          <td>
 <?        
 }
 
function page_footer()
 {
 ?>
         </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
 <?
 } 

// Show a messgae
function show_message($message)
 {
 ?>
             <table border="0" align="" width="100%">
              <tr bgcolor="#CCCCFF"> 
                <td><b><?echo $message;?></b></td>
              </tr>
            </table>
 <?
 }
 
// Display MySQL's last error message an die
function mysql_die()
 {
 global $strMySQLError;
 echo "$strMySQLError: <br>";
 echo mysql_error();
 page_footer();
 exit;
 }

// Display a custom error message and die 
function php_die($title="Error", $message="Unkown error")
 {
 ?>
             <table border="0" align="" width="100%">
              <tr bgcolor="#CCCCFF"> 
                <td><b><?echo $title;?></b><br><?echo $message;?></td>
              </tr>
            </table>
 <?
 page_footer();
 exit;
 }
 
require("view.inc.php");
 
$link = mysql_pconnect($phpAds_hostname, $phpAds_mysqluser, $phpAds_mysqlpassword);
?>
