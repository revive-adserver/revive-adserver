<?php

class OX_Common_Validate_Url extends Zend_Validate_Abstract
{
    const INVALID_URL = 'invalidUrl';
    
    protected $_messageTemplates = array (
            self::INVALID_URL => 'Please provide a correct URL');
    
    private $requireProtocol;     

    private $allowWildcards;
            
    /**
     * constructor
     *
     * @param bool $requireProtocol - protocol is required if true, not allowed if false
     * @param bool $allowWildcards - wildcards are allowed if true
     */
    public function __construct($requireProtocol = true, $allowWildcards = false)
    {
        $this->requireProtocol = $requireProtocol;
        $this->allowWildcards  = $allowWildcards;
        if ($allowWildcards) {
            $this->_messageTemplatess = array (
                self::INVALID_URL => 'Please provide a correct URL, you can use * as a wildcard.');
        }
    }
                
            
    public function isValid($url)
    {
        $valid = self::isUrlValid($url, $this->requireProtocol, $this->allowWildcards);
        if (!$valid) {
            $this->_error();
        }
        
        return $valid;
    }
    
    
    public static function isUrlValid($url, $requireProtocol = true, $allowWildcards = false)
    {
       $prefix = $requireProtocol ? 'http(s?)\:\/\/' : '';
       $path = $allowWildcards ? '[\w\d\*\-]+(\.[\w\d\*\-]+)*(:[\d\*]{1,5})?(\/[\w\d:#@%\/;$()~_?\+\-=\\\.&\*]*)?$/' 
                               : '[\w\d\-]+(\.[\w\d\-]+)*(:[\d]{1,5})?(\/[\w\d:#@%\/;$()~_?\+\-=\\\.&]*)?$/';
       return preg_match('/^'.$prefix.$path, $url) == 1;
        
    }
    
    public static function clean($url)
    {
        return preg_replace('/^\s*(https?:\/\/)?|(\s|\/)*$/', '', $url);
    }
    
}
