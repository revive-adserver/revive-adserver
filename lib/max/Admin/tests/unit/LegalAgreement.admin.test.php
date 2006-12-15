<?php
/**
 * Legal agreement page tests for Max Media Manager
 *
 * @since 0.3.22 - Apr 13, 2006
 * @copyright 2006 M3 Media Services
 * @version $Id: LegalAgreement.admin.test.php 4735 2006-04-24 13:36:06Z matteo@beccati.com $
 */

require_once MAX_PATH . '/lib/max/Admin/LegalAgreement.php';
require_once MAX_PATH . '/lib/max/Dal/LegalAgreement.php';
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';

Mock::generate('MAX_Dal_LegalAgreement');

class LegalAgreementTest extends UnitTestCase
{
    function setUp()
    {
        $this->mock_dal = new MockMAX_Dal_LegalAgreement($this);
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('MAX_Dal_LegalAgreement', $this->mock_dal);
    }
    
    function testAgreementShowsIfSessionAndDalSaySo()
    {
        $this->mock_dal->setReturnValue('isAgreementNecessaryForPublisher', true);
        $this->mock_dal->expectOnce('isAgreementNecessaryForPublisher', array(1));
        
        global $session;
        $session['usertype'] = phpAds_Publisher;
        $session['userid'] = 1;
        $session['needs_to_agree'] = 1;
        
        $agreement_page = new MAX_Admin_LegalAgreement();
        $this->assertTrue($agreement_page->doesCurrentUserNeedToSeeAgreement());
    }
    
    function testAgreementDoesntShowIfSessionSaysNotTo()
    {
        global $session;
        $session['usertype'] = phpAds_Publisher;
        $session['needs_to_agree'] = 0;
        
        $agreement_page = new MAX_Admin_LegalAgreement();
        $this->assertFalse($agreement_page->doesCurrentUserNeedToSeeAgreement());
    }
    
    function testAgreementDoesntShowIfSessionDoesntSayAnything()
    {
        global $session;
        $session['usertype'] = phpAds_Publisher;
        unset($session['needs_to_agree']);
        
        $agreement_page = new MAX_Admin_LegalAgreement();
        $this->assertFalse($agreement_page->doesCurrentUserNeedToSeeAgreement());
    }
    
    function tearDown()
    {
        $this->mock_dal->tally();
    }
}

?>
