<?
require ("config.php");
require("kcsm.php");
require("gdcolors.inc.php");
require("gd.php");

Header("Content-type: image/$gdimageformat");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$im  =  imagecreate(385,150);
$bgcolor = ImageColorAllocate($im,$bgcolors[0],$bgcolors[1],$bgcolors[2]);
$linecolor = ImageColorAllocate($im,$linecolors[0],$linecolors[1],$linecolors[2]);
$textcolor = ImageColorAllocate($im,$textcolors[0],$textcolors[1],$textcolors[2]);
$adviewscolor = ImageColorAllocate($im,$adviewscolors[0],$adviewscolors[1],$adviewscolors[2]);
$adclickscolor = ImageColorAllocate($im,$adclickscolors[0],$adclickscolors[1],$adclickscolors[2]);

$i=0;
$total=0;
$max=0;
$where=urldecode($where);

mysql_select_db($phpAds_db);

$query="select count(*), DATE_FORMAT(t_stamp, '%k') as hour from $phpAds_tbl_adviews where ($where) GROUP BY hour";
$query2="select count(*), DATE_FORMAT(t_stamp, '%k') as hour from $phpAds_tbl_adclicks where ($where) GROUP BY hour";

$result = mysql_query($query);
$result2 = mysql_query($query2);
$count=array();
for($x=0;$x<24;$x++){
        $row = mysql_fetch_row($result);

        $count[$row[1]] = $row[0];
        $total += $row[0];
        if($row[0]>$max) $max=$row[0];
        
        $row2 = mysql_fetch_row($result2);
        $count2[$row2[1]] = $row2[0];
        $total2 += $row2[0];
        if($row2[0]>$max) $max=$row2[0];

        imagestringup($im, 1, ($x)*12+52, 140, $x, $textcolor);
}

$scale = (double)100/(double)$max;

imageline($im, 50, 20, 335, 20, $linecolor);
imageline($im, 50, 45, 335, 45, $linecolor);
imageline($im, 50, 70, 335, 70, $linecolor);
imageline($im, 50, 95, 335, 95, $linecolor);
imageline($im, 50, 120, 335, 120, $linecolor);
ImageFilledRectangle($im,50,2,60,12,$adviewscolor);
ImageRectangle($im,50,2,60,12,$linecolor);
imagestring($im, 2, 65, 0, "$strViews: $total", $textcolor);

ImageFilledRectangle($im,160,2,170,12,$adclickscolor);
ImageRectangle($im,160,2,170,12,$linecolor);

imagestring($im, 2, 175, 0, "$strClicks: $total2", $textcolor);

imagestring($im, 2, 20, 12, $max, $textcolor);
imagestring($im, 2, 25, 115, "0", $textcolor);
for($x = 0;$x<24;$x++){
     ImageFilledRectangle($im,$x*12+50,120-($count[$x]*$scale),$x*12+59,120,$adviewscolor);
     ImageRectangle($im,$x*12+50,120-($count[$x]*$scale),$x*12+59,120,$linecolor);
     ImageFilledRectangle($im,$x*12+52,120-($count2[$x]*$scale),$x*12+61,120,$adclickscolor);
     ImageRectangle($im,$x*12+52,120-($count2[$x]*$scale),$x*12+61,120,$linecolor);
}
showimage($im);
ImageDestroy($im);
?>
