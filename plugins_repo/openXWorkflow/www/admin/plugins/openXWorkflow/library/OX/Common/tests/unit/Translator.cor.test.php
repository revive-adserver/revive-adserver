<?php

require_once(LIB_PATH . '/simpletest/unit_tester.php');
require_once(LIB_PATH . '/simpletest/reporter.php');


class OX_Common_TranslatorTest extends UnitTestCase
{
    private $configFile;
    private $baseDir;
    private $aErrors;
    
    public function setUp()
    {
        $this->aErrors = array();
        
        $this->baseDir = realpath(dirname(__FILE__));
        if (!defined('CACHE_PATH')) {
            define('CACHE_PATH', $this->baseDir.'/cache');
        }
        if (file_exists(CACHE_PATH) && is_dir(CACHE_PATH)) {
            $this->cleardir(CACHE_PATH);
        }
        
        if (!file_exists(CACHE_PATH)) {
            mkdir(CACHE_PATH);
        }
        
        $this->configFile = $this->baseDir . '/test-data/languages-config.php';
    }
    
    
    public function tearDown()
    {
        $this->cleardir(CACHE_PATH);
    }
    

    public function testInit()
    {
        try {
            OX_Common_Translator::init();        
        } 
        catch (Exception $e) {
            $this->fail('Init should not fail: ' .  $e->getMessage());
        }

        $oTransCache = Zend_Translate::getCache();
        
        $this->assertIsA($oTransCache, 'Zend_Cache_Core');
    }
    
    
    public function testAddTranslationsOnce()
    {
        $this->init();
        OX_Common_Translator::addTranslations($this->baseDir.'/test-data/languages/set1');
        
        $oTranslate = OX_Common_Translator::getTranslate();
        $this->checkTranslate($oTranslate, array('en' => 5, 'pl' => 2));
        
        //test for messages existence
        $this->checkMessage($oTranslate, 'Untranslated string', 'en', false);
        $this->checkMessage($oTranslate, 'Test message 1', 'en');
        $this->checkMessage($oTranslate, 'Test message 2', 'en');
        $this->checkMessage($oTranslate, 'Test message 3', 'en');
        $this->checkMessage($oTranslate, 'Message with %s variable', 'en');
        
        $this->checkMessage($oTranslate, 'Test message 1', 'pl');
        $this->checkMessage($oTranslate, 'Test message 2', 'pl');
        $this->checkMessage($oTranslate, 'Test message 3', 'pl', false);
        $this->checkMessage($oTranslate, 'Message with %s variable', 'pl', false);
    }
    
    
    public function testAddTranslationsTwice()
    {
        $this->testAddTranslationsOnce();        
        
        //test second translation set - should add 2 english and 1 pl message key
        OX_Common_Translator::addTranslations($this->baseDir.'/test-data/languages/set2');
        $oTranslate = OX_Common_Translator::getTranslate();
        $this->checkTranslate($oTranslate, array('en' => 7, 'pl' => 3));
        
        //test for messages existence
        $this->checkMessage($oTranslate, 'Untranslated string', 'en', false);
        $this->checkMessage($oTranslate, 'Test message 1', 'en');
        $this->checkMessage($oTranslate, 'Test message 2', 'en');
        $this->checkMessage($oTranslate, 'Test message 3', 'en');
        $this->checkMessage($oTranslate, 'Test message 4', 'en');
        $this->checkMessage($oTranslate, 'Test message 5', 'en');
        $this->checkMessage($oTranslate, 'Untranslated string', 'pl', false);
        $this->checkMessage($oTranslate, 'Test message 1', 'pl');
        $this->checkMessage($oTranslate, 'Test message 2', 'pl');
        $this->checkMessage($oTranslate, 'Test message 3', 'pl', false);
        $this->checkMessage($oTranslate, 'Test message 4', 'pl');
        $this->checkMessage($oTranslate, 'Test message 5', 'pl', false);
    }
    
    
    public function testTOneSource()
    {
        $this->init();
        OX_Common_Translator::addTranslations($this->baseDir.'/test-data/languages/set1');
        $oTranslate = OX_Common_Translator::getTranslate();
        
        //test translations for different locales
        $oTranslate->setLocale('en');
        $translated = OX_Common_Translator::t('Test message 1');
        $this->assertEqual('Test message 1 translated from source 1', $translated);
        
        $translated = OX_Common_Translator::t('Test message 2');
        $this->assertEqual('Test message 2 translated from source 1', $translated);

        $oTranslate->setLocale('pl');
        $translated = OX_Common_Translator::t('Test message 1');
        $this->assertEqual('Testowy komunikat nr 1 ze zrodla 1', $translated);
        
        $translated = OX_Common_Translator::t('Test message 2');
        $this->assertEqual('Testowy komunikat nr 2 ze zrodla 1', $translated);

        //test locale downgrade
        $oTranslate->setLocale('en_US');
        $translated = OX_Common_Translator::t('Test message 1');
        $this->assertEqual('Test message 1 translated from source 1', $translated);
        
        //test missing translation
        $oTranslate->setLocale('en');
        $translated = OX_Common_Translator::t('Untranslated message');
        $this->assertEqual('Untranslated message', $translated);
        
        //test missing translation in locale PL does not return translatin from different locale
        $oTranslate->setLocale('pl');
        $translated = OX_Common_Translator::t('Test message 3');
        $this->assertEqual('Test message 3', $translated);
        
        //test locale override from function call
        $oTranslate->setLocale('pl');
        $translated = OX_Common_Translator::t('Test message 1', null, 'en');
        $this->assertEqual('Test message 1 translated from source 1', $translated);
    }
    
    
    public function testTTwoSources()
    {
        $this->testTOneSource();
        OX_Common_Translator::addTranslations($this->baseDir.'/test-data/languages/set2');
        $oTranslate = OX_Common_Translator::getTranslate();
        
        //test translations from set1 and set 2 for different locales (check set2 not overriden set1)
        $oTranslate->setLocale('en');
        $translated = OX_Common_Translator::t('Test message 1');
        $this->assertEqual('Test message 1 translated from source 1', $translated);
        
        $translated = OX_Common_Translator::t('Test message 2');
        $this->assertEqual('Test message 2 translated from source 1', $translated);
        
        $oTranslate->setLocale('pl');
        $translated = OX_Common_Translator::t('Test message 1');
        $this->assertEqual('Testowy komunikat nr 1 ze zrodla 1', $translated);
        
        $translated = OX_Common_Translator::t('Test message 2');
        $this->assertEqual('Testowy komunikat nr 2 ze zrodla 1', $translated);
        
        //test translation from set2
        $oTranslate->setLocale('en');
        $translated = OX_Common_Translator::t('Test message 4');
        $this->assertEqual('Test message 4 translated from source 2', $translated);
        
        $translated = OX_Common_Translator::t('Test message 5');
        $this->assertEqual('Test message 5 translated from source 2', $translated);
        
        
        
        $oTranslate->setLocale('pl');
        $translated = OX_Common_Translator::t('Test message 4');
        $this->assertEqual('Testowy komunikat nr 4 ze zrodla 2', $translated);
        
        //test locale downgrade
        $oTranslate->setLocale('en_US');
        $translated = OX_Common_Translator::t('Test message 1');
        $this->assertEqual('Test message 1 translated from source 1', $translated);
        
        //test missing translation
        $oTranslate->setLocale('en');
        $translated = OX_Common_Translator::t('Untranslated message');
        $this->assertEqual('Untranslated message', $translated);

        $oTranslate->setLocale('pl');
        $translated = OX_Common_Translator::t('Untranslated message');
        $this->assertEqual('Untranslated message', $translated);
        
        //test missing translation in locale PL does not return translatin from different locale
        $oTranslate->setLocale('pl');
        $translated = OX_Common_Translator::t('Test message 3');
        $this->assertEqual('Test message 3', $translated);
        
        $translated = OX_Common_Translator::t('Test message 5');
        $this->assertEqual('Test message 5', $translated);
        
        //test locale override from function call
        $oTranslate->setLocale('pl');
        $translated = OX_Common_Translator::t('Test message 1', null, 'en');
        $this->assertEqual('Test message 1 translated from source 1', $translated);
    }
    
    
    public function testTValues()
    {
        $this->init();
        OX_Common_Translator::addTranslations($this->baseDir.'/test-data/languages/set1');
        $oTranslate = OX_Common_Translator::getTranslate();
        
        $oTranslate->setLocale('en');
        
        //test one value
        $translated = OX_Common_Translator::t('Message with %s variable', 'test');
        $this->assertEqual('Message with test variable translated from source 1', $translated);
        
        $translated = OX_Common_Translator::t('Message with %s variable', array('test'));
        $this->assertEqual('Message with test variable translated from source 1', $translated);
        
        //test translation with expected value 
        $translated = OX_Common_Translator::t('Message with %s variable');
        $this->assertEqual('Message with %s variable translated from source 1', $translated);
        
        //multiple values
        $translated = OX_Common_Translator::t('Message with %s variable and %s variable', array('test1', 'test2'));
        $this->assertEqual('Message with test1 variable and test2 variable translated from source 1', $translated);
        
        //multiple values - missing
        $orgErrorHandler = set_error_handler(array($this, 'myErrorHandler'));
        $translated = OX_Common_Translator::t('Message with %s variable and %s variable', array('test1'));
        set_error_handler($orgErrorHandler);
        $this->assertEqual(false, $translated);
        $this->assertTrue(count($this->aErrors) == 1, 'PHP error was expected here');
        $this->assertTrue(strpos($this->aErrors[0][1], 'vsprintf') !== FALSE, 'vsprintf error expected');
        $this->assertTrue(strpos($this->aErrors[0][2], 'Translator.php') !== FALSE, 'Translator.php error expected');

        
        //missing translation with values
        $oTranslate->setLocale('pl');
        $translated = OX_Common_Translator::t('Message with %s variable', array('test'));
        $this->assertEqual('Message with test variable', $translated);
    }
    
    
    private function init()
    {
        //this is intentionally done here and not in setUp since translator init 
        //function is tested separately
        OX_Common_Config::setDefaultConfigFile($this->configFile);
        OX_Common_Config::initLocale();
        OX_Common_Translator::init();
    }
    
    
    
