<?php

/**
 *	base include file for SimpleTest
 *	@package	SimpleTest
 */

/**
 *  Static methods for compatibility between different
 *  PHP versions.
 *  @package	SimpleTest
 */
class SimpleTestCompatibility
{
    /**
    	 *	  Creates a copy whether in PHP5 or PHP4.
    	 *	  @param object $object		Thing to copy.
    	 *	  @return object			A copy.
    	 *	  @access public
    	 *	  @static
    	 */
    public static function copy($object)
    {
        return clone $object;
    }

    /**
     *    Identity test. Drops back to equality + types for PHP5
     *    objects as the === operator counts as the
     *    stronger reference constraint.
     *    @param mixed $first    Test subject.
     *    @param mixed $second   Comparison object.
     *	  @return boolean		 True if identical.
     */
    public static function isIdentical($first, $second)
    {
        if ($first != $second) {
            return false;
        }

        return SimpleTestCompatibility::_isIdenticalType($first, $second);
    }

    /**
     *    Recursive type test.
     *    @param mixed $first    Test subject.
     *    @param mixed $second   Comparison object.
     *	  @return boolean		 True if same type.
     */
    private static function _isIdenticalType($first, $second)
    {
        if (gettype($first) != gettype($second)) {
            return false;
        }
        if (is_object($first) && is_object($second)) {
            if ($first::class != $second::class) {
                return false;
            }
            return SimpleTestCompatibility::_isArrayOfIdenticalTypes(
                get_object_vars($first),
                get_object_vars($second),
            );
        }
        if (is_array($first) && is_array($second)) {
            return SimpleTestCompatibility::_isArrayOfIdenticalTypes($first, $second);
        }
        return $first === $second;
    }

    /**
     *    Recursive type test for each element of an array.
     *    @param mixed $first    Test subject.
     *    @param mixed $second   Comparison object.
     *	  @return boolean		 True if identical.
     */
    private static function _isArrayOfIdenticalTypes($first, $second)
    {
        if (array_keys($first) != array_keys($second)) {
            return false;
        }
        foreach (array_keys($first) as $key) {
            $is_identical = SimpleTestCompatibility::_isIdenticalType(
                $first[$key],
                $second[$key],
            );
            if (! $is_identical) {
                return false;
            }
        }
        return true;
    }

    /**
     *    Test for two variables being aliases.
     *    @param mixed $first    Test subject.
     *    @param mixed $second   Comparison object.
     *	  @return boolean		 True if same.
     */
    public static function isReference(&$first, &$second)
    {
        if (is_object($first)) {
            return ($first === $second);
        }

        $temp = $first;
        $first = uniqid("test");
        $is_ref = ($first === $second);
        $first = $temp;
        return $is_ref;
    }

    /**
     *    Test to see if an object is a member of a
     *    class hiearchy.
     *    @param object $object    Object to test.
     *    @param string $class     Root name of hiearchy.
     *    @return boolean		  True if class in hiearchy.
     */
    public static function isA($object, $class)
    {
        if (! class_exists($class, false)) {
            if (function_exists('interface_exists')) {
                if (! interface_exists($class, false)) {
                    return false;
                }
            }
        }

        return $object instanceof $class;
    }

    /**
     *    Sets a socket timeout for each chunk.
     *    @param resource $handle    Socket handle.
     *    @param integer $timeout    Limit in seconds.
     */
    public static function setTimeout($handle, $timeout)
    {
        stream_set_timeout($handle, $timeout);
    }
}
