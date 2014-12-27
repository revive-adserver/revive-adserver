<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * A factory for creating BucketProcessingStrategy classes.
 *
 * @package    OpenXExtension
 * @subpackage DeliveryLog
 */
class OX_Extension_DeliveryLog_BucketProcessingStrategyFactory
{

    /**
     * Creates a BucketProcessingStrategy for aggregate type buckets.
     *
     * @return OX_Extension_DeliveryLog_BucketProcessingStrategy
     */
    public static function getAggregateBucketProcessingStrategy()
    {
        return OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::_getBucketProcessingStrategy('Aggregate');
    }

    /**
     * Creates a BucketProcessingStrategy for raw type buckets.
     *
     * @return OX_Extension_DeliveryLog_BucketProcessingStrategy
     */
    public static function getRawBucketProcessingStrategy()
    {
        return OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::_getBucketProcessingStrategy('Raw');
    }

    /**
     * A private method to get the required default deliveryLog extension
     * bucket processing strategy class.
     *
     * @access private
     * @param string $type Either "Aggregate" or "Raw".
     * @return OX_Extension_DeliveryLog_BucketProcessingStrategy
     */
    private static function _getBucketProcessingStrategy($type)
    {
        $dbType = $GLOBALS['_MAX']['CONF']['database']['type'];

        // Prepare the required filename for the default bucket processing strategy needed
        $fileName = LIB_PATH . '/Extension/deliveryLog/' . ucfirst(strtolower($type)) . 'BucketProcessingStrategy' . ucfirst(strtolower($dbType)) . '.php';
        // Include the required bucket processing strategy file
        if (file_exists($fileName)) {
            @include_once $fileName;
            // Prepare the required class name for the default bucket processing strategy needed
            $className = 'OX_Extension_DeliveryLog_' . ucfirst(strtolower($type)) . 'BucketProcessingStrategy' . ucfirst(strtolower($dbType));
            if (class_exists($className)) {
                return new $className();
            }
        }

        $message = 'Unable to instantiate the required default ' . strtolower($type) .
            " datbase bucket processing strategy for database type '$dbType'.";
        MAX::raiseError($message, MAX_ERROR_INVALIDARGS, PEAR_ERROR_DIE);
    }
}

?>