<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Translate
 * @subpackage Zend_Translate_Adapter
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Date.php 2498 2006-12-23 22:13:38Z thomas $
 */

/**
 * @see Zend_Locale
 */
require_once 'Zend/Locale.php';

/**
 * Basic adapter class for each translation source adapter
 *
 * @category   Zend
 * @package    Zend_Translate
 * @subpackage Zend_Translate_Adapter
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class Zend_Translate_Adapter {
    /**
     * Shows if locale detection is in automatic level
     * @var boolean
     */
    private          $_automatic = true;

    /**
     * Internal cache for all adapters
     * @var Zend_Cache_Core
     */
    protected static $_cache     = null;

    /**
     * Scans for the locale within the name of the directory
     * @constant integer
     */
    const LOCALE_DIRECTORY = 1;

    /**
     * Scans for the locale within the name of the file
     * @constant integer
     */
    const LOCALE_FILENAME  = 2;

    /**
     * Array with all options, each adapter can have own additional options
     *       'clear'  => clears already loaded data when adding new files
     *       'scan'   => searches for translation files using the LOCALE constants
     *       'locale' => the actual set locale to use
     * @var array
     */
    protected $_options = array(
        'clear'  => false,
        'scan'   => null,
        'locale' => 'auto' 
    );

    /**
     * Translation table
     * @var array
     */
    protected $_translate = array();

    /**
     * Generates the adapter
     *
     * @param  string|array       $data    Translation data or filename for this adapter
     * @param  string|Zend_Locale $locale  (optional) Locale/Language to set, identical with Locale
     *                                     identifiers see Zend_Locale for more information
     * @param  array              $options (optional) Options for the adaptor
     * @throws Zend_Translate_Exception
     * @return void
     */
    public function __construct($data, $locale = null, array $options = array())
    {
        if (isset(self::$_cache)) {
            $id = 'Zend_Translate_' . $this->toString();
            if ($result = self::$_cache->load($id)) {
                $this->_translate = unserialize($result);
                $this->_options   = $this->_translate['_options_'];
                unset($this->_translate['_options_']);
                return;
            }
        }

        $this->addTranslation($data, $locale, $options);
        $this->_automatic = true;
    }

    /**
     * Add translation data
     *
     * It may be a new language or additional data for existing language
     * If $clear parameter is true, then translation data for specified
     * language is replaced and added otherwise
     *
     * @param  array|string       $data    Translation data
     * @param  string|Zend_Locale $locale  (optional) Locale/Language to add data for, identical
     *                                        with locale identifier, see Zend_Locale for more information
     * @param  array              $options (optional) Option for this Adapter
     * @throws Zend_Translate_Exception
     * @return Zend_Translate_Adapter Provides a fluid interface
     */
    public function addTranslation($data, $locale = null, array $options = array())
    {
        if ($locale === null) {
            $locale = new Zend_Locale();
        }
        if ($locale instanceof Zend_Locale) {
            $locale = $locale->toString();
        }
        $originate = $locale;

        $this->setOptions($options);
        if (is_string($data) and is_dir($data)) {
            foreach (new RecursiveIteratorIterator(
                     new RecursiveDirectoryIterator($data, RecursiveDirectoryIterator::KEY_AS_PATHNAME), 
                     RecursiveIteratorIterator::SELF_FIRST) as $file => $info) {
                if ($info->isDir()) {

                    $directory = $info->getPath();
                    // pathname as locale
                    if (($this->_options['scan'] === self::LOCALE_DIRECTORY) and (Zend_Locale::isLocale((string) $info))) {
                        $locale = (string) $info;
                    }

                } else if ($info->isFile()) {

                    // filename as locale
                    if ($this->_options['scan'] === self::LOCALE_FILENAME) {
                        $filename = explode('.', (string) $info);
                        array_pop($filename);
                        $filename = implode('.', $filename);
                        if (Zend_Locale::isLocale($filename)) {
                            $locale = (string) $filename;
                        } else {
                            $found = false;
                            $parts = explode('.', $filename);
                            foreach($parts as $token) {
                                $parts = array_merge(explode('_', $token), $parts);
                            }
                            foreach($parts as $token) {
                                $parts = array_merge(explode('-', $token), $parts);
                            }
                            $parts = array_unique($parts);
                            foreach($parts as $token) {
                                if (Zend_Locale::isLocale($token)) {
                                    $locale = $token;
                                }
                            }
                        }
                    }
                    try {
                        $this->_addTranslationData((string) $info->getPathname(), $locale, $this->_options);
                        if ((array_key_exists($locale, $this->_translate)) and (count($this->_translate[$locale]) > 0)) {
                            $this->setLocale($locale);
                        }
                    } catch (Zend_Translate_Exception $e) {
                        // ignore failed sources while scanning
                    }
                }
            }
        } else {
            $this->_addTranslationData($data, $locale, $this->_options);
            if ((array_key_exists($locale, $this->_translate)) and (count($this->_translate[$locale]) > 0)) {
                $this->setLocale($locale);
            }
        }
        if ((array_key_exists($originate, $this->_translate)) and (count($this->_translate[$originate]) > 0)) {
            $this->setLocale($originate);
        }
        return $this;
    }

    /**
     * Sets new adapter options
     *
     * @param  array $options Adapter options
     * @throws Zend_Translate_Exception
     * @return Zend_Translate_Adapter Provides a fluid interface
     */
    public function setOptions(array $options = array())
    {
        foreach ($options as $key => $option) {
            if ($key == "locale") {
                $this->setLocale($option);
            } else {
                $this->_options[strtolower($key)] = $option;
            }
        }
        return $this;
    }

    /**
     * Returns the adapters name and it's options
     *
     * @param  string|null $optionKey String returns this option
     *                                null returns all options
     * @return integer|string|array|null
     */
    public function getOptions($optionKey = null)
    {
        if ($optionKey === null) {
            return $this->_options;
        }
        if (array_key_exists(strtolower($optionKey), $this->_options)) {
            return $this->_options[strtolower($optionKey)];
        }
        return null;
    }

    /**
     * Gets locale
     *
     * @return Zend_Locale|string|null
     */
    public function getLocale()
    {
        return $this->_options['locale'];
    }

    /**
     * Sets locale
     *
     * @param  string|Zend_Locale $locale Locale to set
     * @throws Zend_Translate_Exception
     * @return Zend_Translate_Adapter Provides a fluid interface
     */
    public function setLocale($locale)
    {
        if ($locale instanceof Zend_Locale) {
            $locale = $locale->toString();
        } else if (!$locale = Zend_Locale::isLocale($locale)) {
            /**
             * @see Zend_Translate_Exception
             */
            require_once 'Zend/Translate/Exception.php';
            throw new Zend_Translate_Exception("The given Language ({$locale}) does not exist");
        }

        if (!array_key_exists($locale, $this->_translate) and empty($this->_translate[$locale])) {
            $temp = explode('_', $locale);
            if (!array_key_exists($temp[0], $this->_translate)) {
                /**
                 * @see Zend_Translate_Exception
                 */
                require_once 'Zend/Translate/Exception.php';
                throw new Zend_Translate_Exception("Language ({$locale}) has to be added before it can be used.");
            }
            $locale = $temp[0];
        }

        $this->_options['locale'] = $locale;
        if ($locale == "auto") {
            $this->_automatic = true;
        } else {
            $this->_automatic = false;
        }
        return $this;
    }

    /**
     * Returns the available languages from this adapter
     *
     * @return array
     */
    public function getList()
    {
        $list = array_keys($this->_translate);
        $result = null;
        foreach($list as $key => $value) {
            if (!empty($this->_translate[$value])) {
                $result[$value] = $value;
            }
        }
        return $result;
    }

    /**
     * Returns all available message ids from this adapter
     * If no locale is given, the actual language will be used
     *
     * @param  string|Zend_Locale $locale (optional) Language to return the message ids from
     * @return array
     */
    public function getMessageIds($locale = null)
    {
        if (empty($locale) or !$this->isAvailable($locale)) {
            $locale = $this->_options['locale'];
        }
        return array_keys($this->_translate[$locale]);
    }

    /**
     * Returns all available translations from this adapter
     * If no locale is given, the actual language will be used
     * If 'all' is given the complete translation dictionary will be returned
     *
     * @param  string|Zend_Locale $locale (optional) Language to return the messages from
     * @return array
     */
    public function getMessages($locale = null)
    {
        if ($locale == 'all') {
            return $this->_translate;
        }
        if (empty($locale) or !$this->isAvailable($locale)) {
            $locale = $this->_options['locale'];
        }
        return $this->_translate[$locale];
    }

    /**
     * Is the wished language available ?
     *
     * @see    Zend_Locale
     * @param  string|Zend_Locale $locale Language to search for, identical with locale identifier,
     *                                    @see Zend_Locale for more information
     * @return boolean
     */
    public function isAvailable($locale)
    {
        if ($locale instanceof Zend_Locale) {
            $locale = $locale->toString();
        }

        return array_key_exists($locale, $this->_translate);
    }

    /**
     * Load translation data
     *
     * @param  mixed              $data
     * @param  string|Zend_Locale $locale
     * @param  array              $options (optional)
     * @return void
     */
    abstract protected function _loadTranslationData($data, $locale, array $options = array());

    /**
     * Internal function for adding translation data
     *
     * It may be a new language or additional data for existing language
     * If $clear parameter is true, then translation data for specified
     * language is replaced and added otherwise
     *
     * @see    Zend_Locale
     * @param  array|string       $data    Translation data
     * @param  string|Zend_Locale $locale  Locale/Language to add data for, identical with locale identifier,
     *                                     @see Zend_Locale for more information
     * @param  array              $options (optional) Option for this Adapter
     * @throws Zend_Translate_Exception
     * @return Zend_Translate_Adapter Provides a fluid interface
     */
    private function _addTranslationData($data, $locale, array $options = array())
    {
        if (!$locale = Zend_Locale::isLocale($locale)) {
            /**
             * @see Zend_Translate_Exception
             */
            require_once 'Zend/Translate/Exception.php';
            throw new Zend_Translate_Exception("The given Language ({$locale}) does not exist");
        }

        if (!array_key_exists($locale, $this->_translate)) {
            $this->_translate[$locale] = array();
        }

        $this->_loadTranslationData($data, $locale, $options);
        if ($this->_automatic === true) {
            $find = new Zend_Locale($locale);
            $browser = $find->getBrowser() + $find->getEnvironment();
            arsort($browser);
            foreach($browser as $language => $quality) {
                if (array_key_exists($language, $this->_translate)) {
                    $this->_options['locale'] = $language;
                    break;
                }
            }
        }

        if (isset(self::$_cache)) {
            $id = 'Zend_Translate_' . $this->toString();
            $temp = $this->_translate;
            $temp['_options_'] = $this->_options;
            self::$_cache->save( serialize($temp), $id);
        }
        return $this;
    }

    /**
     * Translates the given string
     * returns the translation
     *
     * @see Zend_Locale
     * @param  string             $messageId Translation string
     * @param  string|Zend_Locale $locale    (optional) Locale/Language to use, identical with
     *                                       locale identifier, @see Zend_Locale for more information
     * @return string
     */
    public function translate($messageId, $locale = null)
    {
        if ($locale === null) {
            $locale = $this->_options['locale'];
        }
        if (!$locale = Zend_Locale::isLocale($locale)) {
            // language does not exist, return original string
            return $messageId;
        }

        if (is_array($messageId)) {
            return $messageId;
        }
        if ((is_array($this->_translate) and array_key_exists($locale, $this->_translate)) and
            (is_array($this->_translate[$locale]) and array_key_exists($messageId, $this->_translate[$locale]))) {
            // return original translation
            return $this->_translate[$locale][$messageId];
        } else if (strlen($locale) != 2) {
            // faster than creating a new locale and separate the leading part
            $locale = substr($locale, 0, -strlen(strrchr($locale, '_')));

            if ((is_array($this->_translate) and array_key_exists($locale, $this->_translate)) and
                (is_array($this->_translate[$locale]) and array_key_exists($messageId, $this->_translate[$locale]))) {
                // return regionless translation (en_US -> en)
                return $this->_translate[$locale][$messageId];
            }
        }

        // no translation found, return original
        return $messageId;
    }

    /**
     * Translates the given string
     * returns the translation
     *
     * @param  string             $messageId Translation string
     * @param  string|Zend_Locale $locale    (optional) Locale/Language to use, identical with locale
     *                                       identifier, @see Zend_Locale for more information
     * @return string
     */
    public function _($messageId, $locale = null)
    {
        return $this->translate($messageId, $locale);
    }

    /**
     * Checks if a string is translated within the source or not
     * returns boolean
     *
     * @param  string             $messageId Translation string
     * @param  boolean            $original  (optional) Allow translation only for original language
     *                                       when true, a translation for 'en_US' would give false when it can
     *                                       be translated with 'en' only
     * @param  string|Zend_Locale $locale    (optional) Locale/Language to use, identical with locale identifier,
     *                                       see Zend_Locale for more information
     * @return boolean
     */
    public function isTranslated($messageId, $original = false, $locale = null)
    {
        if (($original !== false) and ($original !== true)) {
            $locale = $original;
            $original = false;
        }
        if ($locale === null) {
            $locale = $this->_options['locale'];
        } else {
            if (!$locale = Zend_Locale::isLocale($locale)) {
                // language does not exist, return original string
                return false;
            }
        }

        if (is_array($messageId)) {
            return false;
        }
        if ((is_array($this->_translate) and array_key_exists($locale, $this->_translate)) and
            (is_array($this->_translate[$locale]) and array_key_exists($messageId, $this->_translate[$locale]))) {
            // return original translation
            return true;
        } else if ((strlen($locale) != 2) and ($original === false)) {
            // faster than creating a new locale and separate the leading part
            $locale = substr($locale, 0, -strlen(strrchr($locale, '_')));

            if ((is_array($this->_translate) and array_key_exists($locale, $this->_translate)) and
                (is_array($this->_translate[$locale]) and array_key_exists($messageId, $this->_translate[$locale]))) {
                // return regionless translation (en_US -> en)
                return true;
            }
        }

        // no translation found, return original
        return false;
    }

    /**
     * Sets a cache for all Zend_Translate_Adapters
     *
     * @param Zend_Cache_Core $cache Cache to store to
     */
    public static function setCache(Zend_Cache_Core $cache)
    {
        self::$_cache = $cache;
    }

    /**
     * Returns the adapter name
     *
     * @return string
     */
    abstract public function toString();
}