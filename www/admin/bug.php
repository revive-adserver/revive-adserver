<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once '../../init.php';
require_once MAX_PATH . '/lib/max/BugReporter.php';

$reporter = new MAX_BugReporter();
    
if ($_POST['submitted']) {

    //  send email
    $oReport = new MAX_BugReport((object) $_POST['bug']);
    $email = $reporter->buildEmail($oReport);
    $ok = $email->send();
    $message = ($ok) ? 'Bug report sent successfully - thanks' : '';
    
    //  post to Trac
    $aExtensions = get_loaded_extensions();
    if (in_array('curl', $aExtensions)) {
        
        //  check if remote posting enabled
        $allowed = @file('http://www.openads.org/trac_remote_post.txt');
        if ($allowed[0] == 1) {
        
            require_once MAX_PATH . '/lib/max/CurlWrapper.php';
            $curl = new MAX_CurlWrapper();
            
            $target = 'https://trac.openads.org/newticket#preview';
            $aBody = array(
                //  report details
                'reporter' => $oReport->getEmail(), 
                'summary' => $oReport->getSummary(),
                'description' => $oReport->toString(),
                
                //  necessary hidden vars
                'mode' => 'newticket',
                'action' => 'create',
                'status' => 'new',
                
                //  categorisation
                'component' => 'General',
                'severity' => 'normal',
                'priority' => 'normal',
                
                //  doesn't work without this
                'create' => 'Submit+ticket'
                );
            $ret = $curl->sendRequest($target, $aBody);
        }
    }
}

// max init and html framework
require_once MAX_PATH . '/www/admin/config.php';
phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client + phpAds_Affiliate);
phpAds_PageHeader(1);

global $pref;
if (!empty($pref['name'])) {
    $productName = $pref['name'];
} elseif (empty($pref['my_logo'])) {
    $productName = MAX_PRODUCT_NAME;
} else {
    $productName = '';
}

?>

<script language="javascript">
function enableField()
{
    myField = document.getElementById('foo');
    myField.disabled = false;
}
</script>
    
<form id="bugReport" name="bugReport" method="post" onSubmit="enableField();">
    <h1>Bug Report</h1>
    <table>
        <tr>
            <td colspan="2">Found a bug? Please fill out and submit the form below - help us make <?php echo "$productName"; ?> better software.<br /> -- Thanks</td>
        </tr>

        <tr>
            <td style="color:Red" colspan="2"><strong><?php echo $message ?></strong></td>
        </tr>

        <tr>

            <td>First Name:</td>
            <td>
                <input type="text" name="bug[first_name]" value="" size="30" />
            </td>
        </tr>

        <tr>
            <td>Last Name:</td>

            <td>
                <input type="text" name="bug[last_name]" value="" size="30" />
            </td>
        </tr>

        <tr>
            <td>Email:</td>
            <td>
                <input type="text" name="bug[email]" value="" size="30" />

            </td>
        </tr>

        <tr>
            <td>Severity of bug:</td>
            <td>
                <select name="bug[severity]">
                    <option>critical</option>
                    <option>major</option>
                    <option>minor</option>
                    <option>enhancement</option>
                    <option>question</option>
                    <option>feature request</option>
                    <option>not categorized</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>Issue summary</td>
            <td>
                <input type="text" name="bug[summary]" value="" size="61" />

            </td>
        </tr>
        
        <tr>
            <td>Comment:</td>
            <td>
                <textarea name="bug[comment]" cols="60" rows="5"></textarea>
            </td>
        </tr>
        
        <tr>
            <td>Your environment:</td>
            <td>
                <textarea id="foo" name="bug[environment]" cols="100" rows="11" disabled="true">
<?php
print $reporter->buildEnvironmentReport();
?>
                </textarea>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <input type="submit" name="submitted" value="Send it" />
            </td>
        </tr>
    </table>
</form>

<?php
phpAds_PageFooter();
?>