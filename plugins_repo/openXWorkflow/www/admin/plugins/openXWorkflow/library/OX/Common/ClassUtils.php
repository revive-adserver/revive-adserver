<?php

class OX_Common_ClassUtils
{
    /**
     * If the provided argument is an object, returns its class. Otherwise, returns the
     * argument.
     */
    public static function getClass($objectOrClassName)
    {
        if (is_object($objectOrClassName)) {
            return get_class($objectOrClassName);
        } else {
            return $objectOrClassName;
        }
    }
}
