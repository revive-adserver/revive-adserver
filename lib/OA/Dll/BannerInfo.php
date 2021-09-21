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
 *  The OA_Dll_BannerInfo class extends the base OA_Info class and contains
 *  information about the banner.
 *
 */

class OA_Dll_BannerInfo extends OA_Info
{
    /**
     * This field provides the ID of the banner.
     *
     * @var integer $bannerId
     */
    public $bannerId;

    /**
     * This field provides the ID of the campaign to associate with the banner.
     *
     * @var integer $campaignId
     */
    public $campaignId;

    /**
     * This field provides the name of the banner.
     *
     * @var integer $bannerName
     */
    public $bannerName;

    /**
     * This field provides the storageType for the banner, which is one of
     * 'sql','web','url','html','txt'.
     *
     * @var string $storageType
     */
    public $storageType;

    /**
     * This field provides the URL for the image file for an external banner.
     *
     * @var string $imageURL
     */
    public $imageURL;

    /**
     * This field provides the HTML template for a HTML banner.
     *
     * @var text $htmlTemplate
     */
    public $htmlTemplate;

    /**
     * This field provides the width of the banner.
     *
     * @var integer $width
     */
    public $width;

    /**
     * This field provides the height of the banner.
     *
     * @var integer $height
     */
    public $height;

    /**
     * This field provides the priority weight of the banner.
     *
     * @var integer $weight
     */
    public $weight;

    /**
     * This field provides the HTML target of the banner (e.g. _blank, _self)
     *
     * @var text $target
     */
    public $target;

    /**
     * This field provides the destination URL of the banner.
     *
     * @var text $url
     */
    public $url;

    /**
     * This field provides the Text value of the text banner.
     *
     * @var string $bannerText
     */
    public $bannerText;

    /**
     * A boolean field to indicate if the banner is active
     *
     * @var int $status
     */
    public $status;

    /**
     * A text field for HTML banners to indicate which adserver this ad is from
     *
     * @var string $adserver
     */
    public $adserver;

    /**
     * This field provides transparency information for SWF banners
     *
     * @var boolean
     */
    public $transparent;

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
     * An array field for SQL/Web banners to contain the image name and binary data
     *
     * Array
     * (
     *      [filename] => banner.swf
     *      [content]  => {binarydata}
     * )
     *
     * @var array
     */
    public $aImage;

    /**
     * An array field for SQL/Web banners to contain the backup image name and binary data
     * in case the primary image is a swf file
     *
     * @deprecated
     *
     * Array
     * (
     *      [filename] => banner.gif
     *      [content]  => {binarydata}
     * )
     *
     * @var array
     */
    public $aBackupImage;

    /**
     * This field provides any additional comments to be stored.
     *
     * @var string $comments
     */
    public $comments;

    /**
     * This field provides the alt value for SQL/Web/External banners.
     *
     * @var string $alt
     */
    public $alt;

    /**
     * This field provides the filename of the banner.
     *
     * @var string $filename
     */
    public $filename;

    /**
     * This field provides appended code for this banner.
     *
     * @var string $append
     */
    public $append;

    /**
     * This field provides the filename of the banner.
     *
     * @var string $prepend
     */
    public $prepend;

    /**
     * This method sets all default values when adding a new banner.
     *
     * @access public
     *
     */
    public function setDefaultForAdd()
    {
        if (!isset($this->storageType)) {
            $this->storageType = 'html';
        }

        if (!isset($this->width)) {
            $this->width = 0;
        }

        if (!isset($this->height)) {
            $this->height = 0;
        }

        if (!isset($this->weight)) {
            $this->weight = 1;
        }

        if (!isset($this->status)) {
            $this->status = OA_ENTITY_STATUS_RUNNING;
        }

        if (!isset($this->transparent)) {
            $this->transparent = false;
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
    }

    public function encodeImage($aImage)
    {
        return new XML_RPC_Value([
            'filename' => new XML_RPC_Value($aImage['filename']),
            'content' => new XML_RPC_Value($aImage['content'], 'base64'),
        ], 'struct');
    }

    public function toArray()
    {
        $aInfo = parent::toArray();
        if (isset($this->aImage)) {
            $aInfo['aImage'] = $this->encodeImage($this->aImage);
        }
        if (isset($this->aBackupImage)) {
            $aInfo['aBackupImage'] = $this->encodeImage($this->aBackupImage);
        }
        return $aInfo;
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
                    'bannerId' => 'integer',
                    'campaignId' => 'integer',
                    'bannerName' => 'string',
                    'storageType' => 'string',
                    'imageURL' => 'string',
                    'htmlTemplate' => 'string',
                    'width' => 'integer',
                    'height' => 'integer',
                    'weight' => 'integer',
                    'target' => 'string',
                    'url' => 'string',
                    'bannerText' => 'string',
                    'status' => 'integer',
                    'adserver' => 'string',
                    'transparent' => 'integer',
                    'capping' => 'integer',
                    'sessionCapping' => 'integer',
                    'block' => 'integer',
                    'aImage' => 'custom',
                    'aBackupImage' => 'custom',
                    'comments' => 'string',
                    'alt' => 'string',
                    'filename' => 'string',
                    'append' => 'string',
                    'prepend' => 'string',
                ];
    }
}
