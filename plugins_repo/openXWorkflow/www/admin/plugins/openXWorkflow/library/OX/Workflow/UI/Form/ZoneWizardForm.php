<?php

class OX_Workflow_UI_Form_ZoneWizardForm
    extends OX_UI_Form
{
    /**
     * Currrent step data
     *
     * @var array
     */
    private $stepData;
    
    /**
     * @var ZoneWizardSizes
     */
    private $oSizes;
    
    
    private $marketStepEnabled;
    
    /**
     * A helper to get string replacement from PC
     *
     * @var Workflow_View_Helper_PcString
     */
    private $pcString;
    
    public function __construct($aSettings, array $options = null)
    {
        parent::__construct();
        if ($options) {
            $this->setOptions($options);
        }
        $this->setAttrib('id', 'zoneWorkflowForm');

        if (!empty($aSettings)) { 
            if (!empty($aSettings['step'])) {
                $step = $aSettings['step'];
            }
            else {
                $step = 1;
            }
            
            //add a helper to download strings from PC
            $this->pcString = $aSettings['pcStringHelper'];  
                        
            if (!empty($aSettings['data'])) {
                $this->stepData = $aSettings['data'];
            }
            
            if (!empty($aSettings['sizes'])) {
                $this->oSizes = $aSettings['sizes'];
            }
            
            if (!empty($aSettings['marketEnabled'])) {
                $this->marketStepEnabled = true;
            }
        }
        
        switch($step) {
            case 1: {
                $this->addWebsiteSection();
                $this->addSubmitButton($this->pcString->pcString('zone-wizard-website-step', 'button-next-label' ,'Next'), 'next', 
                array (
                    'type' => 'submit',
                    'arrow' => 'right',
                    'class' => 'right'));
                break; 
            }
            case 2: {
                $this->addZonesSection();
                $this->addSecondaryButton($this->pcString->pcString('zone-wizard-zone-step', 'button-back-label' ,'Back'), 
                  'back', array (
                    'type' => 'submit',
                    'arrow' => 'left',
                    'class' => 'left'));
                $this->addSubmitButton($this->marketStepEnabled 
                    ? $this->pcString->pcString('zone-wizard-zone-step', 'button-next-label-with-market' ,'Next') 
                    : $this->pcString->pcString('zone-wizard-zone-step', 'button-next-label-no-market' ,'Get HTML tags'), 
                    'next', array (
                    'type' => 'submit',
                    'arrow' => 'right',
                    'class' => 'right'));
                break; 
            }
            case 3: {
                $this->addMarketSection();
                $this->addSecondaryButton($this->pcString->pcString('zone-wizard-market-step', 'button-back-label' ,'Back'), 'back', array (
                    'type' => 'submit',
                    'arrow' => 'left',
                    'class' => 'left'));
                $this->addSubmitButton($this->pcString->pcString('zone-wizard-market-step', 'button-next-label' ,'Get HTML tags'), 'next', array (
                    'type' => 'submit',
                    'arrow' => 'right',
                    'class' => 'right'));
                break; 
            }
            case 4: {
                $this->addSubmitButton($this->pcString->pcString('zone-wizard-tags-step', 'button-next-label' , 'Next'), 'next', array (
                    'type' => 'submit',
                    'arrow' => 'right',
                    'class' => 'right nofocus'));
                break; 
            }
            case 5: {
                $this->addSecondaryButton($this->pcString->pcString('zone-wizard-congrats-step', 'button-back-label' , 'Back'), 'back', array (
                    'type' => 'submit',
                    'arrow' => 'left',
                    'class' => 'left'));
                $this->addSubmitButton($this->pcString->pcString('zone-wizard-congrats-step', 'button-next-label' , 'Close'), 'next', array (
                    'type' => 'submit',
                    'arrow' => 'right',
                    'class' => 'right'));
                break; 
            }
            default: {
                $this->addWebsiteSection();
            }
                
        }
        
        
        // Populate from the provided step data
        $this->populateForm($step, $this->stepData);
    }
    
    
    private function addWebsiteSection()
    {
        $this->addElementWithLine('text', 'url', 'urlLine', array (
                'required' => true,
                'validators' => array (new OX_Common_Validate_Url(true, false)), 
                'label' => $this->pcString->pcString('zone-wizard-website-step', 'field-website-url-label', 'Website URL'), 
                'title' => $this->pcString->pcString('zone-wizard-website-step', 'field-website-url-title', 'eg. http://www.example.com'), 
                'filters' => array (
                        'StringTrim'), 
                'width' => OX_UI_Form_Element_Widths::LARGE));
        
        $this->addElementWithLine('text', 'name', 'nameLine', array (
                'required' => true, 
                'label' => $this->pcString->pcString('zone-wizard-website-step', 'field-website-name-label', 'Website name'), 
                'filters' => array (
                        'StringTrim'), 
                'width' => OX_UI_Form_Element_Widths::LARGE));
        
        $this->addElementWithLine('text', 'contact', 'contactLine', array (
                'required' => true, 
                'label' => $this->pcString->pcString('zone-wizard-website-step', 'field-website-contact-label', 'Website contact'), 
                'filters' => array (
                        'StringTrim'), 
                'width' => OX_UI_Form_Element_Widths::LARGE));
        
        $this->addElementWithLine('text', 'contactEmail', 'contactEmailLine', array (
                'required' => true, 
                'label' => $this->pcString->pcString('zone-wizard-website-step', 'field-website-contact-email-label', 'Website contact\'s email'), 
                'filters' => array (
                        'StringTrim'), 
                'width' => OX_UI_Form_Element_Widths::LARGE));
        
        $this->addDisplayGroup(array ('urlLine', 'nameLine', 'contactLine', 'contactEmailLine'), 
            'basic', array ('legend' => null));
    }
    
    
    private function addZonesSection()
    {
        $aCounts = $this->getZoneCounts();   
        $aSizes = $this->oSizes->getDefaultSizes();
        $aAdditionalSizes = $this->oSizes->getAdditionalSizes();
        
        $aLines = array();
        $this->addElement('hidden', 'allSizesShown', array (
                'id' => 'allSizesShown'));
        
        $allSizesShown = (isset($this->stepData['allSizesShown']) && $this->stepData['allSizesShown'] == '1')
            || (isset($_POST['allSizesShown']) && $_POST['allSizesShown'] == '1'); 

        $this->addElementWithLine('content', 'headers', 'sizeHeadersLine', array (
                'content' => $this->pcString->pcString('zone-wizard-zone-step', 'size-headers' ,
                '<label class="type">Zone (ad size)</label><label class="count">Number of times displayed on a page <span class="note">(this is the number of tags generated for the zone)</span></label>')
        ));            
            
        
        foreach ($aSizes as $key => $label) {
            list($width, $height) = explode('x', $key);
            $previewLink = OX_UI_View_Helper_ActionUrl::actionUrl('size-preview', 'zone', 'workflow', 
                array('width' => $width, 'height' => $height));
                       
            $this->addElementWithLine('select', $key, 'sizeLine', 
                array (
                    'prefix' => $label, 
                    'width' => OX_UI_Form_Element_Widths::SMALL, 
                    'multiOptions' => $aCounts,
                    'suffix' => '<a href="'.$previewLink.'" title="'.$this->pcString->pcString('zone-wizard-zone-step', 'size-preview-link-title', 'Size Preview')
                    .'" class="thickbox size-preview" target="_blank">'.$this->pcString->pcString('zone-wizard-zone-step', 'size-preview-link-label', 'size preview').'</a>'
                ), 
                array('class' => 'size-container',
                    'suffix' => $allSizesShown ? null : '<a href="" id="sizesLink">'
                    .$this->pcString->pcString('zone-wizard-zone-step', 'more-sizes-link-label', 'See more ad sizes...')
                    .'</a>')
            );
        }
        foreach ($aAdditionalSizes as $key => $label) {
            list($width, $height) = explode('x', $key);
            $previewLink = OX_UI_View_Helper_ActionUrl::actionUrl('size-preview', 'zone', 'workflow', 
                array('width' => $width, 'height' => $height));       
            
            $this->addElementWithLine('select', $key, 'additionalSizeLine', 
                array (
                    'prefix' => $label, 
                    'width' => OX_UI_Form_Element_Widths::SMALL, 
                    'multiOptions' => $aCounts,
                    'suffix' => '<a href="'.$previewLink.'" title="'.$this->pcString->pcString('zone-wizard-zone-step', 'size-preview-link-title', 'Size Preview')
                    .'" class="thickbox size-preview" target="_blank">'.$this->pcString->pcString('zone-wizard-zone-step', 'size-preview-link-label', 'size preview').'</a>'                
                ),
                array (
                    'id' => 'additionalSizeLine', 
                    'class' => 'size-container'.($allSizesShown ? '' : ' hide'))
            );
        }        
        
        
        $this->addDisplayGroup(array ('sizeHeadersLine', 'sizeLine', 'additionalSizeLine'),
            'basic', array ('legend' => null));        
        
        $this->addFormValidator(new OX_Workflow_UI_Form_Validator_SizesNotEmpty(
            array_keys(array_merge($aSizes, $aAdditionalSizes))));
            
        $this->registerThickboxJSandCSSResources();            
    }
    
    
    private function addMarketSection() //step3
    {
        $oMarketComponent = OX_Component::factory('admin', 'oxMarket');
        $view = $this->getView();
        $view->assign('aBranding', $oMarketComponent->aBranding);
    }
    
    
    private function populateForm($step, $aData)
    {
        $values = array ();
        switch($step) {
            case 1: {
                OX_Common_ArrayUtils::addIfNotNull($values, 'url', $aData['url']);
                OX_Common_ArrayUtils::addIfNotNull($values, 'name', $aData['name']);
                OX_Common_ArrayUtils::addIfNotNull($values, 'contact', $aData['contact']);
                OX_Common_ArrayUtils::addIfNotNull($values, 'contactEmail', $aData['contactEmail']);
                break; 
            }
            case 2: {
                OX_Common_ArrayUtils::addIfNotNull($values, 'allSizesShown', $aData['allSizesShown']);
                
                $aAllSizes = $this->oSizes->getAllSizes(); 
                foreach ($aAllSizes as $key => $label) {
                    OX_Common_ArrayUtils::addIfNotNull($values, $key, $aData['sizes'][$key]);
                }
                break; 
            }
            case 3: {
                break; 
            }
            case 4: {
                break; 
            }
            case 5: {
                break; 
            }
            default: {
            }
        }
        
        $this->populate($values);
    }
    
    
    public function populateStepData($step, $aData)
    {
        switch($step) {
            case 1: {
                $aData['url'] = $this->getValue('url');
                $aData['name'] = $this->getValue('name');
                $aData['contact'] = $this->getValue('contact');
                $aData['contactEmail'] = $this->getValue('contactEmail');
                break; 
            }
            case 2: {
                $aData['allSizesShown'] = $this->getValue('allSizesShown');
                $aData['sizes'] = array();
                $aAllSizes = $this->oSizes->getAllSizes(); 
                foreach ($aAllSizes as $key => $label) {
                    OX_Common_ArrayUtils::addIfNotNull($aData['sizes'], $key, $this->getValue($key));
                }
                break; 
            }
            case 3: {
                break; 
            }
            case 4: {
                break; 
            }
            case 5: {
                break; 
            }
            default: {
            }
        }
        
        return $aData;
    }
    
    
    private function getZoneCounts()
    {
        $aCounts = array();
        $aCounts[null] = '-';
        for ($i = 1; $i <= 10; $i++) {
            $aCounts[$i] = $i;     
        }
        
        return $aCounts;
    }
    

    private function registerThickboxJSandCSSResources()
    {
        $oUrlBaseHelper = new OX_UI_View_Helper_UrlBase();
        $urlBase = $oUrlBaseHelper->urlBase();
        
        $helper = new OX_UI_View_Helper_InlineScriptOnce();
        $helper->inlineScriptOnce(Zend_View_Helper_HeadScript::FILE, $urlBase . '/assets/base/js/jquery/thickbox/thickbox-compressed.js');
        
        $headLink = new Zend_View_Helper_HeadLink();        
        $headLink->appendStylesheet($urlBase . '/assets/base/js/jquery/thickbox/css/thickbox.css');
    }    
    
    
}

?>