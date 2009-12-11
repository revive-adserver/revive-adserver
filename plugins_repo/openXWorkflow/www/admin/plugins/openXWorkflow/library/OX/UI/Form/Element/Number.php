<?php

/**
 * An input element for decimal numbers. Please note that numbers to be edited by 
 * this element should be provided using the 'number' attribute (setNumber()) and correct
 * values should also be retrieved using the getNumber() method. 
 * 
 * This element respects locale setting when it comes to the decimal separator, but removes 
 * and forbids thousands separator in the values. The reason for this is that comma is 
 * in some locales used as a thousand separator and in other locales as a decimal seprarator, 
 * which may lead to accepting a syntactially correct, but wrong (based on the user's 
 * intent) value. Additionally, the component allows spaces inside numbers to aid entering 
 * large values. 
 */
class OX_UI_Form_Element_Number extends OX_UI_Form_Element_Text
{
    protected $class = "typeText";
    private $precision = 2;
    private $thousandsSeparator;
    
    private $examplePrefix;
    private $example;
    private $exampleSuffix;
    private $numberValidationErrorMessage = 'Please provide a correct decimal value';

    
    public function __construct($spec, $options = null)
    {
        $symbols = Zend_Locale_Data::getList(Zend_Locale::findLocale(), 'symbols');
        $this->thousandsSeparator = $symbols['group']; 
        
        parent::__construct($spec, $options);
        
        $thousandsSeparatorValidator = new OX_Common_Validate_Regex('/\\' . $symbols['group'] . '/', true);
        $thousandsSeparatorValidator->setMessage($this->numberValidationErrorMessage);
        $this->addValidator($thousandsSeparatorValidator);
        
        $floatValidator = new Zend_Validate_Float();
        $floatValidator->setMessage($this->numberValidationErrorMessage);
        $this->addValidator($floatValidator);
        
        $title = $this->getAttrib('title');
        if (empty($title)) {
            $this->setAttrib('title', $this->getExamplePrefix() . 
                $this->formatAndFilterNumber($this->getExample()) . $this->getExampleSuffix());
        }
        
        $this->addFilter(new Zend_Filter_StringTrim());
        $this->addFilter(new Zend_Filter_PregReplace('/ /'));
    }


    public function setNumber($number)
    {
        parent::setValue($this->formatAndFilterNumber($number, $this->precision));
        return $this;
    }
    
    
    public function getNumber()
    {
        return Zend_Locale_Format::getFloat(parent::getValue());
    }

    
    private function formatAndFilterNumber($number)
    {
        return preg_replace('/\\' . $this->thousandsSeparator . '/', '', 
            OX_UI_View_Helper_FloatFormat::floatFormat($number, $this->precision));
    }
    

    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }


    public function getPrecision()
    {
        return $this->precision;
    }


    public function setExampleSuffix($exampleSuffix)
    {
        $this->exampleSuffix = $exampleSuffix;
    }


    public function setExample($example)
    {
        $this->example = $example;
    }


    public function setExamplePrefix($examplePrefix)
    {
        $this->examplePrefix = $examplePrefix;
    }


    public function getExampleSuffix()
    {
        return $this->exampleSuffix;
    }


    public function getExample()
    {
        return $this->example;
    }


    public function getExamplePrefix()
    {
        return $this->examplePrefix;
    }
    
    
	public function setNumberValidationErrorMessage($numberValidationErrorMessage)
    {
        $this->numberValidationErrorMessage = $numberValidationErrorMessage;
    }

    
	public function getNumberValidationErrorMessage()
    {
        return $this->numberValidationErrorMessage;
    }
}