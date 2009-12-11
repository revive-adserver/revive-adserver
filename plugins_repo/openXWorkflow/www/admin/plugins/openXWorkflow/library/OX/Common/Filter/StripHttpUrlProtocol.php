<?php

/**
 * Strips HTTP and HTTPS protocols from URLs. Also strips leading and trailing spaces.
 */
class OX_Common_Filter_StripHttpUrlProtocol implements Zend_Filter_Interface
{
    public function filter($value)
    {
        return self::stripProtocolAndSpaces($value);
    }
    

    public static function stripProtocolAndSpaces($url)
    {
        return preg_replace('/^\s*(https?:\/\/)?|(\s|\/)*$/', '', $url);
    }
}
