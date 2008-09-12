<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * A factory for creating BucketProcessingStrategy classes.
 *
 * @package    OpenXExtension
 * @subpackage DeliveryLog
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     David Keen <david.keen@openx.org>
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