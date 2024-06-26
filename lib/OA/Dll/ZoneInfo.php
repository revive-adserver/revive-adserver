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
 */

// Require the base Info class.
require_once MAX_PATH . '/lib/OA/Info.php';

/**
 * The OA_Dll_ZoneInfo class extends the base OA_Info class and
 * contains information about the zone.
 *
 */

class OA_Dll_ZoneInfo extends OA_Info
{
    /**
     * This field provides the ID of the zone.
     *
     * @var integer $zoneId
     */
    public $zoneId;

    /**
     * This field provides the ID of the publisher associated with the zone.
     *
     * @var integer $publisherId
     */
    public $publisherId;

    /**
     * This field provides the name of the zone.
     *
     * @var string $zoneName
     */
    public $zoneName;

    /**
     * This field provides the type of the zone (banner, interstitial, popup, text, email).
     *
     * @var integer $type
     */
    public $type;

    /**
     * This field provides the width of the zone.
     *
     * @var integer $width
     */
    public $width;

    /**
     * This field provides the height of the zone.
     *
     * @var integer $height
     */
    public $height;

    /**
     * Frequency capping: total views per user.
     *
     * @var integer $capping
     */
    public $capping;

    /**
     * Frequency capping: total views per period.
     * (defined in seconds by "block").
     *
     * @var integer $sessionCapping
     */
    public $sessionCapping;

    /**
     * Frequency capping: reset period, in seconds.
     *
     * @var integer $block
     */
    public $block;

    /**
     * This field provides any additional comments to be stored.
     *
     * @var string $comments
     */
    public $comments;

    /**
     * This field provides the appended code for this zone.
     *
     * @var string $append
     */
    public $append;

    /**
     * This field provides the prepended code of the zone.
     *
     * @var string $prepend
     */
    public $prepend;

    /**
     * This field provides the chained zone of the current zone.
     *
     * @var int $chainedZoneId
     */
    public $chainedZoneId;

    /**
     * This method sets all default values when adding a new zone.
     *
     * @access public
     *
     */
    public function setDefaultForAdd()
    {
        if (is_null($this->type)) {
            $this->type = 0;
        }

        if (is_null($this->width)) {
            $this->width = 0;
        }

        if (is_null($this->height)) {
            $this->height = 0;
        }

        if (is_null($this->capping)) {
            // Leave null
        }

        if (is_null($this->sessionCapping)) {
            // Leave null
        }

        if (is_null($this->block)) {
            // Leave null
        }

        if (is_null($this->chainedZoneId)) {
            // Leave null
        }
    }

    /**
     * This method returns an array of fields with their corresponding types.
     *
     * @access public
     *
     * @return array
     */
    public function getFieldsTypes()
    {
        return [
            'zoneId' => 'integer',
            'publisherId' => 'integer',
            'zoneName' => 'string',
            'type' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
            'capping' => 'integer',
            'sessionCapping' => 'integer',
            'block' => 'integer',
            'comments' => 'string',
            'append' => 'string',
            'prepend' => 'string',
            'chainedZoneId' => 'integer',
        ];
    }
}
