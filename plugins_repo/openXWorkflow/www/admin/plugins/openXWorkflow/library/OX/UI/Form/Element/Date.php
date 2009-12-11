<?php

/**
 * OX-specific date select element.
 */
class OX_UI_Form_Element_Date extends OX_UI_Form_Element_Text
{
    protected $class = "typeText typeDate";
    
    /**
     * Zend_Date format used by this date component.
     */
    private static $zendDateFormat;


    /**
     * Add date validator.
     */
    public function init()
    {
        parent::init();
        
        $this->addValidator(new Zend_Validate_Date(self::getZendDateFormat()));
        
        if ($this->isRequired()) {
            $this->setClass('readOnly');
        }
        
        // Add a global variable with the desired datepicker format
        OX_UI_View_Helper_InlineScriptOnce::inline('jQuery.datepickerFormat = "' . self::getDatepickerFormat() . '"', false);
        $title = $this->getAttrib('title');
        if (empty($title))
        {
            $this->setAttrib('title', strtolower(self::getZendDateFormat()));
        }
    }

    /**
     * Strips time portion from the date.
     */
    public function setValue($value)
    {
        if ($value instanceof Zend_Date) {
            parent::setValue($value->toString(self::getZendDateFormat()));
        }
        else {
            parent::setValue($value);
        }
        return $this;
    }


    public function getZendDateValue()
    {
        $value = $this->getValue();
        return !empty($value) ? new Zend_Date($this->getValue(), self::getZendDateFormat()) : null;
    }

    public static function getZendDateFormat()
    {
        if (self::$zendDateFormat === null)
        {
            return OX_Common_Config::getUiDateFormat('short');
        }
        
        return self::$zendDateFormat;
    }

    private static function getDatepickerFormat()
    {
        return self::toUiDatepickerFormat(self::getZendDateFormat());
    }


    /**
     * Performs a limited conversion from Zend_Date format strings
     * to jQuery UI Datepicker format.
     */
    public static function toUiDatepickerFormat($zendDateFormat)
    {
        $y = preg_replace('/yy/', 'y', $zendDateFormat);
        $m = preg_replace('/MMMM/', 'MM', $y);
        $m = preg_replace('/MMM/', 'M', $m);
        if ($m == $y) {
            $m = preg_replace('/M/', 'm', $y);
        }
        
        return $m;
    }
}
