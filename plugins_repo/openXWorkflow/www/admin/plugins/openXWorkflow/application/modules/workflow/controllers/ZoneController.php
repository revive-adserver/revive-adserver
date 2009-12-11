<?php
require_once MAX_PATH . '/lib/max/Admin/Invocation.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Zones.php';


class Workflow_ZoneController 
    extends OX_Workflow_UI_Controller_WorkflowController
{
    public function indexAction()
    {
        $oMarketManager = new MarketManager();
        $oWizard = new OX_Workflow_UI_WizardManager($this->getWizardId(), array( 
            'steps' => $this->getSteps($oMarketManager)));
        $oWizard->reset();
        $this->redirect($oWizard->getFirstStep());
    }
    
    
    protected function getSteps(MarketManager $oMarketManager)
    {
        $aStepLabels = array(
            'website' => $this->view->pcString('zone-wizard', 'website-step-label', 'Define your website'),
            'zone' => $this->view->pcString('zone-wizard', 'zone-step-label', 'Define your zones'),
            'market' => $this->view->pcString('zone-wizard', 'market-step-label', 'Optimize ad revenue'),
            'tags' => $this->view->pcString('zone-wizard', 'tags-step-label', 'Insert your ad tags'),
            'congrats' => $this->view->pcString('zone-wizard', 'congrats-step-label', 'Finish')
        );        
        
        if ($oMarketManager->isMarketAvailable()) {
            $aSteps = array(
                'step1' => '1. ' . $aStepLabels['website'],
                'step2' => '2. ' . $aStepLabels['zone'], 
                'step3' => '3. ' . $aStepLabels['market'], 
                'step4' => '4. ' . $aStepLabels['tags'], 
                'step5' => '5. ' . $aStepLabels['congrats']
            );    
        }
        else {
            $aSteps = array(
                'step1' => '1. ' . $aStepLabels['website'],
                'step2' => '2. ' . $aStepLabels['zone'], 
                'step4' => '3. ' . $aStepLabels['tags'], 
                'step5' => '4. ' . $aStepLabels['congrats']
            );    
        }
        
        return $aSteps;
    }
    
    
    /** website step **/
    public function step1Action()
    {
        $oMarketManager = new MarketManager();
        $aSteps = $this->getSteps($oMarketManager);
        $current = 'step1';
        
        $oWizard = new OX_Workflow_UI_WizardManager($this->getWizardId(), array('current' => $current, 
            'steps' => $aSteps));
        $aStepData = $oWizard->getStepData();
        
        if (empty($aStepData)) {
            $aStepData = array();
            $oCurrentUser = OA_Permission::getCurrentUser();
            $aStepData['url'] = 'http://';
            $aStepData['contact'] = $oCurrentUser->aUser['contact_name'];
            $aStepData['contactEmail'] = $oCurrentUser->aUser['email_address'];
        }
        
        $oForm = new OX_Workflow_UI_Form_ZoneWizardForm(array(
            'step' => 1, 
            'data' => $aStepData, 
            'marketEnabled' => $oMarketManager->isMarketAvailable(),
            'pcStringHelper' => $this->view->getHelper('pcString')        
        ));
        $this->controlStep(1, $oWizard, $oForm);
        $this->view->form = $oForm;
        $this->view->aSteps = $aSteps;
        $this->view->current = $current;
    }
    
    
    /** sizes step **/
    public function step2Action()
    {
        $oMarketManager = new MarketManager();
        $aSteps = $this->getSteps($oMarketManager);
        $current = 'step2';
        
        $oWizard = new OX_Workflow_UI_WizardManager($this->getWizardId(), array('current' => $current, 
            'steps' => $aSteps));
                    
        if (!$oWizard->checkStepReachable()) {
            $this->redirect($oWizard->getFirstStep());
        }        
                
        $aStepData = $oWizard->getStepData();
        $oForm = new OX_Workflow_UI_Form_ZoneWizardForm(array(
            'step' => 2, 
            'data' => $aStepData, 
            'sizes' => new ZoneWizardSizes(), 
            'marketEnabled' => $oMarketManager->isMarketAvailable(),
            'pcStringHelper' => $this->view->getHelper('pcString')
        ));
        $this->controlStep(2, $oWizard, $oForm);
        $this->view->form = $oForm;
        $this->view->aSteps = $aSteps;
        $this->view->current = $current;
        $this->view->allSizesPreviewUrl = $this->getOxWorkflowComponent()
            ->getConfigValue('adSizesPreviewUrl');
    }
    
    
    /** market step **/
    public function step3Action()
    {
        $oMarketManager = new MarketManager();
        $aSteps = $this->getSteps($oMarketManager);
        $current = 'step3';
        
        $oWizard = new OX_Workflow_UI_WizardManager($this->getWizardId(), array('current' => $current, 
            'steps' => $aSteps));
                    
        if (!$oWizard->checkStepReachable()) {
            $this->redirect($oWizard->getFirstStep());
        }        
        
        $aStepData = $oWizard->getStepData();
        $oForm = new OX_Workflow_UI_Form_ZoneWizardForm(array(
            'step' => 3, 
            'data' => $aStepData, 
            'marketEnabled' => $oMarketManager->isMarketAvailable(),
            'pcStringHelper' => $this->view->getHelper('pcString')        
        ));
        $this->controlStep(3, $oWizard, $oForm);
        $this->view->form = $oForm;
        $this->view->aSteps = $aSteps;
        $this->view->current = $current;
    }
    
    
    /** tags step **/
    public function step4Action()
    {
        $oMarketManager = new MarketManager();
        $aSteps = $this->getSteps($oMarketManager);
        $current = 'step4';
        
        $oWizard = new OX_Workflow_UI_WizardManager($this->getWizardId(), array('current' => $current, 
            'steps' => $aSteps));
                    
        if (!$oWizard->checkStepReachable()) {
            $this->redirect($oWizard->getFirstStep());
        }        
        
        
        if (!$oWizard->isStepCompleted()) { //save website and zones
            //save website and zones here and continue with generation
            //also set saved entities in storage      
            $aNewStepData = array();
            
            $websiteId = $this->saveWebsite($oWizard, $oMarketManager);
            if (!empty($websiteId)) {
                $zoneIds = $this->saveZones($oWizard, $oMarketManager, $websiteId);
                
                $aNewStepData['websiteId'] = $websiteId;
                $aNewStepData['zoneIds'] = $zoneIds;

                //if market is not enabled create sample adv.camp,banner 
                //and link them to created zones
                if (!$oMarketManager->isMarketAvailable()) {
                    $advertiserId = $this->saveAdvertiser($oWizard);
                    $campaignId = $this->saveCampaign($oWizard, $advertiserId);
                    $aBannerIds = $this->saveBanners($oWizard, $campaignId, $zoneIds);
                    $aNewStepData['campaignId'] = $campaignId;
                    $aNewStepData['bannerIds'] = $aBannerIds;
                }
                
                $oWizard->setStepData($aNewStepData);
                $oWizard->markStepAsCompleted();
            }
        }
            
        $aStepData = $oWizard->getStepData();
        
        
        $oForm = new OX_Workflow_UI_Form_ZoneWizardForm(array(
            'step' => 4, 
            'data' => $aStepData, 
            'marketEnabled' => $oMarketManager->isMarketAvailable(),
            'pcStringHelper' => $this->view->getHelper('pcString')
        ));
        if ($this->getRequest()->isPost()) {
            if (!empty($_POST['next']) && $oForm->isValid($_POST)) {
                $this->redirect($oWizard->getNextStep($stepId));
            }
            else if(!empty($_POST['back'])) {
                $this->redirect($oWizard->getPreviousStep($stepId));
            }
        }

        $this->generateAndAssignTags($oWizard);
        $this->view->form = $oForm;
        $this->view->aSteps = $aSteps;
        $this->view->current = $current;
    }
    
    
    /** congrats step **/
    public function step5Action()
    {
        $oMarketManager = new MarketManager();
        $aSteps = $this->getSteps($oMarketManager);
        $current = 'step5';
        
        $oWizard = new OX_Workflow_UI_WizardManager($this->getWizardId(), array('current' => $current, 
            'steps' => $aSteps));
                    
        if (!$oWizard->checkStepReachable()) {
            $this->redirect($oWizard->getFirstStep());
        }        
                
        
        $aStepData = $oWizard->getStepData();
        $oForm = new OX_Workflow_UI_Form_ZoneWizardForm(array(
            'step' => 5, 
            'data' => $aStepData, 
            'marketEnabled' => $oMarketManager->isMarketAvailable(),
            'pcStringHelper' => $this->view->getHelper('pcString')
        ));
        $this->controlStep(5, $oWizard, $oForm);
        $this->view->form = $oForm;
        $this->view->aSteps = $aSteps;
        $this->view->current = $current;
        $this->view->adminWebPath = MAX::constructURL(MAX_URL_ADMIN, '');
    }
   
   
    public function sizePreviewAction()
    {
        $this->_helper->layout->setLayout('layout-preview');
        $width = $this->_request->getParam('width');
        $height = $this->_request->getParam('height');
        
        $this->view->width = $width;
        $this->view->height = $height;
    }    
    
    
    protected function getWizardId()
    {
        $accountId = Oa_Permission::getAccountId();
        return 'Workflow_ZoneController_ac'.$accountId;
    }
   
   
    /**
    * A common method to control submit identical in most of the steps (apart tags step)
    *
    * @param int $stepNo
    * @param OX_Workflow_UI_WizardManager $oWizard
    * @param OX_UI_Form $oForm
    */
    protected function controlStep($stepNo, $oWizard, $oForm)
    {
        $stepId = 'step'.$stepNo;
        
        if ($this->getRequest()->isPost()) {
            if (!empty($_POST['next']) && $oForm->isValid($_POST)) {
                $aStepData = array();
                $aStepData = $oForm->populateStepData($stepNo, $aStepData);
                $oWizard->setStepData($aStepData);
                $oWizard->markStepAsCompleted();
                
                $nextStep = $oWizard->getNextStep($stepId);
                if ($nextStep) {
                    $this->redirect($nextStep);
                }
                else { //close the wizard
                    $oWizard->reset();
                    OX_Admin_Redirect::redirect('affiliate-zones.php');
                }
            }
            else if(!empty($_POST['back'])) {
                //save user's current data (do not validate, will validate on next)
                $aStepData = array();
                $oForm->populate($_POST);
                $aStepData = $oForm->populateStepData($stepNo, $aStepData);
                $oWizard->setStepData($aStepData);
                
                $prevStep = $oWizard->getPreviousStep($stepId);
                if ($prevStep) {
                    $this->redirect($prevStep);
                }
            }
        }
    }
    
    
    /**
     * Used by tags step. Invokes SPC invocation tag component and directs it
     * to generate header and zone tags with for given zones. Uses number of
     * occurences to generate aliases.
     * 
     * Generated tags (header and zone) are then assigned to view.
     *
     * @param OX_Workflow_UI_WizardManager $oWizard
     */
    private function generateAndAssignTags(OX_Workflow_UI_WizardManager $oWizard)
    {
        $aEntities = $this->getCreatedEntities($oWizard);
        $aWebsite = $aEntities['website'];
        $oAliasBuilder = new OX_Workflow_UI_ZoneAliasBuilder();
        $aZoneAliases = $oAliasBuilder->buildZoneAliases($aEntities['zones']);
        
        $invocationTag = OX_Component::factoryByComponentIdentifier("invocationTags:oxInvocationTags:spc");        
        $oInvocation = new MAX_Admin_Invocation();
        
        $aInvocationParams = array(
            'affiliateid' => $aWebsite['affiliateid'],
            'block' => 0, //0 default
            'blockcampaign' => 0, //0 default 
            'target' => "",  //"" default, values: _blank, _top
            'source' => "",  //"" default
            'withtext' => 0, //0 default
            'charset' => "", //"" default - means autodetect
            'noscript' => 1, //1 default 
            'ssl' => 0, //0 default
            'comments' => 1 //1 default
        );
        
        $oInvocation->assignVariables($aInvocationParams);
        $invocationTag->setInvocation($oInvocation);
        $headerTag = $invocationTag->getHeaderCode($aZoneAliases);
        
        $aZoneTags = array();
        foreach ($aEntities['zones'] as $aZoneElem) {
            $aZone = $aZoneElem['zone'];
            
            $aAliases = $aZoneAliases[$aZone['zoneid']];
            $aliasesCount = count($aAliases);
            for ($i = 0; $i < $aliasesCount; $i++) {
                $aTagElem['tag'] = htmlspecialchars($invocationTag->getZoneCode($aZoneElem['zone'], $aWebsite, $aAliases[$i])); 
                $aTagElem['name'] = $oAliasBuilder->buildAliasedTagName($aZone['zonename'], $i+1, $aliasesCount);
                $aZoneTags[] = $aTagElem;     
            }
        }
        
        $this->view->websiteName = $aWebsite['name'];         
        $this->view->aZoneTags = $aZoneTags; 
        $this->view->headerTag = htmlspecialchars($headerTag);
    }
   
    
    /**
     * Saves webiste to Ad Server db. If market plugin is installed and enabled
     * it will also invoke 'processAffiliateForm' if available.
     *
     * @param OX_Workflow_UI_WizardManager $oWizard
     * @param MarketManager $oMarketManager helper for market plugin* 
     */
    private function saveWebsite(OX_Workflow_UI_WizardManager $oWizard, 
        MarketManager $oMarketManager)
    {
        $aWebsiteData = $oWizard->getStepData('step1');
        
        // Setup a new publisher object and set the fields passed in from the form:
        $oPublisher = new OA_Dll_PublisherInfo();
        $oPublisher->publisherId    = null;
        $oPublisher->agencyId       = OA_Permission::getAgencyId();
        $oPublisher->website        = $aWebsiteData['url'];
        $oPublisher->publisherName  = $aWebsiteData['name'];
        $oPublisher->contactName    = $aWebsiteData['contact'];
        $oPublisher->emailAddress   = $aWebsiteData['contactEmail'];
        $oPublisher->advSignup      = false;
        $oPublisher->oacCategoryId  = null;
        $oPublisher->oacCountryCode = null;
        $oPublisher->oacLanguageId  = null;
    
        $oPublisherDll = new OA_Dll_Publisher();
        if ($oPublisherDll->modify($oPublisher) && !$oPublisherDll->_noticeMessage) {
            $oComponent = $oMarketManager->getMarketComponent();
            //if there's market component schedule website registration in market
            if ($oComponent && method_exists($oComponent, 'processAffiliateForm')) { 
                //prepare aFields table (need to reuse names from website form, 
                //since these are used by market plugin as well
                $aFields['agencyid'] = OA_Permission::getAgencyId();
                $aFields['website'] = $aWebsiteData['url'];       
                $aFields['name'] = $aWebsiteData['name'];
                $aFields['contact'] = $aWebsiteData['contact']; 
                $aFields['email'] = $aWebsiteData['contactEmail'];
                $aFields['affiliateid'] = $oPublisher->publisherId;;
                $aFields['category'] = null;
                $aFields['country'] = null;
                $aFields['language'] = null;
                $aFields['advsignup'] = 0;
                
                $oComponent->processAffiliateForm($aFields);
            }
        }
        
        return $oPublisher->publisherId;
    }
    
    
    /**
     * Saves zones to Ad Server db. If market plugin is installed and enabled
     * and user accepted market usage in market step, it will also invoke 
     * market's component ZoneOptIn method if available  to opt in zone.
     *
     * @param OX_Workflow_UI_WizardManager $oWizard
     * @param MarketManager $oMarketManager helper for market plugin
     * @param int $websiteId
     */
    private function saveZones(OX_Workflow_UI_WizardManager $oWizard, MarketManager $oMarketManager,
     $websiteId)
    {
        $aSizesData = $oWizard->getStepData('step2');
        $aSizes = $aSizesData['sizes']; 
        $oSizeContainer = new ZoneWizardSizes();
        $aAllSizes = $oSizeContainer->getAllSizes();

        
        //get optional market zone opt in option
        if ($oMarketManager->isMarketAvailable()) {
            $oZoneOptIn = $oMarketManager->getMarketComponent()->getZoneOptInManager();
        }
        
        $aZoneIds = array();
        foreach ($aSizes as $sizeKey => $sizeCount) {
            if (empty($sizeCount)) {
                continue; //check if any zones are to be created
            }
            $doZones = OA_Dal::factoryDO('zones');
            $doZones->affiliateid = $websiteId;
            list($doZones->width, $doZones->height) = explode('x', $sizeKey);
            $doZones->delivery = phpAds_ZoneBanner;
            $doZones->zonetype = phpAds_ZoneCampaign;
            $doZones->zonename = $aAllSizes[$sizeKey];
            $doZones->description = null;
            $doZones->comments = 'Wizard generated zone';
            $doZones->oac_category_id  = null;
            $doZones->category = '';
            $doZones->ad_selection = '';
            $doZones->chain = '';
            $doZones->prepend = '';
            $doZones->append = '';
            
            $zoneId = $doZones->insert();
            $aZoneIds[$sizeKey] = $zoneId; 
            
            //if market is enabled, opt in the zones
            if ($oZoneOptIn) {
                $oZoneOptIn->updateZoneOptInStatus($zoneId, true);
            }
        }
        
        return $aZoneIds;
    }
    
    /**
     * Saves a sample advertiser. With a predefined name.
     *
     * @param OX_Workflow_UI_WizardManager $oWizard
     * @return int saved advertiser id
     */
    private function saveAdvertiser(OX_Workflow_UI_WizardManager $oWizard)
    {
        $oCurrentUser = OA_Permission::getCurrentUser();
        
        $oAdvertiser = new OA_Dll_AdvertiserInfo();
        $oAdvertiser->agencyId = OA_Permission::getAgencyId();
        $oAdvertiser->advertiserName = 'Wizard generated advertiser';
        $oAdvertiser->contactName = $oCurrentUser->aUser['contact_name'];
        $oAdvertiser->comments = 'Wizard generated advertiser';
        $oAdvertiser->emailAddress = $oCurrentUser->aUser['email_address'];

        $oAdvertiserDll = new OA_Dll_Advertiser();
        $oAdvertiserDll->modify($oAdvertiser);
        
        return $oAdvertiser->advertiserId;
    }
    
    
    /**
     * Generates sample campaign and HTML banners matching given zone sizes
     * in order to get user really started.
     * 
     * @param OX_Workflow_UI_WizardManager $oWizard
     * @param int saved advertiser id (generated campaign belongs to that advertiser) 
     * *  
     */
    private function saveCampaign(OX_Workflow_UI_WizardManager $oWizard, $advertiserId)
    {
        //create campaign
        $oCampaign = new OA_Dll_CampaignInfo();
        
        $oCampaign->advertiserId = $advertiserId;
        $oCampaign->campaignName = 'Wizard generated campaign';
        $oCampaign->weight = 1;
        $oCampaign->comments = 'Wizard generated campaign';
        
        $oCampaignDll = new OA_Dll_Campaign();
        $oCampaignDll->modify($oCampaign);
        return $campaignId = $oCampaign->campaignId;
    }
    
    
    /**
     * Generates HTML banners matching given zone sizes
     * in order to get user really started. 
     */
    private function saveBanners(OX_Workflow_UI_WizardManager $oWizard, $campaignId, $aZoneIds)
    {
        //create banners
        $oSizeContainer = new ZoneWizardSizes();
        $aAllSizes = $oSizeContainer->getAllSizes();        
        
        $oBannerDll = new OA_Dll_Banner();
        $aBannerIds = array();
        foreach ($aZoneIds as $sizeKey => $zoneId) {
            list($width, $height) = explode('x', $sizeKey);
        
            //create banners with sizes corresponding to created zones
            $oBanner = new OA_Dll_BannerInfo();
            $oBanner->campaignId = $campaignId;
            $oBanner->bannerName  = $aAllSizes[$sizeKey].' Banner';
            $oBanner->storageType = 'html';
            $oBanner->htmlTemplate = '<div style="width:'.$width.';height:'.$height.';background-color:#66C761">Sample '.$oBanner->bannerName.'</div>';
            $oBanner->width = (int)$width;      
            $oBanner->height = (int)$height;
            $oBanner->url = 'http://www.example.com';
            $oBanner->target = '_blank';
            $oBanner->comments = 'Wizard generated banner';
            
            $oBannerDll->modify($oBanner);
            $aBannerIds[$sizeKey] = $oBanner->bannerId;
        }
        
        //link created campaign to zones
        $oDalZones = new MAX_Dal_Admin_Zones();
        $aZonesIds = array_values($aZoneIds);
        $oDalZones->linkZonesToCampaign($aZonesIds, $campaignId);

        return $aBannerIds;
    }
    
    

    private function getCreatedEntities(OX_Workflow_UI_WizardManager $oWizard)
    {
        $aSizesStepData = $oWizard->getStepData('step2');
        $aSelectedSizes = $aSizesStepData['sizes']; 
        
        $aStepData = $oWizard->getStepData('step4');
        $websiteId = $aStepData['websiteId'];
        
        if (empty($websiteId)) {
            return null;        
        }
        
        $aEntities = array();        
        
        // Get the affiliate information
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if ($doAffiliates->get($websiteId)) {
            $aWebsite = $doAffiliates->toArray();
        }
        
        //ATM get all zones from the created website not by ids stored in session
        //this should be fine sice website was just created nevertheless
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = $websiteId;
        $doZones->find();
        while ($doZones->fetch() && $row = $doZones->toArray()) {
            $aElem = array(
                'zone' => $row,
                'count'=> $aSelectedSizes[$row['width'].'x'.$row['height']]
            );
            $aZones[] = $aElem;
        }
        
        $aEntities['website'] = $aWebsite;
        $aEntities['zones'] =  $aZones;
    
        return $aEntities;
    }
}

