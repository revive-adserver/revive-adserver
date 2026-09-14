<?php

/**
 *	base include file for SimpleTest
 *	@package	SimpleTest
 *	@subpackage	UnitTester
 */
/**
 * does type matter
 */
if (! defined('TYPE_MATTERS')) {
    define('TYPE_MATTERS', true);
}

/**
 *    Displays variables as text and does diffs.
 *	  @package	SimpleTest
 *	  @subpackage	UnitTester
 */
class SimpleDumper
{
    /**
     *    Renders a variable in a shorter form than print_r().
     *    @param mixed $value      Variable to render as a string.
     *    @return string           Human readable string form.
     */
    public function describeValue($value)
    {
        $type = $this->getType($value);
        return match ($type) {
            "Null" => "NULL",
            "Boolean" => "Boolean: " . ($value ? "true" : "false"),
            "Array" => "Array: " . count($value) . " items",
            "Object" => "Object: of " . $value::class,
            "String" => "String: " . $this->clipString($value, 200),
            default => "$type: $value",
        };
        return "Unknown";
    }

    /**
     *    Gets the string representation of a type.
     *    @param mixed $value    Variable to check against.
     *    @return string         Type.
     */
    public function getType($value)
    {
        if (! isset($value)) {
            return "Null";
        }
        if (is_bool($value)) {
            return "Boolean";
        }
        if (is_string($value)) {
            return "String";
        }
        if (is_int($value)) {
            return "Integer";
        }
        if (is_float($value)) {
            return "Float";
        }
        if (is_array($value)) {
            return "Array";
        }
        if (is_resource($value)) {
            return "Resource";
        }
        if (is_object($value)) {
            return "Object";
        }
        return "Unknown";
    }

    /**
     *    Creates a human readable description of the
     *    difference between two variables. Uses a
     *    dynamic call.
     *    @param mixed $first        First variable.
     *    @param mixed $second       Value to compare with.
     *    @param boolean $identical  If true then type anomolies count.
     *    @return string             Description of difference.
     */
    public function describeDifference($first, $second, $identical = false)
    {
        if ($identical) {
            if (! $this->_isTypeMatch($first, $second)) {
                return "with type mismatch as [" . $this->describeValue($first) .
                    "] does not match [" . $this->describeValue($second) . "]";
            }
        }
        $type = $this->getType($first);
        if ($type == "Unknown") {
            return "with unknown type";
        }
        $method = '_describe' . $type . 'Difference';
        return $this->$method($first, $second, $identical);
    }

    /**
     *    Tests to see if types match.
     *    @param mixed $first        First variable.
     *    @param mixed $second       Value to compare with.
     *    @return boolean            True if matches.
     *    @access private
     */
    public function _isTypeMatch($first, $second)
    {
        return ($this->getType($first) == $this->getType($second));
    }

    /**
     *    Clips a string to a maximum length.
     *    @param string $value         String to truncate.
     *    @param integer $size         Minimum string size to show.
     *    @param integer $position     Centre of string section.
     *    @return string               Shortened version.
     */
    public function clipString($value, $size, $position = 0)
    {
        $length = strlen($value);
        if ($length <= $size) {
            return $value;
        }
        $position = min($position, $length);
        $start = ($size / 2 > $position ? 0 : $position - $size / 2);
        if ($start + $size > $length) {
            $start = $length - $size;
        }
        $value = substr($value, $start, $size);
        return ($start > 0 ? "..." : "") . $value . ($start + $size < $length ? "..." : "");
    }

    /**
     *    Creates a human readable description of the
     *    difference between two variables. The minimal
     *    version.
     *    @param null $first          First value.
     *    @param mixed $second        Value to compare with.
     *    @return string              Human readable description.
     *    @access private
     */
    public function _describeGenericDifference($first, $second)
    {
        return "as [" . $this->describeValue($first) .
                "] does not match [" .
                $this->describeValue($second) . "]";
    }

    /**
     *    Creates a human readable description of the
     *    difference between a null and another variable.
     *    @param null $first          First null.
     *    @param mixed $second        Null to compare with.
     *    @param boolean $identical   If true then type anomolies count.
     *    @return string              Human readable description.
     *    @access private
     */
    public function _describeNullDifference($first, $second, $identical)
    {
        return $this->_describeGenericDifference($first, $second);
    }

    /**
     *    Creates a human readable description of the
     *    difference between a boolean and another variable.
     *    @param boolean $first       First boolean.
     *    @param mixed $second        Boolean to compare with.
     *    @param boolean $identical   If true then type anomolies count.
     *    @return string              Human readable description.
     *    @access private
     */
    public function _describeBooleanDifference($first, $second, $identical)
    {
        return $this->_describeGenericDifference($first, $second);
    }

    /**
     *    Creates a human readable description of the
     *    difference between a string and another variable.
     *    @param string $first        First string.
     *    @param mixed $second        String to compare with.
     *    @param boolean $identical   If true then type anomolies count.
     *    @return string              Human readable description.
     *    @access private
     */
    public function _describeStringDifference($first, $second, $identical)
    {
        if (is_object($second) || is_array($second)) {
            return $this->_describeGenericDifference($first, $second);
        }
        $position = $this->_stringDiffersAt($first, $second);
        $message = "at character $position";
        $message .= " with [" .
                $this->clipString($first, 200, $position) . "] and [" .
                $this->clipString($second, 200, $position) . "]";
        return $message;
    }

