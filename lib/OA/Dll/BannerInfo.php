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
 * @author     Ivan Klishch <iklishch@lohika.com>
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
    var $bannerId;

    /**
     * This field provides the ID of the campaign to associate with the banner.
     *
     * @var integer $campaignId
     */
    var $campaignId;

    /**
     * This field provides the name of the banner.
     *
     * @var integer $bannerName
     */
    var $bannerName;

    /**
     * This field provides the storageType for the banner, which is one of
     * 'sql','web','url','html','txt'.
     *
     * @var string $storageType
     */
    var $storageType;

    /**
     * This field provides the URL for the image file for an external banner.
     *
     * @var string $imageURL
     */
    var $imageURL;

    /**
     * This field provides the HTML template for a HTML banner.
     *
     * @var text $htmlTemplate
     */
    var $htmlTemplate;

    /**
     * This field provides the width of the banner.
     *
     * @var integer $width
     */
    var $width;

    /**
     * This field provides the height of the banner.
     *
     * @var integer $height
     */
    var $height;

    /**
     * This field provides the priority weight of the banner.
     *
     * @var integer $weight
     */
    var $weight;

    /**
     * This field provides the HTML target of the banner (e.g. _blank, _self)
     *
     * @var text $target
     */
    var $target;

    /**
     * This field provides the destination URL of the banner.
     *
     * @var text $url
     */
    var $url;

    /**
     * This field provides the Text value of the text banner.
     *
     * @var string $bannerText
     */
    var $bannerText;

    /**
     * A boolean field to indicate if the banner is active
     *
     * @var int $status
     */
    var $status;

    /**
     * A text field for HTML banners to indicate which adserver this ad is from
     *
     * @var string $adserver
     */
    var $adserver;

    /**
     * This field provides transparency information for SWF banners
     *
     * @var boolean
     */
    var $transparent;

    /**
     * Frequency capping: total views per user.
     *
     * @var integer $capping
     */
    var $capping;

    /**
     * Frequency capping: total views per period.
     * (defined in seconds by "block").
     *
     * @var integer $sessionCapping
     */
    var $sessionCapping;

    /**
     * Frequency capping: reset period, in seconds.
     *
     * @var integer $block
     */
    var $block;

    /**
     * An array field for SQL/Web banners to contain the image name and binary data
     *
     * Array
     * (
     *      [filename] => banner.swf
     *      [content]  => {binarydata}
     *      [editswf]  => true
     * )
     *
     * If the editswf member is present and true, any SWF files will be scanned for hardcoded
     * links and eventually converted
     *
     * @var array
     */
    var $aImage;

    /**
     * An array field for SQL/Web banners to contain the backup image name and binary data
     * in case the primary image is a swf file
     *
     * Array
     * (
     *      [filename] => banner.gif
     *      [content]  => {binarydata}
     * )
     *
     * @var array
     */
    var $aBackupImage;

    /**
     * This field provides any additional comments to be stored.
     *
     * @var string $comments
     */
    var $comments;

    /**
     * This field provides the alt value for SQL/Web/External banners.
     *
     * @var string $alt
     */
    var $alt;
    
    /**
     * This field provides the filename of the banner.
     *
     * @var string $filename
     */
    var $filename;
    
    /**
     * This field provides appended code for this banner.
     *
     * @var string $append
     */
    var $append;
    
    /**
     * This field provides the filename of the banner.
     *
     * @var string $prepend
     */
    var $prepend;

    /**
     * This method sets all default values when adding a new banner.
     *
     * @access public
     *
     */
    function setDefaultForAdd() {
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

    function encodeImage($aImage)
    {
        return new XML_RPC_Value(array(
            'filename' => new XML_RPC_Value($aImage['filename']),
            'content'  => new XML_RPC_Value($aImage['content'], 'base64'),
            'editswf'  => new XML_RPC_Value(!empty($aImage['editswf']), 'boolean'),
        ), 'struct');
    }

    function toArray()
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
    function getFieldsTypes()
    {
        return array(
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
                );
    }
}

?>
