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

require_once MAX_PATH . '/extensions/deliveryLog/LogCommon.php';
require_once MAX_PATH . '/extensions/deliveryLog/BucketProcessingStrategyFactory.php';

class Plugins_DeliveryLog_OxLogConversion_LogConversionVariable extends Plugins_DeliveryLog_LogCommon
{
    function __construct()
    {
        // Conversions are not aggregate.
        $dbType = $GLOBALS['_MAX']['CONF']['database']['type'];
        $this->processingStrategy =
                    Plugins_DeliveryLog_BucketProcessingStrategyFactory::getRawBucketProcessingStrategy($dbType);
    }

    function onInstall()
    {
        // no additional code (stored procedures) are required for logging conversions
        return true;
    }

    function getDependencies()
    {
        return array(
            'deliveryLog:oxLogConversion:logConversionVariable' => array(
            )
        );
    }

    function getBucketName()
    {
        return 'data_bkt_a_var';
    }

    public function getTableBucketColumns()
    {
        return array();
    }
}

?>