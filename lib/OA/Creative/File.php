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

require_once MAX_PATH . '/lib/OA/Creative.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';

/**
 * A class to deal with uploaded creatives
 *
 */
class OA_Creative_File extends OA_Creative
{
    public $fileName;

    /**
     * Class constructor
     *
     * @param string $fileName
     *
     * @return OA_Creative_File
     *
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * A method to load the creative from a file
     *
     * @param string $filePath
     * @return mixed True on success, PEAR_Error otherwise
     */
    public function loadFile($filePath)
    {
        if (($this->content = @file_get_contents($filePath)) === false) {
            return new PEAR_Error("Cannot load image file");
        }

        return $this->readCreativeDetails($filePath);
    }

    /**
     * @throws \RuntimeException
     */
    public static function checkSize(int $size): void
    {
        $maxFilesize = (int) ($GLOBALS['_MAX']['CONF']['store']['maxFilesize'] ?? 0);

        if ($maxFilesize > 0 && $size > $maxFilesize) {
            throw new \RuntimeException("Image file size is greater than {$maxFilesize} bytes");
        }
    }

    /**
     * A method to load the creative from a file
     *
     * @param string $filePath
     * @param array  $aTypes Optional parameters of allowed types (@see getimagesize)
     * @return mixed True on success, PEAR_Error otherwise
     */
    public function readCreativeDetails($filePath, $aTypes = null)
    {
        if (!($aImage = @getimagesize($filePath))) {
            return new PEAR_Error("Unrecognized image file format");
        }

        if (!isset($aTypes[$aImage[2]])) {
            return new PEAR_Error('Unsupported image format');
        }

        if (PHP_VERSION_ID < 80200 && $aImage[2] === IMAGETYPE_AVIF) {
            return new PEAR_Error('AVIF is only supported with PHP 8.2+');
        }

        $this->contentType = $aTypes[$aImage[2]];
        $this->width = $aImage[0];
        $this->height = $aImage[1];

        return true;
    }

    public function getFileDetails()
    {
        return [
            'filename' => $this->fileName,
            'width' => $this->width,
            'height' => $this->height,
            'contenttype' => $this->contentType,
            'pluginversion' => 0,
        ];
    }

    public function store($type)
    {
        $this->fileName = phpAds_ImageStore($type, $this->fileName, $this->content);
    }

    public function getContentTypeByExtension($alt = false)
    {
        return OA_Creative_File::staticGetContentTypeByExtension(
            $this->fileName,
            $alt,
        );
    }

    public static function staticGetContentTypeByExtension($fileName, $alt = false)
    {
        $contentType = '';

        $ext = substr($fileName, strrpos($fileName, '.') + 1);
        $contentType = match (strtolower($ext)) {
            'jpeg' => 'jpeg',
            'jpg' => 'jpeg',
            'png' => 'png',
            'gif' => 'gif',
            'webp' => 'webp',
            'avif' => 'avif',
            'swf' => $alt ? '' : 'swf',
            'dcr' => $alt ? '' : 'dcr',
            'rpm' => $alt ? '' : 'rpm',
            'mov' => $alt ? '' : 'mov',
            default => $contentType,
        };
        return $contentType;
    }

