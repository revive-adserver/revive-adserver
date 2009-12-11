<?php
/**
 * A manaber class used to setup application wide translations. 
 *
 */
class OX_Common_Translator
{
    /**
     * Sets up translations cache and loads all translations from /languages
     * directory
     *
     */
    public static function init()
    {
        Zend_Translate::setCache(Zend_Cache::factory('Core',
                             'File',
                             array(
                                'lifetime' => null,
                                'cache_id_prefix' => 'trans'
                             ),
                             array(
                                'cache_dir' => CACHE_PATH 
                             )));
    }
    
    
    /**
     * Registers new directory with gettext translations. Please note that
     * it is expected that this directory will contain directories name after
     * language locales eg. 'en', 'de', 'it'. Do not put lanugage files directly
     * in this dir, put them in language directories. Names are not important,
     * as loong as the file have the gettext recognizable '.mo' extension 
     *
     * @param string $translationsDirectoryPath absolute root path to translations
     */
    public static function addTranslations($translationsDirectoryPath)
    {
        try {
            $oTranslate = self::getTranslate();
        }
        catch (Zend_Exception $exc) {
            //ignore. no Zend_Translate set yet, we need to create and register one
        }
        
        $adapterOptions = array(
            'scan' => Zend_Translate::LOCALE_DIRECTORY,
            'disableNotices' => true,
            'logUntranslated' => OX_Common_Config::isDebugTranslations()                             
        );
        
        if (empty($oTranslate)) {
            $oTranslate = new Zend_Translate('OX_Common_Translate_Adapter_Gettext',
                $translationsDirectoryPath,
                null,
                $adapterOptions);
            
            //since Zend_Translate caches itself and its options so we need to
            //reinitialize logger if isDebugTranslations have been turned on
            if (OX_Common_Config::isDebugTranslations()) {
                // Create a log instance
                $log = OX_Common_Log::getLog('missing-translations');
                $oTranslate->setOptions(array(
                    'log'             => $log,
                    'logMessage'      => "Locale: '%locale%', missing: '%message%'"));
            }
        }
        else {
            $oTranslate->addTranslation($translationsDirectoryPath,
                null,
                $adapterOptions);
        }
        
        //since Zend_Translate updates its own locale when adding translations,
        //we'll override it here with app wide locale
        $oTranslate->setLocale(Zend_Registry::get('Zend_Locale'));
        
        self::setTranslate($oTranslate);
    }
    
    
    /**
     * Translate method, returns translation of the given string. If values
     * are given substitution is made on the string using vsprintf function.
     * If the locale is null, default locale stored in Zend_Registry will be used.
     *
     * @param string $messageId String to be translated
     * @param string|array $aValues single value or array of values to be substituted in the translated string
     * @param locale Zend_Locale|string desired locale for the translation
     */
    public static function t($messageId, $aValues = null, $locale = null)
    {
        $oTranslation = self::getTranslate();
        $translated = $oTranslation->translate($messageId, $locale);
        
        // If substitution variables have been provided
        if (!empty($aValues)) {
            $aValues = is_string($aValues) ? array($aValues) : $aValues;
            $translated = vsprintf($translated, $aValues);
        }
        
        return $translated;
    }
    
        
    /**
     * @return Zend_Translate preconfigured zend translate with app translations
     */
    public static function getTranslate()
    {
         return Zend_Registry::get('Zend_Translate');
    }
    
    
    /**
     * Internal setter. Saves the translate object under 'Zend_Translate' key in
     * Zend_Registry static instance
     *
     * @param Zend_Translate $oTranslate
     */
    private static function setTranslate(Zend_Translate $oTranslate)
    {
        Zend_Registry::set('Zend_Translate', $oTranslate);            
    }
    
    
}
?>