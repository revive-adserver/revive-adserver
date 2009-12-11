<?php

class OX_UI_Form_Sso_Account extends OX_UI_Form
{
    const SSO_ACCOUNT_RADIOBUTTON = 'hasSsoAccount';
    const EXISTING_USERNAME_TEXT = 'existingUsername';
    const EXISTING_PASSWORD_TEXT = 'existingPassword';
    const NEW_USERNAME_TEXT = 'newUsername';
    const NEW_PASSWORD_TEXT = 'newUserPassword';
    const CONFIRM_NEW_PASSWORD_TEXT = 'confirmNewUserPassword';
    const TERMS_CHECKBOX = 'terms';
    
    private $hasSsoAccount;    
    
    
    /**
     * @param string $element_name
     * @return string
     */
    private static function getLine($element_name)
    {
        return $element_name . 'Line';
    }
    
    public function __construct(Zend_Controller_Request_Http $request)
    {
        parent::__construct();
        
        $this->setFormValidationErrorMessage('To complete your registration, please correct the marked fields.');
        
        // The form depends on the value of the radio button, so we need
        // to extract it from the request first
        $this->hasSsoAccount = $request->getParam(self::SSO_ACCOUNT_RADIOBUTTON);
        
        $existingAccountValidationEnabledCallback = array($this, 'isUsingExistingAccount');
        $newAccountValidationEnabledCallback = array($this, 'isCreatingNewAccount');
        
        $this->addElementWithLine('radio', self::SSO_ACCOUNT_RADIOBUTTON,
            self::getLine(self::SSO_ACCOUNT_RADIOBUTTON),
            array (
                'required' => true, 
                'width' => OX_UI_Form_Element_Widths::LARGE,
                'label' => 'Do you already have an OpenX account?', 
                'value' => $this->hasSsoAccount,
                'multiOptions' => array (
                        'true' => 'Yes, I want to use my existing OpenX account', 
                        'false' => 'No, I want to create a new account')),
            array('class' => 'compact'));
            
        $this->addDisplayGroup(array(self::getLine(
            self::SSO_ACCOUNT_RADIOBUTTON)), 'ssoAccountInfo', 
            array ('legend' => 'Account'));
            
        $this->addElementWithLine('text', self::EXISTING_USERNAME_TEXT,
            self::getLine(self::EXISTING_USERNAME_TEXT), 
            array (
                'required' => true, 
                'validationEnabledCallback' => $existingAccountValidationEnabledCallback,
                'label' => 'User Name', 
                'filters' => array('StringTrim'), 
                'width' => OX_UI_Form_Element_Widths::LARGE));
            
        $this->addElementWithLine('password', self::EXISTING_PASSWORD_TEXT,
            self::getLine(self::EXISTING_PASSWORD_TEXT), 
            array (
                'required' => true, 
                'validationEnabledCallback' => $existingAccountValidationEnabledCallback,
                'label' => 'Password', 
                'width' => OX_UI_Form_Element_Widths::LARGE));
         
        $this->addDisplayGroup(array(
            self::getLine(self::EXISTING_USERNAME_TEXT),
            self::getLine(self::EXISTING_PASSWORD_TEXT)), 
            'existingSsoAccountGroup', 
            array ('legend' => 'Enter user name and password for your OpenX account',
                'id' => 'existingSsoAccountGroup',
                'class' => ($this->isUsingExistingAccount() ? '' : 'hide')));
            
            
        $this->addElementWithLine('text', self::NEW_USERNAME_TEXT,
            self::getLine(self::NEW_USERNAME_TEXT), 
            array (
                'required' => true, 
                'validationEnabledCallback' => $newAccountValidationEnabledCallback,
                'label' => 'Desired user name', 
                'filters' => array (
                        'StringTrim'), 
                'width' => OX_UI_Form_Element_Widths::LARGE), 
            array ('id' => self::getLine(self::NEW_USERNAME_TEXT)));
            
        $this->addElementWithLine('password', self::NEW_PASSWORD_TEXT,
            self::getLine(self::NEW_PASSWORD_TEXT), 
            array (
                'required' => true, 
                'validationEnabledCallback' => $newAccountValidationEnabledCallback,
                'label' => 'Password', 
                'width' => OX_UI_Form_Element_Widths::LARGE), 
            array ('id' => self::getLine(self::NEW_PASSWORD_TEXT)));
            
        $this->addElementWithLine('password', self::CONFIRM_NEW_PASSWORD_TEXT,
            self::getLine(self::CONFIRM_NEW_PASSWORD_TEXT), 
            array (
                'required' => true, 
                'validationEnabledCallback' => $newAccountValidationEnabledCallback,
                'label' => 'Re-enter password', 
                'width' => OX_UI_Form_Element_Widths::LARGE), 
            array ('id' => self::getLine(self::CONFIRM_NEW_PASSWORD_TEXT)));
            
        $this->addDisplayGroup(array(
            self::getLine(self::NEW_USERNAME_TEXT),
            self::getLine(self::NEW_PASSWORD_TEXT),
            self::getLine(self::CONFIRM_NEW_PASSWORD_TEXT)), 
            'newSsoAccountGroup', 
            array ('legend' => 'Details for your new OpenX account',
                'id' => 'newSsoAccountGroup',
                'class' => ($this->isCreatingNewAccount() ? '' : 'hide')));
            
        $termsUrl = OX_Common_Config::instance('ui')->get('termsUrl');
        $privacyUrl = OX_Common_Config::instance('ui')->get('privacyUrl');
        $this->addElementWithLine('checkbox', self::TERMS_CHECKBOX,
            'termsLine', 
            array (
                'required' => true, 
                'label' => 'I agree with',
                'suffix' => '<a href="' . $termsUrl . '" target="_blank">Terms & Conditions</a> and <a href="' . $privacyUrl . '" target="_blank">Privacy Policy</a>'), 
            array ('class' => 'compact'));
            
        $this->addDisplayGroup(array('termsLine'), 
            'termsGroup', 
            array ('legend' => 'Terms & Privacy',
                'id' => 'termsGroup',
                'class' => (empty($this->hasSsoAccount) ? 'hide' : '')));
            
        $this->addSubmitButton('Complete Registration', 'submit', array('class' => (empty($this->hasSsoAccount) ? 'hide' : '')));
    }
    