    /**
     * A factory method to load a cretive from a file
     *
     * @param string $filePath
     * @param string $fileName If empty, it will be generated from filePath
     * @return OA_Creative_File|PEAR_Error
     */
    public static function factory($filePath, $fileName = '')
    {
        if (!@is_readable($filePath)) {
            return new PEAR_Error('Could not read the file: ' . $filePath);
        }

        if (empty($fileName)) {
            $fileName = basename($filePath);
        }

        $validImageExtensions = 'png|svg|gif|jpg|jpeg|jpe|tif|tiff|ppm|bmp|rle|dib|tga|pcz|wbmp|wbm|webp|avif';
        if (preg_match('/\.(?:dcr|rpm|mov)$/i', $fileName)) {
            $type = 'RichMedia';
        } elseif (preg_match('/\.(' . $validImageExtensions . ')$/i', $fileName)) {
            $type = 'Image';
        } else {
            return new PEAR_Error('The uploaded file does not have a valid extension.
            The file must be an image file (JPG, PNG, GIF, etc.).');
        }

        require_once(MAX_PATH . '/lib/OA/Creative/File/' . $type . '.php');
        $className = 'OA_Creative_File_' . $type;

        /** @var OA_Creative_File $oCreative */
        $oCreative = new $className($fileName);

        $result = $oCreative->loadFile($filePath);
        if (PEAR::isError($result)) {
            return $result;
        }

        return $oCreative;
    }

    /**
     * A factory method to load a cretive from a variable
     *
     * @param string $fileName
     * @param string $content
     * @return OA_Creative_File|PEAR_Error
     */
    public static function factoryString($fileName, $content)
    {
        try {
            self::checkSize(strlen($content));
        } catch (\Exception $e) {
            return new PEAR_Error($e->getMessage());
        }

        // Create temp file
        $filePath = tempnam(MAX_PATH . '/var', 'oa_creative_');
        // Open temp file
        if (!($fp = @fopen($filePath, 'w'))) {
            return new PEAR_Error('Could not open the file: ' . $filePath);
        }
        // Write to temp file
        if (!@fwrite($fp, $content)) {
            return new PEAR_Error('Could not write to file: ' . $filePath);
        }

        // Get new instance
        $oCreative = OA_Creative_File::factory($filePath, $fileName);

        // Cleanup
        @fclose($fp);
        @unlink($filePath);

        return $oCreative;
    }

    /**
     * A factory method to load a cretive from an uploaded file
     *
     * @todo: improve checks
     *
     * @param string $variableName
     * @return OA_Creative_File|PEAR_Error
     */
    public static function factoryUploadedFile($variableName)
    {
        if (!empty($_FILES[$variableName]['error'])) {
            $aErrors = [
                UPLOAD_ERR_INI_SIZE => "file size exceeds PHP max allowed size.",
                UPLOAD_ERR_FORM_SIZE => "file size exceeds form max allowed size.",
                UPLOAD_ERR_PARTIAL => "partial upload.",
                UPLOAD_ERR_NO_FILE => "no file uploaded.",
                UPLOAD_ERR_NO_TMP_DIR => "temp directory not available.",
            ];

            $message = $aErrors[$_FILES[$variableName]['error']] ?? "Error code {$_FILES[$variableName]['error']}";

            return new PEAR_Error('An error occurred dealing with the file upload: ' . $message);
        }
        if (!isset($_FILES[$variableName]['tmp_name']) || !is_uploaded_file($_FILES[$variableName]['tmp_name'])) {
            return new PEAR_Error('Could not find the uploaded file: ' . $variableName);
        }
        if (!isset($_FILES[$variableName]['name'])) {
            return new PEAR_Error('Could not find the uploaded file name: ' . $variableName);
        }

        try {
            self::checkSize($_FILES[$variableName]['size']);
        } catch (\Exception $e) {
            return new PEAR_Error($e->getMessage());
        }

        $fileName = basename($_FILES[$variableName]['name']);
        $filePath = $_FILES[$variableName]['tmp_name'];
        if (!@is_readable($filePath)) {
            // The uploaded file is not directly readable, we should use a file from the var folder instead
            $tmpName = tempnam(MAX_PATH . '/var', 'oa_creative_');
            if ($tmpName === false) {
                return new PEAR_Error('Cannot create a temporary file: ' . $filePath);
            }
            // Move uploaded file to a temporary file
            if (!@move_uploaded_file($filePath, $tmpName)) {
                // Cleanup
                @unlink($tmpName);
                return new PEAR_Error('Could not move the uploaded file to: ' . $tmpName);
            }
            $filePath = $tmpName;
        }

        // Get new instance
        $oCreative = OA_Creative_File::factory($filePath, $fileName);

        // Cleanup
        if (isset($tmpName)) {
            @unlink($tmpName);
        }

        return $oCreative;
    }
}
