<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


function phpAds_InstallMessage($title, $message)
{
?>
<br><br>
		<table border='0' cellpadding='1' cellspacing='1' width='100%'><tr><td bgcolor='#0033FF'>
			
      <table border='0' cellpadding='5' cellspacing='0' width='100%'>
        <tr bgcolor='#F7F7F7'> 
          <td width='20' valign='top'><img src='images/info-w.gif' hspace='3'></td>
          <td valign='top' bgcolor="#F7F7F7"><b> </b> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="18" valign="top"><b> 
                  <?php echo $title;?>
                  </b></td>
              </tr>
              <tr> 
                <td height="3" valign="top"><img src="images/break-l.gif" width="100%" height="1"></td>
              </tr>
              <tr> 
                <td><br>
                  <?php echo $message;?>
                  <br>
                  &nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
		</td></tr></table>
<?php
}

?>
