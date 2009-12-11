<?php

class OX_Common_ArrayUtils
{
    public static function single($coll)
    {
        if (count($coll) > 1) {
            throw new RuntimeException("Array size > 1");
        }
        return OX_Common_ArrayUtils::first($coll);
    }
    
    public static function first($coll)
    {
        if (count($coll) == 0) {
            return null;
        }
        foreach ($coll as $elem) {
            return $elem;
        }
    }
    
    public static function project($coll, $field, $sort = true)
    {
        $result = array ();
        
        foreach ($coll as $object) {
            $val = self::getByPropertyOrGetter($object, $field);
            if (isset($val)) {
                $result [] = $val;
            } 
        }
        
        if ($sort) {
            natcasesort($result);
        	$result = array_values($result);
        }
        
        return $result;
    }
    
    /**
     * To perform filtering, pass the $acceptObjectCallback, which will be called with
     * the current object as first parameter. The object will be added to the resulting
     * array only if the callback returns true. The filtering callback is optional. 
     */
    public static function biject($coll, $idField, $labelField, 
            $acceptObjectCallback = null, $sort = true)
    {
        $result = array ();
        
        foreach ($coll as $object) {
            if ($acceptObjectCallback) {
                if (! call_user_func($acceptObjectCallback, $object)) {
                    continue;
                }
            }
            $result [self::getByPropertyOrGetter($object, $idField)] = self::getByPropertyOrGetter($object, $labelField);
        }
        if ($sort) {
            natcasesort($result);
        }
        return $result;
    }
    

    private static function getByPropertyOrGetter($object, $field)
    {
        if (isset($object [$field])) {
            return $object [$field];
        } 
        else {
            $method = 'get' . ucfirst($field);
            if (method_exists($object, $method)) {
                return $object->$method();
            }
        }
        return null;
    }
    
    
    public static function sortByProperty(&$arr, $prop, $comparator = null, $preserverKeys = false)
    {
        $callback = array (OX_Common_ComparatorUtils::byPropertyComparator(
                        $prop, $comparator), 'compare');
        if ($preserverKeys) {
            uasort($arr, $callback);
        } else {
            usort($arr, $callback);
        }
        return $arr;
    }

    
    public static function transformByProperty($arr, $prop)
    {
        return self::transform($arr, new OX_Common_ToPropertyTransfromer($prop));
    }
    
    
    public static function transformByMethod($arr, $methodName)
    {
        return self::transform($arr, new OX_Common_ToMethodTransfromer($methodName));
    }
    
    
    public static function transform($arr, OX_Common_Transformer $transformer)
    {
        $result = array();
        foreach ($arr as $k => $v) {
            $result[$k] = $transformer->transform($v);
        }
        return $result;
    }
    
    
    public static function mapByProperty($arr, $prop)
    {
        return self::mapUsingTransformer($arr, new OX_Common_ToPropertyTransfromer($prop));
    }

    
    public static function mapByMethod($arr, $methodName)
    {
        return self::mapUsingTransformer($arr, new OX_Common_ToMethodTransfromer($methodName));
    }
    
    
    public static function mapUsingTransformer($arr, OX_Common_Transformer $transformer)
    {
        $result = array();
        foreach ($arr as $v) {
            $result[$transformer->transform($v)] = $v;
        }
        return $result;
    }
    
    
    public static function addIfNotNull(&$array, $key, $value)
    {
        if ($value) {
            $array [$key] = $value;
        }
    }
    
    public static function addIfSet(&$array, $key, $value)
    {
        if (isset($value)) {
            $array [$key] = $value;
        }
    }
    
    public static function addAll(&$dest, $source)
    {
        if (isset($dest) && $source) {
            foreach ($source as $key => $val) {
                $dest [$key] = $val;
            }
        }
        
        return $dest;
    }
    
    public static function appendAll(&$dest, $source)
    {
        if (isset($dest) && $source) {
            foreach ($source as $val) {
                $dest[] = $val;
            }
        }
        return $dest;
    }
    
    public static function binarySearch($value, $aTable, $columnName, $start, 
            $length, $ascending, 
            $string_values = true)
    {
        $error_result = $start - 1;
        $end = $start + $length - 1;
        while ($start <= $end) {
            $index = intval(floor(($end + $start) / 2));
            
            if (0 == self::_compare($value, $aTable [$index] [$columnName], $string_values)) {
                return $index;
            }
            
            if ($ascending) {
                if (self::_compare($aTable [$index] [$columnName], $value, $string_values) > 0) {
                    $end = $index - 1;
                } else {
                    $start = $index + 1;
                }
            } else {
                if (self::_compare($aTable [$index] [$columnName], $value, $string_values) > 0) {
                    
                    $start = $index + 1;
                } else {
                    $end = $index - 1;
                }
            }
        }
        
        return $error_result;
    }
    
    private static function _compare($value1, $value2, $string_values)
    {
        if ($string_values) {
            return strcmp($value1, $value2);
        } else {
            return ($value1 - $value2);
        }
    
    }
    
    public static function getDefault($array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }
}
