<?php

class OX_Common_StringUtils
{
    public static function underscore($camelCase)
    {
    	$result = "";
    	$len = strlen($camelCase);
    	for ($i = 0; $i < $len; $i++) {
    		$c = substr($camelCase, $i, 1);
    		$cLower = strtolower($c);
    		if ($cLower != $c) {
    			$result .= "_" . $cLower;
    		}
    		else {
    			$result .= $c;
    		}
    	}
    	return $result;
    }

    public static function camelCase($underscore)
    {
    	$result = "";
    	$len = strlen($underscore);
    	$upper = true;
    	for ($i = 0; $i < $len; $i++) {
    		$c = substr($underscore, $i, 1);
    		if ($c == '_') {
    		    $upper = true;
    		    continue;
    		}
    		$result .= ($upper ? strtoupper($c) : $c);
    		$upper = false;
    	}
    	return $result;
    }
    
    public static function nullOrValue($string)
    {
        if ($string && is_string($string) && strlen($string) > 0)
        {
            return $string;
        }
        else
        {
            return null;
        }
    }
    
    
    public static function endsWith($str, $suffix)
    {
    	return strlen($str) >= strlen($suffix) &&
    		substr_compare($str, $suffix, -strlen($suffix)) == 0;
    }
    

    public static function startsWith($str, $prefix)
    {
        return strlen($str) >= strlen($prefix) &&
        	substr_compare($str, $prefix, 0, strlen($prefix)) == 0;
    }
}
