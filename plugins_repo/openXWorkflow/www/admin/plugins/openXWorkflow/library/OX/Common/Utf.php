<?php

/**
 * 
 */
class OX_Common_Utf
{
    const UTF8_SIGNATURE = "\xef\xbb\xbf";
    const UTF16LE_SIGNATURE = "\xff\xfe";


    public static function isConversionAvailable()
    {
        return extension_loaded('iconv') || extension_loaded('mbstring');
    }


    public static function utf8ToUtf16LE($utf8String)
    {
        if (extension_loaded('iconv')) {
            return iconv('UTF-8', 'UTF-16LE', $utf8String);
        }
        elseif (extension_loaded('mbstring')) {
            return mb_convert_encoding($utf8String, 'UTF-16LE', 'UTF-8');
        }
        else {
            trigger_error('UTF-8 to UTF-16 conversion requested but neither 
                iconv or mbstring is available. Returning UTF-8.', E_USER_NOTICE);
            return $utf8String;
        }
    }
}
