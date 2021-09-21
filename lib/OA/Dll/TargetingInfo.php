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
 * @package    OpenXDll
 *
 */

// Require the base Info class.
require_once MAX_PATH . '/lib/OA/Info.php';

/**
 * The OA_Dll_PublisherInfo class extends the base OA_Info class and contains
 * information about publisher
 *
 */
class OA_Dll_TargetingInfo extends OA_Info
{
    /**
     * 99% will be "and" or "or", but that's not enforced
     *
     * @var string
     */
    public $logical;

    /**
     * This is the plugin-component identifier
     *
     * @var string
     */
    public $type;

    /**
     * String showing the operation to be applied (e.g.: '==', '!=', '>=',
     * 'ne')
     *
     * @var string
     */
    public $comparison;

    /**
     * The exact structure varies from component to component
     *
     * @var string
     */
    public $data;


    public function getFieldsTypes()
    {
        return [
                    'logical' => 'string',
                    'type' => 'string',
                    'comparison' => 'string',
                    'data' => 'string'
                ];
    }
}
