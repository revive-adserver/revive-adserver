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

require_once MAX_PATH . '/lib/OA/Creative/File.php';
require_once MAX_PATH . '/www/admin/lib-swf.inc.php';

/**
 * A class to deal with uploaded creatives
 *
 */
class OA_Creative_File_Swf extends OA_Creative_File
{
    var $pluginVersion;
    var $hardcodedLinks;

    function loadFile($fileName)
    {
        $result = parent::loadFile($fileName);

        if (PEAR::isError($result)) {
            return $result;
        }

        // Fix any wrong-case clickTAG
        if (phpAds_SWFCompressed($this->content)) {
            $buffer = phpAds_SWFDecompress($this->content);
            $buffer = preg_replace('/clickTAG/i', 'clickTAG', $buffer);
            $this->content = phpAds_SWFCompress($buffer);
        } else {
            $this->content = preg_replace('/clickTAG/i', 'clickTAG', $this->content);
        }

        return true;
    }

    function readCreativeDetails($fileName)
    {
        // The standard check can fail with compressed SWF files and zlib not statically compiled in,
        // so we need to be more relaxed here and accept all matching files
        if (!phpAds_SWFVersion($this->content)) {
            return new PEAR_Error('Unsupported SWF image format');
        }

        $this->contentType = 'swf';

        list($this->width, $this->height) = phpAds_SWFDimensions($this->content);

        $this->pluginVersion  = phpAds_SWFVersion($this->content);
        $this->hardcodedLinks = phpAds_SWFInfo($this->content);

        return true;
    }

    function getFileDetails()
    {
        $aDetails = parent::getFileDetails();
        $aDetails['pluginversion'] = $this->pluginVersion;
        $aDetails['editswf']       = $this->pluginVersion >= 3 && $this->hardcodedLinks;

        return $aDetails;
    }
}

?>