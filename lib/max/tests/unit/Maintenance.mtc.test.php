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

require_once MAX_PATH . '/lib/max/Maintenance.php';

/**
 * A class for testing the MAX_OperationInterval class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMaxMaintenance extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMaxMaintenance()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests that an e-mail advising a campaign has been activated is able to
     * be generated correctly.
     */
    function testSendActivateCampaignEmail()
    {
        $contactName = 'Andrew Hill';
        $campaignName = 'Test Activation Campaign';
        $ads[0] = array('First Test Banner', '', 'http://example.com/');
        $ads[1] = array('Second Test Banner', 'Alt. Description', 'http://example.com/');
        $ads[2] = array('', 'Third Test Banner', 'http://example.com/foo/bar.html');
        $ads[3] = array('', '', 'http://example.com/foo.html');
        $email = MAX_Maintenance::prepareActivateCampaignEmail($contactName, $campaignName, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been activated because '. "\n";
        $desiredEmail .= 'the campaign activation date has been reached.' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nThank you for advertising with us.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= $conf['email']['admin_name'];
        $this->assertEqual($email, $desiredEmail);
    }

    /**
     * Tests that e-mails advising a campaign has been deactivated is able to
     * be generated correctly.
     */
    function testSendDeactivateCampaignEmail()
    {
        $contactName = 'Andrew Hill';
        $campaignName = 'Test Activation Campaign';
        $ads[0] = array('First Test Banner', '', 'http://example.com/');
        $ads[1] = array('Second Test Banner', 'Alt. Description', 'http://example.com/');
        $ads[2] = array('', 'Third Test Banner', 'http://example.com/foo/bar.html');
        $ads[3] = array('', '', 'http://example.com/foo.html');
        $email = MAX_Maintenance::prepareDeactivateCampaignEmail($contactName, $campaignName, 2, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - There are no impressions remaining' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nIf you would like to continue advertising on our website,\n";
        $desiredEmail .= "please feel free to contact us.\n";
        $desiredEmail .= "We'd be glad to hear from you.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= $conf['email']['admin_name'];
        $this->assertEqual($email, $desiredEmail);
        $email = MAX_Maintenance::prepareDeactivateCampaignEmail($contactName, $campaignName, 4, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - There are no clicks remaining' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nIf you would like to continue advertising on our website,\n";
        $desiredEmail .= "please feel free to contact us.\n";
        $desiredEmail .= "We'd be glad to hear from you.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= $conf['email']['admin_name'];
        $this->assertEqual($email, $desiredEmail);
        $email = MAX_Maintenance::prepareDeactivateCampaignEmail($contactName, $campaignName, 8, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - There are no conversions remaining' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nIf you would like to continue advertising on our website,\n";
        $desiredEmail .= "please feel free to contact us.\n";
        $desiredEmail .= "We'd be glad to hear from you.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= $conf['email']['admin_name'];
        $this->assertEqual($email, $desiredEmail);
        $email = MAX_Maintenance::prepareDeactivateCampaignEmail($contactName, $campaignName, 16, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - The campaign deactivation date has been reached' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nIf you would like to continue advertising on our website,\n";
        $desiredEmail .=  "please feel free to contact us.\n";
        $desiredEmail .= "We'd be glad to hear from you.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= $conf['email']['admin_name'];
        $this->assertEqual($email, $desiredEmail);
        $value = 0 | 2 | 4 | 8 | 16;
        $email = MAX_Maintenance::prepareDeactivateCampaignEmail($contactName, $campaignName, $value, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - There are no impressions remaining' . "\n";
        $desiredEmail .= '  - There are no clicks remaining' . "\n";
        $desiredEmail .= '  - There are no conversions remaining' . "\n";
        $desiredEmail .= '  - The campaign deactivation date has been reached' . "\n\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 0] First Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 1] Second Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 2] Third Test Banner' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo/bar.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= 'Ad [ID 3] Untitled' . "\n";
        $desiredEmail .= 'Linked to: http://example.com/foo.html' . "\n";
        $desiredEmail .= "-------------------------------------------------------\n";
        $desiredEmail .= "\nIf you would like to continue advertising on our website,\n";
        $desiredEmail .=  "please feel free to contact us.\n";
        $desiredEmail .= "We'd be glad to hear from you.\n\n";
        $desiredEmail .= "Regards,\n\n";
        $desiredEmail .= $conf['email']['admin_name'];
        $this->assertEqual($email, $desiredEmail);
    }

}

?>
