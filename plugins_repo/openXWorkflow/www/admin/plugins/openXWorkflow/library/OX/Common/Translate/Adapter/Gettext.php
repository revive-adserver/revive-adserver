<?php

class OX_Common_Translate_Adapter_Gettext 
    extends Zend_Translate_Adapter_Gettext 
{
    private $debugMode;
    
    /**
     * Generates the  adapter
     *
     * @param  string              $data     Translation data
     * @param  string|Zend_Locale  $locale   OPTIONAL Locale/Language to set, identical with locale identifier,
     *                                       see Zend_Locale for more information
     * @param  array               $options  OPTIONAL Options to set
     */
    public function __construct($data, $locale = null, array $options = array())
    {
        parent::__construct($data, $locale, $options);
        $this->debugMode = OX_Common_Config::isDebugTranslations();
    }
    
    
    /**
     * Wrapper function for original adapter 'translate' function.
     * Adds <strike> tags when debugTranslations is enabled.
     *
     * @param  string             $messageId Translation string
     * @param  string|Zend_Locale $locale    (optional) Locale/Language to use, identical with
     *                                       locale identifier, @see Zend_Locale for more information
     */
    public function translate($messageId, $locale = null)
    {
        $result = parent::translate($messageId, $locale);

        if ($this->debugMode) {
            $result = '!---' . $result . '---!';
        }
        
        return $result;
    }
}