    /**
     *    Creates a human readable description of the
     *    difference between an integer and another variable.
     *    @param integer $first       First number.
     *    @param mixed $second        Number to compare with.
     *    @param boolean $identical   If true then type anomolies count.
     *    @return string              Human readable description.
     *    @access private
     */
    public function _describeIntegerDifference($first, $second, $identical)
    {
        if (is_object($second) || is_array($second)) {
            return $this->_describeGenericDifference($first, $second);
        }
        return "because [" . $this->describeValue($first) .
                "] differs from [" .
                $this->describeValue($second) . "] by " .
                abs((int) $first - (int) $second);
    }

    /**
     *    Creates a human readable description of the
     *    difference between two floating point numbers.
     *    @param float $first         First float.
     *    @param mixed $second        Float to compare with.
     *    @param boolean $identical   If true then type anomolies count.
     *    @return string              Human readable description.
     *    @access private
     */
    public function _describeFloatDifference($first, $second, $identical)
    {
        if (is_object($second) || is_array($second)) {
            return $this->_describeGenericDifference($first, $second);
        }
        return "because [" . $this->describeValue($first) .
                "] differs from [" .
                $this->describeValue($second) . "] by " .
                abs($first - $second);
    }

    /**
     *    Creates a human readable description of the
     *    difference between two arrays.
     *    @param array $first         First array.
     *    @param mixed $second        Array to compare with.
     *    @param boolean $identical   If true then type anomolies count.
     *    @return string              Human readable description.
     *    @access private
     */
    public function _describeArrayDifference($first, $second, $identical)
    {
        if (! is_array($second)) {
            return $this->_describeGenericDifference($first, $second);
        }
        if (! $this->_isMatchingKeys($first, $second, $identical)) {
            return "as key list [" .
                    implode(", ", array_keys($first)) . "] does not match key list [" .
                    implode(", ", array_keys($second)) . "]";
        }
        foreach (array_keys($first) as $key) {
            if ($identical && ($first[$key] === $second[$key])) {
                continue;
            }
            if (! $identical && ($first[$key] == $second[$key])) {
                continue;
            }
            return "with member [$key] " . $this->describeDifference(
                $first[$key],
                $second[$key],
                $identical,
            );
        }
        return "";
    }

    /**
     *    Compares two arrays to see if their key lists match.
     *    For an identical match, the ordering and types of the keys
     *    is significant.
     *    @param array $first         First array.
     *    @param array $second        Array to compare with.
     *    @param boolean $identical   If true then type anomolies count.
     *    @return boolean             True if matching.
     *    @access private
     */
    public function _isMatchingKeys($first, $second, $identical)
    {
        $first_keys = array_keys($first);
        $second_keys = array_keys($second);
        if ($identical) {
            return ($first_keys === $second_keys);
        }
        sort($first_keys);
        sort($second_keys);
        return ($first_keys == $second_keys);
    }

    /**
     *    Creates a human readable description of the
     *    difference between a resource and another variable.
     *    @param resource $first       First resource.
     *    @param mixed $second         Resource to compare with.
     *    @param boolean $identical    If true then type anomolies count.
     *    @return string              Human readable description.
     *    @access private
     */
    public function _describeResourceDifference($first, $second, $identical)
    {
        return $this->_describeGenericDifference($first, $second);
    }

    /**
     *    Creates a human readable description of the
     *    difference between two objects.
     *    @param object $first        First object.
     *    @param mixed $second        Object to compare with.
     *    @param boolean $identical   If true then type anomolies count.
     *    @return string              Human readable description.
     *    @access private
     */
    public function _describeObjectDifference($first, $second, $identical)
    {
        if (! is_object($second)) {
            return $this->_describeGenericDifference($first, $second);
        }
        return $this->_describeArrayDifference(
            get_object_vars($first),
            get_object_vars($second),
            $identical,
        );
    }

    /**
     *    Find the first character position that differs
     *    in two strings by binary chop.
     *    @param string $first        First string.
     *    @param string $second       String to compare with.
     *    @return integer             Position of first differing
     *                                character.
     *    @access private
     */
    public function _stringDiffersAt($first, $second)
    {
        if (! $first || ! $second) {
            return 0;
        }
        if (strlen($first) < strlen($second)) {
            [$first, $second] = [$second, $first];
        }
        $position = 0;
        $step = strlen($first);
        while ($step > 1) {
            $step = (int) (($step + 1) / 2);
            if (strncmp($first, $second, $position + $step) == 0) {
                $position += $step;
            }
        }
        return $position;
    }

    /**
     *    Sends a formatted dump of a variable to a string.
     *    @param mixed $variable    Variable to display.
     *    @return string            Output from print_r().
     */
    public static function dump($variable)
    {
        ob_start();
        print_r($variable);
        $formatted = ob_get_contents();
        ob_end_clean();
        return $formatted;
    }
}
