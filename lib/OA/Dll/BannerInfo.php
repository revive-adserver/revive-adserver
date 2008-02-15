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
     * 'sql','web','url','html','network','txt'.
     *
     * @var enum $storageType
     */
    var $storageType;

    /**
     * This field provides the name of the banner file.
     *
     * @var string $fileName
     */
    var $fileName;

    /**
     * This field provides the URL for the image file for a network banner.
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
     * This field provides the destination URL of the banner.
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
            $this->status = OA_ENTITY_STATUS_RUNNING;
        }

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
