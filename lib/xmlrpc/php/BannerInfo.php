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
 * This file describes the BannerInfo class.
 *
 */

// Require the base info class.
require_once 'Info.php';

/**
 *  The BannerInfo class extends the base Info class and contains information about the banner.
 *
 */

class OA_Dll_BannerInfo extends OA_Info
{

    /**
     * The bannerID variable is the unique ID of the banner.
     *
     * @var integer $bannerId
     */
    var $bannerId;

    /**
     * The campaignID variable is the ID of the campaign associated with the banner.
     *
     * @var integer $campaignId
     */
    var $campaignId;

    /**
     * The bannerName variable is the name of the banner.
     *
     * @var integer $bannerName
     */
    var $bannerName;

    /**
     * The storageType variable is one of the following: 'sql','web','url','html',,'txt'.
     *
     * @var enum $storageType
     */
    var $storageType;

    /**
     * The imageURL variable is the URL for an image file for network banners.
     *
     * @var string $imageURL
     */
    var $imageURL;

    /**
     * The htmlTemplate variable is the HTML template for HTML banners.
     *
     * @var text $htmlTemplate
     */
    var $htmlTemplate;

    /**
     * The width variable contains the width of a banner.
     *
     * @var integer $width
     */
    var $width;

    /**
     * The height variable contains the height of the banner.
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
     * The url variable is the destination URL of the banner.
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
     * @var string $alt
     */
    var $filename;

    /**
     * This method sets all default values when adding a new banner.
     *
     * @access public
     *
     */
    function setDefaultForAdd() {
        if (is_null($this->storageType)) {
            $this->storageType = 'sql';
        }

        if (is_null($this->width)) {
            $this->width = 0;
        }

        if (is_null($this->height)) {
            $this->height = 0;
        }

        if (is_null($this->weight)) {
            $this->weight = 1;
        }

        if (is_null($this->status)) {
            $this->status = 0;
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