/**
 * A helper class to access Market component (if installed in version at least 1.2.0-rc1
 *
 */
class MarketManager
{
    private $marketAvailable;
    private $oMarketComponent;
    private $requiredMarketVersion;
    
    public function __construct()
    {
        $this->requiredMarketVersion = '1.2.0-rc1';
        $oComponent = &OX_Component::factory ( 'admin', 'oxMarket', 'oxMarket' );
        $this->oMarketComponent = $oComponent != null 
            && $oComponent->enabled 
            && method_exists($oComponent, 'isActive') 
            && $oComponent->isActive()
            && $this->isZoneOptInAvailable() 
            ? $oComponent : null;

        $this->marketAvailable = !empty($this->oMarketComponent);
        $this->userAcceptedMarket = true;    
    }
    
    
    private function isZoneOptInAvailable()
    {
        $oPluginManager = new OX_PluginManager();
        $aInfo =  $oPluginManager->getPackageInfo('openXMarket', false);    
        $version =  strtolower($aInfo['version']);
    
        return version_compare($version, $this->requiredMarketVersion, '>=');
        
    }    
    
    
    public function getMarketComponent()
    {
        return $this->oMarketComponent;
    }
    
    
    public function isMarketAvailable()
    {
        return $this->marketAvailable;
    }
}

