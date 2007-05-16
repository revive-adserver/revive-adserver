<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA/Email.php';

/**
 * A class for testing the OA_Email class.
 *
 * @package    Openads
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Email extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Email()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests that an e-mail advising a placement has been activated is able to
     * be generated correctly.
     */
    function testPrepareActivatePlacementEmail()
    {
        $contactName = 'Andrew Hill';
        $placementName = 'Test Activation Placement';
        $ads[0] = array('First Test Banner', '', 'http://example.com/');
        $ads[1] = array('Second Test Banner', 'Alt. Description', 'http://example.com/');
        $ads[2] = array('', 'Third Test Banner', 'http://example.com/foo/bar.html');
        $ads[3] = array('', '', 'http://example.com/foo.html');
        $email = OA_Email::prepareActivatePlacementEmail($contactName, $placementName, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been activated because '. "\n";
        $desiredEmail .= 'the placement activation date has been reached.' . "\n\n";
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
     * Tests that e-mails advising a placement has been deactivated is able to
     * be generated correctly.
     */
    function testSendDeactivatePlacementEmail()
    {
        $contactName = 'Andrew Hill';
        $placementName = 'Test Activation Placement';
        $ads[0] = array('First Test Banner', '', 'http://example.com/');
        $ads[1] = array('Second Test Banner', 'Alt. Description', 'http://example.com/');
        $ads[2] = array('', 'Third Test Banner', 'http://example.com/foo/bar.html');
        $ads[3] = array('', '', 'http://example.com/foo.html');
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, 2, $ads);
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
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, 4, $ads);
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
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, 8, $ads);
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
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, 16, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - The placement deactivation date has been reached' . "\n\n";
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
        $email = OA_Email::prepareDeactivatePlacementEmail($contactName, $placementName, $value, $ads);
        $desiredEmail  = 'Dear Andrew Hill,' . "\n\n";
        $desiredEmail .= 'The following ads have been disabled because:' . "\n";
        $desiredEmail .= '  - There are no impressions remaining' . "\n";
        $desiredEmail .= '  - There are no clicks remaining' . "\n";
        $desiredEmail .= '  - There are no conversions remaining' . "\n";
        $desiredEmail .= '  - The placement deactivation date has been reached' . "\n\n";
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