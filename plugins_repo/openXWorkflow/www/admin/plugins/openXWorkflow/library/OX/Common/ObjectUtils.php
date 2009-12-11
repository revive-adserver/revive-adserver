<?php

/**
 * Utitlities for working with generic objects.
 */
class OX_Common_ObjectUtils
{
    public static function setOptions($object, array $options = null, 
            array $forbidden = array(), 
            array $allowed = array())
    {
        if (!$object || !$options) {
            return array ();
        }
        
        $unused = array ();
        foreach ($options as $key => $value) {
            if (count($allowed) > 0 && !in_array($key, $allowed)) {
                continue;
            }
            if (in_array($key, $forbidden)) {
                $unused[$key] = $value;
                continue;
            }
            $normalized = ucfirst($key);
            
            $method = 'set' . $normalized;
            if (method_exists($object, $method)) {
                $object->$method($value);
            }
            else {
                $unused[$key] = $value;
            }
        }
        
        return $unused;
    }


    public static function getDefault($result, $defaultIfNull)
    {
        return ($result === null) ? $defaultIfNull : $result;
    }
}
