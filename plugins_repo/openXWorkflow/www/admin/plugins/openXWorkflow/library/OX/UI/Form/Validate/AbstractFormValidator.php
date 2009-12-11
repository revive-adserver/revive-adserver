<?php


abstract class OX_UI_Form_Validate_AbstractFormValidator 
    implements OX_UI_Form_Validate_FormValidator
{
    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array();
    

    /**
     * Array of validation failure messages. Key is a $elementName, value is an
     * array $messageKey => $messageString.
     *
     * @var array
     */
    protected $_elementMessages = array();


    /**
     * Additional variables available for validation failure messages
     * Please note that these are used only for element messages.
     * use messageKey as key to variables.
     *
     * @var array
     */
    protected $_messageVariables = array();
        
    
    /**
     * Translation object
     * @var Zend_Translate
     */
    protected $_translator;

    /**
     * Default translation object for all validate objects
     * @var Zend_Translate
     */
    protected static $_defaultTranslator;
    
    
    /**
     * Array with form validation failure message
     *
     * @var array
     */
    protected $_formMessage = array();
    
    
    /**
     * Returns array of validation failure messages for elements
     *
     * @return array
     */
    public function getElementMessages()
    {
        return $this->_elementMessages;
    }
    
    
    /**
     * Returns single element array of with global form validation failure message
     *
     * @return single element array
     */
    public function getFormMessage()
    {
        return $this->_formMessage;
    }

    
    /**
     * Registers error on element level. Used internally by form validators
     * to mark fields which failed the global form validation.
     * 
     * @param  string $elementName      
     * @param  string $messageKey
     * @param  string $value OPTIONAL  
     * @return void
     */
    protected function _elementError($elementName, $messageKey, $value = null)
    {
        if (isset($this->_elementMessages[$elementName])) {
            $this->_elementMessages[$elementName] = array();
        }
        
        $this->_elementMessages[$elementName][$messageKey] = $this->_createMessage($messageKey, $value);
    }
    
    
    /**
     * @param  string $messageKey 
     * @param  string $value      
     * @return void
     */
    protected function _formError($messageKey)
    {
        $this->_formMessage[$messageKey] = $this->_createMessage($messageKey, null);
    }
    
    
    /**
     * Constructs and returns a validation failure message with the given message key and value.
     *
     * Returns null if and only if $messageKey does not correspond to an existing template.
     *
     * If a translator is available and a translation exists for $messageKey, 
     * the translation will be used.
     *
     * @param  string $messageKey
     * @param  string $value optional
     * @return string
     */
    protected function _createMessage($messageKey, $value = null)
    {
        if (!isset($this->_messageTemplates[$messageKey])) {
            return null;
        }

        $message = $this->_messageTemplates[$messageKey];

        if (null !== ($translator = $this->getTranslator())) {
            if ($translator->isTranslated($messageKey)) {
                $message = $translator->translate($messageKey);
            }
        }

        $message = str_replace('%value%', (string) $value, $message);
        
        if (isset($this->_messageVariables[$messageKey])) {
            foreach ($this->_messageVariables[$messageKey] as $ident => $value) {
                $message = str_replace("%$ident%", $value, $message);
            }
        }
        return $message;
    }
    

    /**
     * Set translation object
     * 
     * @param  Zend_Translate|Zend_Translate_Adapter|null $translator 
     * @return Zend_Validate_Abstract
     */
    public function setTranslator($translator = null)
    {
        if ((null === $translator) || ($translator instanceof Zend_Translate_Adapter)) {
            $this->_translator = $translator;
        } elseif ($translator instanceof Zend_Translate) {
            $this->_translator = $translator->getAdapter();
        } else {
            require_once 'Zend/Validate/Exception.php';
            throw new Zend_Validate_Exception('Invalid translator specified');
        }
        return $this;
    }
    

    /**
     * Return translation object
     * 
     * @return Zend_Translate_Adapter|null
     */
    public function getTranslator()
    {
        if (null === $this->_translator) {
            return self::getDefaultTranslator();
        }

        return $this->_translator;
    }
    

    /**
     * Set default translation object for all validate objects
     * 
     * @param  Zend_Translate|Zend_Translate_Adapter|null $translator 
     * @return void
     */
    public static function setDefaultTranslator($translator = null)
    {
        if ((null === $translator) || ($translator instanceof Zend_Translate_Adapter)) {
            self::$_defaultTranslator = $translator;
        } elseif ($translator instanceof Zend_Translate) {
            self::$_defaultTranslator = $translator->getAdapter();
        } else {
            require_once 'Zend/Validate/Exception.php';
            throw new Zend_Validate_Exception('Invalid translator specified');
        }
    }

    /**
     * Get default translation object for all validate objects
     * 
     * @return Zend_Translate_Adapter|null
     */
    public static function getDefaultTranslator()
    {
        if (null === self::$_defaultTranslator) {
            require_once 'Zend/Registry.php';
            if (Zend_Registry::isRegistered('Zend_Translate')) {
                $translator = Zend_Registry::get('Zend_Translate');
                if ($translator instanceof Zend_Translate_Adapter) {
                    return $translator;
                } elseif ($translator instanceof Zend_Translate) {
                    return $translator->getAdapter();
                }
            }
        }
        return self::$_defaultTranslator;
    }    
}
