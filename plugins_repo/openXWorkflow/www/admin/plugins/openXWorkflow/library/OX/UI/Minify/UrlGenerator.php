<?php

/**
 * Generates URLs for resources minified by the Minify library.
 */
class OX_UI_Minify_UrlGenerator
{
    const MINIFY_PROCESSOR = 'min.php';

    /**
     * @return url for the resource identified by $groupId. Groups are usually defined
     * in 'minify-init.php' in the application folder.
     */
    public static function groupUrl($groupId)
    {
        return self::buildMinifyUrl(array ('g' => $groupId));
    }


    private static function buildMinifyUrl(array $params)
    {
        $url = Zend_Controller_Front::getInstance()->getBaseUrl() . '/' . self::MINIFY_PROCESSOR . '?';
        $params['v'] = OX_Common_Config::getApplicationVersion();
        $tuples = array ();
        foreach ($params as $name => $value) {
            $tuples[] = $name . '=' . $value;
        }
        return $url . join('&', $tuples);
    }
}
