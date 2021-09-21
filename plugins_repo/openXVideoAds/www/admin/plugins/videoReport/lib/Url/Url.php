<?php

// From Piwik core/Url.php
class OX_Vast_Url
{
    /**
     * If current URL is "http://example.org/dir1/dir2/index.php?param1=value1&param2=value2"
     * will return "http://example.org/dir1/dir2/index.php?param1=value1&param2=value2"
     * @return string
     */
    public static function getCurrentUrl()
    {
        return	self::getCurrentHost()
                . self::getCurrentScriptName()
                . self::getCurrentQueryString();
    }
    
    /**
     * If current URL is "http://example.org/dir1/dir2/index.php?param1=value1&param2=value2"
     * will return "http://example.org/dir1/dir2/index.php"
     * @return string
     */
    public static function getCurrentUrlWithoutQueryString()
    {
        return	self::getCurrentHost()
                . self::getCurrentScriptName();
    }
    
    /**
     * If current URL is "http://example.org/dir1/dir2/index.php?param1=value1&param2=value2"
     * will return "http://example.org/dir1/dir2/"
     * @return string with trailing slash
     */
    public static function getCurrentUrlWithoutFileName()
    {
        $host = self::getCurrentHost();
        $urlDir = self::getCurrentScriptPath();
        return $host . $urlDir;
    }

    /**
     * If current URL is "http://example.org/dir1/dir2/index.php?param1=value1&param2=value2"
     * will return "/dir1/dir2/"
     * @return string with trailing slash
     */
    public static function getCurrentScriptPath()
    {
        $queryString = self::getCurrentScriptName();
        
        //add a fake letter case /test/test2/ returns /test which is not expected
        $urlDir = dirname($queryString . 'x');
        $urlDir = str_replace('\\', '/', $urlDir);
        // if we are in a subpath we add a trailing slash
        if (strlen($urlDir) > 1) {
            $urlDir .= '/';
        }
        return $urlDir;
    }
    
    /**
     * If current URL is "http://example.org/dir1/dir2/index.php?param1=value1&param2=value2"
     * will return "/dir1/dir2/index.php"
     * @return string
     */
    public static function getCurrentScriptName()
    {
        $url = '';
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        } elseif (!empty($_SERVER['REQUEST_URI'])) {
            if (($pos = strpos($_SERVER['REQUEST_URI'], "?")) !== false) {
                $url = substr($_SERVER['REQUEST_URI'], 0, $pos);
            } else {
                $url = $_SERVER['REQUEST_URI'];
            }
        }
        
        if (empty($url)) {
            $url = $_SERVER['SCRIPT_NAME'];
        }
        return $url;
    }

    /**
     * If current URL is "http://example.org/dir1/dir2/index.php?param1=value1&param2=value2"
     * will return "http://example.org"
     * @return string
     */
    public static function getCurrentHost()
    {
        if (isset($_SERVER['HTTPS'])
            && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] === true)
            ) {
            $url = 'https';
        } else {
            $url = 'http';
        }
        
        $url .= '://';
        
        if (isset($_SERVER['HTTP_HOST'])) {
            $url .= $_SERVER['HTTP_HOST'];
        } else {
            $url .= 'unknown';
        }
        return $url;
    }
        
    /**
     * If current URL is "http://example.org/dir1/dir2/index.php?param1=value1&param2=value2"
     * will return "?param1=value1&param2=value2"
     * @return string
     */
    public static function getCurrentQueryString()
    {
        $url = '';
        if (isset($_SERVER['QUERY_STRING'])
            && !empty($_SERVER['QUERY_STRING'])) {
            $url .= "?" . $_SERVER['QUERY_STRING'];
        }
        return $url;
    }
    
    /**
     * If current URL is "http://example.org/dir1/dir2/index.php?param1=value1&param2=value2"
     * will return
     *  array
     *    'param1' => string 'value1'
     *    'param2' => string 'value2'
     *
     * @return array
     */
    public static function getArrayFromCurrentQueryString()
    {
        $queryString = substr(self::getCurrentQueryString(), 1);
        parse_str($queryString, $urlValues);
        return $urlValues;
    }
    
    /**
     * Given an array of name-values, it will return the current query string
     * with the new requested parameter key-values;
     * If a parameter wasn't found in the current query string, the new key-value will be added to the returned query string.
     *
     * @param array $params array ( 'param3' => 'value3' )
     * @return string ?param2=value2&param3=value3
     */
    public static function getCurrentQueryStringWithParametersModified($params)
    {
        $urlValues = self::getArrayFromCurrentQueryString();
        foreach ($params as $key => $value) {
            $urlValues[$key] = $value;
        }
        $query = self::getQueryStringFromParameters($urlValues);
        if (strlen($query) > 0) {
            return '?' . $query;
        }
        return '';
    }
    
    /**
     * Given an array of parameters name->value, returns the query string.
     * Also works with array values using the php array syntax for GET parameters.
     * @param $parameters eg. array( 'param1' => 10, 'param2' => array(1,2))
     * @return string eg. "param1=10&param2[]=1&param2[]=2"
     */
    public static function getQueryStringFromParameters($parameters)
    {
        $query = '';
        foreach ($parameters as $name => $value) {
            if (empty($value)) {
                continue;
            }
            if (is_array($value)) {
                foreach ($value as $theValue) {
                    $query .= $name . "[]=" . urlencode($theValue) . "&";
                }
            } else {
                $query .= $name . "=" . urlencode($value) . "&";
            }
        }
        $query = substr($query, 0, -1);
        return $query;
    }
    
    /**
     * Redirects the user to the Referer if found.
     * If the user doesn't have a referer set, it redirects to the current URL without query string.
     *
     * @return void http Location: header sent
     */
    public static function redirectToReferer()
    {
        $referer = self::getReferer();
        if ($referer !== false) {
            self::redirectToUrl($referer);
        }
        self::redirectToUrl(self::getCurrentUrlWithoutQueryString());
    }
    
    /**
     * Redirects the user to the specified URL
     *
     * @param string $url
     * @return void http Location: header sent
     */
    public static function redirectToUrl($url)
    {
        header("Location: $url");
        exit;
    }
    
    /**
     * Returns the HTTP_REFERER header, false if not found.
     *
     * @return string|false
     */
    public static function getReferer()
    {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        }
        return false;
    }
}