    public function isUsingExistingAccount()
    {
        return $this->hasSsoAccount == 'true';
    }
    
    public function isCreatingNewAccount()
    {
        return $this->hasSsoAccount == 'false';
    }
    
    public function isValid($data)
    {
        $valid = parent::isValid($data);
        
        // Check if passwords match
        return $valid && $this->validatePasswords($data) && 
               $this->validateTerms($data);
    }
    
    private function validatePasswords(array $data)
    {
        $passwordsMatch = 0 == strcmp($data[self::NEW_PASSWORD_TEXT], 
                        $data[self::CONFIRM_NEW_PASSWORD_TEXT]);
        
        if (!$passwordsMatch) {
            $message = 'Re-entered password does not match. Please type the same password again';
            $this->setFormValidationErrorMessage($message);
            $this->getElement(self::CONFIRM_NEW_PASSWORD_TEXT)->addError($message);
            $this->markAsError();
        }
                        
        return $passwordsMatch;
    }
    
    private function validateTerms(array $data)
    {
        if (isset($data[self::TERMS_CHECKBOX]) && $data[self::TERMS_CHECKBOX]) {
            return true;
        }
                        
        $this->setFormValidationErrorMessage('Please agree to Terms & Conditions and Privacy Policy');
        $this->markAsError();
        return false;
    }
    
    public function getExistingUsername()
    {
        return $this->getValue(self::EXISTING_USERNAME_TEXT);
    }
    
    public function getExistingPassword()
    {
        return $this->getValue(self::EXISTING_PASSWORD_TEXT);
    }
    
    public function getNewUsername()
    {
        return $this->getValue(self::NEW_USERNAME_TEXT);
    }
    
    public function getNewUserPassword()
    {
        return $this->getValue(self::NEW_PASSWORD_TEXT);
    }
}