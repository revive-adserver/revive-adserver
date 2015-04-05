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

    function readCreativeDetails($fileName, $aTypes = null)
    {
        // The standard check can fail with compressed SWF files and zlib not statically compiled in,
        // so we need to be more relaxed here and accept all matching files
        if (!phpAds_SWFVersion($this->content)) {
            return new PEAR_Error('Unrecognized image file format');
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