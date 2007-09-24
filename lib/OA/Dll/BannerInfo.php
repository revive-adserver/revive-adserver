<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * @package    OpenadsDll
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 * A file to description Banner Information class.
 *
 */

// Include base info class.
require_once MAX_PATH . '/lib/OA/Info.php';

/**
 *  Class with information about banner
 *
 */

class OA_Dll_BannerInfo extends OA_Info
{

    /**
     * The ID of the banner.
     *
     * @var integer $bannerId
     */
	var $bannerId;

    /**
     * The ID of the campaign to which to add the banner.
     *
     * @var integer $campaignId
     */
	var $campaignId;

    /**
     * The name of the banner.
     *
     * @var integer $bannerName
     */
	var $bannerName;

    /**
     * One of 'sql','web','url','html','network','txt'.
     *
     * @var enum $storageType
     */
    var $storageType;

    /**
     * The name of the file in SQL or Web types.
     *
     * @var string $fileName
     */
	var $fileName;

    /**
     * The URL of the image file in network types.
     *
     * @var string $imageURL
     */
	var $imageURL;

    /**
     * The HTML template for HTML types.
     *
     * @var text $htmlTemplate
     */
	var $htmlTemplate;

    /**
     * The priority of this banner.
     *
     * @var integer $width
     */
	var $width;

    /**
     * The height of the banner.
     *
     * @var integer $height
     */
	var $height;

    /**
     * The destination URL of the banner.
     *
     * @var text $url
     */
	var $url;

	/**
	 * Setting all default values. Used in adding new banner.
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
                    'url' => 'string'
                );
    }
}

?>