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
$Id:$
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
     * The nbannerName variable is the name of the banner.
     *
     * @var integer $bannerName
     */
    var $bannerName;

    /**
     * The storageType variable is one of the following: 'sql','web','url','html','network','txt'.
     *
     * @var enum $storageType
     */
    var $storageType;

    /**
     * The fileName variable is the name of a banner file in either SQL or web address format.
     *
     * @var string $fileName
     */
    var $fileName;

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
     * The url variable is the destination URL of the banner.
     *
     * @var text $url
     */
    var $url;

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
     * This method sets all default values when adding a new banner.
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

    }

    function getFieldsTypes()
    {
        return array(
                    'bannerId' => 'integer',
                    'campaignId' => 'integer',
                    'bannerName' => 'string',
                    'storageType' => 'string',
                    'fileName' => 'string',
                    'imageURL' => 'string',
                    'htmlTemplate' => 'string',
                    'width' => 'integer',
                    'height' => 'integer',
                    'weight' => 'integer',
                    'url' => 'string',
                    'status' => 'integer',
                    'adserver' => 'string'
                );
    }
}

?>