/**
 * A container for zone sizes used in the wizard
 */
class ZoneWizardSizes
{
    private $aVisibleSizes;
    private $aAdditionalSizes;
    private $aAllSizes;
    
        
    public function __construct()
    {
        $this->aVisibleSizes = array(
                '728x90'  => 'Leaderboard (728x90)',
                '300x250' => 'Medium Rectangle (300x250)',
                '160x600' => 'Wide Skyscraper (160x600)',
                '468x60'  => 'Full Banner (468x60)',
                '120x600' => 'Skyscraper (120x600)',
                '336x280' => 'Large Rectangle (336x280)'
        );
        
        $this->aAdditionalSizes = array(
            '120x90' => 'Button 1 (120x90)',
            '120x60' => 'Button 2 (120x60)',
            '234x60' => 'Half Banner (234x60)',
            '88x31'  => 'Micro Bar (88x31)',
            '180x150'=> 'Rectangle (180x150)',
            '125x125'=> 'Square Button (125x125)',
            '250x250'=> 'Square Pop-up (250x250)',
            '120x240'=> 'Vertical Banner (120x240)',
            '240x400'=> 'Vertical Rectangle (240x400)'
            );    
                
        $this->aAllSizes = array_merge($this->aVisibleSizes, $this->aAdditionalSizes);
    }
        
        
    public function getDefaultSizes()
    {
        return $this->aVisibleSizes;
    }
    
    
    public function getAdditionalSizes()
    {
        return $this->aAdditionalSizes;
    } 

    
    public function getAllSizes()
    {
        return $this->aAllSizes;
    }
}


?>

