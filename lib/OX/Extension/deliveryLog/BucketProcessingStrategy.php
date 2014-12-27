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
 * The BucketProcessingStrategy interface
 *
 * @package    OpenXExtension
 * @subpackage DeliveryLog
 */
interface OX_Extension_DeliveryLog_BucketProcessingStrategy {

    public function processBucket($oBucket, $oEnd);

     /**
     * A method to prune a bucket of all records up to and
     * including the time given.
     *
     * @param Date $oEnd   Prune until this interval_start (inclusive).
     * @param Date $oStart Only prune before this interval_start date (inclusive)
     *                     as well. Optional.
     * @return mixed Either the number of rows pruned, or an MDB2_Error objet.
     */
    public function pruneBucket($oBucket, $oEnd, $oStart = null);

}

?>