    private function checkTranslate(Zend_Translate $oTranslate, $aMessagesCount)
    {
        $this->assertNotNull($oTranslate);
        
        foreach ($aMessagesCount as $locale => $expectedMessageCount) {
            $aMessageIds = null;
            $aMessageIds = $oTranslate->getMessageIds($locale);
            $this->checkLocaleMessages($aMessageIds, $locale, $expectedMessageCount);
        }
    }
    
    
    private function checkLocaleMessages($aMessageIds, $locale, $expectedMessageCount)
    {
        $this->assertEqual($expectedMessageCount, count($aMessageIds), "Locale $locale: %s");
    }
    
    
    private function checkMessage(Zend_Translate $oTranslate, $message, $locale, $exists = true)
    {
        if ($exists) { 
            $this->assertTrue($oTranslate->isTranslated($message, false, $locale), "Locale $locale: Failed to find message: " . $message);
        }
        else {
            $this->assertFalse($oTranslate->isTranslated($message, false, $locale), "Locale $locale: Unexpected message found: " . $message);
        }
                
    }

    
    /**
     * Delete a file, or a folder and its contents (recursive algorithm)
     *
     * @author      Aidan Lister <aidan@php.net>
     * @version     1.0.3
     * @link        http://aidanlister.com/repos/v/function.rmdirr.php
     * @param       string   $dirname    Directory to delete
     * @return      bool     Returns TRUE on success, FALSE on failure
     */
    function cleardir($dirname)
    {
       // Sanity check
        if (!file_exists($dirname)) {
            return false;
        }    
        $aCacheFiles = scandir($dirname);
        $aCacheFiles = array_filter($aCacheFiles, array($this, 'filterFiles' )); 

        foreach ($aCacheFiles as $filename) {
            $filePath = $dirname.'/'.$filename;
            if( is_file($filePath) ) {
                unlink($filePath);
            }
        }
    }
    
    
    function filterFiles($value)
    {
        return strpos($value, 'zend_cache') !== FALSE;
    }
    
    // error handler function
    function myErrorHandler($errno, $errstr, $errfile, $errline)
    {
        $error = array($errno, $errstr, $errfile, $errline);
        $this->aErrors[] = $error;
        
        /* Don't execute PHP internal error handler */
        return true;
    }    
}
?>
