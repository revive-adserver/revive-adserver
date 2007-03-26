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

/**
 * Legal agreement DAL tests for Max Media Manager
 *
 * @package MaxDal
 * @subpackage TestSuite
 * @since 0.3.22 - Apr 13, 2006
 * @copyright 2006 M3 Media Services
 * @version $Id$
 */

require_once MAX_PATH . '/lib/max/Dal/LegalAgreement.php';

class Dal_TestOfDalLegalAgreement extends UnitTestCase
{
    function setUp()
    {
        TestEnv::startTransaction();
        $this->addSamplePublishers();
        $this->dal = new MAX_Dal_LegalAgreement();
    }
    
    function tearDown()
    {
        TestEnv::rollbackTransaction();
    }
    
    function addSamplePublishers()
    {
        $dbh = &OA_DB::singleton();
        $conf = $GLOBALS['_MAX']['CONF'];
        $publisher_table = $conf['table']['prefix'] . 'affiliates';
        
        $query = "
            INSERT INTO $publisher_table
            (affiliateid, last_accepted_agency_agreement, mnemonic, name, email, agencyid)
            VALUES
            (1, NULL, 'fresh', 'Freshly signed-up affiliate', 'fresh@example.com', 674),
            (2, '1999-12-31 23:59:59', 'codger', 'Agreed ages ago', 'codger@example.com', 674),  
            (3, NULL, 'simple', 'Affiliate with no agreement', 'fresh@example.com', 999)
        ";
        $dbh->exec($query);
    }
    
    function addSampleAgencies()
    {
        $dbh = &OA_DB::singleton();
        $conf = $GLOBALS['_MAX']['CONF'];
        $agency_table = $conf['table']['prefix'] . 'agency';
        $preference_table = $conf['table']['prefix'] . 'preference';
        
        $query = "
            INSERT INTO $agency_table
            (agencyid, name, email)
            VALUES
            (674, 'Agency with agreement', 'agreement@example.com'),
            (999, 'Agency without agreement', 'no.agreement@example.com')
        ";
        $dbh->exec($query);
        
        $query = "
            INSERT INTO $preference_table
            (agencyid, publisher_agreement, publisher_agreement_text)
            VALUES
            (674, 't', 'I will breathe in and out at least once.'),
            (999, 'f', NULL)
        ";
        $dbh->exec($query);
    }
        
    function testDetectPublisherHasAgreed_NotAgreed()
    {
        $this->assertFalse($this->dal->hasPublisherAgreed(1), "Publisher ID #1 is freshly signed up and hasn't agreed yet.");
    }
    
    function testDetectPublisherHasAgreed_AlreadyAgreed()
    {
        $this->assertTrue($this->dal->hasPublisherAgreed(2), "Publisher ID #2 agreed ages ago.");
    }
    
    function testDetectAgreementIsNecessary()
    {
        $this->addSampleAgencies();
        $this->assertTrue($this->dal->isAgreementNecessaryForPublisher(1), "Publisher ID #1 is freshly signed up and hasn't agreed yet.");
    }
    
    function testDetectAgreementIsUnnecessary_NoAgreement()
    {
        $this->addSampleAgencies();
        $this->assertFalse($this->dal->isAgreementNecessaryForPublisher(3), "Publisher ID #3's agency has no agreement text set.");
    }
    
    function testDetectAgreementExistsForPublisher()
    {
        $this->addSampleAgencies();
        $this->assertTrue($this->dal->doesAgreementExistForPublisher(1), "Publisher ID #1's agency has agreement text.");
    }
    
    function testDetectAgreementExistsForAgency()
    {
        $this->addSampleAgencies();
        $this->assertTrue($this->dal->doesAgreementExistForAgency(674), "Agency ID #674 has agreement text.");
    }
    
    function testDetectAgreementNotExistsForAgency()
    {
        $this->addSampleAgencies();
        $this->assertTrue(!$this->dal->doesAgreementExistForAgency(999), "Agency ID #999 has no agreement text set.");
    }
    
    function testAgreeingWorks()
    {
        $this->dal->acceptAgreementForPublisher(1);
        $this->assertTrue($this->dal->hasPublisherAgreed(1));
    }
    
    function testUnAgreeingWorks()
    {
        $this->dal->unAcceptAgreementForPublisher(2);
        $this->assertTrue(!$this->dal->hasPublisherAgreed(2));
    }
    
    function testRetrieveAgreementForAgency()
    {
        $this->addSampleAgencies();
        $text = $this->dal->getAgreementTextForAgency(674);
        $this->assertEqual($text, 'I will breathe in and out at least once.');
    }
    
    function testAgreementTextIsEmptyWhenNoAgreementSet()
    {
        $this->addSampleAgencies();
        $text = $this->dal->getAgreementTextForAgency(999);
        $this->assertEqual($text, '');
    }
}

?>
